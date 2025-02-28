<?php
Trait basePage {

	private $_page_id;

	public function get_page_id() {
		return $this->_page_id;
	}

	private function saveBasePage($_fields, $_fields_must) {

		$pagedata = $this->execSanitize($_fields, $_fields_must);

		if ($_POST['id']) {
			$pagedata['id'] = intval($_POST['id']);
		}

		$this->set_postdata($pagedata);
		$this->set_tbl($this->_pfx . 'page');
		$this->set_fields($_fields);

		if ($pagedata['id']) {
			$this->set_where(['id' => 'integer']);
			$this->updateTable();
		} else {
			$this->_postdata['regist_date'] = date('Y-m-d H:i:s');
			$this->_fields['regist_date'] = "text";
			$this->insertTable();
			$pagedata['id'] = $this->get_last_insertId();
		}

		$this->_page_id = $pagedata['id'];

//ログの書き込み
		$logdata['process'] = $this->_kind;
		$logdata['kind'] = $this->_kind;
		$logdata['component'] = COMPONENT;
		$logdata['app_id'] = null;
		$logdata['value'] = json_encode($pagedata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

	}

}
?>
