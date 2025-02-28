<?php
class adminLivingDB extends commonDB {

	use adminAuth;
	use baseSendmail;
	use baseFunction;
	use execAdminLog;
	use execConfig;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

}
