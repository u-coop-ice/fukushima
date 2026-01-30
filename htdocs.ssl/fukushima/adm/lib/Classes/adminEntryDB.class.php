<?php
class adminEntryDB extends commonDB {

	use adminAuth;
	use baseSendmail;
	use baseFunction;
	use checkEntryCategories;
	use execShoppingCategories;
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

	public function create_entry_stock_multi_table() {

		$this->_tbl = "entry_stock_multi";

/*		if (!$this->existTable()) {

		$sql = <<< HERE

CREATE TABLE entry_stock_multi (
  `category_id` int unsigned NOT NULL,
  `stock_multi` json DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute();
		} catch (Exception $e) {
			throw new Exception("Database Error " . $e->getMessage(), 1);
		}

		}
*/
		$categories = $this->selectCategories();

		foreach ($categories as $category) {
			$this->_category_id = $category['id'];

			$_category = $this->getEntryCategorySimple();

			$this->updateEntryStockMulti($_category);
		}

	}

	private function selectCategories() {

		$this->set_tbl('entry_category');
		$this->set_where(['component' => 'text']);
		$this->set_postdata(['component' => COMPONENT]);
		$this->_fetchall = 1;
		$categories = $this->selectTable();

		if (!is_array($categories)) {
			throw new Exception("汎用エントリの設定が見つかりませんでした", 1);
		}

		return $categories;

	}

}
