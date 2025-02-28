<?php
trait execCreditCard {

	protected $_paymentdata;
	protected $_regist_code;
	protected $_site_api_key;
	protected $_site_api_secret_key;
	protected $_push_url;
	protected $_redirection_url;

	public function set_paymentdata($_paymentdata) {
		$this->_paymentdata = $_paymentdata;
	}
	public function set_regist_code($_regist_code) {
		$this->_regist_code = $_regist_code;
	}

	public function set_site_api_key($_site_api_key, $_site_api_secret_key = null) {
		$this->_site_api_key = $_site_api_key;
		$this->_site_api_secret_key = $_site_api_secret_key;
	}

	public function set_push_url($_push_url) {
		$this->_push_url = $_push_url;
	}
	public function set_redirection_url($_redirection_url) {
		$this->_redirection_url = $_redirection_url;
	}

// カード決済情報の格納
	private function calcCardPayment() {

		$paymentdata = $this->_paymentdata;

		switch ($paymentdata['payment']) {
		case '4':
			unset($paymentdata['token_id']);
			unset($paymentdata['req_card_number']);

			if (isset($_POST['chgCardInfo'])) {
				unset($paymentdata['payjp-token']);
			}

			if ($_POST['payjp-token']) {
				$paymentdata['payjp-token'] = addslashes($_POST['payjp-token']);
				$paymentdata['card_id'] = '';
			} else if ($_POST['payjp-card_id']) {
				$paymentdata['card_id'] = addslashes($_POST['payjp-card_id']);
			}

			$paymentdata['regist_card'] = 0;
			if (isset($_POST['regist_card'])) {
				$paymentdata['regist_card'] = intval($_POST['regist_card']);
			}

			if ($paymentdata['payjp-token']) {
				$paymentdata['card_id'] = '';
			} else {
				$paymentdata['regist_card'] = 0;
			}

			if ($paymentdata['regist_card']) {
				$paymentdata['card_id'] = '';
			}

			if ($this->_auth->getAuthData('cust_id')) {
				if (!isset($_POST['cust_id_error'])) {
					$paymentdata['cust_id'] = $this->_auth->getAuthData('cust_id');
				}

			}

			if (!$paymentdata['payjp-token'] && !$paymentdata['card_id']) {
				$this->_smarty->assign('card_err', 1);
				$this->_smarty->assign('err', 1);
			}
			if (isset($paymentdata['jpo'])) {
				unset($paymentdata['jpo']);
			}
			break;
		case '5':

			unset($paymentdata['payjp-token']);

			//veritrans処理
			if ($_POST['token_id']) {
				$paymentdata['token_id'] = addslashes($_POST['token_id']);
				$paymentdata['req_card_number'] = addslashes($_POST['req_card_number']);
				$paymentdata['card_id'] = '';
			} else if ($_POST['veritrans-card_id']) {

				$paymentdata['card_id'] = addslashes($_POST['veritrans-card_id']);
				$paymentdata['regist_card_number'] = addslashes($_POST['regist_card_number']);
				$paymentdata['token_id'] = '';
				$paymentdata['req_card_number'] = '';

			} else {
				$this->_smarty->assign('card_err', 1);
				$this->_smarty->assign('err', 1);
			}

			$paymentdata['regist_card'] = 0;
			if (isset($_POST['regist_card'])) {
				$paymentdata['regist_card'] = intval($_POST['regist_card']);
			}

			if (isset($_POST['jpo'])) {
				$paymentdata['jpo'] = addslashes($_POST['jpo']);
			}

			break;
		}

		return $paymentdata;

	}

	public function getEndpointPayjp() {

		$endpoint = \shopping\payjp\webCharge::ENDPOINT_3D_SECURE;
		$endpoint = preg_replace('/:resource_id/', $this->_paymentdata['charged_id'], $endpoint);

		$endpoint .= '?publickey=' . $this->_paymentdata['api_key_public'];

		$back_url = $this->_redirection_url;
		$back_url .= "&OrderId=" . $this->_paymentdata['charged_id'];

		$header = ["alg" => "HS256", "typ" => "JWT"];
		$payload = ["url" => $back_url];

		$signature = $this->_paymentdata['api_key'];

		$jws = new \Gamegos\JWS\JWS();

		$endpoint .= '&back_url=' . $jws->encode($header, $payload, $signature);

		return $endpoint;
	}

	public function setCharges() {

		global $init_url;

		switch ($this->_paymentdata['payment']) {
		case 4:

			$redirection_url = $init_url . "app/" . COMPONENT . "/";
			if (defined("PART")) {
				$redirection_url .= PART . "/";
			}
			$redirection_url .= "?mode=catch";

			$this->set_redirection_url($redirection_url);

			$this->execCreditCardPayjp();
			break;
		case 5:

			$redirection_url = $init_url . "app/" . COMPONENT . "/";
			if (defined("PART")) {
				$redirection_url .= PART . "/";
			}
			$redirection_url .= "?mode=catch";

			$this->set_redirection_url($redirection_url);
//			$this->execCreditCardVeritrans();
			$this->execCreditCard3DVeritrans();

			break;
		case 6:
			$this->execCvsVeritrans();
			break;
		default:
			$this->_paymentdata['token_id'] = null;
			$this->_paymentdata['payjp-token'] = null;
			$this->_paymentdata['req_card_number'] = null;
			$this->_paymentdata['charged_id'] = null;
			$this->_paymentdata['cust_id'] = null;
			$this->_paymentdata['card_id'] = null;
			$this->_paymentdata['api_key'] = null;
			$this->_paymentdata['api_secret_key'] = null;
			$this->_paymentdata['test_mode'] = null;
			break;
		}
		return $this->_paymentdata;
	}

	private function setBaseCreditCardPayjp() {
		if (!$this->_site_api_key) {
			throw new Exception("Error NO API", 1);
		}

		$card = new shopping\payjp\webCharge();
		$card->setApi_key($this->_site_api_key);

		return $card;
	}

	private function deleteCreditCardPayjp() {

		$changedata = $this->_postdata;

		$this->_card = setBaseCreditCardPayjp();

		$this->_card->setCustomer_id($changedata['cust_id']);
		$this->_card->setCard_id($changedata['card_id']);
		$card = $this->_card->deleteCard();

		if (is_array($card['err'])) {
			throw new Exception($card['err']['errmsg'], 1);
		}

	}

	private function execCreditCardPayjp() {

		$this->_charge = new shopping\payjp\webCharge();

		switch (COMPONENT) {
		case 'shopping':

			$init_category = $this->getShoppingCategory();

			if ($init_category['test_mode'] == 1) {
				$api_key = $this->_smarty->getConfigVars('payjp_api_test');
				$api_key_public = $this->_smarty->getConfigVars('payjp_public_api_test');
			} else {
				$api_key = $this->_smarty->getConfigVars('payjp_api');
				$api_key_public = $this->_smarty->getConfigVars('payjp_public_api');
			}
			break;

		default:

		}

		$this->_paymentdata['test_mode'] = $init_category['test_mode'];
		$this->_paymentdata['api_key'] = $api_key;
		$this->_paymentdata['api_key_public'] = $api_key_public;

		$this->_charge->setApi_key($this->_paymentdata['api_key']);

//PAY.JPユーザー
		$this->execUserPayjp();

		$card = [];
		if ($this->_paymentdata['payjp-token']) {
			$card['card'] = $this->_paymentdata['payjp-token'];

		} else if ($this->_paymentdata['cust_id']) {

			if ($this->_paymentdata['card_id']) {
				$card['customer'] = $this->_paymentdata['cust_id'];
				$card['card'] = $this->_paymentdata['card_id'];
			} else {
				$card['customer'] = $this->_paymentdata['cust_id'];
			}
		} else {
			throw new Exception('クレジットカードの処理に失敗しました(cus)', 9);
		}

		$card['amount'] = $this->_paymentdata['total_price_all'];
		$card['amount'] = intval($card['amount']);
		$card['description'] = $this->_regist_code;

		$this->_charge->setCard($card);

		$charges = $this->_charge->charge();
		if (is_array($charges['err'])) {
			$this->_smarty->assign('card_err', $charges['err']['errmsg']);
			$this->_smarty->assign('err', 1);
			throw new Exception('クレジットカードの処理に失敗しました(chg)', 9);
		}

		$this->_paymentdata['charged_id'] = $charges['id'];

	}

	private function execUserPayjp() {
		if (!$this->_auth->checkAuth()) {
			return;
		}

		if ($this->_paymentdata['regist_card'] && $this->_paymentdata['payjp-token']) {

			if ($this->_auth->getAuthData('cust_id')) {
//ユーザー更新
				$this->_charge->setCustomer_id($this->_auth->getAuthData('cust_id'));
				$this->_charge->setToken_id($this->_paymentdata['payjp-token']);
				$new_card = $this->_charge->createCard();
				$this->_paymentdata['card_id'] = $new_card->id;

//デフォルトカードを新規カードに変更
				$this->_charge->setCard_id($this->_paymentdata['card_id']);

				$customerdata['email'] = $this->_auth->getAuthData('email');
				$this->_charge->setCustomerData($customerdata);
				$this->_charge->updateCustomer();

			} else {

//ユーザー新規作成
				$this->_charge->setToken_id($this->_paymentdata['payjp-token']);
				$card['description'] = PART . '申込の際に登録';
				$this->_charge->setCustomerData($card);
				$new_customer = $this->_charge->createCustomer();

				if (!is_array($new_customer['err'])) {
					$custdata['cust_id'] = $new_customer->id;
					$custdata['card_id'] = $new_customer->cards->all()->data[0]->id;
					$fields = array('cust_id' => 'text');
					$custdata['id'] = $this->_auth->getAuthData('id');

					$this->set_fields($fields);
					$this->set_where(['id' => 'integer']);
					$this->set_postdata($custdata);
					$this->set_tbl('regist');

					$this->updateTable();
					$this->_auth->setAuthData('cust_id', $custdata['cust_id']);

					$this->_paymentdata['cust_id'] = $custdata['cust_id'];
					$this->_paymentdata['card_id'] = $custdata['card_id'];
				}
			}

			if (is_array($new_card['err'])) {
				$this->_smarty->assign('err', 1);
				throw new Exception('クレジットカードの処理に失敗しました(cus)', 9);
			} else if (is_array($new_customer['err'])) {
				$this->_smarty->assign('err', 1);
				throw new Exception('クレジットカードの処理に失敗しました(cus)', 9);
			} else {
				unset($this->_paymentdata['payjp-token']); //使用済みトークンの削除
			}

		}
	}

	private function deleteCreditCardVeritrans() {

		$changedata = $this->_postdata;

		$this->_card = new \shopping\veritrans\webCharge();
		$this->_card->setApi_key($this->_site_api_key, $this->_site_api_secret_key, 0);

		$this->_card->setCustomer_id($changedata['cust_id_veritrans']);
		$this->_card->setCard_id($changedata['card_id']);
		$card = $this->_card->deleteCard();

		if (is_array($card['err'])) {
			throw new Exception($card['err']['errmsg'], 1);
		}

	}

	private function addCreditCardVeritrans() {
		if (!$this->_auth->checkAuth()) {
			return;
		}
		$changedata = $this->_paymentdata;

		$this->_card = new \shopping\veritrans\webCharge();
		$this->_card->setApi_key($this->_site_api_key, $this->_site_api_secret_key, 0);

		$this->_card->setCustomer_id($changedata['cust_id_veritrans']);
		$this->_card->setToken_id($changedata['token_id']);
		$card = $this->_card->addCard();

		if (is_array($card['err'])) {
			throw new Exception($card['err']['errmsg'], 1);
		}

	}

	private function generateCusidVeritrans() {
		$uuid = "cus_" . sprintf('%011d', $this->_auth->getAuthData('id')) . '_' . self::generateUuid();
		return $uuid;
	}

	private function execCreditCardVeritrans() {

		$card = [];

		if ($this->_paymentdata['token_id']) {
			$card['token'] = $this->_paymentdata['token_id'];
		} else if ($this->_paymentdata['card_id']) {
			$card['card_id'] = $this->_paymentdata['card_id'];
			if (!$this->_auth->getAuthData('cust_id_veritrans')) {
				throw new Exception('クレジットカードの処理に失敗しました(1)');
			}
			$card['account_id'] = $this->_auth->getAuthData('cust_id_veritrans');
		} else {
			throw new Exception('クレジットカードの処理に失敗しました(1)');
		}

		if ($this->_paymentdata['regist_card'] && $this->_paymentdata['token_id']) {

			if ($this->_auth->getAuthData('cust_id_veritrans')) {
//ユーザー更新
				$card['account_id'] = $this->_auth->getAuthData('cust_id_veritrans');

			} else {
//ユーザー追加
				$card['account_id'] = $this->generateCusidVeritrans();
				$new_customer = 1;
			}
		}

		$card['charged_id'] = preg_replace('/:/', '-', $this->_regist_code);
		$card['charged_id'] .= "-" . Text_Password::create(8, 'unpronounceable', 'alphanumeric');
		$card['amount'] = $this->_paymentdata['total_price_all'];
		$card['amount'] = intval($card['amount']);
		$card['payment'] = intval($card['payment']);

		$card['regist_code'] = $this->_regist_code;
		$card['school_name'] = $this->_paymentdata['school_name'];
		$card['coopname'] = $this->_paymentdata['coopname'];

		if ($this->_paymentdata['with_capture']) {
			$card['with_capture'] = $this->_paymentdata['with_capture'];
		}
		$card['jpo'] = $this->_paymentdata['jpo'];

		$this->_charge = new \shopping\veritrans\webCharge();

		$this->_paymentdata['test_mode'] = null;

		$this->_paymentdata['api_key'] = $this->_smarty->getConfigVars('veritrans_api');
		$this->_paymentdata['api_secret_key'] = $this->_smarty->getConfigVars('veritrans_secret_api');

		switch (COMPONENT) {
		case 'shopping':

			$init_category = $this->getShoppingCategory();
			break;
		default:

		}

		$this->_paymentdata['test_mode'] = $init_category['test_mode'];

		$this->_charge->setApi_key($this->_paymentdata['api_key'], $this->_paymentdata['api_secret_key'], $this->_paymentdata['test_mode']);

		$this->_charge->setCard($card);
		$this->_paymentdata['charged_id'] = $this->_charge->charge();

		if ($this->_smarty->getTemplateVars('card_err')) {
			$this->_smarty->assign('card_err', $this->_smarty->getTemplateVars('card_err'));
			$this->_smarty->assign('err', 1);
			throw new Exception('クレジットカードの処理に失敗しました(chg)', 9);
		}

//ユーザー追加処理
		if ($new_customer && $card['account_id']) {

			$custdata['cust_id_veritrans'] = $card['account_id'];
			$fields = array('cust_id_veritrans' => 'text');
			$custdata['id'] = $this->_auth->getAuthData('id');

			$this->set_fields($fields);
			$this->set_where(['id' => 'integer']);
			$this->set_postdata($custdata);
			$this->set_tbl('regist');

			$this->updateTable();
			$this->_auth->setAuthData('cust_id_veritrans', $custdata['cust_id_veritrans']);
		}

	}

	private function execCreditCard3DVeritrans() {

		$card = [];

		if ($this->_paymentdata['token_id']) {
			$card['token'] = $this->_paymentdata['token_id'];
		} else if ($this->_paymentdata['card_id']) {
			$card['card_id'] = $this->_paymentdata['card_id'];
			if (!$this->_auth->getAuthData('cust_id_veritrans')) {
				throw new Exception('クレジットカードの処理に失敗しました(1)');
			}
			$card['account_id'] = $this->_auth->getAuthData('cust_id_veritrans');
		} else {
			throw new Exception('クレジットカードの処理に失敗しました(1)');
		}

		if ($this->_paymentdata['regist_card'] && $this->_paymentdata['token_id']) {

			if ($this->_auth->getAuthData('cust_id_veritrans')) {
//ユーザー更新
				$card['account_id'] = $this->_auth->getAuthData('cust_id_veritrans');

			} else {
//ユーザー追加
				$card['account_id'] = $this->generateCusidVeritrans();
				$new_customer = 1;
			}
		}

		$card['charged_id'] = preg_replace('/-\d{4,}$/', '', $this->_regist_code);
		$card['charged_id'] = preg_replace('/:/', '-', $card['charged_id']);
		$card['charged_id'] .= "-" . Text_Password::create(8, 'unpronounceable', 'alphanumeric');
		$card['amount'] = $this->_paymentdata['total_price_all'];
		$card['amount'] = intval($card['amount']);
		$card['payment'] = intval($this->_paymentdata['payment']);

		$card['regist_code'] = $this->_regist_code;
		$card['school_name'] = $this->_paymentdata['school_name'];
		$card['coopname'] = $this->_paymentdata['coopname'];

		if ($this->_paymentdata['with_capture']) {
			$card['with_capture'] = $this->_paymentdata['with_capture'];
		}
		$card['jpo'] = $this->_paymentdata['jpo'];

		$this->_charge = new \shopping\veritrans\webCharge();

		$this->_paymentdata['test_mode'] = null;

		$this->_paymentdata['api_key'] = $this->_smarty->getConfigVars('veritrans_api');
		$this->_paymentdata['api_secret_key'] = $this->_smarty->getConfigVars('veritrans_secret_api');

		switch (COMPONENT) {
		case 'shopping':

			$init_category = $this->getShoppingCategory();
			break;
		default:

		}

		if ($this->_push_url) {
			$this->_charge->set_push_url($this->_push_url);
		}
		if ($this->_redirection_url) {
			$this->_charge->set_redirection_url($this->_redirection_url);
		}

		$this->_paymentdata['test_mode'] = $init_category['test_mode'];

		$this->_charge->setApi_key($this->_paymentdata['api_key'], $this->_paymentdata['api_secret_key'], $this->_paymentdata['test_mode']);

		$this->_charge->setCard($card);
		$this->_paymentdata['charged_id'] = $this->_charge->charge3D();
		$this->_paymentdata['response_contents'] = $this->_charge->getResponseContents();

		if ($this->_smarty->getTemplateVars('card_err')) {
			$this->_smarty->assign('card_err', $this->_smarty->getTemplateVars('card_err'));
			$this->_smarty->assign('err', 1);
			throw new Exception('クレジットカードの処理に失敗しました(chg)', 9);
		}

//ユーザー追加処理
		if ($new_customer && $card['account_id']) {

			$custdata['cust_id_veritrans'] = $card['account_id'];
			$fields = array('cust_id_veritrans' => 'text');
			$custdata['id'] = $this->_auth->getAuthData('id');

			$this->set_fields($fields);
			$this->set_where(['id' => 'integer']);
			$this->set_postdata($custdata);
			$this->set_tbl('regist');

			$this->updateTable();
			$this->_auth->setAuthData('cust_id_veritrans', $custdata['cust_id_veritrans']);
		}

	}

	public function checkAuthHash() {

		if (!$this->_paymentdata['api_key']) {
			throw new Exception("パラメータが不正です", 1);
		}
		if (!$this->_paymentdata['api_secret_key']) {
			throw new Exception("パラメータが不正です", 1);
		}

		$vt = new \shopping\veritrans\webCharge();

		$vt->setApi_key($this->_paymentdata['api_key'], $this->_paymentdata['api_secret_key'], $this->_paymentdata['test_mode']);

		return $vt->checkAuthHash();
	}

	private function execCvsVeritrans() {
		$card = [];

		$card['charged_id'] = preg_replace('/:/', '-', $this->_regist_code);
		$card['charged_id'] .= "-" . Text_Password::create(8, 'unpronounceable', 'alphanumeric');
		$card['amount'] = $this->_paymentdata['price_total'];
		$card['amount'] = intval($card['amount']);

		$card['namef'] = $this->_paymentdata['namef'];
		$card['nameg'] = $this->_paymentdata['nameg'];

		$card['phonenumber'] = $this->_paymentdata['phonenumber'];

		$card['payment'] = $this->_paymentdata['payment'];
		$card['regist_code'] = $this->_regist_code;
		$card['school_name'] = $this->_paymentdata['school_name'];
		$card['coopname'] = $this->_paymentdata['coopname'];

		if (empty($card['charged_id'])) {
			$this->_smarty->assign('card_err', 'コンビニ払いの処理に失敗しました(1)');
			throw new Exception('コンビニ払いの処理に失敗しました(1)');
		} else if (empty($card['amount'])) {
			$this->_smarty->assign('card_err', '決済金額がゼロです');
			throw new Exception('コンビニ払いの処理に失敗しました(1)');
		}

		$vt = new \shopping\veritrans\webCharge();

		$init_travel = $this->_smarty->getTemplateVars("init_travel");

		$this->_paymentdata['test_mode'] = null;

		$this->_paymentdata['api_key'] = $this->_smarty->getConfigVars('veritrans_api');
		$this->_paymentdata['api_secret_key'] = $this->_smarty->getConfigVars('veritrans_secret_api');

		switch (COMPONENT) {
		case 'shopping':

			$init_category = $this->getShoppingCategory();
			break;
			$init_category['test_mode'] = null;
		default:

		}

		$vt->setApi_key($this->_paymentdata['api_key'], $this->_paymentdata['api_secret_key'], $this->_paymentdata['test_mode']);
		$vt->setCard($card);
		$this->_paymentdata['charged_id'] = $vt->chargeCvs();
		$this->_paymentdata['receipt_number'] = $vt->getReceiptNumber();
		$this->_paymentdata['payment_limit'] = $vt->getPaymentLimit();
//		$this->_paymentdata['haraikomi_url'] = $vt->getHaraikomiUrl();
	}
}
?>