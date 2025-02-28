<?php
trait execAskCategories {

	private $_ask_category_id;

	public function get_ask_category_id() {
		return $this->_ask_category_id;
	}

	public function set_ask_category_id($_ask_category_id) {
		$this->_ask_category_id = $_ask_category_id;
	}

	public function saveAskCategory() {

		$fields = [
			'denomination' => 'text',
			'ordermail' => 'text',
			'description' => 'text',
			'sort_order' => 'integer',
			'color' => 'text',
			'visible' => 'integer',
		];

		$fields_must = [
			'name' => 'text',
			'sort_order' => 'integer',
		];

		$postdata = $this->baseSanitize($fields, $fields_must);

		if ($_POST['category_id']) {
			$postdata['id'] = intval($_POST['category_id']);
		}

		$this->set_tbl('ask_category');

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
		$this->_ask_category_id = $postdata['id'];

		$logdata['process'] = 'save_ask_category';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();
	}

	public function deleteAskCategory() {

		if (!$this->_authority['ask']['delete']) {
			throw new Exception("実行する権限がありません", 1);
		}

		if (!$this->_ask_category_id) {
			throw new Exception("パラメータが不正です", 1);
		}

/*
if ($this->getCountApp()) {
throw new Exception("登録があるため削除できません。", 1);
}
 */

		$postdata = ['id' => $this->_ask_category_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('ask_category');
		$this->deleteTable();

		$logdata['process'] = 'delete_ask_category';
		$logdata['value'] = $this->_ask_category_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

}
?>