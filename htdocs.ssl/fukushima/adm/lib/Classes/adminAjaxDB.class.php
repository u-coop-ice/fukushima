<?php
class adminAjaxDB extends commonDB {

	use adminAuth;
	use baseFunction;
	use baseApp;
	use checkEntryCategories;
	use execEntryCalendar;
	use checkRegist;
	use checkApp;
	use execRegist;
	use execApp;
	use execLog;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function searchRegists() {

		$data = [];
		$where = [];

		$search = strip_tags(trim($_REQUEST['term']));
		if (!$search) {
			return;
		}

		if ($search) {
			$search = preg_replace('/　/', ' ', $search);
			$search = mb_convert_kana($search, "a");
			$search = preg_replace('/\s+/', ' ', $search);
			$words = explode(' ', $search);
			foreach ($words as $word) {
				array_push($data, '%' . $word . '%', '%' . $word . '%', '%' . $word . '%', '%' . $word . '%', '%' . $word . '%');
				array_push($where, " (r.namef LIKE ? OR r.nameg LIKE ? OR r.kanaf LIKE ? OR r.kanag LIKE ? OR r.username LIKE ?) ");
			}
		}

		$sql = <<< HERE
SELECT r.* FROM regist AS r

HERE;

		array_push($where, 'r.status = 1');

		if (count($where)) {
			$sql .= " WHERE " . implode(" \nAND ", $where) . "\n";
		}

		$this->_sql = $sql;
		$this->_postdata = $data;
		$this->_fetchall = 1;
		$regists = $this->selectTable();
		return $regists;
	}

	public function correctApp() {

		if (!$this->_category_id) {
			throw new Exception("パラメーターが不正です", 1);
		}
		if (!$this->_app_id) {
			throw new Exception("パラメーターが不正です", 1);
		}

		$appinfo = $this->getAppInfo();
		if (!$appinfo['component']) {
			throw new Exception("パラメーターが不正です", 1);
		}
		$this->set_component($appinfo['component']);

		$category = $this->getEntryCategory();

		$postdata = $this->execSanitize((array) $category['fields']['all'], (array) $category['fields']['must']);

		$fields_sql = $this->get_fields_sql();
		$fields_sql_app = $this->get_fields_sql_app();

		unset($fields_sql['emailcfrm']);
		unset($fields_sql['name']);

		$fields_sql_app['extra'] = 'text';
		$postdata['extra'] = json_encode($postdata['extra']);

		try {

//トランザクション開始

			$this->_pdo->query("SET innodb_lock_wait_timeout=30;");
			$this->_pdo->beginTransaction();

			$postdata['regist_id'] = $this->_regist_id;
			$postdata['app_id'] = $this->_app_id;

			$this->set_postdata($postdata);

			$this->saveRegist($fields_sql);

			$this->saveApp($fields_sql_app);

//ログの書き込み
			$logdata['process'] = "update_app";
			$logdata['kind'] = "update_app";
			$logdata['component'] = COMPONENT;
			$logdata['target_id'] = $this->_app_id;
			$logdata['value'] = json_encode($postdata);
			$logdata['username'] = $this->_adminAuth->getUsername();
			$logdata['auth_username'] = $this->_adminAuth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();

			$this->_pdo->commit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function setAppFields() {

		$this->set_skip_auth_check();
		$appinfo = $this->getAppInfo();

		$this->set_regist_id($appinfo['regist_id']);
		$registinfo = $this->getRegistInfo();

		$this->set_category_id($appinfo['category_id']);
		$category = $this->getEntryCategory();
		$this->checkWorkigEntryCategory();

		$this->_smarty->assign("methods", $category['method']); //項目のテンプレート発行

		$method = $this->get_method_category();
		$stock_multi = $this->get_multi_stock();

		foreach ($this->_fields_extension_app as $f => $fields) {
			foreach ($fields as $field => $value) {
				$registinfo[$field] = $appinfo[$field];
			}
		}

		if (is_array($appinfo['extra'])) {
			$registinfo['extra'] = $appinfo['extra'];
		}

		$registinfo['app_id'] = $this->_app_id;
		$registinfo['regist_id'] = $this->_regist_id;
		$registinfo['category_id'] = $appinfo['category_id'];

		$this->_smarty->assign('post', $registinfo);
		$this->_smarty->assign("methods", $category['method']); //項目のテンプレート発行

		$this->_smarty->assign('stock_multi', $stock_multi);

		$pp = "post_";

		while (list($key, $value) = each($this->_method)) {
			if (!preg_match('/^extra/', $key)) {
				$html .= $this->_smarty->fetch($pp . $key . '.tpl');
			} else {
				$k = intval(substr($key, 5));
				$this->_smarty->assign('k', $k);
				$extraList[$k] = [];
				if ($category['method']['extra'][$k]['select']) {
					$select = trim($category['method']['extra'][$k]['select']);
					$select = preg_replace('/\n|\r\n/', "\n", $select);

					$extraList[$k] = explode("\n", $select);
					if ($k == 0) {
						foreach ($extraList[$k] as $v) {
							$tmp = explode(",", $v);
							$tmps[$tmp[0]] = $tmp[1];
						}
						$extraList[$k] = array_keys($tmps);
					}

				}
				$this->_smarty->assign('extraList', $extraList[$k]);

				$html .= $this->_smarty->fetch($pp . 'extra.tpl');
			}
		}
		$this->_smarty->assign('html', $html);

	}

	public function saveAdminUnsubscribeMail() {

		$unsubscribe_mail = intval($_POST['dm']);

		if (!$this->_regist_id) {
			throw new Exception("regist_id error", 1);
		}
		try {
			$this->_pdo->beginTransaction();

			$changedata = [
				'dm' => $unsubscribe_mail,
				'id' => $this->_regist_id,
			];
			$fields = ['dm' => 'integer'];

			$this->set_postdata($changedata);
			$this->set_fields($fields);
			$this->set_where(['id' => 'integer']);
			$this->set_tbl('regist');
			$this->updateTable();

//ログの書き込み
			$logdata['process'] = "update_unsubscribe_mail";
			$logdata['kind'] = "update_unsubscribe_mail";
			$logdata['component'] = COMPONENT;
			$logdata['target_id'] = null;
			$logdata['value'] = json_encode($changedata);
			$logdata['username'] = $this->_adminAuth->getUsername();
			$logdata['auth_username'] = $this->_adminAuth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();

			$this->_pdo->commit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception('データベースへの処理に失敗しました。', 1);
		}

	}

}
?>
