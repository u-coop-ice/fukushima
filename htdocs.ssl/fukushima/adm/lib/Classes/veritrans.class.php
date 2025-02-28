<?php

//$webpay_api = $smarty->getConfigVars('webpay_api');
//$webpay_url = $smarty->getConfigVars('webpay_url');

namespace shopping\veritrans;

require_once "tgMdk/3GPSMDK.php";

use CardAuthorizeRequestDto;
use CardCancelRequestDto;
use CardCaptureRequestDto;
use CardInfoAddRequestDto;
use CardInfoDeleteRequestDto;
use CardInfoGetRequestDto;
use CommonSearchParameter;
use CvsAuthorizeRequestDto;
use CvsCancelRequestDto;
use Exception;
use MpiAuthorizeRequestDto;
use OrderInfos;
use SearchParameters;
use SearchRequestDto;
use TGMDK_AuthHashUtil;
use TGMDK_MerchantSettingContext;
use TGMDK_Transaction;

class webCharge {

	public $_smarty;

	public function __construct() {
		global $smarty;
		global $init_url;
		$this->_smarty = $smarty;
		$this->_push_url = $init_url . "app/whk/veritrans_cvs.php";
		$this->_push_mpi_url = $init_url . "app/whk/veritrans_mpi.php";
	}

	public function set_redirection_url($_redirection_url) {
		$this->_redirection_url = $_redirection_url;
	}
	public function get_has_captured() {
		return $this->_has_captured;
	}
	public function get_has_expired() {
		return $this->_has_expired;
	}

	const TXN_FAILURE_CODE = 'failure';
	const TXN_PENDING_CODE = 'pending';
	const TXN_SUCCESS_CODE = 'success';
	const TRUE_FLAG_CODE = true;
	const FALSE_FLAG_CODE = false;

// コンビニ区分定義

	const SEVEN_ELEVEN_CODE = 'sej';
	const E_CONTEXT_CODE = 'econ';
	const WELL_NET_CODE = 'other';

// 3Dセキュア
//	const SERVICE_OPTION_TYPE = 'mpi-complete'; // 本人認証未対応／未契約カードの場合決済エラー（カード会社負担のみ）
//	const SERVICE_OPTION_TYPE = 'mpi-company'; // 本人認証未対応／未契約カードの場合決済エラー
	const SERVICE_OPTION_TYPE = 'mpi-merchant'; // 本人認証未対応／未契約カードの場合通常決済
	const DEVICE_CHANNEL = '02';
	const VERIFY_TIMEOUT = 10; //本人認証有効期限（分）

	private $_card_id;
	private $_err;
	private $_charged;
	private $_charged_id;
	private $_token_id;
	private $_customer_id;

	private $_carddata;
	private $_customerdata;
	private $_api_key;
	private $_api_secret_key;
	private $_test_mode;

	private $_service_option_type = self::E_CONTEXT_CODE;
//	private $_service_option_type = self::WELL_NET_CODE;
	private $_payment_limit_day = 14;
	private $_payment_limit_hhmm = null;
	private $_payment_limit;
//	private $_push_url = "https://us-central1-uc-kimachi.cloudfunctions.net/sample-slack-bot";
	private $_response_contents;
	private $_push_url;

	public function setApi_key($_api_key, $_api_secret_key, $_test_mode) {
		$this->_api_key = $_api_key;
		$this->_api_secret_key = $_api_secret_key;
		$this->_test_mode = intval($_test_mode);
		TGMDK_MerchantSettingContext::set_merchant_ccid($this->_api_key);
		TGMDK_MerchantSettingContext::set_merchant_secret_key($this->_api_secret_key);
		TGMDK_MerchantSettingContext::set_dummy_request($this->_test_mode);
	}

	public function getResponseContents() {
		return $this->_response_contents;
	}

	public function setCard($_carddata) {
		$this->_carddata = (object) $_carddata;
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

	public function setPaymentLimitDay($_payment_limit_day) {
		$this->_payment_limit_day = $_payment_limit_day;
	}

	public function getReceiptNumber() {
		return $this->_receipt_number;
	}

	public function getPaymentLimit() {
		if ($this->_payment_limit_hhmm) {
			$this->_payment_limit . ' ' . $this->_payment_limit_hhmm;
		} else {
			$this->_payment_limit .= ' 23:59:00';
		}
		$this->_payment_limit = date('Y-m-d H:i', strtotime($this->_payment_limit));
		return $this->_payment_limit;
	}

	public function charge() {

		$charge_data = new CardAuthorizeRequestDto();

		$charge_data->setOrderId($this->_carddata->charged_id);
		$charge_data->setAmount($this->_carddata->amount);

		if ($this->_carddata->token) {
			$charge_data->setToken($this->_carddata->token);
		} else if ($this->_carddata->card_id) {
			$charge_data->setCardId($this->_carddata->card_id);
		}
		$charge_data->setMemo1($this->_carddata->regist_code);
		$charge_data->setMemo2($this->_carddata->school_name);
		$charge_data->setMemo3($this->_carddata->coopname);

		if ($this->_carddata->with_capture) {
			$charge_data->setWithCapture($this->_carddata->with_capture);
		} else {
			$charge_data->setWithCapture(false);
		}

		if (isset($this->_carddata->jpo)) {
			//※指定が無い場合は、"10"（一括払い）が適用されます。
			$charge_data->setJpo($this->_carddata->jpo);
		}

		if (isset($this->_carddata->account_id)) {
			//ユーザー情報紐付け。
			$charge_data->setAccountId($this->_carddata->account_id);
		}

		try {
			$charge = new TGMDK_Transaction();
			$charges = $charge->execute($charge_data);
		} catch (Exception $e) {
			$this->errorOperation($e);
		}

		$this->errorOperation($charges);
		return $this->_charged_id;
	}

	public function charge3D() {

		$charge_data = new MpiAuthorizeRequestDto();

		$charge_data->setServiceOptionType(self::SERVICE_OPTION_TYPE);

		$charge_data->setOrderId($this->_carddata->charged_id);
		$charge_data->setAmount($this->_carddata->amount);

		if ($this->_carddata->token) {
			$charge_data->setToken($this->_carddata->token);
		} else if ($this->_carddata->card_id) {
			$charge_data->setCardId($this->_carddata->card_id);
		}

		$charge_data->setDeviceChannel(self::DEVICE_CHANNEL);

		if (isset($this->_carddata->regist_code)) {
			$charge_data->setMemo1($this->_carddata->regist_code);
		}
		if (isset($this->_carddata->school_name)) {
			$charge_data->setMemo2($this->_carddata->school_name);
		}
		if (isset($this->_carddata->coopname)) {
			$charge_data->setMemo3($this->_carddata->coopname);
		}

		if (isset($this->_carddata->with_capture) && $this->_carddata->with_capture) {
			$charge_data->setWithCapture($this->_carddata->with_capture);
		} else {
			$charge_data->setWithCapture(false);
		}

		if (isset($this->_carddata->jpo)) {
			//※指定が無い場合は、"10"（一括払い）が適用されます。
			$charge_data->setJpo($this->_carddata->jpo);
		}

		if (isset($this->_carddata->account_id)) {
			//ユーザー情報紐付け。
			$charge_data->setAccountId($this->_carddata->account_id);
		}

		$charge_data->setVerifyTimeout(self::VERIFY_TIMEOUT);

		if (isset($this->_redirection_url)) {
			$charge_data->setRedirectionUri($this->_redirection_url);
		}

		$charge_data->setPushUrl($this->_push_mpi_url);

		try {
			$charge = new TGMDK_Transaction();
			$charges = $charge->execute($charge_data);
		} catch (Exception $e) {
			$this->errorOperation($e);
		}

		$this->errorOperation($charges);
		return $this->_charged_id;
	}

	public function checkAuthHash() {
		if (!$this->_api_key) {
			throw new Exception("パラメータが不正です", 1);
		}
		if (!$this->_api_secret_key) {
			throw new Exception("パラメータが不正です", 1);
		}

		return TGMDK_AuthHashUtil::checkAuthHash(@$_POST, $this->_api_key, $this->_api_secret_key, 'UTF-8');
	}

	public function chargeCvs() {

		$request_data = new CvsAuthorizeRequestDto();

		$request_data->setServiceOptionType($this->_service_option_type);
		$request_data->setOrderId($this->_carddata->charged_id);
		$request_data->setAmount($this->_carddata->amount);
		$request_data->setName1($this->_carddata->namef);
		$request_data->setName2($this->_carddata->nameg);
		$request_data->setTelNo($this->_carddata->phonenumber);
		$request_data->setFree1($this->_carddata->regist_code);
		$request_data->setMemo1($this->_carddata->regist_code);
		$request_data->setMemo2($this->_carddata->school_name);
		$request_data->setMemo3($this->_carddata->coopname);

//		$payment_limit = date('Y/m/d', time());
		$this->_payment_limit = date('Y/m/d', time() + ($this->_payment_limit_day - 1) * 60 * 60 * 24);
		$request_data->setPayLimit($this->_payment_limit);
//		$this->_payment_limit_hhmm = "11:00";
		$request_data->setPayLimitHhmm($this->_payment_limit_hhmm);
		$request_data->setPushUrl($this->_push_url);
		$request_data->setPaymentType("0");

		try {
			$charge = new TGMDK_Transaction();
			$charges = $charge->execute($request_data);
		} catch (Exception $e) {
			$this->errorOperation($e);
		}

		$this->errorOperation($charges);
		return $this->_charged_id;
	}

	private function errorOperation($e) {

		if (!isset($e)) {
			$this->_smarty->assign('err', 1);
			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('errmsg', '決済処理に失敗しました(9)。');
//想定応答の取得
		} else {

			$this->_charged_id = $e->getOrderId();
			if ($this->_carddata->payment == 6) {
				$this->_receipt_number = $e->getReceiptNo();
//				$this->_haraikomi_url = $e->getHaraikomiUrl();
			}
			$txn_status = $e->getMStatus();
			/**
			 * 詳細コード取得
			 */
			$txn_result_code = $e->getVResultCode();
			/**
			 * エラーメッセージ取得
			 */
			$error_message = $e->getMerrMsg();

			switch ($txn_result_code) {
			case "AB12000000000000":
			case "GB12000000000000":
				$error_message = "ご利用できないカード会社です。";
				break;
			}

			// 成功
			if (self::TXN_SUCCESS_CODE === $txn_status) {

				if (isset($this->_carddata->payment) && $this->_carddata->payment == 5) {
					$this->_response_contents = $e->getResResponseContents();
				}

			} else if (self::TXN_PENDING_CODE === $txn_status) {
				$this->_smarty->assign('err', 1);
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('card_err', $error_message . "(p)");

			} else if (self::TXN_FAILURE_CODE === $txn_status) {
				$this->_smarty->assign('err', 1);
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('card_err', $error_message . "(p)");
			} else {
				$this->_smarty->assign('err', 1);
				$this->_smarty->assign('page_title', 'エラー');
				$this->_smarty->assign('card_err', $error_message . "(e)");
			}
		}

	}

	public static function getErrorMsg($_VSResultCode = null): string {
		if (!$_VSResultCode) {
			$_VSResultCode = "GE99";
		}
		$_code = substr($_VSResultCode, 0, 4);
		$_code_sub = substr($_VSResultCode, 4, 4);

		$_msg = [
			'GE01' => '本人認証実行不可（本人認証利用契約のないブランド）他のクレジットカードをご利用下さい。',
			'GE02' => '本人認証実行不可（本人認証の利用ができません）他のクレジットカードをご利用下さい。',
			'GE03' => '本人認証失敗 未対応デバイス（未対応ブラウザ、携帯等）等の理由で認証できません。',
			'GE04' => '本人認証失敗 障害発生により決済が完了できません。',
			'GE05' => '本人認証失敗 障害発生により決済が完了できません。',
			'GE06' => '本人認証対象外のカードのため、認証できません。',
			'GE11' => '本人認証に失敗しました。（パスワード間違い、キャンセル）',
			'GE12' => '暫定的に認証成功とみなされました。（決済不可）',
			'GE13' => '本人認証失敗（不正PAReq、他技術的要因）',
			'GE14' => '本人認証失敗 障害発生により決済が完了できません。',
			'GE15' => '本人認証失敗 障害発生により決済が完了できません。',
			'GE16' => '本人認証失敗 認証データが改ざんされている可能性があります。',
			'GE21' => '本人認証実行不可（本人認証利用契約のないブランド）他のクレジットカードをご利用下さい。',
			'GE22' => '本人認証実行不可（キャッシュカードが本人認証に対応していません）他のクレジットカードをご利用下さい。',
			'GE23' => '本人認証実行不可（認証失敗）',
			'GE24' => '本人認証実行不可（認証拒否）',
			'GE25' => '本人認証実行不可（認証失敗）',
			'GE26' => '本人認証実行不可（異常応答）',
			'GE27' => '本人認証実行不可（センタ接続通信エラーが発生）',
			'GE28' => '本人認証実行不可（本人認証ライブラリでエラー発生）',
			'GE29' => '本人認証実行不可（チャレンジが必要）',
			'GE31' => '本人認証に失敗しました。（パスワード間違い、キャンセル)',
			'GE32' => '暫定的に認証成功とみなされました。（決済不可）',
			'GE33' => '本人認証に失敗しました。（技術的要因など)',
			'GE34' => '本人認証に失敗しました。（異常応答）',
			'GE35' => '本人認証に失敗しました。（センタ接続通信エラーが発生({0})）',
			'GE36' => '本人認証に失敗しました。（本人認証ライブラリでエラー発生）',
			'GH01' => 'GWのアプリケーション例外により発生する場合があります。',
			'GE99' => '本人認証失敗（不明なエラー）',

			'GA11' => '認証処理の制限時間を過ぎているため、処理に失敗しました。',
			'GB24' => '利用不可のカードブランドです。',

			'AB12' => '利用不可のカードブランドです。',
			'AG16' => '被仕向センタービジーです。',
			'AG17' => '被仕向センタ障害中です。',
			'AG18' => '被仕向センタ個別終了です。',
			'AG21' => 'CAFIS輻輳中です。',
			'AG24' => 'タイムアウトです。',
			'AG29' => '電文対応エラーです。',
			'AG33' => 'カード使用不可です。',
			'AG34' => 'PINバイパス実行後のオフライン拒否（MS遷移あり）です。',
			'AG35' => 'オンライン処理失敗後の2nd Generate ACでのオフライン拒否です。',
			'AG36' => 'G14、G17、G18以外の1st Generate ACでのオフライン拒否です。',
			'AG37' => 'PINバイパス実行後のオフライン拒否（MS遷移なし）です。',
			'AG38' => 'PIN誤入力回数オーバー時（PINブロック時）のオフライン拒否です。',
			'AG39' => '取引判定保留（有人判定）です。カード会社へお問い合わせ頂くか、別のカードをご利用ください。',
			'AG40' => '暗証番号エラーです。',
			'AG41' => 'セキュリティコード誤りです。',
			'AG42' => 'セキュリティコード無です。',
			'AG43' => 'JISII面情報エラーです。',
			'AG44' => '1口座利用回数または金額オーバーです。',
			'AG45' => '1日限度額オーバーです。',
			'AG46' => 'クレジットカードが無効です。',
			'AG47' => '事故カードです。',
			'AG48' => '無効カードです。',
			'AG49' => '会員番号エラーです。',
			'AG50' => '商品コードエラーです。',
			'AG51' => '金額エラーです。',
			'AG52' => '税送料エラーです。',
			'AG57' => '分割回数エラーです。',
			'AG58' => '分割金額エラーです。',
			'AG59' => '初回金額エラーです。',
			'AG60' => '業務区分エラーです。',
			'AG61' => '支払区分エラーです。',
			'AG62' => '取消区分エラーです。',
			'AG63' => '取扱区分エラーです。',
			'AG64' => '有効期限エラーです。',
			'AG65' => 'サービス対象外カードです。',
			'AG68' => '当該業務オンライン終了です。',
			'AG69' => '事故カードデータエラーです。',
			'AG70' => '当該要求拒否です。',
			'AG71' => '当該自社対象業務エラーです。',
			'AG72' => '接続要求自社受付受付拒否です。',
			'AG73' => 'オンラインステータス開局以外です。',
			'AG74' => 'キー同期エラー（KPE）です。',
			'AG75' => '取引二重受信です。',
			'AG76' => '元取引無し（障害取消）です。',
			'AG77' => '仕向契約無しです。',
			'AG78' => 'イシュア判定処理エラーです。',
			'AG79' => 'アクアイアラ判定エラーです。',
			'AG80' => '加盟店契約判定エラーです。',
			'AG81' => 'イシュア契約判定エラーです。',
			'AG82' => '送信先判定処理エラーです。',
			'AG83' => '会員番号入力エラーです。',
			'AG84' => '金額入力エラーです。',
			'AG85' => '税・その他入力エラーです。',
			'AG90' => '分割回数入力エラーです。',
			'AG91' => '分割金額入力エラーです。',
			'AG92' => '初回金額入力エラーです。',
			'AG93' => 'セパレータ設定エラーです。',
			'AG94' => '取消区分入力エラーです。',
			'AG95' => '有効期限入力エラーです。',
			'AG96' => '承認番号入力エラーです。',
			'AG97' => 'フォーマットエラー（BODY部フィールド妥当性・保証項目チェックエラー）です。',
			'AG98' => 'オンラインステータス開局以外です。',
			'AG99' => '障害中（システム不調）です。',

		];

		if (isset($_msg[$_code])) {
			$_error_msg = $_msg[$_code];
		} else if (isset($_msg[$_code_sub])) {
			$_error_msg = $_msg[$_code_sub];
		} else {
			$_error_msg = $_msg['GE99'];
		}
		return $_error_msg;
	}

	public function getChargedInfo() {

		if ($this->_carddata->charged_id) {
// Commonパラメータクラスへのセット
			$common_param = new CommonSearchParameter();
			$common_param->setOrderId($this->_carddata->charged_id);
//			$common_param->setCommand($command);
			//			$common_param->setMstatus($mstatus);
			//			$common_param->setOrderStatus($orderStatus);
			//			$common_param->setTxnDatetime($txnDatatimeRange);
			//			$common_param->setAmount($amountRange);

// Searchパラメータクラスへのセット
			$search_param = new SearchParameters();
			$search_param->setCommon($common_param);

// 検索DTOへパラメータクラスをセット
			if ($this->_carddata->isNewerTxn) {
				$isNewerTxn = true;
			} else {
				$isNewerTxn = false;
			}
			$serviceTypeCdList = ['cvs', 'card', 'mpi'];
			$request_data = new SearchRequestDto();
//			$request_data->setRequestId($requestId); // リクエストID
			$request_data->setNewerFlag($isNewerTxn); // 商品に紐付く最後の取引のみ対象にするかを示す
			$request_data->setContainDummyFlag(true); // 検索対象にダミー決済のレコードを含めるかを示す
			$request_data->setServiceTypeCd($serviceTypeCdList); // 検索対象のサービスタイプを示す
			$request_data->setSearchParameters($search_param); // 各機能の固有条件

// --------------------------------------------------------------
			// コマンドを実行し、応答DTOを取得します。
			// --------------------------------------------------------------
			$transaction = new TGMDK_Transaction();
			$response_data = $transaction->execute($request_data);

// --------------------------------------------------------------
			// 結果画面に表示します。
			// --------------------------------------------------------------
			// 処理結果メッセージを設定
			$warning = $response_data->getMerrMsg();

// 配列データを設定
			$order_infos = $response_data->getOrderInfos();
			if (empty($order_infos) == false && $order_infos instanceof OrderInfos) {
				$order_info = $order_infos->getOrderInfo();
			}
		} else {
			$charged['err']['errmsg'] = '課金情報が見つかりません';
		}
		return $order_info;
	}

	public function getChargedInfoDetail() {
		$charged = $this->getChargedInfo();

		$this->_has_captured = 0;
		$this->_has_expired = 0;
		$result = [];
		if (is_array($charged)) {

			if (!count($charged)) {
				throw new Exception("決済の履歴がありません。", 1);
			}

			foreach ($charged as $ch) {
				$order_info['expired'] = $ch->getOrderStatus();
				$properOrderInfo = $ch->getProperOrderInfo();

//cvs
				$order_info['cvs_type'] = $properOrderInfo->getcvsType(); // 受付番号

				$order_info['receipt_number'] = $properOrderInfo->getreceiptNo(); // 受付番号
				$order_info['amount'] = $properOrderInfo->getamount(); // 決済金額
				$order_info['payLimit'] = $properOrderInfo->getpayLimit(); // 支払期限
				$order_info['paidDatetime'] = $properOrderInfo->getpaidDatetime(); //入金受付日時

				$transactionInfos = $ch->getTransactionInfos();
				$transactionInfo = $transactionInfos->getTransactionInfo();

				if (isset($transactionInfo) && count($transactionInfo) > 0) {

					foreach ($transactionInfo as $i => $tr) {
						$properTransactionInfo = $tr->getProperTransactionInfo();
						$result[$i]['reqCardNumber'] = $properTransactionInfo->getreqCardNumber();
						$result[$i]['cardTransactionType'] = $properTransactionInfo->getCardTransactionType(); // 決済状態

						$result[$i]['reqJpoInformation'] = $properTransactionInfo->getReqJpoInformation(); // 決済状態

						$result[$i]['txnDatetime'] = $tr->getTxnDatetime();
						$result[$i]['amount'] = $tr->getAmount(); // 金額
						$result[$i]['command'] = $tr->getCommand(); // コマンド
						$result[$i]['mstatus'] = $tr->getMstatus(); // ステータスコード

//csv
						$result[$i]['cvsTxnType'] = $properTransactionInfo->getcvsTxnType(); //取引対象タイプ
//bank
						$result[$i]['peTxnType'] = $properTransactionInfo->getpeTxnType(); //取引対象タイプ

						$result[$i]['startDatetime'] = $properTransactionInfo->getstartDatetime(); //取引日時

						if ($result[$i]['mstatus'] == 'success') {
							if ($result[$i]['cvsTxnType'] == "fix_capture") {
								$this->_has_captured = 1;
							} else if ($result[$i]['cvsTxnType'] == "cancel_capture") {
								$this->_has_expired = 1;
							} else if ($result[$i]['cvsTxnType'] == "cancel_authorize") {
								$this->_has_expired = 1;
							}

							if ($result[$i]['peTxnType'] == "capture") {
								$this->_has_captured = 1;
							}

							if ($result[$i]['cardTransactionType'] == "pa" || $result[$i]['cardTransactionType'] == "ac") {
								$this->_has_captured = 1;
							} else if ($result[$i]['cardTransactionType'] == "va" || $result[$i]['cardTransactionType'] == "rad" || $result[$i]['cardTransactionType'] == "rae") {
								$this->_has_expired = 1;
							}
							if ($result[$i]['cardTransactionType'] == "a") {
								$result[$i]['cardExpire'] = $ch->getProperOrderInfo()->getCardExpire();
								$result[$i]['expire_time'] = date('Y-m-d H:i:s', strtotime($result[$i]['txnDatetime']) + (60 * 60 * 24 * 60));
							}
						}
						$last_transaction = $result[$i]['cardTransactionType'];
						$last_transaction_cvs = $result[$i]['cvsTxnType'];
					}
				}
			}
		}
		return $result;
	}

	public function capture() {

		if ($this->_carddata->charged_id) {

			try {

				$request_data = new CardCaptureRequestDto();

				$request_data->setOrderId($this->_carddata->charged_id);
				$request_data->setAmount($this->_carddata->amount);
				$transaction = new TGMDK_Transaction();
				$capture = $transaction->execute($request_data);
			} catch (Exception $e) {
				$this->errorOperation($e);
			}

			$this->errorOperation($capture);
			// 取引ID
			$captured['charged_id'] = $capture->getOrderId();
			$captured['charged_date'] = $capture->getGatewayResponseDate();
			$captured['amount'] = $capture->getReqAmount();

		} else {
			$this->_smarty->assign('err', 1);
			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('card_err', '課金情報が見つかりません');
		}
		return $captured;
	}

	public function cancel() {

		if ($this->_carddata->charged_id) {

			try {

				$request_data = new CardCancelRequestDto();

				$request_data->setOrderId($this->_carddata->charged_id);
				if ($this->_carddata->amount) {
					$request_data->setAmount($this->_carddata->amount);
				}
				$transaction = new TGMDK_Transaction();
				$cancel = $transaction->execute($request_data);
			} catch (Exception $e) {
				$this->errorOperation($e);
			}

			$this->errorOperation($cancel);
			// 取引ID
			$cancelled['charged_id'] = $cancel->getOrderId();
			$cancelled['cancel_date'] = $cancel->getGatewayResponseDate();
			$cancelled['amount'] = $cancel->getReqAmount();

		} else {
			$this->_smarty->assign('err', 1);
			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('card_err', '課金情報が見つかりません');
		}
		return $cancelled;
	}

	public function cancelCvs() {

		if ($this->_carddata->charged_id) {

			try {

				$request_data = new CvsCancelRequestDto();

				$request_data->setOrderId($this->_carddata->charged_id);
				$request_data->setServiceOptionType($this->_service_option_type);

				$transaction = new TGMDK_Transaction();
				$cancel = $transaction->execute($request_data);
			} catch (Exception $e) {
				$this->errorOperation($e);
			}

			$this->errorOperation($cancel);
			// 取引ID
			$cancelled['charged_id'] = $cancel->getOrderId();

		} else {
			$this->_smarty->assign('err', 1);
			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('card_err', '課金情報が見つかりません');
		}
		return $cancelled;
	}

	public function getCustomerInfo() {

		try {
			$request_data = new CardInfoGetRequestDto();
			$request_data->setAccountId($this->_customer_id);

			$transaction = new TGMDK_Transaction();
			$response_data = $transaction->execute($request_data);

		} catch (Exception $e) {
			$this->errorOperation($e);
		}

		$pay_now_id_res = $response_data->getPayNowIdResponse();
		if (isset($pay_now_id_res)) {

			$account = $pay_now_id_res->getAccount();
			if (isset($account)) {
				/**
				 * カード情報取得
				 */
				$cardInfos = $account->getCardInfo();
				$cardList = array();
				foreach ((array) $cardInfos as $cardInfo) {
					$key = $cardInfo->getCardId();
					$value = $cardInfo->getCardNumber() . " " . $cardInfo->getCardExpire();
					$map = [$key, $value];
					array_push($cardList, $map);
				}

				$cardList;
			}
		}

		return $cardList;

	}

	public function deleteCard() {

		try {
			$request_data = new CardInfoDeleteRequestDto();
			$request_data->setAccountId($this->_customer_id);
			$request_data->setCardId($this->_card_id);

			$transaction = new TGMDK_Transaction();
			$response_data = $transaction->execute($request_data);

		} catch (Exception $e) {
			$this->errorOperation($e);
		}

		$this->errorOperation($response_data);
		$result = [];

		if ($this->_smarty->getTemplateVars('err')) {
			$result['err']['errmsg'] = $this->_smarty->getTemplateVars('card_err');
		}

		return $result;

	}

	public function addCard() {

		try {
			$request_data = new CardInfoAddRequestDto();
			$request_data->setAccountId($this->_customer_id);
			$request_data->setToken($this->_token_id);

			$transaction = new TGMDK_Transaction();
			$response_data = $transaction->execute($request_data);

		} catch (Exception $e) {
			$this->errorOperation($e);
		}

		$this->errorOperation($response_data);
		$result = [];

		if ($this->_smarty->getTemplateVars('err')) {
			$result['err']['errmsg'] = $this->_smarty->getTemplateVars('card_err');
		}

		return $result;
	}

}
?>