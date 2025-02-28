<?php
trait execAdminLog {

	public function saveAdminLog() {

		$fileds_log = [
			'app_id' => 'integer',
			'process' => 'text',
			'value' => 'text',
			'component' => 'text',
			'memo' => 'text',
			'auth_username' => 'text',
		];

		if (isset($this->_adminAuth) && is_object($this->_adminAuth) && $this->_adminAuth->checkAuth()) {
			$this->_postdata['auth_username'] = $this->_adminAuth->getUsername();
		} else {
			$this->_postdata['auth_username'] = 'webhook';
		}

		$this->set_fields($fileds_log);
		$this->set_tbl('admin_log');
		$this->insertTable();
	}

}
?>