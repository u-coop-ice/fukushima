<?php
class adminRegistDB extends commonDB {

	use adminAuth;
	use checkRegists;
	use checkMagazine;
	use baseFunction;
	use checkCode;
	use checkExportRegists;
	use execAdminLog;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

}
