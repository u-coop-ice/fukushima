<?php
trait checkApp {

	public function getAppInfo() {

		$data = [];
		$where = [];

		if ($this->_app_id) {
			$data[':app_id'] = $this->_app_id;
			array_push($where, 'a.id = :app_id');
		} else if ($this->_app_code) {
			array_push($where, 'a.code = :app_code');
			$data[':app_code'] = $this->_app_code;
		} else if ($this->_app_charged_id) {
			array_push($where, 'a.charged_id = :charged_id');
			$data[':charged_id'] = $this->_app_charged_id;
		} else {
			throw new Exception('お申込みのIDが不明です。');
		}

		$sql = <<< HERE
SELECT a.*,
IFNULL(a.total_price,0)+IFNULL(a.postage,0)-IFNULL(a.reduction,0) AS total_price_all
 FROM app AS a

HERE;

		if ($_SESSION['mode']) {
//			array_push($where, 'a.regist_id = :regist_id');
			//			$data[':regist_id'] = $this->_auth->getAuthData('id');
		}

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		if ($this->_for_update) {
			$sql .= " FOR UPDATE";
			$this->_for_update = null;
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error", 1);
		}

		$appinfo = $res->fetch();

		if ($appinfo['extra']) {
			$appinfo['extra'] = json_decode($appinfo['extra'], true);
		}

		if (!$this->_app_id) {
			$this->_app_id = $appinfo['id'];
		}

		$regist_code = $_SESSION['config']['component'][$appinfo['component']]['infocode'];

		switch ($appinfo['component']) {
		case 'entry':
		case 'reserve':
		case 'mealcard':
		case 'living':
		case 'leave':
		case 'transition':

			if ($appinfo['category_id']) {
				$this->_category_id = $appinfo['category_id'];
				$this->_component = $appinfo['component'];
				$categoryinfo = $this->getEntryCategorySimple();

				if ($categoryinfo['cat_code']) {
					$regist_code .= '-' . $categoryinfo['cat_code'];
				}

				if ($appinfo['component'] == "lab") {
					if ($appinfo['part'] == "order") {
						$regist_code .= '-' . strtoupper($categoryinfo['part']);
					}

				}$appinfo['category_denomination'] = $categoryinfo['denomination'];
			}
			break;

		case 'shopping':
			$this->_shopping_category_id = $appinfo['category_id'];
			$init_category = $this->getShoppingCategory();

			if ($init_category["infocode"]) {$regist_code = $init_category["infocode"];}
			$regist_code .= '-ODR';

			break;
		}

		$regist_code .= ':' . date('Ymd', strtotime($appinfo['regist_date'])) . '-' . sprintf('%04d', intval($appinfo['app_count']));

		$appinfo['regist_code'] = $regist_code;

		return $appinfo;

	}

	public function getAppInfoArranged() {
		$appinfo = $this->getAppInfo();

		$appinfo['methods'] = json_decode($appinfo['methods'], true);

		$method = [];

		if (count($appinfo['methods'])) {

			foreach ($appinfo['methods'] as $key => $value) {
				if ($key != 'extra') {
					if (is_array($value)) {
						if ($value['use']) {
							$method[$key] = $value['sort'];
						}
					}
				} else {
					foreach ($value as $k => $v) {
						if ($v['use']) {
							$method[$key . $k] = $v['sort'];
						}
					}
				}
			}
		}
		asort($method);

		$fields = [];
		while (list($key, $value) = each($method)) {

			if (preg_match('/^extra/', $key)) {
				$k = intval(substr($key, 5));
				$extras[$key]['k'] = $k;

//				$smarty->assign('k', $k);

				if ($appinfo['methods']['extra'][$k]['select']) {

					$select = trim($appinfo['methods']['extra'][$k]['select']);
					$select = preg_replace('/\n|\r\n/', "\n", $select);

//					$extraList[$k] = explode("\n", $select);
					$extras[$key]['list'] = explode("\n", $select);
				}
			} else {
				if ($this->_fields_extension_app[$key]) {
					$fields['app'][$key] = 1;
				} else {
					$fields['regist'][$key] = 1;
				}

			}
		}

		$appinfo['method'] = $method;
		$appinfo['extras'] = $extras;
		$appinfo['fields'] = $fields;

		return $appinfo;

	}

	public function checkDuplicateApp() {

		if (!$this->_auth->checkAuth()) {
			throw new Exception("サインインしていません。", 3);
		}

		if (!$this->_category_id) {
			throw new Exception("カテゴリが指定されていません。", 1);
		}

		$where = [];
		$data = [];

		if ($this->_category_id) {
			array_push($where, "app.category_id = :category_id");
			$data[':category_id'] = $this->_category_id;
		}

		array_push($where, "app.regist_id = :regist_id");
		$data[':regist_id'] = $this->_auth->getAuthData('id');

		if (COMPONENT) {
			array_push($where, "component = :component");
			$data[':component'] = COMPONENT;
		}

		array_push($where, "IFNULL(cancelled,0) < 1");
		array_push($where, "IFNULL(archived,0) < 1");

		$sql = <<< HERE
SELECT id FROM app AS app

HERE;

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			throw new Exception("Database Error", 1);
		}

		$result = $res->rowCount();
		if ($result > 0) {
			throw new Exception("重複してお申込みはできません。", 7);
		}

	}

	public function checkDuplicateComedateApp() {

		if (!$this->_auth->checkAuth()) {
			throw new Exception("サインインしていません。", 3);
		}

		if (!$this->_category_id) {
			throw new Exception("カテゴリが指定されていません。", 1);
		}

		if (!$this->_comedate) {
			return;
		}

		$where = [];
		$data = [];

		if ($this->_category_id) {
			array_push($where, "app.category_id = :category_id");
			$data[':category_id'] = $this->_category_id;
		}

		array_push($where, "app.regist_id = :regist_id");
		$data[':regist_id'] = $this->_auth->getAuthData('id');

		array_push($where, "app.comedate = :comedate");
		$data[':comedate'] = $this->_comedate;

		if (defined('COMPONENT')) {
			array_push($where, "component = :component");
			$data[':component'] = COMPONENT;
		}

		array_push($where, "IFNULL(cancelled,0) < 1");
		array_push($where, "IFNULL(archived,0) < 1");

		$sql = <<< HERE
SELECT id FROM app AS app

HERE;

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			throw new Exception("Database Error", 1);
		}

		$result = $res->rowCount();
		if ($result > 0) {
			throw new Exception("<p>すでに" . $this->_comedate . 'のお申込みをいただいており、同日のお申込みはお受けできません</p><p><a class="btn btn-primary" href="/app/user/?mode=list_app">お申込み内容確認</a>よりご確認ください。</p>', 6);
		}

	}

	private function getCcEmail(array $_appinfo = null, int $_admin_user_id = null, int $_ask_category_id = null) {

		$ccs = [];

		if ($_appinfo['component']) {

			$cc = null;

			$store_ordermail = $_SESSION['config']['component'][$_appinfo['component']]['store_ordermail'];

			switch ($_appinfo['component']) {
			case "entry":

				$this->set_category_id($_appinfo['category_id']);
				$categoryinfo = $this->getEntryCategory();
				if ($categoryinfo['ordermail']) {
					array_push($ccs, $categoryinfo['ordermail']);
				}
				break;

			case "htkt":
				if ($store_ordermail) {
					array_push($ccs, $store_ordermail);
				}

/*
$cat = new setDB();
$cat->set_category_id($apps['category_id']);
$ct = $cat->get_category_htkt();
if ($ct['ordermail']) {
array_push($ccs, $ct['ordermail']);
}
 */
				break;

			default:
				if ($store_ordermail) {
					array_push($ccs, $store_ordermail);
				}
				break;
			}

		}

//管理ユーザーのメルアド
		if ($_admin_user_id) {

			$sql = 'SELECT `email` as `email` FROM init_user WHERE id = :id';

			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindValue(':id', (int) $_admin_user_id, PDO::PARAM_INT);
				$res->execute();
			} catch (PDOException $e) {
				throw new Exception("Error Database access", 1);
			}
			$ccinfo = $res->fetch();
			if ($ccinfo['email']) {
				array_push($ccs, $ccinfo['email']);
			}

		}

//ask_categoryのメルアド
		if ($_ask_category_id) {

			$sql = 'SELECT `ordermail` as `ordermail` FROM ask_category WHERE id = :ask_category_id';

			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindValue(':ask_category_id', (int) $_ask_category_id, PDO::PARAM_INT);
				$res->execute();
			} catch (PDOException $e) {
				throw new Exception("Error Database access", 1);
			}
			$ccinfo = $res->fetch();
			if ($ccinfo['ordermail']) {
				array_push($ccs, $ccinfo['ordermail']);
			}

		}

		if (count($ccs)) {
			$ccs = array_unique($ccs);
			$cc = implode(",", $ccs);
		}

		return $cc;
	}

	public function getArchiveAppComedate() {

		$where = [];
		$data = [];

		$sql = <<< HERE
SELECT comedate FROM app

HERE;

		array_push($where, 'category_id = :category_id');
		$data[':category_id'] = $this->_category_id;

		if ($this->_condition['opt_cancelled']) {
			array_push($where, 'IFNULL(cancelled,0) = 0');
		}

		array_push($where, 'comedate > NOW() - INTERVAL 30 DAY ');

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		$sql .= " GROUP BY comedate ";

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error", 1);
		}

		$comedays = $res->fetchAll();
		return $comedays;
	}

	public function getArchiveApp() {
		$data = [];
		$where = [];
		$result = [];

		$sql = <<< HERE
SELECT comedate,YEAR(comedate) as year,MONTH(comedate) as month,DAY(comedate) as day, count(id) as ct
,SUM( TRUNCATE(IFNULL(cancelled,0)/2+0.9,0) ) AS cn FROM app

HERE;

		array_push($where, "component = :component");
		$data[':component'] = COMPONENT;

		if (defined('PART')) {
			array_push($where, "part = :part");
			$data[':part'] = PART;
		}

		array_push($where, "category_id = :category_id");
		$data[':category_id'] = $this->_category_id;

		$sql .= ' WHERE ' . implode(' AND ', $where);

		$sql .= " GROUP BY comedate ORDER BY comedate";

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("Database Error", 1);
		}

// 年月を配列に読み込む
		while ($archive = $res->fetch()) {
			$result['count'][$archive['comedate']] = intval($archive['ct']);
			$result['diff'][$archive['comedate']] = intval($archive['ct']) - intval($archive['cn']);
			$result['archive'][$archive['year']][$archive['month']] += $archive['ct'];
		}

		return $result;
	}

	public function getCountApp() {
		$where = [];

		$sql = <<< HERE
SELECT id FROM app

HERE;

		if ($this->_category_id) {
			array_push($where, "category_id = :category_id");
			$data[':category_id'] = $this->_category_id;
		}

		$sql .= ' WHERE ' . implode(' AND ', $where);

		try {
			$res = $this->_pdo_repl->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception("Database Error", 1);
		}

		$ct = $res->rowCount();
		return $ct;
	}
}
?>