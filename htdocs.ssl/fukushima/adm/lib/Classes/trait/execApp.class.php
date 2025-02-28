<?php
trait execApp {

	protected $_fields_vars = array(

		//step2系

		'exam' => array('exam' => 'integer')
		, 'dept' => array('dept' => 'integer')

		, 'email' => array('email' => 'text', 'emailcfrm' => 'text')

		//step3系
		, 'name' => array('namef' => 'text', 'nameg' => 'text', 'kanaf' => 'text', 'kanag' => 'text')
		, 'new_add' => array('new_zipcodef' => 'integer', 'new_zipcodes' => 'integer', 'new_pref' => 'text', 'new_addressf' => 'text')
		, 'address' => array('zipcodef' => 'integer', 'zipcodes' => 'integer', 'pref' => 'text', 'addressf' => 'text')
		, 'age' => array('birth_year' => 'integer', 'birth_month' => 'integer', 'birth_day' => 'integer', 'age' => 'integer')
		, 'phonenumber' => array('phonenumber1' => 'text', 'phonenumber2' => 'text', 'phonenumber3' => 'text')
		, 'mobilephone' => array('mobilephone1' => 'text', 'mobilephone2' => 'text', 'mobilephone3' => 'text')
		, 'student_phone' => array('student_phone1' => 'text', 'student_phone2' => 'text', 'student_phone3' => 'text')
		, 'student_email' => array('student_email' => 'text', 'student_emailcfrm' => 'text')
		, 'student_email_mobile' => array('student_email_mobile' => 'text', 'student_emailcfrm_mobile' => 'text')
		, 'parent_name' => array('parent_namef' => 'text', 'parent_nameg' => 'text', 'parent_kanaf' => 'text', 'parent_kanag' => 'text')
		, 'parent_email' => array('parent_email' => 'text', 'parent_emailcfrm' => 'text')
		, 'parent_email_mobile' => array('parent_email_mobile' => 'text', 'parent_emailcfrm_mobile' => 'text')
		, 'parent_sex' => array('parent_sex' => 'integer', 'parent_relation' => 'text')
		, 'parent_mobile' => array('parent_mobile1' => 'text', 'parent_mobile2' => 'text', 'parent_mobile3' => 'text')
		, 'parent_com_phone' => array('parent_com_phone1' => 'text', 'parent_com_phone2' => 'text', 'parent_com_phone3' => 'text')
		, 'student_phone' => array('student_phone1' => 'text', 'student_phone2' => 'text', 'student_phone3' => 'text')
		, 'major' => array('major' => 'text')

		, 'number' => array('number' => 'text')
		, 'membership' => array('membership' => 'text')
		, 'sex' => array('sex' => 'integer')

		//app系
		, 'schoolyear' => array('schoolyear' => 'text')
		, 'graduateyear' => array('graduateyear' => 'text')
		, 'bank' => array('bankname' => 'text', 'branch' => 'text', 'code_branch' => 'integer', 'account' => 'integer', 'holder' => 'text', 'holderk' => 'text')
		, 'memo' => array('memo' => 'text')
		, 'agree' => array('agree' => 'text')
		, 'stock_multi' => array('stock_multi' => 'text')

		, 'creditcard' => array('cardnumber1' => "text", 'cardnumber2' => "text", 'cardnumber3' => "text", 'cardnumber4' => "text"
			, 'exp_month' => "integer", 'exp_year' => "integer", 'cvc' => "text", 'holdername' => "text"),

	);

	public function get_fields_sql() {return $this->_fields_sql;}
	public function get_fields_sql_app() {return $this->_fields_sql_app;}

/*
public function set_notes($_notes) {$this->_notes = $_notes;}

public function get_fields_input() {

if (is_null($this->_notes)) {
$this->trans_notes();
}
$notes = $this->_notes;
$fields_vars = $this->_fields_vars;

$fields['all'] = array();
$fields['must'][2] = array();
$fields['free'][2] = array();
$fields['must'][3] = array();
$fields['free'][3] = array();
$fields['must'][4] = array();
$fields['free'][4] = array();

$fields_sql = array();
$fields_sql_app = array();
if (count($notes)) {
foreach ($notes as $k => $n) {
foreach ($n as $key => $value) {

switch ($key) {
case "address":
$fields['free'][$k] += array('addresss' => 'text', 'addresst' => 'text');
break;
case "new_add":
$fields['free'][$k] += array('new_add' => 'integer', 'new_addresss' => 'text', 'new_addresst' => 'text');
break;
case "ship":
$fields['free'][$k] += array('ship_addresss' => 'text', 'ship_addresst' => 'text');
break;
}

if ($value < 2) {
$fields['free'][$k] += $fields_vars[$key];
} else {
$fields['must'][$k] += $fields_vars[$key];
}
//					$fields['all'] += $fields_vars[$key];
if ($key == 'age') {
$fields_sql += array('birthday' => 'text');
} else if ($key == 'phonenumber' || $key == 'mobilephone' || $key == 'parent_com_phone' || $key == 'parent_mobile' || $key == 'student_phone') {
$fields_sql += array($key => 'text');
} else if (preg_match('/email/', $key)) {
$fields_sql += array($key => 'text');
} else if (preg_match('/^address/', $key)) {
$fields_sql += $fields_vars[$key];
$fields_sql += array('addresss' => 'text', 'addresst' => 'text');
} else if (preg_match('/^new_add/', $key)) {
$fields_sql += $fields_vars[$key];
$fields_sql += array('new_add' => 'integer', 'new_addresss' => 'text', 'new_addresst' => 'text');
} else {
switch ($k) {
case 2:
$fields_sql += $fields_vars[$key];
break;
case 3:
$fields_sql += $fields_vars[$key];
break;
case 4:
$fields_sql_app += $fields_vars[$key];
break;
}
}

}

}
$fields['all'] = array_merge($fields['must'][2], $fields['free'][2], $fields['must'][3], $fields['free'][3]);
$fields['app'] = array_merge($fields['must'][4], $fields['free'][4], $fields['must'][4], $fields['free'][4]);

$this->_fields_sql = $fields_sql;
$this->_fields_sql_app = $fields_sql_app;
return $fields;
}
}

private function trans_notes() {
$methods = $this->_methods;
if (!is_array($methods)) {return;}

$meth = array();
foreach ($methods as $m => $v) {
if ($v['use'] < 1) {continue;}
if ($m == "extra") {continue;}
if ($m == "exam" || $m == "dept") {
$meth[2][$m] = $v['use'];
} else if ($m == "schoolyear" || $m == "bank" || $m == "memo" || $m == "agree"
|| $m == "creditcard" || $m == "stock_multi" || $m == "graduateyear") {
$meth[4][$m] = $v['use'];
} else {
$meth[3][$m] = $v['use'];
}
}

$this->_notes = $meth;
return;
}
 */

	private function getMaxAppCount() {

		$where = [];
		$data = [];

		$where = ['app.component = :component', 'IFNULL(app.archived,0) = 0'];
		$data[':component'] = COMPONENT;

		if (isset($this->_component) && $this->_component) {
			$data[':component'] = $this->_component;
		}

		if (COMPONENT != 'htkt') {
			if ($this->_shopping_category_id) {
				array_push($where, 'app.category_id = :category_id');
				$data[':category_id'] = $this->_shopping_category_id;
			} else if ($this->_postdata['category_id']) {
				array_push($where, 'app.category_id = :category_id');
				$data[':category_id'] = $this->_postdata['category_id'];
			} else {
				if (isset($this->_part) && $this->_part) {
					array_push($where, 'app.part = :part');
					$data[':part'] = $this->_part;
				} else if (defined('PART')) {
					array_push($where, 'app.part = :part');
					$data[':part'] = PART;
				}
			}
		}

		$sql = <<< HERE
SELECT MAX(app_count) AS app_count FROM app

HERE;

		if (count($where)) {
			$sql .= 'WHERE ' . implode(" AND\n", $where);
		}

		$sql .= <<< HERE

FOR UPDATE

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			throw new Exception($e->getMessage(), 1);
		}

		$rr = $res->fetch();
		return $rr['app_count'];
	}

	public function saveApp(array $_fields) {

		if ($this->_postdata['app_id']) {
			$this->updateApp($_fields);
		} else {
			$this->saveAppNew($_fields);
		}

	}

	private function saveAppNew(array $_fields) {

		if (!$this->_skip_app_count) {
			$this->_postdata['app_count'] = $this->getMaxAppCount() + 1;
		}
//環境変数をセット
		$this->_postdata['remote_addr'] = getenv('REMOTE_ADDR');
		$this->_postdata['remote_host'] = getenv('REMOTE_HOST');
		$this->_postdata['user_agent'] = getenv('HTTP_USER_AGENT');
//投稿日時を取得
		$this->_postdata['regist_date'] = date('Y-m-d H:i:s');

		if (!$this->_skip_code) {
			$this->_postdata['code'] = self::generateUuid();
		}
		$_fields['regist_id'] = 'integer';

		$_fields['remote_addr'] = 'text';
		$_fields['remote_host'] = 'text';
		$_fields['user_agent'] = 'text';
		$_fields['regist_date'] = 'text';

		$_fields['app_count'] = 'integer';
		$_fields['code'] = 'text';

		$this->set_fields($_fields);
		$this->set_tbl('app');
		$this->insertTable();

	}

	public function changeStatusApp() {

		$appinfo = $this->getAppInfo();

		$_fields = [
			'treat' => 'text',
			'status' => 'integer',
		];

		if (isset($_POST['sendmail_paid_completed'])) {
			$_fields['sendmail_paid_completed'] = "integer";
		}

		if (isset($_POST['sendmail_nopaid'])) {
			$_fields['sendmail_nopaid'] = "integer";
		}

		if (isset($_POST['date_cancelled'])) {
			$_fields['date_cancelled'] = "text";
		}
		if (isset($_POST['price_cancelled'])) {
			$_fields['price_cancelled'] = "integer";
		}
		if (isset($_POST['note_cancelled'])) {
			$_fields['note_cancelled'] = "text";
		}

		$postdata = $this->execSanitize($_fields, []);

		$this->set_postdata($postdata);
		$this->updateApp($_fields);

		if ($appinfo['component'] == "shopping") {
			if ($postdata['status'] == 9) {
				if (abs($appinfo['status']) < 9) {
					$this->createCalcItems();
					$this->execAppItemStock(-1);
				}
			} else if (abs($appinfo['status']) == 9) {
				if ($postdata['status'] < 9) {

					$this->createCalcItems();
					$this->execAppItemStock(1);
				}
			}
		}

		$logdata['app_id'] = $this->_app_id;
		$logdata['process'] = 'change_app_status_' . COMPONENT;
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	private function updateApp(array $_fields) {

		if ($this->_app_id) {
			$this->_postdata['id'] = $this->_app_id;
		} else {
			$this->_postdata['id'] = $this->_postdata['app_id'];
		}

		if (!$this->_postdata['id']) {
			throw new Exception("パラーメータが不正です。", 1);
		}

		if ($_fields['extra']) {
			if (is_array($this->_postdata['extra'])) {
				$this->_postdata['extra'] = json_encode($this->_postdata['extra']);
			}
		}

		$this->set_fields($_fields);
		$this->set_tbl('app');
		$this->set_where(['id' => 'integer']);
		$this->updateTable();

	}

	public function saveArchived() {
		$data = [];
		$where = [];
		$this->_condition;

//SELECT

		$sql = <<< HERE
UPDATE app AS a SET a.`archived` = 1

HERE;

		array_push($where, 'a.component = :component');
		$data[':component'] = COMPONENT;

		if ($this->_condition['term1']) {
			array_push($where, 'a.regist_date >= :term1');
			$data[':term1'] = $this->_condition['term1'];
		}
		if ($this->_condition['term2']) {
			array_push($where, 'a.regist_date - INTERVAL 1 DAY < :term2');
			$data[':term2'] = $this->_condition['term2'];
		}

		if ($this->_condition['category_id']) {
			array_push($where, 'a.category_id = :category_id');
			$data[':category_id'] = $this->_condition['category_id'];
		}

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute($data);

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			throw new Exception("Database Error", 1);
		}

		$logdata['process'] = 'archived_app_' . COMPONENT;
		$logdata['value'] = json_encode($this->_condition);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

		return;

	}

	public function deleteApp() {

		if (!$this->_app_id) {
			throw new Exception("No app_id", 1);
		}

		$appinfo = $this->getAppInfo();

		$postdata = ['id' => $this->_app_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('app');
		$this->deleteTable();

//component check

		if ($appinfo['component'] == "reserve") {
			$this->set_category_id($appinfo['category_id']);
			$this->set_component($appinfo['component']);
			$this->set_comedate($appinfo['comedate']);
			$this->set_cometime($appinfo['cometime']);

			$this->updateSelectTime();
		}

		$logdata['process'] = 'delete_app_' . COMPONENT;
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	private function setStockLogData($_logdata) {

		if (!isset($_logdata['item_id'])) {
			throw new Exception("No item_id", 1);
		}
		if (!$_logdata['item_id']) {
			throw new Exception("No item_id", 1);
		}

		$_logdata['auth_username'] = "webhook";

		if (isset($this->_adminAuth) && is_object($this->_adminAuth)) {
			$_logdata['auth_username'] = $this->_adminAuth->getUsername();
		}
		$this->_stock_logdata = $_logdata;
	}

	private function addStockLog() {

		if (!isset($this->_stock_logdata)) {
			throw new Exception("No logdata", 1);
		}

		$fields = [
			'num' => 'integer',
			'item_id' => 'integer',
			'auth_username' => 'text',
		];

		if (isset($this->_stock_logdata['app_id'])) {
			$fields['app_id'] = 'integer';
			if (isset($this->_stock_logdata['regist_code'])) {
				$fields['regist_code'] = 'text';
			}
		}

		$this->_tbl = 'stock_log';
		$this->set_fields($fields);
		$this->set_postdata($this->_stock_logdata);
		$this->insertTable();
	}

}
?>