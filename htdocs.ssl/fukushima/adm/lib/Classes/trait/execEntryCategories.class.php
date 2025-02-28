<?php
trait execEntryCategories {

	public function saveEntryCategory() {

		$fields = [
			'denomination' => 'text',
			'ordermail' => 'text',
			'pressmail' => 'text',
			'description' => 'text',
			'description_web' => 'text',
			'description_closed' => 'text',
			'cat_code' => 'text',
			'date_limit' => 'text',
			'date_start' => 'text',
			'onstock' => 'integer',
			'stock' => 'integer',
			'oncancel' => 'integer',
			'date_limit_cancel' => 'text',
			'onduplicate' => 'integer',
			'archived' => 'integer',
			'select_time' => 'text',
			'authorization' => 'integer',
			'js' => 'text',
			'set_year' => 'text',
			'comedate_title' => 'text',
			'cometime_title' => 'text',
			'limit_time' => 'integer',
			'set_year' => 'text',
		];

		$fields_must = ['denomination' => 'text'];

		if (COMPONENT == 'entry' || COMPONENT == 'reserve') {
			$fields['sort_order'] = 'integer';
			$fields_must['sort_order'] = 'integer';
		}

		$postdata = $this->baseSanitize($fields, $fields_must);

		if ($_POST['id']) {
			$postdata['id'] = intval($_POST['id']);
		}

		$sort = $_POST['result'];

		$sorts = explode(",", $sort);

		while (list($key, $value) = each($sorts)) {
			if ($value) {
				$value = preg_replace('/sort_/', '', $value);
				if (preg_match('/^extra/', $value)) {
					$v = preg_replace('/^extra/', '', $value);
					$methoddata['extra'][$v] = array('sort' => $key);

				} else {
					$methoddata[$value] = array('sort' => $key);
				}
			}
		}

		$fields_method = array(
			'title' => 'text'
			, 'note' => 'text'
			, 'select' => 'text'
			, 'use' => 'integer'
			, 'tag' => 'text',
		);

		if (count($methoddata)) {

			foreach (array_keys($methoddata) as $method) {
				if ($method == 'extra') {
					$extradata = $methoddata['extra'];
					foreach (array_keys($extradata) as $n) {
						if (!$_POST[$method]['use'][$n]) {
							unset($methoddata['extra'][$n]);
							continue;}
						foreach ($fields_method as $k => $v) {
							if (isset($_POST[$method][$k][$n])) {
								if ($v == 'integer') {
									$methoddata[$method][$n][$k] = intval($_POST[$method][$k][$n]);
								} else if ($v == 'float') {
									$methoddata[$method][$n][$k] = floatval($_POST[$method][$k][$n]);
								} else {
									$methoddata[$method][$n][$k] = addslashes($_POST[$method][$k][$n]);
								}
							}
						}

					}

				} else {
					foreach ($fields_method as $k => $v) {
						if (isset($_POST[$method][$k])) {
							if ($v == 'integer') {
								$methoddata[$method][$k] = intval($_POST[$method][$k]);
							} else if ($v == 'float') {
								$methoddata[$method][$k] = floatval($_POST[$method][$k]);
							} else {
								$methoddata[$method][$k] = addslashes($_POST[$method][$k]);
							}
						}
					}

				}
			}

		}

		if ($postdata['onstock'] == 2) {
			foreach ($fields_method as $k => $v) {
				if (isset($_POST["stock_multi"][$k])) {
					if ($v == 'integer') {
						$postdata["stock_multi"][$k] = intval($_POST["stock_multi"][$k]);
					} else if ($v == 'float') {
						$postdata["stock_multi"][$k] = floatval($_POST["stock_multi"][$k]);
					} else {
						$postdata["stock_multi"][$k] = addslashes($_POST["stock_multi"][$k]);
					}
				}
			}
			$postdata['stock_multi'] = json_encode($postdata['stock_multi']);
		} else {
			$postdata["stock_multi"] = "";
		}

		$fields['stock_multi'] = 'text';
		$fields['method'] = 'text';

		$postdata['method'] = json_encode($methoddata);

		if ($postdata['select_time']) {
			$postdata['select_time'] = preg_replace('/\n|\r\n/', ',', $postdata['select_time']);
			$postdata['select_time'] = explode(',', $postdata['select_time']);
			$postdata['select_time'] = json_encode($postdata['select_time']);
		}

		$this->set_tbl('entry_category');

// 新規カテゴリーの場合
		if (!$postdata['id']) {

			$fields['component'] = 'text';
			$postdata['component'] = COMPONENT;

			$fields['code'] = 'text';
			$postdata['code'] = Text_Password::create(8, 'unpronounceable', 'alphanumeric');
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
		$this->_category_id = $postdata['id'];

		$logdata['process'] = 'save_category';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();
	}

	public function deleteEntryCategory() {

		if (!$this->_authority['entry']['delete']) {
			throw new Exception("実行する権限がありません", 1);
		}

		if (!$this->_category_id) {
			throw new Exception("パラメータが不正です", 1);
		}

		if ($this->getCountApp()) {
			throw new Exception("登録があるため削除できません。", 1);
		}

		$category = $this->getEntryCategorySimple();

		$postdata = ['id' => $this->_category_id];
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($postdata);
		$this->set_tbl('entry_category');
		$this->deleteTable();

		if ($category['component'] == "reserve") {

			$sql = "DELETE FROM entry_calendar WHERE category_id = :category_id";

			$data[':category_id'] = $this->_category_id;

			try {
				$res = $this->_pdo->prepare($sql);
				$res->execute($data);

			} catch (PDOException $e) {
				throw new Exception("データベース処理エラー", 1);
			}
		}

		if ($this->_authority['master']['master'] == 0) {
//user権限のカテゴリIDを削除

			$key = array_search($this->_category_id, $this->_authority[COMPONENT]['category_id']);

			if ($key) {
				unset($this->_authority[COMPONENT]['category_id'][$key]);

				$this->set_fields(['auth' => 'text']);

				$sadata['id'] = $this->_adminAuth->getAuthData('id');
				$sadata['auth'] = json_encode($this->_authority);
				$this->set_postdata($sadata);
				$this->set_tbl('init_user');
				$this->updateTable();

				$this->_adminAuth->setAuthData("auth", $sadata['auth']);
				$this->_smarty->assign('authority', $this->_authority);
			}
		}

		$logdata['process'] = 'delete_entry_category';
		$logdata['value'] = $this->_category_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

}
?>