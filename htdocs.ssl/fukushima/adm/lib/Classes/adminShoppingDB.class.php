<?php
require_once "Classes/payjp.class.php";
require_once "Classes/veritrans.class.php";

class adminShoppingDB extends commonDB {

	use adminAuth;
	use baseFunction;
	use baseSendmail;
	use baseApp;
	use execApp;
	use checkApp;
	use execShoppingApp;
	use execAppAdd;
	use execConfig;
	use execShoppingCategories;
	use execShoppingItems;
	use execAdminCreditCard;
	use execPayment;
	use execAdminLog;
	use checkExportOrders;
	use checkRegist;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function sendmail2nopaid() {
		global $init_coopname;

		$sends = $this->get_regist_sendmail4shopping();

		if (!count($sends)) {
			throw new Exception("送信対象が見当たりません。", 1);
		}

		$init_ordermail = $_SESSION['config']['email'];
		$replymail = $_SESSION['config']['donotreply_email'];

		$fields_app = ['sendmail_nopaid' => 'integer'];

		foreach ($sends as $i => $send) {

			$this->_smarty->assign('regist_namef', $send['regist_namef']);
			$this->_smarty->assign('regist_nameg', $send['regist_nameg']);

			$this->_smarty->assign('regist_status', $send['regist_status']);

//{orders}に対応
			$this->_smarty->assign('view_app_id', $send['app_id']);

			$this->_smarty->assign('paid_completed_date', $send['paid_completed_date']);
			$this->_smarty->assign('date_returned', $send['date_returned']);
			$this->_smarty->assign('payment_confirmed', $send['payment_confirmed']);
			$this->_smarty->assign('app_status', $send['app_status']);
			$this->_smarty->assign('return', $send['return']);
			$to = $send['email'];

//CODEの作成
			$adic = self::generateUuid();
			$send['code'] = $adic;
			$this->_smarty->assign('adic', $adic);

			$send['send'] = 1;
			$send['noreply'] = 9;
			$send['regist_date'] = date('Y-m-d H:i:s');
			$subject = "ご入金のお願い【" . $send['category_denomination'] . "】";
			$send['process'] = 'sendmail_nopaid';

			$this->_smarty->assign('category_nopaid_message', $send['category_nopaid_message']);
			$send['memo'] = $this->_smarty->fetch('nopaid_mail.tpl');

			$send['add'] = 'nopaid';
			$send['sendmail_nopaid'] = 1;
			$send['id'] = $send['app_id'];
			$send['subject'] = $subject;
			$send['auth_username'] = $this->_adminAuth->getUsername();
			if (!$send['skipped']) {
				$arg = [];

				$arg['component'] = $send['app_component'];
				$arg['part'] = $send['app_part'];
				$arg['category_id'] = intval($send['category_id']);
				$arg['regist_id'] = $send['regist_id'];
				$arg['add_code'] = $adic;
				$arg['univ_id'] = $_SESSION['config']['univ_id'];

				$ordermail = $init_ordermail;
				if ($send['category_ordermail']) {
					$ordermail = $send['category_ordermail'];
				}

				self::send_mail($init_coopname, $replymail, $to, $subject, $send['memo'], $arg);

				$admarg['cc'] = $this->_adminAuth->getAuthData('email');

				self::send_mail($init_coopname, $replymail, $ordermail, "(コピー)" . $subject, "【管理システムからユーザーへ送信した内容のコピーです。】\n\n" . $send['memo'], $admarg);

				$this->set_postdata($send);
				$this->set_tbl('app');
				$this->set_fields($fields_app);
				$this->set_where(['id' => 'integer']);
				$this->updateTablePlus();

				$this->set_postdata($send);
				$this->saveAppAdd();

				$this->set_postdata($send);
				$this->saveAdminLog();

			}

		}

	}

	public function sendmail2paidComplete() {
		global $init_coopname;

		$sends = $this->get_regist_sendmail4shopping();

		if (!count($sends)) {
			throw new Exception("送信対象が見当たりません。", 1);
		}

		$init_ordermail = $_SESSION['config']['email'];
		$replymail = $_SESSION['config']['donotreply_email'];

		$fields_app = ['sendmail_paid_completed' => 'integer'];

		foreach ($sends as $i => $send) {

			$this->_smarty->assign('regist_namef', $send['regist_namef']);
			$this->_smarty->assign('regist_nameg', $send['regist_nameg']);

			$this->_smarty->assign('regist_status', $send['regist_status']);

//{orders}に対応
			$this->_smarty->assign('view_app_id', $send['app_id']);

			$this->_smarty->assign('paid_completed_date', $send['paid_completed_date']);
			$this->_smarty->assign('date_returned', $send['date_returned']);
			$this->_smarty->assign('payment_confirmed', $send['payment_confirmed']);
			$this->_smarty->assign('app_status', $send['app_status']);
			$this->_smarty->assign('return', $send['return']);
			$to = $send['email'];

//CODEの作成
			$adic = self::generateUuid();
			$send['code'] = $adic;
			$this->_smarty->assign('adic', $adic);

			$send['send'] = 1;
			$send['noreply'] = 9;
			$send['regist_date'] = date('Y-m-d H:i:s');
			$subject = "入金を確認しました【" . $send['category_denomination'] . "】";
			$send['process'] = 'sendmail_paid_completed';

			$this->_smarty->assign('category_paid_completed_message', $send['category_paid_completed_message']);
			$send['memo'] = $this->_smarty->fetch('paid_completed_mail.tpl');

			$send['add'] = 'paid_completed';
			$send['sendmail_paid_completed'] = 1;
			$send['id'] = $send['app_id'];
			$send['subject'] = $subject;
			$send['auth_username'] = $this->_adminAuth->getUsername();
			if (!$send['skipped']) {
				$arg = [];

				$arg['component'] = $send['app_component'];
				$arg['part'] = $send['app_part'];
				$arg['category_id'] = intval($send['category_id']);
				$arg['regist_id'] = $send['regist_id'];
				$arg['add_code'] = $adic;
				$arg['univ_id'] = $_SESSION['config']['univ_id'];

				$ordermail = $init_ordermail;
				if ($send['category_ordermail']) {
					$ordermail = $send['category_ordermail'];
				}

				self::send_mail($init_coopname, $replymail, $to, $subject, $send['memo'], $arg);

				$admarg['cc'] = $this->_adminAuth->getAuthData('email');

				self::send_mail($init_coopname, $replymail, $ordermail, "(コピー)" . $subject, "【管理システムからユーザーへ送信した内容のコピーです。】\n\n" . $send['memo'], $admarg);

				$this->set_postdata($send);
				$this->set_tbl('app');
				$this->set_fields($fields_app);
				$this->set_where(['id' => 'integer']);
				$this->updateTable();

				$this->set_postdata($send);
				$this->saveAppAdd();

				$this->set_postdata($send);
				$this->saveAdminLog();

			}

		}

	}

	private function get_regist_sendmail4shopping() {

		$where = [];
		$condition = $this->_condition;

//SELECT

		$sql = <<< HERE
	SELECT r.`email` as `email`,
	r.`username` as `regist_username`,
	r.`namef` as `regist_namef`,
	r.`nameg` as `regist_nameg`,
	r.`id` as `regist_id`,
	r.`status` as `regist_status`,
	a.`id` as `app_id`,
	a.`component` as `app_component`,
	a.`part` as `app_part`,
	a.`status` as `app_status`,
	c.`id` as `category_id`,
	c.`denomination` as `category_denomination`,
	c.`paid_completed_message` as `category_paid_completed_message`,
	c.`nopaid_message` as `category_nopaid_message`,
	c.`ordermail` as `category_ordermail`
	 FROM app as a
	 LEFT JOIN regist as r ON r.id = a.regist_id
	 LEFT JOIN sp_category as c ON a.category_id = c.id

HERE;

		array_push($where, 'a.id = :app_id');
//		array_push($where, 'r.status = 1');

		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		$sends = [];

		try {
			$res = $this->_pdo->prepare($sql);

			foreach ($condition['app_id'] as $app_id) {
				$res->bindValue(':app_id', $app_id, PDO::PARAM_INT);
				$res->execute();
				$entry = $res->fetch();

				if ($entry['email']) {
					array_push($sends, $entry);
				}
			}

		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$this->_smarty->assign('page_title', 'エラー');
			$this->_smarty->assign('errmsg', 'データベースの処理に失敗しました。');
			$this->displayError();
			exit();
		}

		return $sends;

	}

	public function updateAppStatus() {

		if (!is_array($this->_condition['app_id'])) {
			throw new Exception("パラメータが不正です", 1);
		}

		if (count($this->_condition['app_id']) < 1) {
			throw new Exception("パラメータが不正です", 1);
		}

		$fields_app = ['status' => 'integer'];

		$postdata['status'] = 1;

		foreach ($this->_condition['app_id'] as $this->_app_id) {
			$postdata['id'] = $this->_app_id;
			$this->set_postdata($postdata);
			$this->set_tbl('app');
			$this->set_fields($fields_app);
			$this->updateTable();

			$logdata['process'] = 'update_app_status';
			$logdata['value'] = json_encode($postdata);

			$this->set_postdata($logdata);
			$this->saveAdminLog();

		}

	}

	public function updateAppShip() {

		$fields = [
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

			'ship_from_name' => "text",
			'ship_from_kana' => "text",
			'ship_from_zipcodef' => "integer",
			'ship_from_zipcodes' => "integer",
			'ship_from_pref' => "text",
			'ship_from_addressf' => "text",
			'ship_from_addresss' => "text",
			'ship_from_addresst' => "text",
			'ship_from_phonenumber' => "text",

		];

		if (!$this->_app_id) {
			throw new Exception("パラメータが不正です", 1);
		}

		$postdata = $this->execSanitize($fields, []);

		$postdata['ship_from'] = 1;
		$fields['ship_from'] = 'integer';

		$postdata['id'] = $this->_app_id;
		$this->set_postdata($postdata);
		$this->set_tbl('app');
		$this->set_fields($fields);
		$this->set_where(['id' => 'integer']);
		$this->updateTable();

		$logdata['process'] = 'update_app_ship';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	public function updateAppRegist() {

		if (!$this->_app_id) {
			throw new Exception("パラメータが不正です", 1);
		}

		if (!$this->_regist_id) {
			throw new Exception("パラメータが不正です", 1);
		}

// check regist status
		$registinfo = $this->getRegistInfo();

		if ($registinfo['status'] != -9) {
			throw new Exception("ユーザー属性が不正です", 1);
		}

		$fields = array(
			'kanaf' => "text",
			'kanag' => "text",
			'namef' => "text",
			'nameg' => "text",
			'zipcodef' => "integer",
			'zipcodes' => "integer",
			'pref' => "text",
			'addressf' => "text",
			'addresss' => "text",
			'addresst' => "text",
			'phonenumber' => "text",
		);

		$postdata = $this->execSanitize($fields, []);

		$postdata['id'] = $this->_regist_id;
		$this->set_postdata($postdata);
		$this->set_tbl('regist');
		$this->set_fields($fields);
		$this->set_where(['id' => 'integer']);
		$this->updateTable();

		$logdata['process'] = 'update_app_regist';
		$logdata['value'] = json_encode($postdata);

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}
/*
public function changeStatusShoppingApp() {

$postdata = [];
$postdata['status'] = intval($_POST['status']);

$appinfo = $this->getAppinfo();

$this->_smarty->assign('regist_code', $appinfo['regist_code']);

switch (intval($appinfo['status'])) {
case '0':
case '1':
case '2':

if ($postdata['status'] == 9) {
$this->getCartFromAppSub();
$this->checkCartItemStock();
$this->execAppItemStock(-1);
}
break;
case '9':
if ($postdata['status'] < 9) {
$this->getCartFromAppSub();
$this->checkCartItemStock();
$this->execAppItemStock(1);
}

break;
}
$this->changeStatusApp();
}
 */

	private function getCartFromAppSub() {
		if (!$this->_app_id) {
			throw new Exception("No app_id!!", 1);
		}

		$this->set_tbl("app_sub");
		$this->set_where(["app_id" => 'intger']);
		$this->set_postdata(['app_id' => $this->_app_id]);
		$this->_fetchall = 1;
		$appsubs = $this->selectTable();
		if (!$appsubs || !is_array($appsubs)) {
			throw new Exception("No app_subs!!", 1);
		}
		$this->_cart['items'] = $appsubs;
	}

	public function removeApp3DError() {

		date_default_timezone_set('Asia/Tokyo');

		$this->_skip_univ_auth = 1;

		$verify_timeout = shopping\veritrans\webCharge::VERIFY_TIMEOUT; // 本人認証の制限時間(分)

		$sql = <<< HERE
SELECT * FROM app
WHERE (payment = :payment1 OR payment = :payment2)
AND (status = :status1 OR status = :status2)
AND regist_date + INTERVAL :timeout MINUTE < NOW()

HERE;

		$res = $this->_pdo->prepare($sql);
		$res->bindValue(':payment1', 4, PDO::PARAM_INT);
		$res->bindValue(':payment2', 5, PDO::PARAM_INT);
		$res->bindValue(':status1', -1, PDO::PARAM_INT);
		$res->bindValue(':status2', -9, PDO::PARAM_INT);
		$res->bindValue(':timeout', ($verify_timeout + 2), PDO::PARAM_STR);
		$res->execute();
		$applist = $res->fetchAll();

		if (!is_array($applist)) {
			return;
		}

		foreach ($applist as $app) {

			if (!$app['id']) {continue;}

			switch ($app['component']) {
			case "shopping":

				$this->_app_id = $app['id'];

				switch ($app['status']) {
				case "-9":
					$this->deleteAppSeries();
					break;
				case "-1":
					try {
						$this->change3DAppComplete($app);
					} catch (Exception $e) {
						echo $e->getMessage();
					}

					break;
				}

				$logdata['process'] = 'batch_remove_app_id';
				$logdata['app_id'] = $this->_app_id;
				$this->set_postdata($logdata);
				$this->saveAdminLog();

				break;
			}
		}

	}

	private function deleteAppSeries() {

		$this->_tbl = "app_sub";
		$this->_where = ['app_id' => 'integer'];
		$this->_postdata = ['app_id' => $this->_app_id];
		$this->deleteTable();

		$this->_tbl = "app_add";
		$this->_where = ['app_id' => 'integer'];
		$this->_postdata = ['app_id' => $this->_app_id];
		$this->deleteTable();

		$this->_tbl = "payment_log";
		$this->_where = ['app_id' => 'integer'];
		$this->_postdata = ['app_id' => $this->_app_id];
		$this->deleteTable();

		$this->_tbl = "app";
		$this->_where = ['id' => 'integer'];
		$this->_postdata = ['id' => $this->_app_id];
		$this->deleteTable();

	}

}
