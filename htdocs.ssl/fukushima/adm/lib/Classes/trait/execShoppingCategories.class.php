<?php
trait execShoppingCategories {

	private $_shopping_category_id;
	private $_shopping_subcategory_id;
	private $_shopping_sub2category_id;

	public function get_shopping_category_id() {
		return $this->_shopping_category_id;
	}

	public function set_shopping_category_id($_shopping_category_id) {
		$this->_shopping_category_id = $_shopping_category_id;
	}

	public function get_shopping_subcategory_id() {
		return $this->_shopping_subcategory_id;
	}

	public function set_shopping_subcategory_id($_shopping_subcategory_id) {
		$this->_shopping_subcategory_id = $_shopping_subcategory_id;
	}

	public function get_shopping_sub2category_id() {
		return $this->_shopping_sub2category_id;
	}

	public function set_shopping_sub2category_id($_shopping_sub2category_id) {
		$this->_shopping_sub2category_id = $_shopping_sub2category_id;
	}

	public function getShoppingCategoryList() {
		$this->_tbl = 'sp_category';
		$this->_fetchall = 1;

		$categories = $this->selectTable();

		$categoryList = [];

		if ($categories && is_array($categories)) {
			foreach ($categories as $category) {
				$categoryList[$category['id']] = ['denomination' => $category['denomination']];
			}
		}

		return $categoryList;
	}

	public function saveShoppingCategory() {

		$fields = [
			'denomination' => 'text',
			'description' => 'text',
			'flag_send' => 'integer',
			'sort_order' => 'integer',
			'term_start' => 'text',
			'term_end' => 'text',
			'intervals' => 'integer',
			'nominate' => 'integer',
			'visible' => 'integer',
			'opt_bill' => 'integer',
			'autosend_message' => 'text',
			'return_message' => 'text',
			'include_return_message' => 'integer',
			'paid_completed_message' => 'text',
			'nopaid_message' => 'text',
			'ordermail' => 'text',
			'infocode' => 'text',
			'store_name' => 'text',
			'store_address' => 'text',
			'store_time' => 'text',
			'store_phonenumber' => 'text',
			'store_faxnumber' => 'text',

			'payment' => 'integer',
			'opt_ship' => 'integer',
			'test_mode' => 'integer',

			'low' => 'text',

		];

		$fields_must = [
			'denomination' => 'text',
			'opt_ship' => 'integer',
		];

		$postdata = $this->baseSanitize($fields, $fields_must);

		if ($_POST['category_id']) {
			$postdata['id'] = intval($_POST['category_id']);
		}

		if (is_array($postdata['payment'])) {
			$postdata['payment'] = json_encode($postdata['payment']);
			$fields['payment'] = 'text';
		}

		if (is_array($postdata['opt_ship'])) {
			$postdata['opt_ship'] = json_encode($postdata['opt_ship']);
			$fields['opt_ship'] = 'text';
		}

		$this->set_tbl('sp_category');

// 新規カテゴリーの場合
		if (!$postdata['id']) {

			$this->set_postdata($postdata);

			$this->set_fields($fields);
			$this->insertTable();
			$postdata['id'] = $this->get_last_insertId();

			if ($this->_authority['master']['master'] == 0) {
//user権限に新規カテゴリIDを追加
				if (is_array($this->_authority[COMPONENT]['category_id'])) {
					array_push($this->_authority[COMPONENT]['category_id'], intval($postdata['id']));
				} else {
					$this->_authority[COMPONENT]['category_id'] = array(intval($postdata['id']));
				}
				$sadata['auth'] = json_encode($this->_authority);
				$sadata['id'] = $this->_adminAuth->getAuthData('id');

				$fields_sa = array("auth" => "text");

				$this->set_tbl('init_user');
				$this->set_postdata($sadata);
				$this->set_fields($fields_sa);
				$this->updateTable();

				$this->_adminAuth->setAuthData("auth", $sadata['auth']);
				$this->_smarty->assign('authority', $this->_authority);

			}

// 既存カテゴリーの場合
		} else {
			$this->set_postdata($postdata);
			$this->set_fields($fields);
			$this->updateTable();
		}
		$this->_shopping_category_id = $postdata['id'];

		$logdata['process'] = 'save_shopping_category';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();
	}

	public function deleteShoppingCategory() {

		if (!$this->_authority['shopping']['delete']) {
			throw new Exception("実行する権限がありません", 1);
		}

		if (!$this->_shopping_category_id) {
			throw new Exception("パラメータが不正です", 1);
		}

		$postdata = ['id' => $this->_shopping_category_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('sp_category');
		$this->deleteTable();

		if ($this->_authority['master']['master'] == 0) {
//user権限に新規カテゴリIDを追加
			if (is_array($this->_authority[COMPONENT]['category_id'])) {
				$key = array_search($id, $authority['shopping']['category_id']);
				unset($this->_authority[COMPONENT]['category_id'][$key]);
			} else {
				$this->_authority[COMPONENT]['category_id'] = [];
			}

			$sadata['auth'] = json_encode($this->_authority);
			$sadata['id'] = $this->_adminAuth->getAuthData('id');

			$fields_sa = array("auth" => "text");

			$this->set_tbl('init_user');
			$this->set_postdata($sadata);
			$this->set_fields($fields_sa);
			$this->updateTable();

			$this->_adminAuth->setAuthData("auth", $sadata['auth']);
			$this->_smarty->assign('authority', $this->_authority);

		}

		$logdata['process'] = 'delete_shopping_category';
		$logdata['value'] = $this->_shopping_category_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function getShoppingCategory() {

		if (CURRENT == 'app' && COMPONENT == "shopping" && defined('PART')) {

		} else if (!$this->_shopping_category_id) {
			throw new Exception("no category id", 1);
		}

		$this->_postdata = [];
		$where = [];

		$sql = <<< HERE
SELECT * FROM sp_category AS c

HERE;

		if ($this->_shopping_category_id) {
			$this->_postdata[':id'] = $this->_shopping_category_id;
			array_push($where, "c.id = :id");
		} else if (CURRENT == 'app' && COMPONENT == "shopping" && defined('PART')) {

			$this->_postdata[':part'] = PART;
			array_push($where, "c.part = :part");
		}

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		} else {
			throw new Exception("no category setting", 1);
		}

		$this->_sql = $sql;
		$category = $this->selectTable();

		if (!count($category)) {
			throw new Exception("no category setting", 1);
		}

		return $category;

	}

	public function saveShoppingSubcategory() {

		$fields = array(
			'denomination' => 'text',
			'description' => 'text',
			'flag_drink' => 'integer',
			'open_date' => 'text',
			'limit_date' => 'text',
			'visible' => 'integer',
			'sort_order' => 'integer',
			'term_start' => 'text',
			'term_end' => 'text',
			'intervals' => 'integer',
			'category_id' => 'integer',
			'return_message' => 'text',
		);

		$postdata = $this->baseSanitize($fields, $fields_must);

		if ($_POST['subcategory_id']) {
			$postdata['id'] = intval($_POST['subcategory_id']);
		}

		$this->set_tbl('sp_subcategory');

// 新規カテゴリーの場合
		if (!$postdata['id']) {

			$this->set_postdata($postdata);

			$this->set_fields($fields);
			$this->insertTable();
			$postdata['id'] = $this->get_last_insertId();

// 既存カテゴリーの場合
		} else {
			$this->set_postdata($postdata);
			$this->set_fields($fields);
			$this->updateTable();
		}
		$this->_shopping_subcategory_id = $postdata['id'];

		$logdata['process'] = 'save_shopping_subcategory';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteShoppingSubcategory() {

		if (!$this->_authority['shopping']['delete']) {
			throw new Exception("実行する権限がありません", 1);
		}

		if (!$this->_shopping_subcategory_id) {
			throw new Exception("パラメータが不正です", 1);
		}

		$postdata = ['id' => $this->_shopping_subcategory_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('sp_subcategory');
		$this->deleteTable();

		$logdata['process'] = 'delete_shopping_subcategory';
		$logdata['value'] = $this->_shopping_subcategory_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function saveShoppingSub2category() {

		$fields = array(
			'denomination' => 'text',
			'description' => 'text',
			'limit_date' => 'text',
			'visible' => 'integer',
			'sort_order' => 'integer',
			'subcategory_id' => 'integer',
		);

		$postdata = $this->baseSanitize($fields, $fields_must);

		if ($_POST['sub2category_id']) {
			$postdata['id'] = intval($_POST['sub2category_id']);
		}

		$this->set_tbl('sp_sub2category');

// 新規カテゴリーの場合
		if (!$postdata['id']) {

			$this->set_postdata($postdata);

			$this->set_fields($fields);
			$this->insertTable();
			$postdata['id'] = $this->get_last_insertId();

// 既存カテゴリーの場合
		} else {
			$this->set_postdata($postdata);
			$this->set_fields($fields);
			$this->updateTable();
		}
		$this->_shopping_sub2category_id = $postdata['id'];

		$logdata['process'] = 'save_shopping_sub2category';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteShoppingSub2category() {

		if (!$this->_authority['shopping']['delete']) {
			throw new Exception("実行する権限がありません", 1);
		}

		if (!$this->_shopping_sub2category_id) {
			throw new Exception("パラメータが不正です", 1);
		}

		$postdata = ['id' => $this->_shopping_sub2category_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('sp_sub2category');
		$this->deleteTable();

		$logdata['process'] = 'delete_shopping_sub2category';
		$logdata['value'] = $this->_shopping_sub2category_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

}
?>