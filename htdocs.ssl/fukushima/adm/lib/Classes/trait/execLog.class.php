<?php
Trait execLog {

	public function setLogdata(array $_logdata) {
		$this->_logdata = $_logdata;
	}
	protected function setKind(string $_kind) {
		$this->_kind = $_kind;
	}

	public function insertLog() {
		if ($_SESSION['admin_mode']) {
			$this->setAdminLog();
		} else if ($_SESSION[$this->_pfx . "mode"]) {
			$this->setLog();
		} else {
			$this->setLog();
		}
	}

	protected function insertAccessLog(int $_id) {
		if ($_SESSION['admin_mode']) {
			return;
		} else if ($_SESSION[$this->_pfx . "mode"]) {
			return;
		}

		$logdata['entry_id'] = $_id;
		$logdata['ip'] = $_SERVER['REMOTE_ADDR'];
		$logdata['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$logdata['date'] = date('Y-m-d H:i:s');

		$fields = array(
			'entry_id' => 'integer',
			'ip' => 'text',
			'user_agent' => 'text',
			'date' => 'text',
		);
		$this->set_fields($fields);
		$this->set_postdata($logdata);
		$this->set_tbl($this->_pfx . 'access');

		$this->insertTable();

	}

	protected function setLog() {

		$_fileds_log = [
			'username' => 'text'
			, 'kind' => 'text'
			, 'result' => 'integer'
			, 'remote_addr' => 'text'
			, 'remote_host' => 'text'
			, 'user_agent' => 'text'
			, 'target_id' => 'integer'
			, 'app_add_id' => 'integer'
			, 'value' => 'text',

		];

		$envdata = array(
			'remote_addr' => $_SERVER['REMOTE_ADDR']
			, 'remote_host' => $_SERVER['REMOTE_HOST']
			, 'user_agent' => $_SERVER['HTTP_USER_AGENT']
			, 'result' => 1,
		);

		$logdata = $this->_logdata;
		$logdata = array_merge($envdata, $logdata);

		$this->set_postdata($logdata);
		$this->set_fields($_fileds_log);
		$this->set_tbl($this->_pfx . 'regist_log');
		$this->insertTable();
		return;

	}

	protected function setAdminLog() {

		$_fileds_log = [
			'app_id' => 'integer',
			'process' => 'text',
			'value' => 'text',
			'component' => 'text',
			'memo' => 'text',
			'auth_username' => 'text',
		];

		$logdata = $this->_logdata;

		$this->set_postdata($logdata);
		$this->set_fields($_fileds_log);
		$this->set_tbl('admin_log');
		$this->insertTable();
		return;

	}

}
?>
