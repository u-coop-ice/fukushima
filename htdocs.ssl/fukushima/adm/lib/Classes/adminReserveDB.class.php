<?php
class adminReserveDB extends commonDB {

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
	use execEntryCalendar;
	use execApp;
	use execAdminLog;
	use execConfig;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function getAppMinDate() {

		if (!$this->_category_id) {
			return;
		}

		$sql = <<< HERE
SELECT MIN(comedate) AS min_date FROM app WHERE component = "reserve" AND category_id = :category_id
AND comedate > NOW()

HERE;

		try {
			$res = $this->_pdo_repl->prepare($sql);
			$res->bindValue(':category_id', $this->_category_id, PDO::PARAM_INT);
			$res->execute();
			$result = $res->fetchcolumn();
		} catch (PDOException $e) {
			return;
		}
		return $result;
	}

}
