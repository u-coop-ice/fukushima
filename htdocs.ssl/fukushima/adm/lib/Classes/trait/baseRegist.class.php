<?php
Trait baseRegist {

	protected $_regist_id;

	public function get_regist_id() {
		return $this->_regist_id;
	}

	public function saveBaseRegist($fields, $fields_must) {

		$postdata = $this->execSanitize($fields, $fields_must);
// registのinvalid化
		if ($postdata['status'] == 9) {
			$postdata['username'] = md5($this->_regist_id . COMPONENT . time() . $this->_smarty->getConfigVars('salt'));
			$postdata['password'] = sha1($this->_regist_id . time() . $this->_smarty->getConfigVars('salt') . COMPONENT);

			$this->_fields_sql['username'] = 'text';
			$this->_fields_sql['password'] = 'text';
		}

		try {

			if ($_SESSION['admin_mode']) {
				$postdata['id'] = $this->_regist_id;
			} else if ($_SESSION[$this->_pfx . 'mode']) {
				$postdata['id'] = $this->_auth->getAuthdata('id');
			}

//sqlの調整
			unset($this->_fields_sql['name']);

			$this->set_fields($this->_fields_sql);
			$this->set_where(['id' => 'integer']);
			$this->set_postdata($postdata);
			$this->set_tbl($this->_pfx . 'regist');
			$this->updateTable();

//ログの書き込み
			$logdata['process'] = $this->_kind;
			$logdata['kind'] = $this->_kind;
			$logdata['component'] = COMPONENT;
			$logdata['app_id'] = null;
			$logdata['value'] = json_encode($this->_postdata);
			$logdata['username'] = $this->_auth->getUsername();
			$logdata['auth_username'] = $this->_auth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();

			if ($_SESSION[$this->_pfx . 'mode']) {
				foreach ($postdata as $k => $v) {
					if ($k == 'username' || $k == 'password' || $k == 'ct') {continue;}
					$this->_auth->setAuthData($k, $v);
				}
			}
		} catch (Exception $e) {
			throw new Exception("Database Error,Rollback!! " . $e->getMessage(), 1);
		}

	}

	public function saveBasePassword() {

		$this->_target = "save_password";

		$fields = [
			'password_cur' => 'text',
			'password_new' => 'text',
			'passwordcfrm' => 'text',
		];

		$fields_must = [
			'password_cur' => 'text',
			'password_new' => 'text',
			'passwordcfrm' => 'text',
		];

		$postdata = $this->execSanitize($fields, $fields_must);

		try {
			$this->_postdata = [];
			$this->_postdata['id'] = $this->_auth->getAuthdata('id');
			$this->_postdata['password'] = password_hash($postdata['password_new'], PASSWORD_DEFAULT);

			$this->set_where(['id' => 'integer']);
			$this->set_fields(['password' => 'text']);
			$this->set_tbl($this->_pfx . 'regist');
			$this->updateTable();

//ログの書き込み
			$logdata['process'] = $this->_kind;
			$logdata['kind'] = $this->_kind;
			$logdata['component'] = COMPONENT;
			$logdata['app_id'] = null;
			$logdata['value'] = json_encode($this->_postdata);
			$logdata['username'] = $this->_auth->getUsername();
			$logdata['auth_username'] = $this->_auth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();

		} catch (Exception $e) {
			throw new Exception("Database Error!! " . $e->getMessage(), 1);
		}

	}

	public function saveBaseTmpEmail() {
		$this->_target = "save_tmp_email";

		$fields = [
			'email' => 'text',
		];

		$fields_must = [
			'email' => 'text',
		];

		$postdata = $this->execSanitize($fields, $fields_must);

		$fields = [
			'tmp_email' => 'text',
			'tmp_code' => 'text',
			'tmp_date' => 'text',
		];

		$postdata['tmp_email'] = $postdata['email'];
		$postdata['tmp_code'] = md5(time() . $postdata['email'] . $this->_auth->getUsername() . mt_rand());
		$postdata['tmp_date'] = date('Y-m-d H:i:s');
		$postdata['id'] = $this->_auth->getAuthdata('id');

		$this->_smarty->assign('tmp_code', $postdata['tmp_code']);

		try {
			$this->_pdo->beginTransaction();

			$this->set_fields($fields);
			$this->set_where(['id' => 'integer']);
			$this->set_postdata($postdata);
			$this->set_tbl($this->_pfx . 'regist');
			$this->updateTable();

			$infocode = $this->_smarty->getTemplateVars('infocode');
			$init_pagetitle = $this->_smarty->getTemplateVars('init_pagetitle');

			$init_ordermail = $this->_smarty->getTemplateVars('init_ordermail');
			$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

			$cust_body = $this->_smarty->fetch('change_email.tpl');
			$cust_subject = '登録メールアドレスの変更を承りました';

			$replymail = $_SESSION['config']['donotreply_email'];

//登録メール送信
			self::send_mail($init_coopname, $replymail, $postdata['tmp_email'], $cust_subject, $cust_body);

//ログの書き込み
			$logdata['process'] = $this->_kind;
			$logdata['kind'] = $this->_kind;
			$logdata['component'] = COMPONENT;
			$logdata['app_id'] = null;
			$logdata['value'] = json_encode($this->_postdata);
			$logdata['username'] = $this->_auth->getUsername();
			$logdata['auth_username'] = $this->_auth->getUsername();
			$this->setLogdata($logdata);
			$this->insertLog();

			$this->_pdo->commit();
		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception("Database Error,Rollback!! " . $e->getMessage(), 1);
		}

	}

	public function updateBaseEmail() {
// ユーザー名と登録コードを得る
		$code = addslashes($_GET['code']);
		if (!$code) {
			throw new Exception("URLが不正です", 1);
		}

		$this->set_tbl($this->_pfx . 'regist');
		$this->set_postdata(['tmp_code' => $code]);
		$this->set_where(['tmp_code' => 'text']);
		$tmp_registdata = $this->selectTable();

		if (!self::checkFreshness($tmp_registdata['tmp_date'])) {
			throw new Exception("受信確認用URLの期限が切れています。もう一度メールアドレス変更手続きを行って下さい。", 9);

		} else if (!$tmp_registdata['tmp_email']) {

			$this->_auth->logout();
			// 管理者モードをオフにする
			$_SESSION[$this->_pfx . 'mode'] = 0;
			HTTP_Session2::destroy();
			throw new Exception("すでに登録メールアドレスの変更が完了しています。", 8);
		}

		$postdata['id'] = $tmp_registdata['id'];
		$postdata['email'] = $tmp_registdata['tmp_email'];
		$postdata['username'] = $tmp_registdata['tmp_email'];
		$postdata['tmp_email'] = '';
		$postdata['tmp_date'] = '';
		$postdata['tmp_code'] = '';

		$fields = [
			'email' => 'text',
			'username' => 'text',
			'tmp_email' => 'text',
			'tmp_code' => 'text',
			'tmp_date' => 'text',
		];

		try {
			$this->_pdo->beginTransaction();

			$this->set_fields($fields);
			$this->set_where(['id' => 'integer']);
			$this->set_postdata($postdata);
			$this->set_tbl($this->_pfx . 'regist');
			$this->updateTable();

			$this->_pdo->commit();
		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception("Database Error,Rollback!! " . $e->getMessage(), 1);
		}

//ユーザー名変更してサインイン処理
		$this->_auth->setAuth($postdata['username']);

		$_SESSION[$this->_pfx . 'mode'] = 1;
		$this->_smarty->assign('login', 1);
//authデータの上書き
		$this->_auth->setAuth($postdata['email']);

		$registdata = array_merge($tmp_registdata, $postdata);

		foreach ($registdata as $key => $value) {
			if ($key == 'username' || $key == 'password') {continue;}
			$this->_auth->setAuthData($key, $value);
		}

//ログの書き込み
		$logdata['process'] = $this->_kind;
		$logdata['kind'] = $this->_kind;
		$logdata['component'] = COMPONENT;
		$logdata['app_id'] = null;
		$logdata['value'] = json_encode($this->_postdata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

	}

	protected function execSanitize($_fields, $_fields_must) {

		$this->_input_error = [];
		$postdata = $this->baseSanitize($_fields, $_fields_must);

		switch ($this->_target) {

		case 'save_tmp_email':
			if (!self::checkFormatEmail($postdata['email'])) {
				$this->_input_error['no_email'] = 1;
//			} else if ($postdata['email'] != $postdata['emailcfrm']) {
				//				$this->_input_error['no_same_email'] = 1;
			} else if ($postdata['email'] == $this->_auth->getUsername()) {
				$this->_input_error['not_same_email'] = 1;
			} else {
				$this->duplicateUsername($postdata['email']);
			}
			break;
		case 'save_password':

			if ($postdata['password_new'] == $postdata['password_cur']) {
				$this->_input_error['the_same_password'] = 1;
			}

			if ($postdata['password_new'] != $postdata['passwordcfrm']) {
				$this->_input_error['no_same_password'] = 1;
			}
			if (!self::checkStringAlnum($postdata['password_new'])) {
				$this->_input_error['not_password_new_alnum'] = 1;
			}
			if (!self::checkStringLength($postdata['password_new'], 8, 16)) {
				$this->_input_error['not_password_length'] = 1;
			}

			if (count($this->_input_error) == 0) {
				$this->checkPassword($postdata['password_cur']);
			}

			break;
		case 'regist_confirm':
			if (!self::checkFormatEmail($postdata['email'])) {
				$this->_input_error['no_email'] = 1;
			} else if ($postdata['email'] != $postdata['emailcfrm']) {
				if (!$this->_skip_emailcfrm) {
					$this->_input_error['no_same_email'] = 1;
				}
			} else {
				$this->duplicateUsername($postdata['email']);
			}
			break;
		case 'remind':
			if (!self::checkFormatEmail($postdata['email'])) {
				$this->_input_error['no_email'] = 1;
			}
			break;
		case 'save_remind':
			if ($postdata['password'] != $postdata['passwordcfrm']) {
				$this->_input_error['no_same_password'] = 1;
			}
			if (!self::checkStringLength($postdata['password'], 8, 16)) {
				$this->_input_error['not_password_length'] = 1;
			}
			if (!self::checkStringAlnum($postdata['password'])) {
				$this->_input_error['not_password_alnum'] = 1;
			}
			break;
		case 'regist_confirm_end':
			if ($this->_skip_password) {break;}
			if ($postdata['password2'] != $postdata['passwordcfrm']) {
				$this->_input_error['no_same_password'] = 1;
			}
			if (!self::checkStringLength($postdata['password2'], 8, 16)) {
				$this->_input_error['not_password_length'] = 1;
			}
			if (!self::checkStringAlnum($postdata['password2'])) {
				$this->_input_error['not_password_alnum'] = 1;
			}
			$postdata['password'] = $postdata['password2'];
			break;
		case 'remove_username':

			if (count($this->_input_error) == 0) {
				$this->checkPassword($postdata['password']);
			}

			break;

		}

		if (count($this->_input_error) > 0) {
			$this->_smarty->assign('post', $postdata);
			$this->_smarty->assign('error', $this->_input_error);
			throw new Exception("入力エラー", 9);
		}

		return $postdata;
	}

	private function checkPassword($_password) {

		$this->set_tbl($this->_pfx . 'regist');
		$this->set_where(['id' => 'integer', 'status' => 'integer']);
		$this->set_postdata(['id' => $this->_auth->getAuthdata('id'), 'status' => 1]);

		$data = $this->selectTable();

		if (!password_verify($_password, $data['password'])) {
			$this->_input_error['not_password'] = 1;
		}
	}

	protected function duplicateUsername($_email) {
		if (!$_email) {return;}
		$data = [
			'username' => $_email,
			'status' => 1,
		];

		$this->set_tbl($this->_pfx . 'regist');
		$this->set_postdata($data);
		$this->set_where(['username' => 'text', 'status' => 'integer']);
		$result = $this->selectTable();
		if (count($result) > 1) {
			$this->_input_error['duplicate_email'] = 1;
		}
	}

	public function removeBaseRegist() {

		$fields_must = ['password' => 'text', 'reason' => 'integer', 'responsibility' => 'integer'];
		$fields = ['password' => 'text', 'reason' => 'integer', 'reason_memo' => 'text'];
		$this->_target = "remove_username";
		$postdata = $this->execSanitize($fields, $fields_must);

		$fields_sql = ['password' => 'text',
			'username' => 'text',
			'status' => 'integer',
			'reason' => 'integer',
			'reason_memo' => 'text',
			'withdraw_date' => 'text',
		];

		$postdata['password'] = self::generateUuid();
		$postdata['username'] = md5($this->_auth->getUsername() . self::generateUuid());
		$postdata['status'] = 9;
		$postdata['withdraw_date'] = date('Y-m-d H:i:s');
		$postdata['id'] = $this->_auth->getAuthdata('id');

		$this->set_fields($fields_sql);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl($this->_pfx . 'regist');
		$this->set_postdata($postdata);
		$this->updateTable();

// 変更完了メールを送信する

		$init_ordermail = $_SESSION['config']['email'];
		$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

		$cust_body = $this->_smarty->fetch('customer_remove_account_mail.tpl');
		$cust_subject = 'アカウントを削除し退会手続きが完了しました';

		$replymail = $_SESSION['config']['donotreply_email'];

//完了メール送信
		self::send_mail($init_coopname, $replymail, $this->_auth->getAuthdata('email'), $cust_subject, $cust_body);

//生協側へメール送信

		$namef = $this->_auth->getAuthData('namef');
		$nameg = $this->_auth->getAuthData('nameg');
		$username = $this->_auth->getUsername();

		if ($namef) {
			$name = $namef . ' ' . $nameg;
		} else {
			$name = $username;
		}

		$this->_smarty->assign('entry_namef', $namef);
		$this->_smarty->assign('entry_nameg', $nameg);
		$this->_smarty->assign('entry_username', $username);
		$this->_smarty->assign('post', $postdata);

		$order_subject = '【退会手続き】' . $init_coopname;
		$order_body = $this->_smarty->fetch('order_remove_account_mail.tpl');

		self::send_mail($name, $this->_auth->getAuthdata('email'), $init_ordermail, $order_subject, $order_body);

// 変更完了画面表示する
		$this->_smarty->assign('msg', 'アカウントを削除し退会が完了しました。ご利用ありがとうございました。');
		$tmpl = 'withdraw.tpl';

//ログの書き込み
		$logdata['process'] = "remove_account";
		$logdata['kind'] = "remove_account";
		$logdata['component'] = COMPONENT;
		$logdata['target_id'] = null;
		$logdata['value'] = json_encode($postdata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

		$this->setSignOut($this->_auth, 'withdraw');

		$init_url = $this->_smarty->getConfigVars('init_url');

		header("Location: $init_url");
		exit();

	}

	public function set_get_username(string $_username) {

		if (!$_username) {
			throw new Exception("パラメータが不正です", 1);
		}
		$this->_get_username = $_username;
	}

	public function set_unsubscribe_mail(int $_unsubscribe_mail) {

		$this->_unsubscribe_mail = $_unsubscribe_mail;
	}

	private function saveBaseUnsubscribeMail() {

		$changedata = [
			'dm' => $this->_unsubscribe_mail,
			'id' => $this->_auth->getAuthdata('id'),
		];
		$fields = ['dm' => 'integer'];

		$this->set_postdata($changedata);
		$this->set_fields($fields);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl($this->_pfx . 'regist');
		$this->updateTable();

//ログの書き込み
		$logdata['process'] = "update_unsubscribe_mail";
		$logdata['kind'] = "update_unsubscribe_mail";
		$logdata['component'] = COMPONENT;
		$logdata['target_id'] = null;
		$logdata['value'] = json_encode($changedata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();
	}

	public function directBaseUnsubscribeMail() {

		if ($this->_auth->getUsername() != $this->_get_username) {
			throw new Exception("URLが不正です", 1);
		}
		$this->set_unsubscribe_mail(1);
		$this->saveBaseUnsubscribeMail();

	}
}
?>
