<?php

require_once "Classes/payjp.class.php";
require_once "Classes/veritrans.class.php";

class adminShoppingOrderDB extends commonDB {

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	use adminAuth;
	use baseFunction;
	use baseSendmail;
	use execShoppingCategories;
	use execShoppingItems;
	use checkRegist;
	use execRegist;
	use execAppAdd;
	use execApp;
	use execShoppingApp;
	use execCreditCard;
	use execLog;

	public function saveAppShopping() {

		if ($this->_shipdata['category_id']) {
			$this->set_shopping_category_id($this->_shipdata['category_id']);
			$this->_init_category = $this->getShoppingCategory();
		}

		if (isset($_POST['regist'])) {
			$this->execAppShopping();
		} else {
			$this->calcAppShopping();
		}
	}

	private function calcAppShopping() {

		$fields_sql = [];
		$fields_sql_app = [];

		if (is_array(HTTP_Session2::get('fields_sql'))) {
			$fields_sql = HTTP_Session2::get('fields_sql');
		}
		if (is_array(HTTP_Session2::get('fields_sql_app'))) {
			$fields_sql_app = HTTP_Session2::get('fields_sql_app');
		}

		if (isset($_POST['order'])) {
			$this->_step = 1;

			$fields = ['category_id' => 'integer'];

			if (isset($_POST['regist_id'])) {
				$fields['regist_id'] = 'integer';
			} else {
				$shipdata['no_user'] = 1;
			}

			$this->set_postdata((array) $shipdata);
			$shipdata = $this->execSanitize($fields, $fields);

			HTTP_Session2::set('shipdata', $shipdata);
			HTTP_Session2::set('custdata', $custdata);

			throw new Exception("商品リストへ進む", 9);
			exit();
		}

		require_once "../../app/shopping/lib/selectPriceClass.php";

		if ($this->_shipdata['regist_id']) {
			$this->set_regist_id($this->_shipdata['regist_id']);
			$registinfo = $this->getRegistinfo();
		}
		$this->_smarty->assign('regist', $registinfo);

		$shipdata = $this->_shipdata;

		$init_category = $this->_init_category;

		if (isset($_POST['step1'])) {

			$tmpl = "view_cart.tpl";

			$this->calcSessionCart();

			$methods = [];

			$this->_smarty->assign('getAuthdata_birthday', intval($registinfo['birthday']));

			if (($registinfo['new_addressf'] && $registinfo['student_phone']) || $registinfo['mobilephone']) {
				$this->_smarty->assign('getAuthdata_new_add', 1);
			} else if ($registinfo['zipcodef'] && $registinfo['phonenumber']) {
				$this->_smarty->assign('getAuthdata_address', 1);
			} else {
				$methods['address']['use'] = 2;
				$methods['address']['title'] = "ご注文者住所";
				$methods['phonenumber']['use'] = 2;
				$methods['phonenumber']['title'] = "ご注文者電話番号";
			}

			if ($registinfo['phonenumber']) {
				$this->_smarty->assign('getAuthdata_phonenumber', 1);
			}

			if ($this->_cart['flag_drink']) {
				if (!$this->_smarty->getTemplateVars('getAuthdata_birthday')) {
					$methods['age']['use'] = 2;
				}
			}

			$this->_step = 2;

		} else if (isset($_POST['step2']) || isset($_POST['ship_address'])) {

			$this->_step = 3;

			if (!$shipdata['regist_id']) {
				$methods['email']['use'] = 2;
				$methods['name']['use'] = 2;
				$methods['address']['use'] = 2;
				$methods['phonenumber']['use'] = 2;
				$methods['membership']['use'] = 1;
			}

			$methods['ship_flag']['use'] = 1;

			$shipdata['ship_from'] = intval($_POST['ship_from']);

			if ($shipdata['ship_from']) {
				$methods['ship_from']['use'] = 2;
				$methods['ship_from_phonenumber']['use'] = 2;
			}

			$shipdata['ship_flag'] = intval($_POST['ship_flag']);

			switch ($shipdata['ship_flag']) {

			case 1:

				if (is_array($_POST['ship_address'])) {
					if ($shipdata['ship_address'] != intval(key($_POST['ship_address']))) {
						$shipdata['ship_address'] = intval(key($_POST['ship_address']));
						$shipdata['ship_age'] = null;
					}
				} else {
					unset($shipdata['ship_address']);
					unset($shipdata['postage_pref']);
					$methods['ship_to']['use'] = 2;
					$methods['ship_phonenumber']['use'] = 2;
				}
				break;

			case 2:
				$methods['store']['use'] = 2;
				break;

			}

			$fields = $this->calcMethod2Field($methods);

			$this->set_postdata($shipdata);
			$shipdata = $this->execSanitize($fields['all'], $fields['must']);

			HTTP_Session2::set('fields_sql', $this->_fields_sql);
			HTTP_Session2::set('fields_sql_app', $this->_fields_sql_app);

		} else if (isset($_POST['step3'])) {

			$this->_step = 4;

			if ($shipdata['ship_flag'] < 2) {

				if ($init_category['flag_send']) {

					$fields = ['ship_date' => 'text', 'ship_time' => 'text'];
					$this->set_postdata($shipdata);
					$shipdata = $this->execSanitize($fields, $fields);

					$fields_sql_app += $fields;

				}
			}
			if ($this->_cart['flag_drink']) {
				if ($shipdata["ship_flag"] == 1) {
					$shipdata["ship_age"] = intval($_POST["ship_age"]);
					if ($shipdata["ship_age"] == -1) {
						$this->_smarty->assign('no_adult_ship_age_err', 1);
						$this->_smarty->assign('err', 1);
					}

					$fields_sql_app += ['ship_age' => 'integer'];
				}
			}

// カートの商品数
			$ctr = count($this->_cart['items']);

			$fields = ['ship_date', 'ship_time', 'wrap', 'noshi', 'noshi_other', 'noshi_name'
				, 'extra1', 'extra2', 'extra3'];

			for ($i = 1; $i <= $ctr; $i++) {
				foreach ($fields as $field) {
					$value = strip_tags($_POST[$field . $i]);
					$value = mb_convert_kana($value, "KV");
					$value = htmlspecialchars($value, 3, "UTF-8");
					$this->_cart['items'][($i - 1)][$field] = $value;
				}
			}

			HTTP_Session2::set('fields_sql_app', $fields_sql_app);

		} else if (isset($_POST['confirm'])) {

			$this->_step = 5;

			$fields_bill_must = [
				'bill_zipcodef' => 'integer',
				'bill_zipcodes' => 'integer',
				'bill_pref' => 'text',
				'bill_addressf' => 'text',
				'bill_name' => 'text',
			];
			$fields_bill = [
				'bill_zipcodef' => 'integer',
				'bill_zipcodes' => 'integer',
				'bill_pref' => 'text',
				'bill_addressf' => 'text',
				'bill_addresss' => 'text',
				'bill_addresst' => 'text',
				'bill_name' => 'text',
			];

			$fields['all'] = [
				'payment' => 'integer',
				"memo" => 'text',
			];

			$fields['must'] = [
				'payment' => 'integer',
			];
			$fields_sql_app += $fields['all'];

			$paymentTypeList = $this->_smarty->getTemplateVars('paymentTypeList');

			if ($paymentTypeList[$_POST['payment']]) {

				unset($fields_sql_app['bill']);
				unset($shipdata['bill']);
				foreach ($fields_bill as $key => $value) {
					unset($fields_sql_app[$key]);
					unset($shipdata[$key]);
				}

			} else {

				if ($init_category['opt_bill']) {
					if ($shipdata['ship_flag'] < 2) {
						$fields['all']['bill'] = 'integer';
						$fields_sql_app += ['bill' => 'integer'];
					}

					if ($_POST['bill'] == 3) {

						$fields['all'] += $fields_bill;
						$fields['must'] += $fields_bill_must;

						$fields_sql_app += $fields_bill;

					}
				}
			}

			$this->set_postdata($shipdata);

			$shipdata = $this->execSanitize($fields['all'], $fields['must']);

			$paymentdata = [
				'payment' => $shipdata['payment'],
				'token_id' => $shipdata['token_id'],
				'payjp-token' => $shipdata['payjp-token'],
				'req_card_number' => $shipdata['req_card_number'],
				'charged_id' => $shipdata['charged_id'],
				'api_key' => $shipdata['api_key'],
				'api_secret_key' => $shipdata['api_secret_key'],
				'test_mode' => $shipdata['test_mode'],
			];

			$this->set_paymentdata($paymentdata);
			$paymentdata = $this->calcCardPayment();

			$shipdata = array_merge($shipdata, $paymentdata);

			HTTP_Session2::set('fields_sql_app', $fields_sql_app);

// 再入力の場合
		} else if ($_POST['reinput1']) {
			$this->_smarty->assign('reinput', 1);
			$this->_step = 2;
		}

		if ($_POST['reinput2']) {
			$this->_smarty->assign('reinput', 1);
			$this->_step = 3;
		}

		if ($_POST['reinput3']) {
			$this->_smarty->assign('reinput', 1);
			$this->_step = 4;
		}

//合計金額・送料計算

		$namespace = '\\shopping\\' . PART . '\\price';
		if (!class_exists($namespace)) {
			$namespace = '\\shopping\\common\\price';
		}

		$ps = new $namespace;

		if ($shipdata['ship_flag'] == 0) {
			if ($shipdata['new_pref']) {
				$shipdata['postage_pref'] = $shipdata['new_pref'];
			} else if ($registinfo['new_pref']) {
				$shipdata['postage_pref'] = $registinfo['new_pref'];
			} else {
				$shipdata['postage_pref'] = $registinfo['pref'];
			}
		}

		if ($shipdata['ship_address']) {

			$this->set_ship_address_id($shipdata['ship_address']);
			$ship_address = $this->getAppShip();

			$shipdata['postage_pref'] = $ship_address['ship_pref'];
		}

		$ps->set_postdata($shipdata);
		$ps->set_cart($this->_cart);
		$ps->calc_price();

		$cart = $ps->get_cart();

		HTTP_Session2::set('cart' . PART, $cart);

		$postage = $ps->get_postage();
		$reduction = $ps->get_reduction();
		$total_price = $ps->get_price();
		$this->_smarty->assign("postage", $postage);
		$this->_smarty->assign("reduction", $reduction);
		$this->_smarty->assign('total_price', $total_price);
		$this->_smarty->assign('total_price_all', $total_price + $postage - $reduction);

		$this->_smarty->assign('is_item_exist', count($this->_cart['items']));

		$shipdata['postage'] = $postage;
		$shipdata['reduction'] = $reduction;
		$shipdata['total_price'] = $total_price;
		$shipdata['total_price_all'] = $total_price + $postage - $reduction;

		HTTP_Session2::set('shipdata', $shipdata);

		$this->_smarty->assign('post', $shipdata);
		$this->_smarty->assign('methods', $methods);

		$stock_errors = $this->checkCartItemStock();

		if (count($stock_errors)) {
			$this->_smarty->assign('stock_errors', $stock_errors);
		}

		throw new Exception("stepごとに進む", 9);
	}

	private function execAppShopping() {

		$shipdata = $this->_shipdata;
		$init_category = $this->_init_category;
		$this->set_shopping_category_id($init_category['id']);

		if ($this->_shipdata['regist_id']) {
			$this->set_regist_id($this->_shipdata['regist_id']);
			$registinfo = $this->getRegistinfo();
		}
		$this->_smarty->assign('regist', $registinfo);

		if ($this->_shipdata['regist_id']) {
			$this->_smarty->assign('post_pref', $registinfo['pref']);
		} else {
			$this->_smarty->assign('post_pref', $shipdata['pref']);
		}

		if ($this->_cart['flag_drink']) {
			$this->_smarty->assign('flag_drink', 1);
		}

		try {
			$this->_pdo->beginTransaction();

			$stock_errors = $this->checkCartItemStock();

			$app_count = $this->getMaxAppCount() + 1;

			$infocode = $_SESSION['config']['component'][COMPONENT]['infocode'];
			$init_pagetitle = $_SESSION['config']['component'][COMPONENT]['title'];

			if ($init_category["infocode"]) {$infocode = $init_category["infocode"];}
			$infocode .= '-ODR';

			$regist_code = $infocode . ":" . date("Ymd") . "-" . sprintf("%04d", $app_count); //受付番号の番号作成
			$this->_smarty->assign('regist_code', $regist_code);

			if ($this->_smarty->getTemplateVars('err') != '') {
				throw new Exception("Error", 1);
			}

			$fields_sql = HTTP_Session2::get('fields_sql');
			$fields_sql_app = HTTP_Session2::get('fields_sql_app');

			$this->set_postdata($shipdata);

			if (count($fields_sql)) {
				$this->saveRegist($fields_sql);
			}

			if ($shipdata['regist_id']) {

// 発送先の上書き
				if (!$shipdata['ship_flag'] || ($shipdata['ship_flag'] == 1 && $shipdata['ship_address'])) {

					if (!$shipdata['ship_flag']) {

						$shipdata['ship_namef'] = $registinfo['namef'];
						$shipdata['ship_nameg'] = $registinfo['nameg'];
						$shipdata['ship_kanaf'] = $registinfo['kanaf'];
						$shipdata['ship_kanag'] = $registinfo['kanag'];

						if ($registinfo['new_addressf']) {
							$shipdata['ship_zipcodes'] = $registinfo['new_zipcodes'];
							$shipdata['ship_zipcodef'] = $registinfo['new_zipcodef'];
							$shipdata['ship_pref'] = $registinfo['new_pref'];
							$shipdata['ship_addressf'] = $registinfo['new_addressf'];
							$shipdata['ship_addresss'] = $registinfo['new_addresss'];
							$shipdata['ship_addresst'] = $registinfo['new_addresst'];
							if ($registinfo['student_phone']) {
								$shipdata['ship_phonenumber'] = $registinfo['student_phone'];
							} else {
								$shipdata['ship_phonenumber'] = $registinfo['mobilephone'];
							}

						} else {
							$shipdata['ship_zipcodes'] = $registinfo['zipcodes'];
							$shipdata['ship_zipcodef'] = $registinfo['zipcodef'];
							$shipdata['ship_pref'] = $registinfo['pref'];
							$shipdata['ship_addressf'] = $registinfo['addressf'];
							$shipdata['ship_addresss'] = $registinfo['addresss'];
							$shipdata['ship_addresst'] = $registinfo['addresst'];
							$shipdata['ship_phonenumber'] = $registinfo['phonenumber'];
						}

					} else if ($shipdata['ship_address']) {

						$this->set_ship_address_id($shipdata['ship_address']);
						$ship_address = $this->getAppShip();

						$shipdata['ship_namef'] = $ship_address['ship_namef'];
						$shipdata['ship_nameg'] = $ship_address['ship_nameg'];
						$shipdata['ship_kanaf'] = $ship_address['ship_kanaf'];
						$shipdata['ship_kanag'] = $ship_address['ship_kanag'];

						$shipdata['ship_zipcodes'] = $ship_address['ship_zipcodes'];
						$shipdata['ship_zipcodef'] = $ship_address['ship_zipcodef'];
						$shipdata['ship_pref'] = $ship_address['ship_pref'];
						$shipdata['ship_addressf'] = $ship_address['ship_addressf'];
						$shipdata['ship_addresss'] = $ship_address['ship_addresss'];
						$shipdata['ship_addresst'] = $ship_address['ship_addresst'];
						$shipdata['ship_phonenumber'] = $ship_address['ship_phonenumber'];
						if ($this->_cart['flag_drink']) {
							if (!$shipdata['ship_age']) {
								$shipdata['ship_age'] = $ship_address['ship_age'];
							}
						}
					}

				}

				$custdata['regist_id'] = $shipdata['regist_id'];

			} else {

				$shipdata['regist_id'] = $this->get_last_insertId();

				if (!$shipdata['ship_flag']) {

					$shipdata['ship_namef'] = $shipdata['namef'];
					$shipdata['ship_nameg'] = $shipdata['nameg'];
					$shipdata['ship_kanaf'] = $shipdata['kanaf'];
					$shipdata['ship_kanag'] = $shipdata['kanag'];

					$shipdata['ship_zipcodes'] = $shipdata['zipcodes'];
					$shipdata['ship_zipcodef'] = $shipdata['zipcodef'];
					$shipdata['ship_pref'] = $shipdata['pref'];
					$shipdata['ship_addressf'] = $shipdata['addressf'];
					$shipdata['ship_addresss'] = $shipdata['addresss'];
					$shipdata['ship_addresst'] = $shipdata['addresst'];
					$shipdata['ship_phonenumber'] = $shipdata['phonenumber'];
				}

				$custdata['namef'] = $shipdata['namef'];
				$custdata['nameg'] = $shipdata['nameg'];
				$custdata['kanaf'] = $shipdata['kanaf'];
				$custdata['kanag'] = $shipdata['kanag'];

				$custdata['zipcodes'] = $shipdata['zipcodes'];
				$custdata['zipcodef'] = $shipdata['zipcodef'];
				$custdata['pref'] = $shipdata['pref'];
				$custdata['addressf'] = $shipdata['addressf'];
				$custdata['addresss'] = $shipdata['addresss'];
				$custdata['addresst'] = $shipdata['addresst'];

				if ($shipdata['phonenumber1']) {
					$custdata['phonenumber1'] = $shipdata['phonenumber1'];
					$custdata['phonenumber2'] = $shipdata['phonenumber2'];
					$custdata['phonenumber3'] = $shipdata['phonenumber3'];
				}

				if ($shipdata['email']) {
					$custdata['email'] = $shipdata['email'];
					$custdata['emailcfrm'] = $shipdata['email'];
				} else {
					$custdata['email'] = 'NO_USER@u-coop.or.jp';
					$custdata['emailcfrm'] = 'NO_USER@u-coop.or.jp';
				}
				$custdata['no_user'] = 1;

			}

			$custdata['category_id'] = $shipdata['category_id'];

//カード課金しない
			/*
				$this->set_paymentdata($shipdata);
				$this->set_regist_code($regist_code);
				$shipdata = $this->setCharges();
			*/
			$fields_sql_app['component'] = 'text';
			$shipdata['component'] = COMPONENT;

			$fields_sql_app['part'] = 'text';
			$shipdata['part'] = PART;

			$fields_sql_app['category_id'] = 'integer';
			$shipdata['category_id'] = $init_category['id'];

			$fields_sql_app['admin_flag'] = 'integer';
			$shipdata['admin_flag'] = 1;

			$fields_sql_app += [
				'ship_namef' => "text",
				'ship_nameg' => "text",
				'ship_kanaf' => "text",
				'ship_kanag' => "text",
				'ship_zipcodef' => "integer",
				'ship_zipcodes' => "integer",
				'ship_pref' => "text",
				'ship_addressf' => "text",
				'ship_addresss' => "text",
				'ship_addresst' => "text",
				'ship_phonenumber' => "text",
				'ship_age' => "integer",
				'ship_flag' => "integer",

				'postage' => 'integer',
				'total_price' => 'integer',
				'reduction' => 'integer',
				'api_key' => 'text',
				'api_secret_key' => 'text',
				'test_mode' => 'text',
				'charged_id' => 'text',
			];

			$this->set_postdata($shipdata);

			$this->saveApp($fields_sql_app);
			$shipdata = $this->get_postdata();
			$shipdata['app_id'] = $this->get_last_insertId();

			$this->_app_id = $shipdata['app_id'];

//個々の注文の保存
			$this->execAppSub();

			$this->execAppItemStock();

//配送先を保存はしない
			//			$this->set_shipdata($shipdata);
			//			$this->execAppShip();

// 注文完了メールを送信しない
			//ログのセット

			$logdata['process'] = 'regist_app_shopping';
			$logdata['app_id'] = $this->_app_id;
			$logdata['auth_username'] = $this->_adminAuth->getUsername();
			$logdata['value'] = json_encode($shipdata);
			$logdata['component'] = COMPONENT;

			$this->setLogdata($logdata);
			$this->insertLog();

			$this->_pdo->commit();

			$cart['items'] = [];
			$cart['methods'] = [];
			HTTP_Session2::set('cart' . PART, $cart);

			$shipdata['complete'] = 1;
			HTTP_Session2::set('shipdata', $shipdata);
			HTTP_Session2::set('custdata', $custdata);

// 登録完了画面表示する
			$self .= '?mode=complete';
			header("Location: $self");
			exit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception($e->getMessage(), $e->getCode());
		}

		exit();

	}

}
?>
