<?php
class adminMasterDB extends commonDB {

	use adminAuth;
	use baseFunction;
	use execAdminLog;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	protected $_univ_id;
	protected $_code_id;
	protected $_name;
	protected $_myself;

	public function get_univ_id() {return $this->_univ_id;}
	public function get_code_id() {return $this->_code_id;}
	public function get_name() {return $this->_name;}
	public function get_edit_auth_user_id() {return $this->_edit_auth_user_id;}

	public function set_auth_user_myself() {return $this->_myself = 1;}

	public function saveCode() {

		$fields_sql_code = [
			'univ_id' => 'integer',
			'name' => 'text',
			'number' => 'integer',
			'value' => 'text',
			'member' => 'integer',
			'flag' => 'integer',
			'sort_order' => 'integer',
		];

		$this->_simple_name = 1;
		$this->_postdata = $this->baseSanitize($fields_sql_code, []);

		if (!$this->_postdata['univ_id']) {
			throw new Exception("パラメーターが不正です。", 1);
		}

		if ($_POST['id']) {
			$this->_postdata['id'] = intval($_POST['id']);
		}

		$this->set_fields($fields_sql_code);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl('init_code');

		if ($this->_postdata['id']) {
			$this->updateTable();
		}
// 既存コードの場合
		else {
			$this->insertTable();
			$this->_postdata['id'] = $this->get_last_insertId();
		}

		if (!$this->_postdata['id']) {
			throw new Exception("データの処理に失敗しました。", 1);
		}

		$this->_univ_id = $this->_postdata['univ_id'];
		$this->_code_id = $this->_postdata['id'];
		$this->_name = $this->_postdata['name'];

		$logdata['process'] = 'save_code';
		$logdata['value'] = $this->_code_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteCode() {
		$this->_postdata['id'] = intval($_POST['id']);
		$this->_univ_id = intval($_POST['univ_id']);

		if (!$this->_postdata['id']) {
			throw new Exception("パラメーターが不正です。", 1);
		} else if (!$this->_univ_id) {
			throw new Exception("パラメーターが不正です。", 1);
		}

		$this->_where = ['id' => 'integer'];
		$this->_tbl = 'init_code';
		$this->deleteTable();

		$logdata['process'] = 'delete_code';
		$logdata['value'] = $this->_postdata['id'];

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function saveAdminUser() {

		$fields_sql_admin_user = [
			'email' => 'text',
		];

		$this->_postdata = $this->baseSanitize($fields_sql_admin_user, []);

		if (isset($_POST['id'])) {
			$this->_postdata['id'] = intval($_POST['id']);
		} else {
			$this->_postdata['username'] = addslashes($_POST['username']);

			$this->_postdata['password'] = addslashes($_POST['password_new']);

			if ($this->_postdata['password'] != $_POST['password_cfrm']) {
				throw new Exception("パスワードが正しく入力されていません。", 1);
			}

			$this->_postdata['password'] = password_hash($this->_postdata['password'], PASSWORD_DEFAULT);

			$fields_sql_admin_user['username'] = 'text';
			$fields_sql_admin_user['password'] = 'text';
		}

		$authList = $this->_smarty->getTemplatevars('authList');
		$subAuthList = $this->_smarty->getTemplatevars('subAuthList');

		foreach ($authList as $k => $v) {
			if (!isset($this->_authority[$k][0]) || $this->_authority[$k][0] != 9) {
				unset($authList[$k]);
			}
		}

		foreach ($authList as $k => $v) {

//shoppingと汎用エントリカテゴリ権限の調整

			foreach (['shopping', 'entry', 'reserve'] as $key) {
				if ($k == $key) {

					$postdata[$k]['category_id'] = [];
					if (isset($_POST[$k]['category_id']) && is_array($_POST[$k]['category_id'])) {
						$postdata[$k]['category_id'] = array_map("intval", $_POST[$k]['category_id']);
					}
				}
			}

			$postdata[$k][0] = intval($_POST[$k][0]);

		}

		$this->_postdata['auth'] = json_encode($postdata);
		$fields_sql_admin_user['auth'] = 'text';

		if ($this->_myself == 1) {
			$this->_edit_auth_user_id = $this->_postdata['id'];
			$this->checkAdminAuthMyself();
			unset($fields_sql_admin_user['auth']);
		}

		$this->set_fields($fields_sql_admin_user);
		$this->set_tbl('init_user');
		$this->set_where(['id' => 'integer']);

		if ($this->_postdata['id']) {
			$this->updateTable();
		} else {
			$this->insertTable();
			$this->_postdata['id'] = $this->get_last_insertId();
		}

		if ($this->_myself == 1) {
			foreach ($fields_sql_admin_user as $k => $v) {
				$this->_adminAuth->setAuthData($k, $this->_postdata[$k]);
			}
		}

		$logdata['process'] = 'save_user';
		$logdata['value'] = $this->_postdata['id'];

		$this->_edit_auth_user_id = $this->_postdata['id'];

		$this->set_postdata($logdata);
		$this->saveAdminLog();
	}

	public function saveAdminPassword() {
		$fields_admin_password = [
			'password_new' => 'text',
			'password_cfrm' => 'text',
			'id' => 'integer',
		];

		$fields_sql_admin_password = [
			'password' => 'text',
		];

		$this->_postdata = $this->baseSanitize($fields_admin_password, []);

		if (!$this->_postdata['id']) {
			throw new Exception("パラメータが不正です", 1);
		} else if ($this->_postdata['password_new'] != $this->_postdata['password_cfrm']) {
			throw new Exception("パスワードが正しく入力されていません。", 1);
		}

		$this->_edit_auth_user_id = $this->_postdata['id'];
		$this->checkAdminUserAuth();

		if ($this->_myself == 1) {
			$this->checkAdminAuthMyself();
		}

// パスワードの書き換え

		$this->_postdata['password'] = password_hash($this->_postdata['password_new'], PASSWORD_DEFAULT);

		$this->set_fields($fields_sql_admin_password);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl('init_user');
		$this->updateTable();

		$logdata['process'] = 'save_admin_password';

		if ($this->_myself == 1) {
			$logdata['process'] = 'save_myself_password';
		}

		$logdata['value'] = $this->_postdata['id'];

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteAdminUser() {
		$this->_postdata['id'] = intval($_POST['id']);
		$this->_edit_auth_user_id = $this->_postdata['id'];
		$this->checkAdminUserAuth();

		$this->_where = ['id' => 'integer'];
		$this->_tbl = 'init_user';
		$this->deleteTable();

		$logdata['process'] = 'delete_admin_user';
		$logdata['value'] = $this->_edit_auth_user_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	private function checkAdminAuthMyself() {

		if ($this->_adminAuth->getAuthData('id') != $this->_edit_auth_user_id) {
			throw new Exception("不正な操作です。", 1);
		}

	}

	public function checkAdminUserAuth() {

		if (!$this->_edit_auth_user_id) {
			throw new Exception("権限チェックに失敗しました。", 1);
		}

	}

	public function validAdminUser() {

/* RECEIVE VALUE */
		$validateValue = addslashes($_REQUEST['fieldValue']);
		$validateId = addslashes($_REQUEST['fieldId']);

		$sql = "SELECT username FROM init_user WHERE username = :username ";

		$data[':username'] = $validateValue;

		$this->_sql = $sql;
		$this->set_postdata($data);
		$this->_rowcount = 1;
		$ct = $this->selectTable();

/* RETURN VALUE */
		$arrayToJs = [];
		$arrayToJs[0] = $validateId;

		$arrayToJs[1] = false;

// 一致するものがない場合
		if ($ct == 0) {
			$arrayToJs[1] = true; // RETURN TRUE
		}

		return $arrayToJs;
	}

	public function saveSiteSetting() {

		$fields_sql_payment_code = [
			'inherit' => 'integer',
		];

		$postdata = $this->baseSanitize($fields_sql_payment_code, []);

		$_SESSION['config']['inherit'] = $postdata['inherit'];
		$postdata['univ_id'] = $_SESSION['config']['univ_id'];

		$this->_tbl = 'init_config';
		$this->_fields = $fields_sql_payment_code;
		$this->_where = ['univ_id' => 'integer'];
		$this->_postdata = $postdata;

		$logdata['process'] = 'save_site_setting';
		$logdata['value'] = $postdata['inherit'];

		$this->set_postdata($logdata);
		$this->saveAdminLog();
	}

	public function resetAdminUserSecret() {
		$this->_postdata = [];
		$this->_postdata['id'] = intval($_POST['user_id']);
		$this->_postdata['secret'] = "";
		$this->_edit_auth_user_id = $this->_postdata['id'];

		if ($this->_myself == 1) {
			$this->checkAdminAuthMyself();
		} else {
			$this->checkAdminUserAuth();
		}

		$this->_where = ['id' => 'integer'];
		$this->_fields = ['secret' => 'text'];
		$this->_tbl = 'init_user';
		$this->updateTable();

		$logdata['process'] = 'reset_admin_user_secret';
		if ($this->_myself == 1) {
			$logdata['process'] = 'reset_admin_myself_secret';
		}
		$logdata['value'] = $this->_edit_auth_user_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

		if ($this->_myself == 1) {
			$this->_adminAuth->setAuthData('secret', '');
		}

	}

}
