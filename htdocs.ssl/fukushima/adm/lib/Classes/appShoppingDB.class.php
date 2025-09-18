<?php

require_once "Classes/payjp.class.php";
require_once "Classes/veritrans.class.php";

class appShoppingDB extends commonDB {

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	use baseFunction;
	use baseSendmail;
	use execShoppingCategories;
	use execShoppingItems;
	use execRegist;
	use execAppAdd;
	use execApp;
	use execShoppingApp;
	use execCreditCard;
	use extendAuth;
	use execSignOut;
	use execLog;
	use execPayment;
	use checkApp;
	use checkRegist;

	public function saveAppShopping() {

		$this->_init_category = $this->getShoppingCategory();

		if (isset($_POST['regist'])) {
			$this->execAppShopping();
		} else {

			if (isset($this->_shipdata['complete'])) {
				unset($this->_shipdata['complete']);
			}
			if (isset($this->_shipdata['app_id'])) {
				unset($this->_shipdata['app_id']);
			}

			if (isset($this->_shipdata['response_contents'])) {
				unset($this->_shipdata['response_contents']);
			}

			$this->calcAppShopping();
		}

	}

	private function execAppShopping() {

		$shipdata = $this->_shipdata;
		$init_category = $this->_init_category;
		$this->set_shopping_category_id($init_category['id']);

		if ($this->_auth->checkAuth()) {
			$this->_smarty->assign('post_pref', $this->_auth->getAuthData('pref'));
		} else {
			$this->_smarty->assign('post_pref', $shipdata['pref']);
		}

		if ($this->_cart['flag_drink']) {
			$this->_smarty->assign('flag_drink', 1);
		}

		try {
			$this->_pdo->beginTransaction();

			if (isset($shipdata['app_id']) && $shipdata['app_id']) {
				throw new Exception("すでにご注文が完了しています", 1);
			}

			$stock_errors = $this->checkCartItemStock();

			if (count($stock_errors)) {
				$this->_step = 9;
				$this->_smarty->assign('stock_errors', $stock_errors);
				$this->_smarty->assign('now_mode', 'view_cart');
				throw new Exception("Stock Error", 9);
			}

			$app_count = $this->getMaxAppCount() + 1;

			$infocode = $_SESSION['config']['component'][COMPONENT]['infocode'];
			$init_pagetitle = $_SESSION['config']['component'][COMPONENT]['title'];

			if ($init_category["infocode"]) {$infocode = $init_category["infocode"];}
			$infocode .= '-ODR';

			$regist_code = $infocode . ":" . date("Ymd") . "-" . sprintf("%04d", $app_count); //受付番号の番号作成
			$shipdata['regist_code'] = $regist_code;
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

			if ($this->_auth->checkAuth()) {
				$shipdata['regist_id'] = $this->_auth->getAuthData('id');

// 発送先の上書き
				if (!$shipdata['ship_flag'] || ($shipdata['ship_flag'] == 1 && $shipdata['ship_address'])) {

					if (!$shipdata['ship_flag']) {

						$shipdata['ship_namef'] = $this->_auth->getAuthData('namef');
						$shipdata['ship_nameg'] = $this->_auth->getAuthData('nameg');
						$shipdata['ship_kanaf'] = $this->_auth->getAuthData('kanaf');
						$shipdata['ship_kanag'] = $this->_auth->getAuthData('kanag');

						if ($this->_auth->getAuthData('new_addressf')) {
							$shipdata['ship_zipcodes'] = $this->_auth->getAuthData('new_zipcodes');
							$shipdata['ship_zipcodef'] = $this->_auth->getAuthData('new_zipcodef');
							$shipdata['ship_pref'] = $this->_auth->getAuthData('new_pref');
							$shipdata['ship_addressf'] = $this->_auth->getAuthData('new_addressf');
							$shipdata['ship_addresss'] = $this->_auth->getAuthData('new_addresss');
							$shipdata['ship_addresst'] = $this->_auth->getAuthData('new_addresst');
							if ($this->_auth->getAuthData('student_phone')) {
								$shipdata['ship_phonenumber'] = $this->_auth->getAuthData('student_phone');
							} else {
								$shipdata['ship_phonenumber'] = $this->_auth->getAuthData('mobilephone');
							}

						} else {
							$shipdata['ship_zipcodes'] = $this->_auth->getAuthData('zipcodes');
							$shipdata['ship_zipcodef'] = $this->_auth->getAuthData('zipcodef');
							$shipdata['ship_pref'] = $this->_auth->getAuthData('pref');
							$shipdata['ship_addressf'] = $this->_auth->getAuthData('addressf');
							$shipdata['ship_addresss'] = $this->_auth->getAuthData('addresss');
							$shipdata['ship_addresst'] = $this->_auth->getAuthData('addresst');
							$shipdata['ship_phonenumber'] = $this->_auth->getAuthData('phonenumber');
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
			}

//配送元配送先情報のチェック
			if (!$shipdata['ship_pref']) {
				$this->_smarty->assign('now_mode', 'view_cart');
				throw new Exception("Shipping Address Error", 8);
			}

//カード課金

			$this->set_paymentdata($shipdata);
			$this->set_regist_code($regist_code);
			$shipdata = $this->setCharges();

			if ($shipdata['payment'] == 5 && (isset($shipdata['response_contents']) && $shipdata['response_contents'])) {
				$shipdata['status'] = -1;
				$shipdata['arranged'] = 1;
				$this->_skip_app_count = 1;
			} else if ($shipdata['payment'] == 4) {
				$shipdata['status'] = -1;
				$shipdata['arranged'] = 1;
			} else {
				$shipdata['jpo'] = '';
				$shipdata['status'] = '';
				$shipdata['arranged'] = '';
			}

			$fields_sql_app['component'] = 'text';
			$shipdata['component'] = COMPONENT;

			$fields_sql_app['part'] = 'text';
			$shipdata['part'] = PART;

			$fields_sql_app['category_id'] = 'integer';
			$shipdata['category_id'] = $init_category['id'];

			if ($init_category['flag_send']) {
				$fields_sql_app['ship_date'] = 'text';
				$fields_sql_app['ship_time'] = 'text';
			}

			$category_methods['flag_send'] = $init_category['flag_send'];
			$category_methods['nominate'] = $init_category['nominate'];
			$shipdata['methods'] = json_encode($category_methods);
			$fields_sql_app['methods'] = 'text';

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
				'status' => 'integer',
				'jpo' => 'text',
			];

			$this->set_postdata($shipdata);

			$this->saveApp($fields_sql_app);
			$shipdata = $this->get_postdata();
			$shipdata['app_id'] = $this->get_last_insertId();

			if (!$shipdata['app_id']) {
				throw new Exception("受注内容の保存に失敗しました。", 1);
			}

			$this->_app_id = $shipdata['app_id'];

//個々の注文の保存
			$this->execAppSub();

			$this->execAppItemStock();

//配送先を保存
			$this->set_shipdata($shipdata);
			$this->execAppShip();

// 注文完了メールを送信する
			$this->sendMailShopping($shipdata);
			$this->_pdo->commit();

			if ($shipdata['status'] == -1) {
				HTTP_Session2::set('shipdata', $shipdata);
				switch ($shipdata['payment']) {
				case 4:
					$this->set_paymentdata($shipdata);
					$self = $this->getEndpointPayjp();

					break;
				case 5:
					$self .= '?mode=redirect';
					break;
				}
			} else {

				$cart['items'] = [];
				$cart['methods'] = [];
				HTTP_Session2::set('cart' . PART, $cart);

				$shipdata['complete'] = 1;
				HTTP_Session2::set('shipdata', $shipdata);
// 登録完了画面表示する
				$self .= '?mode=complete';
			}

			header("Location: $self");
			exit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();

			$shipdata['token_id'] = null;
			$shipdata['payjp-token'] = null;
			$shipdata['req_card_number'] = null;
			$shipdata['charged_id'] = null;
			$shipdata['api_key'] = null;
			$shipdata['api_secret_key'] = null;
			$shipdata['test_mode'] = null;
			$shipdata['receipt_number'] = null;
			$shipdata['payment_limit'] = null;
			$shipdata['jpo'] = null;
			$shipdata['org_number'] = null;
			$shipdata['customer_number'] = null;
			$shipdata['confirm_number'] = null;
			$shipdata['netbanking_url'] = null;
			$shipdata['response_contents'] = null;
			$shipdata['app_id'] = null;
			HTTP_Session2::set('shipdata', $shipdata);

			$this->_smarty->assign('post', $shipdata);

			throw new Exception($e->getMessage(), $e->getCode());
		}

		exit();

	}

	public function saveAppShip() {

		$fields_ship = [
			'ship_to' => 'text',
			'ship_phonenumber' => 'text',
		];

		$postdata = $this->execSanitize($fields_ship, $fields_ship);

		$postdata['regist_id'] = $this->_auth->getAuthData('id');
		$this->_fields_sql_app['regist_id'] = 'integer';

		if (!$postdata['regist_id']) {
			throw new Exception("ユーザーIDが不正です", 1);
		}

		$this->set_tbl('app_ship');
		$this->set_fields($this->_fields_sql_app);

		if ($_POST['address_id']) {
			$postdata['id'] = intval($_POST['address_id']);
		}

		$this->set_postdata($postdata);

		if ($postdata['id']) {
			$this->set_where(['id' => 'integer', 'regist_id' => 'integer']);
			$this->updateTable();
		} else {
			$this->insertTable();
		}

	}

	public function invisibleAppShip() {
		if (!$this->_auth->getAuthData('id')) {
			throw new Exception("ユーザーIDが不正です", 1);
		}
		if (!$this->_ship_address_id) {
			throw new Exception("アドレスの指定が不正です", 1);
		}

		$this->set_tbl('app_ship');
		$this->set_fields(['invisible' => 'integer']);

		$postdata['invisible'] = 1;
		$postdata['id'] = $this->_ship_address_id;
		$postdata['regist_id'] = $this->_auth->getAuthData('id');

		$this->set_postdata($postdata);

		$this->set_where(['id' => 'integer', 'regist_id' => 'integer']);
		$this->updateTable();

	}

	public function getAppShip() {

		if (!$this->_ship_address_id) {
			throw new Exception("no address id", 1);
		}

		$this->_postdata = [];
		$where = [];

		$sql = <<< HERE
SELECT * FROM app_ship AS s

HERE;

		if ($this->_ship_address_id) {
			$this->_postdata[':id'] = $this->_ship_address_id;
			array_push($where, "s.id = :id");
		}

		if (CURRENT == "app") {
			$this->_postdata[':regist_id'] = $this->_auth->getAuthData('id');
			array_push($where, "s.regist_id = :regist_id");
		}

		if (count($where)) {
			$sql .= " WHERE " . implode("\nAND ", $where) . "\n";
		}

		$this->_sql = $sql;
		$address = $this->selectTable();

		if (!count($address)) {
			throw new Exception("no address setting", 1);
		}

		return $address;

	}

	private function execAppShip() {

		$shipdata = $this->_shipdata;

		if ($this->_auth->checkAuth()) {
			if ($shipdata['ship_flag'] == 1) {

				$fields_ship = [
					'regist_id' => 'integer',
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
				];

				if ($shipdata['ship_address']) {
					$shipdata['id'] = $shipdata['ship_address'];
				}

				$this->set_fields($fields_ship);
				$this->set_tbl('app_ship');
				$this->set_postdata($shipdata);

				if (!$shipdata['ship_address']) {
					$this->insertTable();
				} else {
					$this->set_where(['id' => 'integer']);
					$this->updateTable();
				}
			}

		}
	}

	private function calcAppShopping() {

		$init_category = $this->_init_category;

		$fields_sql = [];
		$fields_sql_app = [];
		if (is_array(HTTP_Session2::get('fields_sql'))) {
			$fields_sql = HTTP_Session2::get('fields_sql');
		}
		if (is_array(HTTP_Session2::get('fields_sql_app'))) {
			$fields_sql_app = HTTP_Session2::get('fields_sql_app');
		}

		$this->calcSessionCart();

		$shipdata = $this->_shipdata;

		$methods = [];

		$this->_smarty->assign('getAuthdata_birthday', intval($this->_auth->getAuthData('birthday')));

		if ($this->_auth->getAuthData('new_addressf') && ($this->_auth->getAuthData('student_phone') || $this->_auth->getAuthData('mobilephone'))) {
			$this->_smarty->assign('getAuthdata_new_add', 1);
		} else if ($this->_auth->getAuthData('zipcodef') && $this->_auth->getAuthData('phonenumber')) {
			$this->_smarty->assign('getAuthdata_address', 1);
		} else {
			$methods['address']['use'] = 2;
			$methods['address']['title'] = "ご注文者住所";
			$methods['phonenumber']['use'] = 2;
			$methods['phonenumber']['title'] = "ご注文者電話番号";
		}

		if ($this->_auth->getAuthData('phonenumber')) {
			$this->_smarty->assign('getAuthdata_phonenumber', 1);
		}
/*
if ($this->_auth->getAuthData('member_namef')) {
$smarty->assign('getAuthdata_member_name', 1);
} else {
$methods['member_name']['use'] = 2;
}
 */

		if ($this->_cart['flag_drink']) {
			if (!$this->_smarty->getTemplateVars('getAuthdata_birthday')) {
				$methods['age']['use'] = 2;
			}
		}

		$tmpl = "view_cart.tpl";

		if (isset($_POST['step1'])) {
			$this->_step = 1;

			$tmpl = "view_cart.tpl";

		} else if (isset($_POST['step2']) || isset($_POST['ship_address'])) {

			$tmpl = "shop_step2.tpl";
			$this->_step = 2;

			if (!$this->_auth->checkAuth()) {
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

			if ($this->_cart['flag_drink']) {
				$methods['age']['use'] = 2;
			}

		} else if (isset($_POST['step3'])) {

			$tmpl = "shop_step3.tpl";
			$this->_step = 3;

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
					$methods['age']['use'] = 2;
					$shipdata["ship_age"] = intval($_POST["ship_age"]);
					if ($shipdata["ship_age"] == -1) {
						$this->_smarty->assign('no_adult_ship_age_err', 1);
						$this->_step = 3;

						$this->_smarty->assign('post', $shipdata);
						$this->_smarty->assign('methods', $methods);

						throw new Exception("お酒フラグエラー", 9);
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

			$tmpl = 'shop_confirm.tpl';
			$this->_step = 4;

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
			$tmpl = 'view_cart.tpl';
		}

		if ($_POST['reinput2']) {
			$this->_smarty->assign('reinput', 1);
			$tmpl = 'shop_step2.tpl';
		}

		if ($_POST['reinput3']) {
			$this->_smarty->assign('reinput', 1);
			$tmpl = 'shop_step3.tpl';
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
			} else if ($this->_auth->getAuthData('new_pref')) {
				$shipdata['postage_pref'] = $this->_auth->getAuthData('new_pref');
			} else {
				$shipdata['postage_pref'] = $this->_auth->getAuthData('pref');
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
			$this->_step = 9;
			$this->_smarty->assign('stock_errors', $stock_errors);
			$this->_smarty->assign('now_mode', 'view_cart');
			throw new Exception("Stock Error", 9);
		}

		$this->_smarty->display($tmpl);
		exit();

	}

}
?>
