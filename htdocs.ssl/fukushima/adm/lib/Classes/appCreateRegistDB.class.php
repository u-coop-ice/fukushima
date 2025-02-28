<?php
class appCreateRegistDB extends appRegistDB {

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	use baseCreateRegist;

	public function saveAppCreateRegistSub() {
		$this->_skip_emailcfrm = 1;
		$this->saveBaseCreateRegistSub();
	}
	public function accessAppCreateRegist() {
		$this->accessBaseCreateRegist();
	}
	public function saveAppCreateRegist() {
		$this->saveBaseCreateRegist($this->_fields_init_regist, $this->_fields_init_regist_must);
	}

	public function completeAppCreateRegistSub() {
		$this->completeBaseCreateRegistSub();
	}
	public function completeAppCreateRegist() {
		$this->completeBaseCreateRegist();
	}

	public function sendAppRemind() {
		$this->sendBaseRemind();
	}
	public function completeAppRemind() {
		$this->completeBaseRemind();
	}
	public function completeAppRemindEnd() {
		$this->completeBaseRemindEnd();
	}
	public function accessAppRemind() {
		$this->accessBaseRemind();
	}
	public function saveAppRemind() {
		$this->saveBaseRemind();
	}

}
?>
