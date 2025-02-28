<?php

namespace shopping\payjp;

require_once "composer/vendor/autoload.php";

class webCharge {

	const ENDPOINT_3D_SECURE = "https://api.pay.jp/v1/tds/:resource_id/start";

	public $_smarty;

	public function __construct() {
		global $smarty;
		$this->_smarty = $smarty;
	}

	private $_options;

	const MESSAGE_3D_SECURE = [
		'unverified' => "本人認証が行われていません。",
		'error' => "本人認証が行われていません。",
		'attempted' => "3Dセキュア（本人認証サービス）に対応しているカードをご利用ください。",
		'failed' => "本人認証に失敗しました。",
		'' => "不明なエラーが発生しました。",
		'verified' => "本人認証に成功しました。",
	];

	private $_api_key;

	private $_card_id;
	private $_err;
	private $_charged;
	private $_charged_id;
	private $_token_id;
	private $_customer_id;

	private $_carddata;
	private $_customerdata;

	public function setApi_key($_api_key) {
		$this->_api_key = $_api_key;

		try {
			\Payjp\Payjp::setVerifySslCerts(false);

			\Payjp\Payjp::setApiKey($this->_api_key);

		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
			exit();
		}

	}

	public function setCharged_id($_charged_id) {
		$this->_charged_id = $_charged_id;
	}
	public function setCard_id($_card_id) {
		$this->_card_id = $_card_id;
	}

	public function setToken_id($_token_id) {
		$this->_token_id = $_token_id;
	}
	public function setCustomer_id($_customer_id) {
		$this->_customer_id = $_customer_id;
	}

	public function setCustomerData($_customerdata) {
		$this->_customerdata = (object) $_customerdata;
	}

	public function setCard($_carddata, $_options = null) {
		$_carddata['currency'] = "jpy";
		$_carddata['capture'] = $this->_smarty->getConfigVars("capture");
		$_carddata['expiry_days'] = $this->_smarty->getConfigVars("expiry_days");
		$_carddata['three_d_secure'] = "true";
		$this->_carddata = $_carddata;
	}

	public function charge() {

		try {
			$ch = \Payjp\Charge::create($this->_carddata);
		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$ch['err'] = $this->_err;
		}
		return $ch;
	}

	public function chargeFinish() {

		try {
			$ch = \Payjp\Charge::retrieve($this->_charged_id);
			$ch->tdsFinish();
		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$ch['err'] = $this->_err;
		}
		return $ch;
	}

	public function getChargedInfo() {

		if ($this->_charged_id) {
			try {

				$charged = \Payjp\Charge::retrieve($this->_charged_id);
				return $charged;

			} catch (\Payjp\Error\Card $e) {
				// Since it's a decline, \Payjp\Error\Card will be caught
				$this->errorOperation($e);
			} catch (\Payjp\Error\InvalidRequest $e) {
				// Invalid parameters were supplied to Payjp's API
				$this->errorOperation($e);
			} catch (\Payjp\Error\Authentication $e) {
				// Authentication with Payjp's API failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\ApiConnection $e) {
				// Network communication with Payjp failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\Base $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
				$this->errorOperation($e);
			} catch (Exception $e) {
				// Something else happened, completely unrelated to Payjp
				$this->errorOperation($e);
			}

			if (is_array($this->_err)) {
				$charged['err'] = $this->_err;
			}

		} else {
			$charged['err']['errmsg'] = '課金情報が見つかりません';
		}
		return $charged;
	}

	public function updateChargedInfo($_description) {

		if ($this->_charged_id) {
			try {

				$charged = \Payjp\Charge::retrieve($this->_charged_id);
				$charged->description = $_description;
				$charged->save();

			} catch (\Payjp\Error\Card $e) {
				// Since it's a decline, \Payjp\Error\Card will be caught
				$this->errorOperation($e);
			} catch (\Payjp\Error\InvalidRequest $e) {
				// Invalid parameters were supplied to Payjp's API
				$this->errorOperation($e);
			} catch (\Payjp\Error\Authentication $e) {
				// Authentication with Payjp's API failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\ApiConnection $e) {
				// Network communication with Payjp failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\Base $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
				$this->errorOperation($e);
			} catch (Exception $e) {
				// Something else happened, completely unrelated to Payjp
				$this->errorOperation($e);
			}

			if (is_array($this->_err)) {
				$charged['err'] = $this->_err;
			}

		} else {
			$charged['err']['errmsg'] = '課金情報が見つかりません';
		}
		return $charged;
	}

	public function capture() {
		$_carddata = $this->_carddata;
		if ($_carddata['charged_id']) {

			try {

				$capture = \Payjp\Charge::retrieve($_carddata['charged_id']);
				if ($_carddata['amount'] > 0) {
					$capture->capture(array("amount" => $_carddata['amount']));
				} else {
					$capture->capture();
				}

			} catch (\Payjp\Error\Card $e) {
				// Since it's a decline, \Payjp\Error\Card will be caught
				$this->errorOperation($e);
			} catch (\Payjp\Error\InvalidRequest $e) {
				// Invalid parameters were supplied to Payjp's API
				$this->errorOperation($e);
			} catch (\Payjp\Error\Authentication $e) {
				// Authentication with Payjp's API failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\ApiConnection $e) {
				// Network communication with Payjp failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\Base $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
				$this->errorOperation($e);
			} catch (Exception $e) {
				// Something else happened, completely unrelated to Payjp
				$this->errorOperation($e);
			}

			if (is_array($this->_err)) {
				$capture['err'] = $this->_err;
			}

		} else {
			$capture['err']['errmsg'] = '課金情報が見つかりません';
		}
		return $capture;
	}

	public function refund() {
		$_carddata = $this->_carddata;
		if ($_carddata['charged_id']) {

			try {

				$capture = \Payjp\Charge::retrieve($_carddata['charged_id']);
				if ($_carddata['amount'] > 0) {
					$capture->refund(array("amount" => $_carddata['amount']));
				} else {
					$capture->refund();
				}

			} catch (\Payjp\Error\Card $e) {
				// Since it's a decline, \Payjp\Error\Card will be caught
				$this->errorOperation($e);
			} catch (\Payjp\Error\InvalidRequest $e) {
				// Invalid parameters were supplied to Payjp's API
				$this->errorOperation($e);
			} catch (\Payjp\Error\Authentication $e) {
				// Authentication with Payjp's API failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\ApiConnection $e) {
				// Network communication with Payjp failed
				$this->errorOperation($e);
			} catch (\Payjp\Error\Base $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
				$this->errorOperation($e);
			} catch (Exception $e) {
				// Something else happened, completely unrelated to Payjp
				$this->errorOperation($e);
			}

			if (is_array($this->_err)) {
				$capture['err'] = $this->_err;
			}

		} else {
			$capture['err']['errmsg'] = '課金情報が見つかりません';
		}
		return $capture;
	}

// tokenから情報取得

	public function getTokenInfo() {
		try {
			$token = \Payjp\Token::retrieve($this->_token_id);
		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$token['err'] = $this->_err;
		}
		return $token;
	}

	private function errorOperation($e) {
		$body = $e->getJsonBody();
		$err = $body['error'];
		$errorList = array(
			'invalid_number' => '不正なカード番号です。',
			'invalid_cvc' => '不正なCVCです。',
			'invalid_expiry_month' => '不正な有効期限(月)です。',
			'invalid_expiry_year' => '不正な有効期限(年)です。',
			'expired_card' => '有効期限切れです。',
			'card_declined' => 'カード会社によって拒否されたカードです。',
			'processing_error' => '決済ネットワーク上でエラーが生じています。',
			'missing_card' => 'カード情報が保持されていません。',
			'invalid_id' => '不正なIDです。',
			'no_api_key' => 'APIキーがセットされていません。',
			'invalid_api_key' => '不正なAPIキーです。',
			'invalid_plan' => '不正なプランです。',
			'invalid_expiry_days' => '不正な失効日数です。',
			'unnecessary_expiry_days' => '失効日数が不要なパラメーターです。',
			'invalid_flexible_id' => '不正なID指定です。',
			'invalid_timestamp' => '不正なUnixタイムスタンプです。',
			'invalid_trial_end' => '不正なトライアル終了日です。',
			'invalid_string_length' => '不正な文字列長です。',
			'invalid_country' => '不正な国名コードです。',
			'invalid_currency' => '不正な通貨コードです。',
			'invalid_address_zip' => '不正な郵便番号です。',
			'invalid_amount' => '不正な支払い金額です。',
			'invalid_plan_amount' => '不正なプラン金額です。',
			'invalid_card' => '不正なカード情報です。',
			'invalid_customer' => '不正な顧客情報です。',
			'invalid_boolean' => '不正な論理値です。',
			'invalid_email' => '不正なメールアドレスです。',
			'no_allowed_param' => 'パラメーターが許可されていません。',
			'no_param' => 'パラメーターが何もセットされていません。',
			'invalid_querystring' => '不正なクエリー文字列です。',
			'missing_param' => '必要なパラメーターがセットされていません。',
			'invalid_param_key' => '指定できない不正なパラメーターです。',
			'no_payment_method' => '支払い手段がセットされていません。',
			'payment_method_duplicate' => '支払い手段が重複してセットされています。',
			'payment_method_duplicate_including_customer' => '支払い手段が重複してセットされています(顧客IDを含む)。',
			'failed_payment' => '指定した支払いが失敗しています。',
			'invalid_refund_amount' => '不正な返金額です。',
			'already_refunded' => 'すでに返金済みです。',
			'cannot_refund_by_amount' => '返金済みの支払いに対して部分返金が行えません。',
			'invalid_amount_to_not_captured' => '確定されていない支払いに対して部分返金が行えません。',
			'refund_amount_gt_net' => '返金額が元の支払い額より大きいです。',
			'capture_amount_gt_net' => '支払い確定額が元の支払い額より大きいです。',
			'invalid_refund_reason' => '不正な返金理由です。',
			'already_captured' => 'すでに支払いが確定済みです。',
			'cant_capture_refunded_charge' => '返金済みの支払いに対して支払い確定が行えません。',
			'charge_expired' => '認証が失効している支払いです。',
			'alerady_exist_id' => 'すでに存在しているIDです。',
			'token_already_used' => 'すでに使用済みのトークンです。',
			'already_have_card' => 'すでに保持しているカード情報です。',
			'dont_has_this_card' => '顧客が指定したカード情報を保持していません。',
			'doesnt_have_card' => '顧客がカード情報を何も保持していません。',
			'invalid_interval' => '不正な課金周期です。',
			'invalid_trial_days' => '不正なトライアル日数です。',
			'invalid_billing_day' => '不正な支払い実行日です。',
			'exist_subscribers' => '購入者が存在するプランは削除できません。',
			'already_subscribed' => 'すでに定期課金済みの顧客です。',
			'already_canceled' => 'すでにキャンセル済みの定期課金です。',
			'already_pasued' => 'すでに停止済みの定期課金です。',
			'subscription_worked' => 'すでに稼働している定期課金です。',
			'test_card_on_livemode' => '本番モードのリクエストにテストカードが使用されています。',
			'not_activated_account' => '本番モードが許可されていないアカウントです。',
			'too_many_test_request' => 'テストモードのリクエストリミットを超過しています。',
			'invalid_access' => '不正なアクセスです。',
			'payjp_wrong' => 'PAY.JPのサーバー側でエラーが発生しています。',
			'pg_wrong' => '決済代行会社のサーバー側でエラーが発生しています。',
			'not_found' => 'リクエスト先が存在しません。',
			'not_allowed_method' => '許可されていないHTTPメソッドです。',
			'not_in_three_d_secure_flow' => '不正な本人認証の手続きです。',
		);

//		print('Status is:' . $e->getHttpStatus() . "\n");
		//		print('Type is:' . $err['type'] . "\n");
		//		print('Param is:' . $err['param'] . "\n");
		//		print('Message is:' . $err['message'] . "\n");
		$err['errmsg'] = $errorList[$err['code']];
		$this->_err = $err;
		return $this->_err;
	}

	public function getCustomerInfo() {

		try {
			$customer = \Payjp\Customer::retrieve($this->_customer_id);

		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$customer['err'] = $this->_err;
		}
		return $customer;
	}

	public function getCardInfo() {
		try {
			$cust = $this->getCustomerInfo();
			$cards = $cust->cards->data;

		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$cards['err'] = $this->_err;
		}
		return $cards;

	}

	public function getCard() {
		try {
			$cust = $this->getCustomerInfo();
			$cd = $cust->cards->retrieve($this->_card_id);

		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$card['err'] = $this->_err;
		}
		return $cd;

	}

	public function updateCustomer() {
		try {
			$cust = $this->getCustomerInfo();
			$cust->default_card = $this->_card_id;

			if ($this->_customerdata->email) {
				$cust->email = $this->_customerdata->email;
			}

			$card = $cust->save();
		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$card['err'] = $this->_err;
		}
		return $card;

	}

	public function createCustomer() {
		if ($this->_token_id) {
			$cd['card'] = $this->_token_id;
		}

		if ($this->_customerdata->email) {
			$cd['email'] = $this->_customerdata->email;
		}
		if ($this->_customerdata->description) {
			$cd['description'] = $this->_customerdata->description;
		}

		try {
			$cus = \Payjp\Customer::create($cd);
		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$cus['err'] = $this->_err;
		}
		return $cus;

	}

	public function deleteCard() {

		try {
			$card = $this->getCard();
			$card->delete();

		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$card['err'] = $this->_err;
		}
		return $card;

	}

	public function createCard() {

		try {
			$cust = $this->getCustomerInfo();
			$card = $cust->cards->create(array(
				"card" => $this->_token_id,
			));
		} catch (\Payjp\Error\Card $e) {
			// Since it's a decline, \Payjp\Error\Card will be caught
			$this->errorOperation($e);
		} catch (\Payjp\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Payjp's API
			$this->errorOperation($e);
		} catch (\Payjp\Error\Authentication $e) {
			// Authentication with Payjp's API failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\ApiConnection $e) {
			// Network communication with Payjp failed
			$this->errorOperation($e);
		} catch (\Payjp\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$this->errorOperation($e);
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Payjp
			$this->errorOperation($e);
		}
		if (is_array($this->_err)) {
			$card['err'] = $this->_err;
		}
		return $card;

	}

}
?>