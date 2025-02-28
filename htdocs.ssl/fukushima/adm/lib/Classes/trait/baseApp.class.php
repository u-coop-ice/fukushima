<?php
trait baseApp {

	protected $_app_id;
	protected $_app_code;

	public function get_app_id() {
		return $this->_app_id;
	}
	public function set_app_id(int $_app_id) {
		$this->_app_id = $_app_id;
	}

	public function set_app_code(string $_app_code) {
		$this->_app_code = $_app_code;
	}

}
?>