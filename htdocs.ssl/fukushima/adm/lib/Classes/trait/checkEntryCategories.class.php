<?php
trait checkEntryCategories {

	protected $_category_id;
	protected $_category_code;
	protected $_component;
	protected $_archived;
	private $_stock_multi = [];
	private $_post_stock_multi;
	private $_skip_auth_check = null;

	public function set_category_id(int $_category_id) {
		$this->_category_id = $_category_id;
	}

	public function set_category_code(string $_category_code) {
		$this->_category_code = $_category_code;
	}

	public function set_component(string $_component) {
		$this->_component = $_component;
	}

	public function set_archived(int $_archived) {
		$this->_archived = $_archived;
	}

	public function set_post_stock_multi(string $_post_stock_multi = null) {
		$this->_post_stock_multi = $_post_stock_multi;
	}

	public function set_skip_auth_check() {
		$this->_skip_auth_check = 1;
	}

	public function get_category_id() {
		return $this->_category_id;
	}

	public function get_result_category() {
		return $this->_result;
	}

	public function get_method_category() {
		return $this->_method;
	}

	public function get_extras_category() {
		return $this->_extras;
	}

	private function getEntryCategorySimple() {

		$this->_postdata = [];
		$where = [];
		$this->_tbl = 'entry_category';

		$sql = <<< HERE
SELECT c.*,a.entry_count AS entry_count
FROM entry_category AS c
LEFT JOIN (SELECT COUNT(id) AS entry_count,category_id FROM app
 WHERE IFNULL(app.cancelled,0) < 1
AND app.component = :component AND IFNULL(app.archived,0) = 0 GROUP BY category_id FOR UPDATE) AS a ON c.id = a.category_id

HERE;

		if ($this->_category_id) {
			$this->_postdata[':id'] = $this->_category_id;
			array_push($where, "c.id = :id");

		} else if ($this->_category_code) {
			$this->_postdata[':code'] = $this->_category_code;
			array_push($where, "c.code = :code");
		}

		if ($this->_component) {
			$this->_postdata[':component'] = $this->_component;
			array_push($where, "c.component = :component");

			if ($this->_part) {
				$this->_postdata[':part'] = $this->_part;
				array_push($where, "c.part = :part");
			}

		} else if (defined('COMPONENT')) {
			$this->_postdata[':component'] = COMPONENT;
			array_push($where, "c.component = :component");
			if (defined('PART')) {
				$this->_postdata[':part'] = PART;
				array_push($where, "c.part = :part");
			}
		}

		if (!count($this->_postdata)) {
			throw new Exception("no category id or code", 1);
		}

		if ($this->_postdata[':component'] == 'entry' || $this->_postdata[':component'] == 'reserve') {
			if (!$this->_postdata[':id'] && !$this->_postdata[':code']) {
				throw new Exception("no category id or code", 1);
			}
		}

/*
if (!$this->_archived) {
}
 */

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

		$sql .= " FOR UPDATE \n";

		$this->_sql = $sql;
		$category = $this->selectTable();

		if (!count($category)) {
			throw new Exception("no category setting", 1);
		}

		if (!$category['id']) {
			throw new Exception("設定が見つかりません", 1);
		}

		$category['method'] = json_decode($category['method'], true);

		return $category;

	}

	public function getEntryCategory() {

		$category = $this->getEntryCategorySimple();
//		var_dump($category['method']['extra']);

		$category = $this->calcCategoryMethod($category);
/*
if (count($category['method'])) {

foreach ($category['method'] as $key => $value) {

if ($key != 'extra') {
if (CURRENT === "app" || $this->_skip_auth_check) {
if (!$value['use']) {continue;}
}
$_method[$key] = $value['sort'];
switch ($value['use']) {
case '1':
$_fields['all'][$key] = 1;
break;
case '2':
$_fields['all'][$key] = 1;
$_fields['must'][$key] = 1;
break;
}
} else {
foreach ($value as $k => $v) {
if (CURRENT === "app" || $this->_skip_auth_check) {
if (!$v['use']) {continue;}
}
$_method[$key . $k] = $v['sort'];
switch ($v['use']) {
case '1':
$_fields['all'][$key][$k] = 1;
break;
case '2':
$_fields['all'][$key][$k] = 1;
$_fields['must'][$key][$k] = 1;
break;
}
}
}
}
asort($_method);

while (list($key, $value) = each($_method)) {
$_result .= "sort_" . $key . ",";
if (preg_match('/^extra/', $key)) {
$k = intval(substr($key, 5));
$_extras[$key]['k'] = $k;

if ($category['method']['extra'][$k]['select']) {

$select = trim($category['method']['extra'][$k]['select']);
$select = preg_replace('/\n|\r\n/', "\n", $select);

$_extras[$key]['list'] = explode("\n", $select);
}
}

}
 */

		if ($category['method']['agree']['use']) {
			$category['method']['agree']['note_href'] = preg_replace('/(https?|http)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', '<a href="\\1\\2" target="_blank">\\1\\2</a>', $category['method']['agree']['note']);
		}

		if (!$this->_category_id) {
			$this->_category_id = $category['id'];
		}

		if ($category['date_limit']) {
			if (time() > strtotime($category['date_limit'])) {
				$category['status'] = -9;
			} else if (time() <= strtotime($category['date_start'])) {
				$category['status'] = 0;
			} else {
				$category['status'] = 1;
			}
		}

		$category['stock_multi'] = json_decode($category['stock_multi'], true);

		if ($category['select_time']) {
			$category['select_time'] = json_decode($category['select_time'], true);
			$category['select_time'] = implode("\n", $category['select_time']);
		}
		if ($category['js']) {
			$category['js'] = stripcslashes($category['js']);
		}

		if ($category['description_web']) {
			$category['description_web'] = stripslashes($category['description_web']);
			$category['description_web'] = htmlspecialchars_decode($category['description_web']);
		}

		if ($category['description']) {
			$category['description'] = stripslashes($category['description']);
		}

		if ($category['description_closed']) {
			$category['description_closed'] = stripslashes($category['description_closed']);
			$category['description_closed'] = htmlspecialchars_decode($category['description_closed']);
		}

		return $category;
	}

	private function calcCategoryMethod($_category) {

		$_method = [];
		$_result = "";

		$_fields = ['all' => [], 'must' => []];

		if (count($_category['method'])) {

			foreach ($_category['method'] as $key => $value) {

				if ($key != 'extra') {
					if (CURRENT === "app" || $this->_skip_auth_check) {
						if (!$value['use']) {
							unset($_fields['all'][$key]);
							unset($_fields['must'][$key]);
							continue;
						}
					}
					$_method[$key] = $value['sort'];
					switch ($value['use']) {
					case '0':
						unset($_fields['all'][$key]);
						unset($_fields['must'][$key]);
						break;
					case '1':
						$_fields['all'][$key] = 1;
						unset($_fields['must'][$key]);
						break;
					case '2':
						$_fields['all'][$key] = 1;
						$_fields['must'][$key] = 1;
						break;
					}
				} else {
					foreach ($value as $k => $v) {
						if (CURRENT === "app" || $this->_skip_auth_check) {
							if (!$v['use']) {
								unset($_fields['all'][$key][$k]);
								unset($_fields['must'][$key][$k]);
								continue;
							}
						}
						$_method[$key . $k] = $v['sort'];
						switch ($v['use']) {
						case '0':
							unset($_fields['all'][$key][$k]);
							unset($_fields['must'][$key][$k]);
							break;
						case '1':
							$_fields['all'][$key][$k] = 1;
							unset($_fields['must'][$key][$k]);
							break;
						case '2':
							$_fields['all'][$key][$k] = 1;
							$_fields['must'][$key][$k] = 1;
							break;
						}
					}
				}
			}
			asort($_method);

			while (list($key, $value) = each($_method)) {
				$_result .= "sort_" . $key . ",";
				if (preg_match('/^extra/', $key)) {
					$k = intval(substr($key, 5));
					$_extras[$key]['k'] = $k;

					if ($_category['method']['extra'][$k]['select']) {

						$select = trim($_category['method']['extra'][$k]['select']);
						$select = preg_replace('/\n|\r\n/', "\n", $select);

						$_extras[$key]['list'] = explode("\n", $select);
					}
				}

			}

			if (!$this->_skip_auth_check) {
				if (CURRENT == 'app') {
					if (!$this->_auth->checkAuth()) {
						$_category['method']['email']['use'] = 2;
						$_fields['all']['email'] = 1;
						$_fields['must']['email'] = 1;
					}
				}
			}

			$this->_method = $_method;
			$this->_result = $_result;
			$this->_extras = $_extras;

			$_category['fields'] = $_fields;

			return $_category;

		}

	}

	public function checkWorkigEntryCategory(array $_category = null) {

		if (is_null($_category)) {
			$_category = $this->getEntryCategory();
		}

		switch ($_category['onstock']) {
		case 1:

			if ($this->_skip_auth_check) {
				break;
			}

			if ($_category['stock'] <= $_category['entry_count']) {
				throw new Exception("お申込みは予定数に達しました(1)。", 1);
			}
			break;
		case 2:
			$this->get_multi_stock_count();

			$app_count_stat = $this->app_count_state_multi();

			HTTP_Session2::set('stock_multi', $this->get_multi_stock());
			$this->_smarty->assign('stock_multi', $this->get_multi_stock());

			if ($this->_skip_auth_check) {
				break;
			}

			if ($app_count_stat < 1) {
				throw new Exception("お申込みは予定数に達しました(2)。", 1);
			} else if ($app_count_stat == 9) {

				$this->_input_error['stock_multi'] = 1;
				$this->_input_error['stock_multi_over'] = 1;
				$this->_smarty->assign('error', $this->_input_error);
				throw new Exception("選択された項目は予定数に達しました。", 9);
			}
			break;
		}

		if ($this->_skip_auth_check) {
			return;
		}
		if ($_category['date_limit']) {
			if (time() > strtotime($_category['date_limit'])) {
				$this->_smarty->assign('closed', 1);
				throw new Exception("お申込みは終了しました。", 1);

			} else if (time() <= strtotime($_category['date_start'])) {
				throw new Exception('お申込みは' . $_category['date_start'] . 'より開始します。', 1);
			}
		}

		if ($_category['authorization']) {
			if ($_category['onduplicate'] == 1) {
				$this->checkDuplicateApp();
			} else if ($_category['onduplicate'] == 9) {
				$this->checkDuplicateComedateApp();
			}
		}
	}

	public function get_multi_stock_count() {

		$data = [];
		$where = [];
		$this->_tbl = 'entry_category';

		$sql = <<< HERE
SELECT c.*,
COUNT(a.id) AS entry_count,
a.stock_multi AS app_stock_multi

FROM entry_category AS c
LEFT JOIN (SELECT id,category_id,archived,stock_multi FROM app
 WHERE IFNULL(app.cancelled,0) < 1
AND app.component = "entry" AND IFNULL(app.archived,0) = 0) AS a ON c.id = a.category_id

HERE;

		if ($this->_category_id) {
			$data = [':id' => $this->_category_id];
			array_push($where, "c.id = :id");

		} else if ($this->_category_code) {
			$data = [':code' => $this->_category_code];
			array_push($where, "c.code = :code");
		}

		if (!count($data)) {
			throw new Exception("no category id or code", 1);
		}

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

		$sql .= " GROUP BY a.stock_multi" . "\n";

		$sql .= " FOR UPDATE \n";

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error" . $e->getMessage(), 1);
		}

		while ($result = $res->fetch()) {

			$sm = $result['stock_multi'];
			$rr[$result['app_stock_multi']] = intval($result['entry_count']);
		}

		if ($sm) {
			$r = json_decode($sm, true);
			$tmp = explode("\n", trim($r['select']));

			return $this->calc_multi_stock_count($tmp, $rr);
		}

	}

	public function get_multi_stock() {
		return $this->_stock_multi;
	}

	private function calc_multi_stock_count($tmp, $rr) {
		if (count($tmp)) {
			foreach ($tmp as $t) {
				$tm = explode(",", $t);
				$stock_multi[trim($tm[0])] = ["stock" => intval($tm[1])];
			}
		}

		if (count($stock_multi)) {
			foreach ($stock_multi as $k => $v) {
				$stock_multi[$k]['ct'] = intval($rr[$k]);
				$stock_multi[$k]['diff'] = $v['stock'] - intval($rr[$k]);
			}
		}
		$this->_stock_multi = $stock_multi;

	}

	public function app_count_state_multi() {
		$stock_multi = $this->_stock_multi;

		if (count($stock_multi)) {
			$n = null;

			foreach ($stock_multi as $v) {
				if ($v['diff'] > 0) {
					$n = 1;
					break;
				} else if ($v['diff'] == 0) {
					$n = 0;
				} else {
					$n = -1;
				}
			}

			if ($n == 1) {
				if ($this->_post_stock_multi) {
					if ($stock_multi[$this->_post_stock_multi]['diff'] < 1) {
						$n = 9;
					}
				}
			}
			return $n;
		}

	}

}
?>