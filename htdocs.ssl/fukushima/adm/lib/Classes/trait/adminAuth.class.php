<?php
trait adminAuth {

	protected $_adminAuth;
	protected $_authority;
	protected $_config;

	public function set_config(array $_config) {$this->_config = $_config;}

	public function setAdminAuth(Auth $_adminAuth) {
		$this->_adminAuth = $_adminAuth;
		if (!is_object($this->_adminAuth)) {return;}

		$this->_is_login = $this->_adminAuth->checkAuth();

		if ($this->_adminAuth->getAuth()) {
			$this->_authority = json_decode($this->_adminAuth->getAuthData("auth"), true);
			$this->_smarty->assign('authority', $this->_authority);
		}

	}

	private function getInitConfig() {

		$this->set_tbl('init_config');
		$this->set_where(['univ_id' => "integer"]);
		if (is_object($this->_smarty)) {
			$this->set_postdata(['univ_id' => $this->_smarty->getConfigVars('univ_id')]);
		} else {
			$this->set_postdata(['univ_id' => $this->_config['univ_id']]);
		}
		$init_config = $this->selectTable();
		$init_config['component'] = json_decode($init_config['component'], true);
		return $init_config;
	}

}
?>