<?php

trait execPayment {

	private $_request;
	private $_skip_return = 0;
	private $_payment_3d  = 0;

	public function savePayment() {

		if (!$this->_app_id) {
			throw new Exception("パラメーターが不正です。", 1);
		}

		$this->getAppPayment();

		$fields = [
			'app_id' => 'integer',
			'value' => 'integer',
			'auth_username' => 'text',
			'memo' => 'text',
			'process' => 'text',
			'payment' => 'integer',
		];

		$updata['app_id'] = $this->_app_id;
		if (is_object($this->_adminAuth)) {
			$updata['auth_username'] = $this->_adminAuth->getUsername();
		} else {
			$updata['auth_username'] = 'webhook';
		}
		$updata['process'] = "payment_confirmed";
		$updata['payment'] = $this->_payment['payment'];
		$updata['memo'] = $this->_postdata['memo'];
		$updata['value'] = $this->_postdata['payment_confirmed'];

		if (isset($this->_postdata['status'])) {
			$updata['status'] = intval($this->_postdata['status']);
		}
		if (isset($this->_postdata['visible'])) {
			$updata['visible'] = intval($this->_postdata['visible']);
		}

		if (isset($this->_postdata['date_returned'])) {
			$updata['date_returned'] = $this->_postdata['date_returned'];
		}

		if (isset($updata['date'])) {
			$updata['date'] = $this->_postdata['memo'];
			$fields['date'] = 'text';
		}

		$this->set_tbl('payment_log');
		$this->set_fields($fields);
		$this->set_postdata($updata);
		$this->insertTable();

		$payment_confirmed = $this->get_payment_confirmed();

		$fields_sql_app = ['payment_confirmed' => 'integer'];
		if (isset($updata['date_returned'])) {
			$fields_sql_app['date_returned'] = 'text';
		}
		$updata['payment_confirmed'] = $payment_confirmed;
		$updata['id'] = $this->_app_id;

		if (isset($updata['status'])) {
			$fields_sql_app['status'] = 'integer';
		}
		if (isset($updata['visible'])) {
			$fields_sql_app['visible'] = 'integer';
		}

		$this->set_tbl('app');
		$this->set_fields($fields_sql_app);
		$this->set_where(['id' => 'integer']);
		$this->set_postdata($updata);

		$this->updateTable();

		if (isset($postdata['date_returned'])) {

			$this->set_tbl('app');

		}

		$this->updateOptSendmail();

		$logdata['process'] = 'payment_confirmed';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

		return $this->_payment;

		return;
	}

	private function getAppPayment() {

//appの更新
		$sql = <<< HERE
SELECT
app.charged_id as `charged_id`,
app.payment as payment,
app.`test_mode` as `test_mode`,
app.`api_key` as `api_key`,
app.`api_secret_key` as `api_secret_key`,
r.`email` as `email`,
r.`namef` as `namef`,
r.`nameg` as `nameg`,
r.`id` as `regist_id`,
r.`univ_id` as `univ_id`,
r.`status` as `status`,
app.id AS app_id,
app.component AS app_component,
app.part AS app_part,
app.category_id AS category_id,
app.code AS app_code,
app.status as status,
app.total_price as total_price,
app.postage as postage,
app.reduction as reduction,
IFNULL(app.total_price,0) + IFNULL(app.postage,0) - IFNULL(app.reduction,0) as total_price_all,
app.payment_confirmed as payment_confirmed,
app.price_cancelled as price_cancelled,
app.date_cancelled as date_cancelled,
app.date_returned as date_returned,
app.sendmail_paid_completed as sendmail_paid_completed,
app.opt_auto_sendmail as opt_auto_sendmail
 FROM app AS app
 LEFT JOIN regist AS r ON app.regist_id = r.id
 WHERE app.`id` = :app_id FOR UPDATE

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute([':app_id' => $this->_app_id]);
		} catch (PDOException $e) {
			throw new Exception("データベースへの処理に失敗しました(s)。", 1);
		}

		$this->_payment = $res->fetch();

		return $this->_payment;
	}

	private function get_payment_confirmed() {
		$sql = <<< HERE
SELECT SUM(`value`) AS `payment_confirmed`
FROM {$this->_pfx2}payment_log
WHERE `app_id` = :app_id AND `process`="payment_confirmed"
FOR UPDATE

HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute([":app_id" => $this->_app_id]);
		} catch (PDOException $e) {
			throw new Exception("データベースへの処理に失敗しました(p)。", 1);
		}

		$sum = $res->fetch();
		return $sum['payment_confirmed'];
	}

	public function updateOptSendmail() {

		$paymentTypeList = $this->_smarty->getTemplateVars('paymentTypeList');
		$plus = $this->getLogPlus();
//		$payment = $this->_payment;
		//		$logs = $this->_logs;

		$this->_payment['logs'] = '';

		if (count($this->_logs)) {
			foreach ($this->_logs as $log) {
				$this->_payment['logs'] .= $log['date'] . ' ' . $log['value'] . "更新<br />";
			}
		}

//支払い済み判定後 appの更新

		$fields = [
			'sendmail_paid_completed' => 'integer',
			'opt_auto_sendmail' => 'integer',
		];
		$data = ['sendmail_paid_completed' => 0,
			'opt_auto_sendmail' => 0,
			'id' => $this->_app_id,
		];

		$this->set_tbl('app');
		$this->set_fields($fields);
		$this->set_where(['id' => 'integer']);

		switch ($this->_payment['status']) {
		case 1:
		case 2:
		case 10:
			if ($this->_payment['price_total_all'] > 0 && $this->_payment['price_total_all'] == $this->_payment['payment_confirmed']) {
				if ($plus[0] == 1) {
					$data['opt_auto_sendmail'] = 1;
				}
				if ($paymentTypeList[$this->_payment['payment']]) {
					$data['opt_auto_sendmail'] = 0;
					$data['sendmail_paid_completed'] = 1;
				}
				$this->set_postdata($data);
				$this->updateTable();
			}
			break;
		case 9:

			if ($this->_payment['price_cancelled'] > 0 && $this->_payment['price_cancelled'] == $this->_payment['payment_confirmed']) {
				if ($plus[1] == 1 || $plus[0] == 1) {
					$data['opt_auto_sendmail'] = 1;
				}
				if ($paymentTypeList[$this->_payment['payment']]) {
					$data['opt_auto_sendmail'] = 0;
					$data['sendmail_paid_completed'] = 1;
				}

				$this->set_postdata($data);
				$this->updateTable();
			}
			break;
		}
	}

	private function getLogs() {

		$sql = <<< HERE
SELECT * FROM {$this->_pfx2}payment_log as l
 WHERE l.`process` = "payment_confirmed" AND l.`app_id` = :app_id
 FOR UPDATE
HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->execute([':app_id' => $this->_app_id]);
		} catch (PDOException $e) {

			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('errmsg', 'データベースへの処理に失敗しました(s)。');
			$this->displayError();
		}

		$this->_logs = $res->fetchAll();
		return $this->_logs;
	}

	private function getLogPlus() {

		$logs = $this->getLogs();

		$this->getAppPayment();

		$ll = array_pop($logs);

		$last_minus = 0;
		$all_plus = 0;

		if (is_array($logs) && count($logs)) {
			$all_plus = 1;
			foreach ($logs as $l) {
				if ($l['value'] < 0) {
					$all_plus = 0;
					break;
				}
			}

			if ($all_plus == 1) {

				if ($ll['value'] < 0) {
					$all_plus = 0;

					$end_l = end($logs);
					if ($this->_payment['date_cancelled']) {
						if (strtotime($end_l['date']) < strtotime($this->_payment['date_cancelled']) + 24 * 60 * 60) {
							$last_minus = 1;
						}
					}
				}
			}
		} else {
			if ($ll['value'] > 0) {$all_plus = 1;}
		}
		$plus = [$all_plus, $last_minus];
		return $plus;
	}

	public function get_request() {
		return $this->_request;
	}

	public function catchUserPayment3D() {

		$this->_request = array_map('self::my_convert_post', $_REQUEST);

		if (isset($this->_request['reqAmount'])) {
			$this->_request['reqAmount'] = intval($this->_request['reqAmount']);
		}

		if (!isset($this->_request['OrderId']) || !$this->_request['OrderId']) {
			throw new Exception("不正なアクセスです", 1);
		}

		$this->_app_charged_id = $this->_request['OrderId'];
		$appinfo = $this->getAppinfo();
		$this->_app = $appinfo['app'];
		if ($appinfo['app_sub']) {
			$this->_app_sub = $appinfo['app'];
		}

		if (!$appinfo['id']) {
			throw new Exception("不正なアクセスです。", 1);
		}
		if ($appinfo['status'] < 0 || $appinfo['status'] > 2) {
			throw new Exception("不正なアクセスです(st)。", 1);
		}
		$this->_app_id = $appinfo['id'];
		$this->set_paymentdata($appinfo);

		switch ($appinfo['payment']) {

		case 4:
			$this->_skip_return = 1;
			$this->catchPayment3DPayjp($appinfo);
			break;

		case 5:
//パラメータ改竄チェック
			if (!$this->checkAuthHash()) {
				throw new Exception("不正なアクセスです(hash)。", 1);
			}

			if ($appinfo['total_price_all'] != $this->_request['reqAmount']) {
				throw new Exception("決済情報が不正です。", 1);
			}

			if (!isset($this->_request['mpiMstatus']) || $this->_request['mpiMstatus'] != "success") {

				$msg = \shopping\veritrans\webCharge::getErrorMsg($this->_request['vResultCode']);

				throw new Exception($msg, 4);
			}
			break;
		}

		switch ($appinfo['app']) {
		case "order":
		case "stay":
			$send = $this->getAppPayment();
			break;
		case "menkyo":
			$send = $this->getAppMenkyo();
			break;
		}

		return $send;

	}

	public function catchPayment3D() {

		$this->_request = array_map('self::my_convert_post', $_REQUEST);

		if (isset($this->_request['reqAmount'])) {
			$this->_request['reqAmount'] = intval($this->_request['reqAmount']);
		}
		if (!isset($this->_request['OrderId']) || !$this->_request['OrderId']) {
			throw new Exception("不正なアクセスです。お申込み情報を取得できませんでした。", 1);
		}

		$this->_app_charged_id = $this->_request['OrderId'];
//受注番号を取得
//		$entry_count = $this->get_app_count();
		$this->_for_update = 1;
		$appinfo = $this->getAppinfo();

		if (!$appinfo['id']) {
			throw new Exception("不正なアクセスです。お申込み情報を取得できませんでした。", 1);
		}
		if (!$appinfo['regist_id']) {
			throw new Exception("不正なアクセスです。お申込み情報を取得できませんでした。", 1);
		}
		$appinfo['pre_status'] = $appinfo['status'];
		if ($appinfo['status'] != -1) {
//			throw new Exception("不正なアクセスです(st)。", 1);
		}
		$this->set_paymentdata($appinfo);

		switch ($appinfo['payment']) {
		case 4:
			$this->_skip_return = 0;
			$this->catchPayment3DPayjp($appinfo);
			break;
		case 5:
			$this->catchPayment3DVeritrans($appinfo);
			break;
		}

		$send = $this->change3DAppComplete($appinfo);

		$appinfo['status'] = $send['status'];
		$appinfo['app_count'] = $send['app_count'];

		$appinfo['regist_code'] = preg_replace("/0000$/", sprintf("%04d", intval($appinfo['app_count'])), $appinfo['regist_code']);

		$this->_payment_3d = 1;
		if ($appinfo['pre_status'] == -1) {
			$this->sendMailShopping($appinfo);
		}

	}

	private function catchPayment3DPayjp($_appinfo) {

		$charge = new shopping\payjp\webCharge();
		$charge->setApi_key($_appinfo['api_key']);
		$charge->setCharged_id($_appinfo['charged_id']);

		$chargeinfo = $charge->getChargedInfo();

		if (isset($chargeinfo['err'])) {
			$this->_app_id = $_appinfo['id'];
			$this->_request['vResultCode'] = $chargeinfo['err']['code'];
			$this->returnStock($_appinfo);

			$msg = $chargeinfo['err']['errmsg'];

			throw new Exception($msg, 4);
		}

		if ($_appinfo['total_price_all'] != $chargeinfo->amount) {
			throw new Exception("不正なアクセスです(amount)。", 1);
		}

		$this->_request['vResultCode'] = $chargeinfo->three_d_secure_status;

		switch ($chargeinfo->three_d_secure_status) {

		case "verified":
			break;
		case "unverified":
		case "error":
		case "attempted":
		case "failed":
		case "":
			$this->_app_id = $_appinfo['id'];
			if ($this->_skip_return == 0) {
				$this->returnStock($_appinfo);
			}
			$errmsg = "エラーが発生しました。";
			if (isset(\shopping\payjp\webCharge::MESSAGE_3D_SECURE[$chargeinfo->three_d_secure_status])) {
				$errmsg = \shopping\payjp\webCharge::MESSAGE_3D_SECURE[$chargeinfo->three_d_secure_status];
			}
			throw new Exception($errmsg, 4);
			break;
		default:
			throw new Exception("不明なエラー。", 4);
			break;
		}

		$charged = $charge->chargeFinish();

		if (isset($charged['err'])) {
			$this->_app_id = $_appinfo['id'];
			if ($this->_skip_return == 0) {
				$this->returnStock($_appinfo);
			}
			$this->_request['vResultCode'] = $charged['err']['code'];
			$msg = $charged['err']['errmsg'];

			throw new Exception($msg, 4);
		}

	}

	private function catchPayment3DVeritrans($_appinfo) {

//パラメータ改竄チェック
		if (!$this->checkAuthHash()) {
			throw new Exception("不正なアクセスです(hash)。", 1);
		}

		if ($_appinfo['total_price_all'] != $this->_request['reqAmount']) {
			throw new Exception("決済情報が不正です。", 1);
		}

		if (!isset($this->_request['mpiMstatus']) || $this->_request['mpiMstatus'] != "success") {
			$this->_app_id = $_appinfo['id'];
			$this->returnStock($_appinfo);

			$msg = \shopping\veritrans\webCharge::getErrorMsg($this->_request['vResultCode']);

			throw new Exception($msg, 4);
		}

		if (!isset($this->_request['cardMstatus']) || $this->_request['cardMstatus'] != "success") {

			$this->_app_id = $_appinfo['id'];
			$this->returnStock($_appinfo);
			$msg = \shopping\veritrans\webCharge::getErrorMsg($this->_request['vResultCode']);

			throw new Exception($msg, 4);
		}

	}

	private function change3DAppComplete($_appinfo) {

		$send = [];

		if ($_appinfo['status'] != -1) {
			throw new Exception('受注データのstatus不正', 1);
		}
		if ($_appinfo['api_key'] == "") {
			throw new Exception('受注データの決済APIが不正', 1);
		}

		$payment_limit = '';

		switch ($_appinfo['payment']) {
		case 5:
			$_charge = new \shopping\veritrans\webCharge();
			$_charge->setApi_key($_appinfo['api_key'], $_appinfo['api_secret_key'], $_appinfo['test_mode']);
			$carddata['charged_id'] = $_appinfo['charged_id'];
			$carddata['isNewerTxn'] = 1;
			$_charge->setCard($carddata);

			$result = $_charge->getChargedInfoDetail();
			$has_captured = $_charge->get_has_captured();
			$has_charged = 0;
			if ($result[0]['cardTransactionType'] != '') {
				$has_charged = 1;
				if ($result[0]['expire_time'] != '') {
					$payment_limit = $result[0]['expire_time'];
				}
			}

			break;
		case 4:
			$_charge = new shopping\payjp\webCharge();
			$_charge->setApi_key($_appinfo['api_key']);
			$_charge->setCharged_id($_appinfo['charged_id']);
			$chargeinfo = $_charge->getChargedInfo();

			$has_captured = $chargeinfo->captured;
			$has_charged = $chargeinfo->paid;
			if (isset($chargeinfo->expired_at) && $chargeinfo->expired_at) {
				$payment_limit = date("Y-m-d H:i:s", $chargeinfo->expired_at);
			}

			break;
		default:
			throw new Exception('受注データの支払方法が不正', 1);
		}

		if ($has_charged) {

			if ($_appinfo['status'] == -1) {

				$this->_component = $_appinfo['component'];
				if (isset($_appinfo['part']) && $_appinfo['part']) {
					$this->_part = $_appinfo['part'];
				}

				$app_count = $this->getMaxAppCount() + 1;

				$this->_app_id = $_appinfo['id'];
				$this->_regist_id = $_appinfo['regist_id'];

				$postdata = [
					'app_id' => $_appinfo['id'],
					'admin_flag' => 0,
					'status' => 0,
					'app_count' => $app_count,
					'payment_limit' => $payment_limit,
				];

				$this->set_postdata($postdata);
				$this->updateApp([
					'admin_flag' => 'integer',
					'status' => 'integer',
					'app_count' => 'integer',
					'payment_limit' => 'text',
				]);

//payment_logに追加はまだ
				if ($has_captured) {

					$updata['memo'] = $result[0]['txnDatetime'];
					$updata['payment_confirmed'] = $result[0]['amount'];
					$updata['status'] = 1;
					$updata['visible'] = 1;
					$this->set_postdata($updata);
					$this->savePayment();
				}

				if ($_appinfo['payment'] == 4) {

					$_appinfo['regist_code'] = preg_replace("/0000$/", sprintf("%04d", intval($app_count)), $_appinfo['regist_code']);

					$_charge->updateChargedInfo($_appinfo['regist_code']);
				}
			}

			switch ($_appinfo['component']) {
			case "shopping":
				$send = $this->getAppPayment();
				break;
			}
			$send['app_count'] = $app_count;

		} else {
			$this->returnStock($_appinfo);
		}

		return $send;
	}

	private function returnStock($_appinfo) {

		if ($_appinfo['status'] != -9) {

			$this->set_postdata(['id' => $this->_app_id, 'admin_flag' => 1, 'status' => -9]);
			$this->_tbl = 'app';
			$this->_fields = ['admin_flag' => 'integer', 'status' => 'integer'];
			$this->_where = ['id' => 'integer'];
			$this->updateTable();

// 在庫を戻す

			if ($_appinfo['component'] == "shopping") {
				$this->createCalcItems();
				$this->execAppItemStock(-1);
			}
		}
		if (function_exists('deleteAppSeries')) {
// DB登録ごと削除
			$this->deleteAppSeries();
		}
	}

}
?>