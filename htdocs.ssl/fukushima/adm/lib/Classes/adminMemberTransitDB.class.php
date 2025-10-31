<?php
class adminMemberTransitDB extends commonDB {

	use adminAuth;
	use baseSendmail;
	use baseFunction;
	use checkEntryCategories;
	use checkRegists;
	use checkCode;
	use checkExportEntries;
	use baseApp;
	use checkApp;
	use execEntryCategories;
	use execApp;
	use execAdminLog;
	use execConfig;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

}
