<?php
trait execShoppingApp {

	private $_item;
	private $_cart;
	private $_step;
	private $_shipdata;
	private $_ship_address_id;

	private $_calc_items;

	public function get_step() {
		return $this->_step;
	}

	public function set_session_cart(array $_cart) {
		$this->_cart = $_cart;
	}
	public function get_session_cart() {
		return $this->_cart;
	}

	public function set_shipdata(array $_shipdata) {
		$this->_shipdata = $_shipdata;
	}

	public function set_ship_address_id(int $_ship_address_id) {
		$this->_ship_address_id = $_ship_address_id;
	}

	public function set_item(array $_item) {

		if (!$_item['item_id']) {
			throw new Exception("パラメータが不正です", 1);
		}

		if ($_item['num'] < 0) {
			throw new Exception("不正な数値です", 1);
		}

		if (!preg_match("/^\d{1,3}$/", $_item['num'])) {
			throw new Exception("不正な数値です", 1);
		}

		$this->_item = $_item;
	}

	private function calcSessionCart() {

		$cart = $this->_cart;

// カート処理のメッセージがあれば、それをSmartyの変数にセットし、
		// セッションから削除する
		if (isset($cart['cart_msg'])) {
			$this->_smarty->assign('cart_msg', $cart['cart_msg']);
			unset($cart['cart_msg']);
		}

		$is_item_exist = count($cart['items']);

//お酒フラッグ更新
		unset($cart['flag_drink']);

		for ($i = 0; $i < $is_item_exist; $i++) {
			if ($cart['items'][$i]['flag_drink']) {
				$cart['flag_drink'] = 1;
				continue;
			}
		}

		$this->_cart = $cart;
		return $this->_cart;

	}

	private function checkCartItemStock() {
//在庫チェック
		$stock_errors = [];

		$this->_calc_items = [];

		if (is_array($this->_cart['items'])) {
			foreach ($this->_cart['items'] as $i => $item) {
				if (isset($item['item_id'])) {$item['id'] = $item['item_id'];}
				$this->_calc_items = $this->resetItem($item['id'], $item['num'], $this->_calc_items);
			}
		}

		if (is_array($this->_calc_items)) {
			foreach ($this->_calc_items as $item_id => $item) {
				if ($item['stock'] < $item['num']) {
					$stock_errors[$item_id]['short'] = abs($item['stock'] - $item['num']);
					$stock_errors[$item_id]['name'] = $item['name'];
				}
			}
		}
		$result = $stock_errors;
		return $result;
	}

	private function createCalcItems() {
		if (!$this->_app_id) {
			throw new Exception("Error No app_id", 1);
		}

		$where = [];

		$sql = <<< HERE
SELECT * FROM app_sub
HERE;

		if ($this->_app_id) {
			array_push($where, "`app_id` = :app_id");
		}
		if ($this->_app_sub_id) {
			array_push($where, "`id` = :app_sub_id");
		}

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		try {
			$res = $this->_pdo->prepare($sql);
			if ($this->_app_id) {
				$res->bindParam(':app_id', $this->_app_id, PDO::PARAM_INT);
			}
			if ($this->_app_sub_id) {
				$res->bindParam(':app_sub_id', $this->_app_sub_id, PDO::PARAM_INT);
			}
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("データベースへの処理に失敗しました(u)。", 1);
		}
		$this->_calc_items = [];
		while ($app_sub = $res->fetch()) {
			if ($app_sub['item_id']) {
				$this->_calc_items = $this->resetItem($app_sub['item_id'], $app_sub['num'], $this->_calc_items);
			}

		}

		return $this->_calc_items;

	}

	private function execAppItemStock(int $_flag = 1) {

		if (!is_array($this->_calc_items)) {
			return;
		}

		$sql = <<< HERE
				UPDATE sp_item_stock SET `stock` = IFNULL(`stock`,0) - IFNULL(:num,0) WHERE `item_id` = :item_id
HERE;

		if (!is_object($this->_smarty)) {
			$appinfo = $this->getAppInfo();
			$regist_code = $appinfo['regist_code'];
		} else if (!$this->_smarty->getTemplateVars('regist_code')) {
			$appinfo = $this->getAppInfo();
			$regist_code = $appinfo['regist_code'];
		} else {
			$regist_code = $this->_smarty->getTemplateVars('regist_code');
		}

		foreach ($this->_calc_items AS $item_id => $item) {
			if ($item['num'] != 0) {
				$num = $item['num'] * $_flag;
				try {
					$res = $this->_pdo->prepare($sql);
					$res->bindParam(':num', $num, PDO::PARAM_INT);
					$res->bindParam(':item_id', $item_id, PDO::PARAM_INT);
					$res->execute();
				} catch (PDOException $e) {
					throw new Exception("データベースへの処理に失敗しました(u)。", 1);
				}

				$stocklogdata = [
					'num' => $num * (-1),
					'item_id' => $item_id,
					'app_id' => $this->_app_id,
					'regist_code' => $regist_code,
				];

				$this->setStockLogData($stocklogdata);
				$this->addStockLog();
			}

		}

	}

	private function execAppSub() {
		$items = $this->_cart['items'];

		if (!count($items)) {
			throw new Exception("注文データが不正です", 1);
		}

		$fields_os = array(
			'app_id' => 'integer',
			'item_id' => 'integer',
			'num' => 'integer',
			'ship_date' => 'text',
			'ship_time' => 'text',
			'noshi' => 'text',
			'noshi_other' => 'text',
			'noshi_name' => 'text',
			'extra1' => 'text',
			'extra2' => 'text',
			'extra3' => 'text',
			'cart1' => 'text',
			'cart2' => 'text',
			'cart3' => 'text',
			'price' => 'integer',
			'name' => 'text',
			'no' => 'text',
			'methods' => 'text',
		);

		$this->set_tbl('app_sub');
		$this->set_fields($fields_os);

		foreach ($items as $i => $item) {

			$this->set_shopping_item_id($item['id']);
			$iteminfo = $this->getShoppingItem();

			if (is_array($this->_cart['methods'][$i])) {

				if ($this->_cart['methods'][$i]['wrap_use']) {
					$this->_cart['methods'][$i]['wrap'] = $item['wrap'];
				}
				if ($this->_cart['methods'][$i]['noshi_use']) {
					$this->_cart['methods'][$i]['noshi'] = $item['noshi'];
					$this->_cart['methods'][$i]['noshi_other'] = $item['noshi_other'];
					$this->_cart['methods'][$i]['noshi_name'] = $item['noshi_name'];
				}
				if (count($this->_cart['methods'][$i]['extra'])) {
					foreach ($this->_cart['methods'][$i]['extra'] as $j => $extra) {
						$this->_cart['methods'][$i]['extra'][$j]['value'] = $item['extra' . $j];
					}
				}
				if (count($this->_cart['methods'][$i]['cart'])) {
					foreach ($this->_cart['methods'][$i]['cart'] as $k => $extra) {
						$this->_cart['methods'][$i]['cart'][$k]['value'] = $item['cart' . $k];
					}
				}

				$item['methods'] = json_encode($this->_cart['methods'][$i]);
			}
			$item['name'] = $iteminfo['name'];
			$item['price'] = $iteminfo['price'];

			$item['app_id'] = $this->_app_id;
			$item['item_id'] = $item['id'];
			$this->set_postdata($item);
			$this->insertTable();

		}

	}

	public function addCart() {

		$sql = <<< HERE
SELECT i.`price` AS price ,
i.`no` AS no,
i.`name` AS name,
i.`postage` AS postage,
i.`size` AS size,
i.`weight` AS weight,
i.`send_date`,
i.`wrap_use`,
i.`noshi_use`,
i.`nominate`,
i.`cart1_use`,
i.`cart1_title`,
i.`cart1_select`,
i.`cart1_note`,
i.`cart2_use`,
i.`cart2_title`,
i.`cart2_select`,
i.`cart2_note`,
i.`cart3_use`,
i.`cart3_title`,
i.`cart3_select`,
i.`cart3_note`,
i.`extra1_use`,
i.`extra1_title`,
i.`extra1_select`,
i.`extra1_note`,
i.`extra2_use`,
i.`extra2_title`,
i.`extra2_select`,
i.`extra2_note`,
i.`extra3_use`,
i.`extra3_title`,
i.`extra3_select`,
i.`extra3_note`,

sc.`flag_drink` AS flag_drink

 FROM sp_item as i,sp_subcategory as sc
WHERE i.subcategory_id = sc.id AND i.id = :id

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':id', $this->_item['item_id'], PDO::PARAM_INT);
			$res->execute();
		} catch (Exception $e) {
			throw new Exception("データベース処理が正しく行われませんでした。", 1);
		}

		$result = $res->fetch();

		$item['id'] = $this->_item['item_id'];
		$item['num'] = $this->_item['num'];

		$item['cart1'] = $this->_item['cart1'];
		$item['cart2'] = $this->_item['cart2'];
		$item['cart3'] = $this->_item['cart3'];

		$item['price'] = $result['price'];
		$item['name'] = $result['name'];
		$item['no'] = $result['no'];
		$item['weight'] = $result['weight'];
		$item['postage'] = $result['postage'];
		if ($result['flag_drink']) {
			$item['flag_drink'] = $result['flag_drink'];
		}

		preg_match('/[a-zA-Z]/', $result['size'], $matches);
		$item['size'] = $matches[0];

//methodの生成

		$method['flag_drink'] = $result['flag_drink'];
		$method['wrap_use'] = $result['wrap_use'];
		$method['noshi_use'] = $result['noshi_use'];
		$method['nominate'] = $result['nominate'];
		$method['send_date'] = $result['send_date'];

		foreach (array('extra', 'cart') as $key) {

			for ($i = 1; $i <= 3; $i++) {
				if ($result[$key . $i . '_use'] > 0) {

					$result[$key . $i . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($result[$key . $i . '_select']));
					$tmp = null;
					if ($result[$key . $i . '_select']) {
						$tmp = explode(",", $result[$key . $i . '_select']);
						array_unshift($tmp, '');
					}

					$method[$key][$i] = array(
						'use' => $result[$key . $i . '_use'],
						'title' => $result[$key . $i . '_title'],
						'select' => $tmp,
						'note' => $result[$key . $i . '_note'],
					);
				}
			}
		}

// 商品の情報をカートに入れる

		if (!isset($this->_cart['items'])) {
			$this->_cart = array('items' => array($item), 'methods' => array($method));
		} else {
			array_push($this->_cart['items'], $item);
			array_push($this->_cart['methods'], $method);
		}

		return $this->_cart;

	}

	private function calcMethod2Field($_method) {

		$_fields = ['all' => [], 'must' => []];

		if (count($_method)) {

			foreach ($_method as $key => $value) {

				if ($key != 'extra') {
					if (CURRENT === "app" || $this->_skip_auth_check) {
						if (!$value['use']) {
							unset($_fields['all'][$key]);
							unset($_fields['must'][$key]);
							continue;
						}
					}
					$_method[$key] = $value['sort'];
					switch ($value['use']) {
					case '0':
						unset($_fields['all'][$key]);
						unset($_fields['must'][$key]);
						break;
					case '1':
						$_fields['all'][$key] = 1;
						unset($_fields['must'][$key]);
						break;
					case '2':
						$_fields['all'][$key] = 1;
						$_fields['must'][$key] = 1;
						break;
					}
				} else {
					foreach ($value as $k => $v) {
						if (CURRENT === "app" || $this->_skip_auth_check) {
							if (!$v['use']) {
								unset($_fields['all'][$key][$k]);
								unset($_fields['must'][$key][$k]);
								continue;
							}
						}
						$_method[$key . $k] = $v['sort'];
						switch ($v['use']) {
						case '0':
							unset($_fields['all'][$key][$k]);
							unset($_fields['must'][$key][$k]);
							break;
						case '1':
							$_fields['all'][$key][$k] = 1;
							unset($_fields['must'][$key][$k]);
							break;
						case '2':
							$_fields['all'][$key][$k] = 1;
							unset($_fields['must'][$key][$k]);
							break;
						}
					}
				}
			}
			asort($_method);

			while (list($key, $value) = each($_method)) {
				if (preg_match('/^extra/', $key)) {
					$k = intval(substr($key, 5));
					$_extras[$key]['k'] = $k;

					if ($_category['method']['extra'][$k]['select']) {

						$select = trim($_category['method']['extra'][$k]['select']);
						$select = preg_replace('/\n|\r\n/', "\n", $select);

						$_extras[$key]['list'] = explode("\n", $select);
					}
				}

			}

			if (!$this->_skip_auth_check) {
				if (CURRENT == 'app') {
					if (!$this->_auth->checkAuth()) {
						$_category['method']['email']['use'] = 2;
						$_fields['all']['email'] = 1;
						$_fields['must']['email'] = 1;
					}
				}
			}

			$this->_method = $_method;
			$this->_extras = $_extras;

			$_fields;

			return $_fields;

		}

	}

	private function sendMailShopping($_appinfo) {

		$this->_regist_id = $_appinfo['regist_id'];
		$registinfo = $this->getRegistInfo();

		$this->_shopping_category_id = $_appinfo['category_id'];
		$init_category = $this->getShoppingCategory();

//生協管理用メールアドレスを取得する。
		$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

		$init_ordermail = $_SESSION['config']['email'];
		$replymail = $_SESSION['config']['donotreply_email'];

//カテゴリごとのメール設定
		if ($init_category['ordermail']) {
			$init_ordermail = $init_category['ordermail'];
		} else if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
			$init_ordermail = $_SESSION['config']['component'][COMPONENT]['store_ordermail'];
		}

		if (is_object($this->_auth) && $this->_auth->checkAuth()) {
			if ($this->_auth->getAuthData('namef')) {

				$this->_smarty->assign('post_namef', $this->_auth->getAuthData('namef'));
				$this->_smarty->assign('post_nameg', $this->_auth->getAuthData('nameg'));

				$name = $this->_auth->getAuthData('namef') . ' ' . $this->_auth->getAuthData('nameg');
			} else {
				$name = $this->_auth->getUsername();
			}

			$email = $this->_auth->getAuthData('email');

		} else {
			$email = $registinfo['email'];
			$name = $registinfo['namef'] . ' ' . $registinfo['nameg'];
			$_appinfo['namef'] = $registinfo['namef'];
			$_appinfo['nameg'] = $registinfo['nameg'];
		}

		$this->_smarty->assign('post', $_appinfo);

// メール記載用変数設定
		$this->_smarty->assign('postage', $_appinfo['postage']);
		$this->_smarty->assign('total_price_all', $_appinfo['total_price_all']);
		$this->_smarty->assign('regist_code', $_appinfo['regist_code']);

		$this->_smarty->assign('init_category', $init_category);

		$_appinfo['add_id'] = '';

		if (intval($_appinfo['status']) > -1) {

			$this->_smarty->assign('master_pdo', 1);

			if (COMPONENT == "whk") {
				$this->_smarty->assign('view_order_id', $_appinfo['id']);
				$this->_smarty->assign('auth_user_id', $_appinfo['regist_id']);
				$this->_smarty->assign('regist', $registinfo);

				$content_order = $this->_smarty->fetch(ETC_DIR . ADM_DIR . 'templates/' . $_appinfo['component'] . '/content_order_mail.tpl');
				$this->_smarty->assign('content_order', htmlspecialchars_decode($content_order, ENT_QUOTES));
			} else if (isset($this->_payment_3d) && $this->_payment_3d == 1) {
				$this->_smarty->assign('view_order_id', $_appinfo['id']);
				$this->_smarty->assign('auth_user_id', $_appinfo['regist_id']);
				$this->_smarty->assign('regist', $registinfo);

				$content_order = $this->_smarty->fetch(ETC_DIR . ADM_DIR . 'templates/' . $_appinfo['component'] . '/content_order_mail.tpl');
				$this->_smarty->assign('content_order', htmlspecialchars_decode($content_order, ENT_QUOTES));
			} else {
				$content_order = $this->_smarty->fetch('content_order_mail.tpl');
				$this->_smarty->assign('content_order', htmlspecialchars_decode($content_order, ENT_QUOTES));
			}

			$cust_body = $this->_smarty->fetch('shop_order_mail.tpl');
			$order_body = $this->_smarty->fetch('coop_order_mail.tpl');

			$cust_subject = 'ご注文ありがとうございました【' . $init_category["denomination"] . '】';

			$arg['component'] = COMPONENT;
			$arg['part'] = PART;
			$arg['category_id'] = $init_category['id'];
			$arg['univ_id'] = $_SESSION['config']['univ_id'];
			$arg['regist_id'] = $this->_regist_id;

			self::send_mail($init_coopname, $replymail, $email, $cust_subject, $cust_body, $arg);

			$order_subject = $_appinfo['regist_code'] . '【' . $init_category["denomination"] . '】';
			$admarg = [];

//			self::send_mail($name, $email, $init_ordermail, $order_subject, $order_body, $admarg);
			self::send_mail($name, $replymail, $init_ordermail, $order_subject, $order_body, $admarg);

			//app_addへの登録

			$adddata['app_id'] = $this->_app_id;
			$adddata['regist_id'] = $this->_regist_id;
			$adddata['code'] = self::generateUuid();
			$this->_smarty->assign('adic', $adddata['code']);
			$this->_smarty->assign('view_ic', $data['code']);

			$adddata['subject'] = $cust_subject;
			$adddata['memo'] = $cust_body;

			$adddata['send'] = 1;
			$adddata['noreply'] = 1;
			$adddata['auto_send'] = 1;
			$adddata['add'] = COMPONENT;

			$this->set_postdata($adddata);
			$this->saveAppAdd();

			$_appinfo['add_id'] = $this->get_last_insertId();
		}
//ログのセット

		$logdata['kind'] = COMPONENT;
		$logdata['app_add_id'] = $_appinfo['add_id'];
		$logdata['target_id'] = $this->_app_id;
		$logdata['username'] = $email;
		$this->setLogdata($logdata);
		$this->insertLog();

	}

}
?>