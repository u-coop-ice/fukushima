<?php

trait execRegist {

	private $_fields_regist = [
		'username' => 'text',
		'password' => 'text',
		'rank' => 'integer',
		'year' => 'integer',
		'email' => 'text',
		'student_phone' => 'text',
		'student_email' => 'text',
		'student_email_mobile' => 'text',
		'parent_email' => 'text',
		'parent_email_mobile' => 'text',
		'mobilephone' => 'text',
		'univ_id' => 'integer',
		'regist_date' => 'text',
		'rc_se' => 'integer',
		'rc_sem' => 'integer',
		'rc_pe' => 'integer',
		'rc_pem' => 'integer',
		'status' => 'integer',
		'remote_addr' => 'text',
		'remote_host' => 'text',
		'user_agent' => 'text',
		'tmp_update_password' => 'integer',
	];

	public function saveRegist(array $_fields = null) {

//環境変数をセット
		$this->_postdata['remote_addr'] = getenv('REMOTE_ADDR');
		$this->_postdata['remote_host'] = getenv('REMOTE_HOST');
		$this->_postdata['user_agent'] = getenv('HTTP_USER_AGENT');
//投稿日時を取得
		$this->_postdata['regist_date'] = date('Y-m-d H:i:s');

		if ($this->_skip_auth_check) {
			if ($_fields) {
				$this->_fields_regist = $_fields;
			}

			$this->_postdata['id'] = $this->_regist_id;
			$this->updateRegist();

		} else if ($_SESSION['admin_mode'] && $this->_postdata['no_user']) {
			if ($_fields) {
				$this->_fields_regist = array_merge($this->_fields_regist, $_fields);
			}
			$this->_postdata['status'] = -9;
			$this->saveRegistNew();
		} else if (!$this->_auth->checkAuth()) {
			if ($_fields) {
				$this->_fields_regist = array_merge($this->_fields_regist, $_fields);
			}
			$this->_postdata['status'] = -9;
			$this->saveRegistNew();
		} else {
			if ($_fields) {
				$this->_fields_regist = $_fields;
			}

			if (!$this->_postdata['id']) {
				$this->_postdata['id'] = $this->_auth->getAuthData('id');
			}
			$this->updateRegist();
		}

	}

	private function saveRegistNew() {

		$this->_postdata['username'] = self::generateUuid();
		$this->_postdata['password'] = self::generateUuid();

		$this->_postdata['rank'] = 1; //本人only仕様
		$this->_postdata['univ_id'] = $_SESSION['config']['univ_id'];

// 電話番号から電話判別

		if ($this->_postdata['student_phone']) {
			if (self::calc_mobilephone($this->_postdata['student_phone'])) {
//				$this->_postdata['mobilephone'] = $registdata['student_phone'];
//				$this->_postdata['student_phone'] = null;
			}
		}

		$this->set_fields($this->_fields_regist);
		$this->set_tbl('regist');
		$this->insertTable();

	}

	private function updateRegist() {

		$this->set_where(['id' => 'integer']);
		$this->set_fields($this->_fields_regist);
		$this->set_tbl('regist');
		$this->updateTable();

		if ($_SESSION[$this->_pfx . 'mode']) {
			foreach ($this->_fields_regist as $k => $v) {
				if ($k == 'username' || $k == 'password' || $k == 'ct') {continue;}
				$this->_auth->setAuthData($k, $this->_postdata[$k]);
			}
		}
	}

}
?>