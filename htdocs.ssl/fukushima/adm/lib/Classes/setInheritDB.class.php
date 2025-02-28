<?php
class setInheritDB extends setDB {
	public function __construct() {
		parent::__construct();
	}

	public function __destruct() { /* デストラクタ */}

//登録ユーザーの重複チェック

	private function checkUser() {

		$sql = <<< HERE
SELECT COUNT(`username`) as ct
FROM regist WHERE (`username` = :username || `email` = :email) AND `status` = 1

HERE;

		$data = $this->get_postdata();

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute(array(":username" => $data['username'], ":email" => $data['email']));
		} catch (PDOException $e) {
			$err['title'] = 'エラー';
			$err['msg'] = 'データベース処理が正しく行われませんでした。';
			$result = array('username' => $postdata['username'], 'result' => 10);
			$this->jsonResult($result);
		}

		$rd = $res->fetch();
		if ($rd['ct'] > 0) {
			return 1;
		}

		return 0;
	}

	public function inheritUser() {

		$postdata = $this->_postdata;

		if ($this->checkUser()) {
			$err['title'] = 'エラー';
			$err['msg'] = 'すでにユーザー登録されています。';
			$result = array('username' => $postdata['username'], 'result' => -9);
			$this->jsonResult($result);
			exit();
		}

		$vars = $this->_vars;

		$fields_raw = array();
		foreach ($vars as $k => $f) {
			$fields_raw += $f;
		}

//fields_raw追加
		$fields_raw['addresss'] = "text";
		$fields_raw['new_addresss'] = "text";
		$fields_raw['new_add'] = "integer";
		$fields_raw['phonenumber'] = "text";
		$fields_raw['mobilephone'] = "text";
		$fields_raw['birthday'] = "intger";
		$fields_raw['highschool'] = "text";
		$fields_raw['year'] = "intger";
		$fields_raw['rank'] = "intger";
		$fields_raw['pass'] = "intger";
		$fields_raw['examnumber'] = "text";
		$fields_raw['major'] = "text";

		$fields_raw['rc_se'] = "intger";
		$fields_raw['rc_sem'] = "intger";
		$fields_raw['rc_pe'] = "intger";
		$fields_raw['rc_pem'] = "intger";

		$fields_raw['parent_email'] = "text";
		$fields_raw['parent_email_mobile'] = "text";
		$fields_raw['parent_mobile'] = "text";
		$fields_raw['parent_com'] = "text";
		$fields_raw['parent_com_phone'] = "text";

//保護者データ微調整

		if ($postdata['parentnamef']) {
			$postdata['parent_namef'] = $postdata['parentnamef'];
			$postdata['parent_nameg'] = $postdata['parentnameg'];
			$postdata['parent_kanaf'] = $postdata['parentkanaf'];
			$postdata['parent_kanag'] = $postdata['parentkanag'];
		}

		$fields = array();
		foreach ($postdata as $key => $value) {
			if ($fields_raw[$key]) {
				$fields[$key] = $fields_raw[$key];
			}
		}

		$postdata['regist_date'] = date("Y-m-d H:i:s");
		$postdata['remote_addr'] = $_SERVER['REMOTE_ADDR'];
		$postdata['remote_host'] = $_SERVER['REMOTE_HOST'];
		$postdata['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

		$fields['regist_date'] = 'text';
		$fields['remote_host'] = 'text';
		$fields['remote_addr'] = 'text';
		$fields['user_agent'] = 'text';

		$fields['username'] = 'text';
		$fields['password'] = 'text';
		$fields['univ_id'] = 'integer';
		$fields['status'] = 'integer';
		$fields['tmp_update_password'] = 'integer';
		$fields['inherit'] = 'integer';

		$postdata['tmp_update_password'] = 1;
		$postdata['inherit'] = 1;
		unset($postdata['date']);
		unset($postdata['id']);

		try {
			$this->set_postdata($postdata);
			$this->set_fields($fields);
			$this->set_tbl('regist');
			$this->insertTable();
			$result = array('username' => $postdata['username'], 'result' => 1);
			$this->jsonResult($result);
		} catch (Exception $e) {
			$result = array('username' => $postdata['username'], 'result' => 10);
			$this->jsonResult($result);
		}
		return;
	}

	public function displayError() {
		throw new Exception('database process error!!');
		return;
	}

	public function jsonResult($e) {
		if ($this->_transaction) {
			throw new Exception('return rollBack!!');
			return;
		} else {
			echo json_encode($e);
			exit();
		}
	}

}
?>
