<?php
class adminMemberDB extends commonDB {

	use adminAuth;
	use baseFunction;
	use execAdminLog;
	use execConfig;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

}
