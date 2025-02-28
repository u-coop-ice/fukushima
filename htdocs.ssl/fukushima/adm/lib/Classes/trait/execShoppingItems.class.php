<?php
trait execShoppingItems {

	private $_shopping_item_id;
	private $_item_num;

	public function get_shopping_item_id() {
		return $this->_shopping_item_id;
	}

	public function set_shopping_item_id($_shopping_item_id) {
		$this->_shopping_item_id = $_shopping_item_id;
	}

	public function saveShoppingItem() {

		$fields = [
			'no' => 'text',
			'name' => 'text',
			'furigana' => 'text',
			'maker' => 'text',
			'size' => 'text',
			'weight' => 'integer',
			'regist_date' => 'text',
			'subcategory_id' => 'integer',
			'sub2category_id' => 'integer',
			'price' => 'integer',
			'price2' => 'integer',
			'postage' => 'integer',
			'description' => 'text',
			'content' => 'text',
			'author' => 'text',
			'page' => 'text',
			'item_code' => 'text',
			'release' => 'text',
			'visible' => 'integer',
			'package' => 'text',
			'temperature' => 'text',
			'bestbefore' => 'text',
			'limit_date' => 'text',
			'limit_note' => 'text',
			'send_date' => 'text',
			'nominate' => 'integer',
			'intervals' => 'integer',
			'nosend' => 'integer',
			'noshi_use' => 'integer',
			'extra1_title' => 'text',
			'extra1_select' => 'text',
			'extra1_note' => 'text',
			'extra1_use' => 'integer',
			'extra2_title' => 'text',
			'extra2_select' => 'text',
			'extra2_note' => 'text',
			'extra2_use' => 'integer',
			'extra3_title' => 'text',
			'extra3_select' => 'text',
			'extra3_note' => 'text',
			'extra3_use' => 'integer',
			'cart1_title' => 'text',
			'cart1_select' => 'text',
			'cart1_note' => 'text',
			'cart1_use' => 'integer',
			'cart2_title' => 'text',
			'cart2_select' => 'text',
			'cart2_note' => 'text',
			'cart2_use' => 'integer',
			'cart3_title' => 'text',
			'cart3_select' => 'text',
			'cart3_note' => 'text',
			'cart3_use' => 'integer',
		];

		$fields_stock = [
			'onstock' => 'integer',
			'stock' => 'integer',
		];

		$fields_must = [
			'no' => 'text',
			'name' => 'text',
			'price' => 'integer',
			'subcategory_id' => 'integer',
		];

		$this->_simple_name = 1;

		$postdata = $this->baseSanitize($fields + $fields_stock, $fields_must);

		if ($_POST['item_id']) {
			$postdata['id'] = intval($_POST['item_id']);
		}

		if (isset($_POST['composition_item_ids']) && is_array($_POST['composition_item_ids'])) {
			$postdata['composition_item_ids'] = $_POST['composition_item_ids'];
			$postdata['composition_item_ids'] = json_encode($postdata['composition_item_ids']);
		}

		if (count($_FILES)) {

			$tbl = 'sp_item';
			$fields_image = [];

			$sizes = ['640', '600', '320', '300', '160', '125', '80', '64'];
			$tbl_image = [];
			array_push($tbl_image, 'image');

			$upload_path = DOMAIN . '/app/' . COMPONENT . '/images/';

			$up = new setUploadGcs;
			$up->set_upload_path($upload_path);
			$up->set_sizes($sizes);

			foreach ($_FILES["image"]["error"] as $key => $error) {

				if ($error == UPLOAD_ERR_OK) {

					$tmp_name = $_FILES['image']['tmp_name'][$key];

					if ($tmp_name) {

						$fields_image += array('image' => "text");

						if ($postdata['id']) {
							$up->set_item_id($postdata['id']);
							$up->set_tbl($tbl);
							$up->set_tbl_image($tbl_image);
							$up->execDeleteImage();
						}

						$up->set_upfile($tmp_name);
						$up->execUpload();
						$postdata['image'] = $up->get_filename();

					} // if tmp_name

				}
			}

			$result['errmsg'] = $this->_smarty->getTemplateVars('errmsg');

			if ($result['errmsg']) {
				throw new Exception("Error Upload image!!", 1);
			}

		}

		if (count($fields_image)) {
			$fields += $fields_image;
		}

		$this->set_tbl('sp_item');

// 新規カテゴリーの場合
		if (!$postdata['id']) {

			$postdata['uuid'] = self::generateUuid();
			$fields['uuid'] = 'text';
			$this->set_postdata($postdata);

			$this->set_fields($fields);
			$this->insertTable();
			$postdata['id'] = $this->get_last_insertId();
			$postdata['item_id'] = $postdata['id'];

			$this->set_tbl('sp_item_stock');
			$this->set_fields(['item_id' => 'integer', 'onstock' => 'integer', 'stock' => 'integer', 'composition_item_ids' => 'text']);
			$this->set_postdata($postdata);
			$this->insertTable();

			if ($postdata['stock'] != 0) {
				$stocklogdata = [
					'num' => $postdata['stock'],
					'item_id' => $postdata['item_id'],
				];

				$this->setStockLogData($stocklogdata);
				$this->addStockLog();
			}

			$logdata['process'] = 'update_item_stock';
			$logdata['app_id'] = $postdata['id'];
			$logdata['component'] = COMPONENT;
			$logdata['value'] = json_encode($postdata);
			$logdata['memo'] = $postdata['stock'];

			$this->set_postdata($logdata);
			$this->saveAdminLog();

// 既存カテゴリーの場合
		} else {
			$this->set_shopping_item_id($postdata['id']);
			$iteminfo = $this->getShoppingItem();

			$this->set_postdata($postdata);
			$this->set_fields($fields);
			$this->updateTable();

			if ($postdata['onstock'] != $iteminfo['onstock'] || $postdata['stock'] || $postdata['composition_item_ids']) {

				$postdata['item_id'] = $postdata['id'];

				$sql = <<< HERE
				UPDATE sp_item_stock SET `stock` = IFNULL(`stock`,0) + IFNULL(:stock,0),`onstock`= :onstock,composition_item_ids = :composition_item_ids WHERE `item_id` = :item_id
HERE;

				try {
					$res = $this->_pdo->prepare($sql);
					$res->bindParam(':stock', $postdata['stock'], PDO::PARAM_INT);
					$res->bindParam(':onstock', $postdata['onstock'], PDO::PARAM_INT);
					$res->bindParam(':item_id', $postdata['item_id'], PDO::PARAM_INT);
					$res->bindParam(':composition_item_ids', $postdata['composition_item_ids'], PDO::PARAM_STR);
					$res->execute();
				} catch (PDOException $e) {
					throw new Exception("データベースへの処理に失敗しました(u)。", 1);
				}

				if ($postdata['stock'] != 0) {
					$stocklogdata = [
						'num' => $postdata['stock'],
						'item_id' => $postdata['id'],
					];

					$this->setStockLogData($stocklogdata);
					$this->addStockLog();
				}

				$logdata['app_id'] = $postdata['id'];
				$logdata['process'] = 'update_item_stock';
				$logdata['component'] = COMPONENT;
				$logdata['value'] = json_encode($postdata);
				$logdata['memo'] = $postdata['stock'];

				$this->set_postdata($logdata);
				$this->saveAdminLog();

			}

		}

		$this->_shopping_item_id = $postdata['id'];

		$logdata = [];
		$logdata['process'] = 'save_shopping_item';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function deleteShoppingItem() {

		if (!$this->_authority['shopping']['delete']) {
			throw new Exception("実行する権限がありません", 1);
		}

		if (!$this->_shopping_item_id) {
			throw new Exception("パラメータが不正です", 1);
		}

//GCSの画像を削除

		$sizes = ['640', '600', '320', '300', '160', '125', '80', '64'];
		$tbl_image = [];
		array_push($tbl_image, 'image');

		$upload_path = DOMAIN . '/app/' . COMPONENT . '/images/';

		$up = new setUploadGcs;
		$up->set_upload_path($upload_path);
		$up->set_sizes($sizes);

		$up->set_item_id($this->_shopping_item_id);
		$up->set_tbl('sp_item');
		$up->set_tbl_image($tbl_image);
		$up->execDeleteImageOnly();

		$postdata = ['id' => $this->_shopping_item_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('sp_item');
		$this->deleteTable();

		$logdata['process'] = 'delete_shopping_item';
		$logdata['value'] = $this->_shopping_item_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function getShoppingItem() {

		if (!$this->_shopping_item_id) {
			throw new Exception("no item id", 1);
		}

		$this->_postdata = [];
		$where = [];

		$sql = <<< HERE
SELECT *,IFNULL(sk.onstock,0) AS onstock,IFNULL(sk.stock,0) AS stock FROM sp_item AS i
LEFT JOIN sp_item_stock AS sk ON sk.item_id = i.id

HERE;

		if ($this->_shopping_item_id) {
			$this->_postdata[':id'] = $this->_shopping_item_id;
			array_push($where, "i.id = :id");
		}

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

		$this->_sql = $sql;
		$item = $this->selectTable();

		if (!count($item)) {
			throw new Exception("no item setting", 1);
		}

		return $item;

	}

	private function set_item_num($_item_num) {
		$this->_item_num = $_item_num;
	}

	private function resetItem(int $_item_id, int $_num, array $_items) {

		$this->set_shopping_item_id($_item_id);
		$_iteminfo = $this->getShoppingItem();

		switch ($_iteminfo['onstock']) {
		case 1:
			if (!is_array($_items[$_iteminfo['id']])) {
				$_items[$_iteminfo['id']]['num'] = 0;
				$_items[$_iteminfo['id']]['stock'] = $_iteminfo['stock'];
				$_items[$_iteminfo['id']]['name'] = $_iteminfo['name'];
			}
			$_items[$_iteminfo['id']]['num'] += $_num;
			break;

		case 2:
			if (!$_iteminfo['composition_item_ids']) {break;}
			$_composition_item_ids = json_decode($_iteminfo['composition_item_ids'], true);
			if (!is_array($_composition_item_ids)) {break;}
			foreach ($_composition_item_ids as $_composition_item_id) {
				$_items = $this->resetItem($_composition_item_id['item_id'], $_composition_item_id['num'] * $_num, $_items);
			}
			break;
		}
		return $_items;
	}

	public function checkItemStock($_flag = null) {

		if (!$this->_shopping_item_id) {
			throw new Exception("No item_id", 1);
		}

		$item_num = 1;

		if ($this->_item_num) {
			$item_num = $this->_item_num;
		}

		$stock_error = 0;
		$stock_errors = [];

		$items = $this->resetItem($this->_shopping_item_id, $item_num, []);

		if (is_array($items)) {
			foreach ($items as $item_id => $item) {
				if ($item['stock'] < $item['num']) {
					$stock_errors[$item_id]['short'] = abs($item['stock'] - $item['num']);
					$stock_errors[$item_id]['name'] = $item['name'];
				}
			}
		}
		if ($_flag) {
			$result = $stock_errors;
		} else {
			$result = count($stock_errors);
		}
		return $result;
	}

}
?>