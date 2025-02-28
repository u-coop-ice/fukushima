<?php

require_once "Classes/payjp.class.php";
require_once "Classes/veritrans.class.php";

class appUserDB extends commonDB {

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	use baseFunction;
	use baseSendmail;
	use baseApp;
	use checkApp;
	use checkEntryCategories;
	use execShoppingCategories;
	use execEntryCalendar;
	use appInit;
	use execAppAdd;
	use extendAuth;
	use execLog;
	use execSignOut;
	use execCreditCard;

	public function cancelApp() {

		if (!$this->_app_code) {
			throw new Exception("不正なアクセスです。", 1);
		}

		if (!$this->_auth->checkAuth()) {
			throw new Exception("不正なアクセスです。", 1);
		}

		$appinfo = $this->getAppInfo();

		if ($appinfo['regist_id'] != $this->_auth->getAuthData('id')) {

//強制サインアウト処理
			$this->setSignOut($this->_auth, 'forced_signout');
			header("Location: " . $this->_smarty->getConfigVars('init_url'));
			exit();
		}

		try {
			$this->_pdo->beginTransaction();

			$this->set_postdata(['cancelled' => 1, 'id' => $this->_app_id]);
			$this->set_fields(['cancelled' => 'integer']);
			$this->set_where(['id' => 'integer']);
			$this->set_tbl('app');
			$this->updateTable();

//component check

			if ($appinfo['component'] == "reserve") {
				$this->set_category_id($appinfo['category_id']);
				$this->set_component($appinfo['component']);
				$this->set_comedate($appinfo['comedate']);
				$this->set_cometime($appinfo['cometime']);

				$this->updateSelectTime();
			}

//生協管理用メールアドレスを取得する。
			$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

			$init_ordermail = $_SESSION['config']['email'];
			$replymail = $_SESSION['config']['donotreply_email'];

			$infocode = $_SESSION['config']['component'][$appinfo['component']]['infocode'];
			$init_pagetitle = $_SESSION['config']['component'][$appinfo['component']]['title'];

//componentでinit_ordermailの上書き
			if ($_SESSION['config']['component'][$appinfo['component']]['store_ordermail']) {
				$init_ordermail = $_SESSION['config']['component'][$appinfo['component']]['store_ordermail'];
			}

			$title_mail = $_SESSION['config']['component'][$appinfo['component']]['title'];

			$this->_smarty->assign('regist_code', $appinfo['regist_code']);
			$this->_smarty->assign('app_code', $appinfo['code']);

			$cc = $this->getCcEmail($appinfo);

			if ($appinfo['component'] == 'entry') {

				$this->_category_id = $appinfo['category_id'];
				$categoryinfo = $this->getEntryCategory();

//メールタイトル生成
				$title_mail = $categoryinfo['denomination'];

			} else if ($appinfo['component'] == 'reserve') {

				$this->_category_id = $appinfo['category_id'];
				$categoryinfo = $this->getEntryCategory();

//メールタイトル生成
				$title_mail = $categoryinfo['denomination'];

			} else if ($appinfo['component'] == 'living') {
/*
$params = ['component' => $data['component'], 'part' => $data['part']];
$ict->set_params($params);
$init_category = $ict->get_init_category_info();

//メールタイトル生成
$title_mail = $init_category['denomination'];
 */
			}

			$this->_smarty->assign('title_mail', $title_mail);

// 変更完了メールを送信する

			if ($this->_auth->getAuthData('namef')) {

				$name = $this->_auth->getAuthData('namef') . ' ' . $this->_auth->getAuthData('nameg');
			} else {
				$name = $this->_auth->getUsername();
			}

			$email = $this->_auth->getAuthData('email');

			$this->_smarty->assign('name', $name);

//app_addへの登録

			$adddata['app_id'] = $this->_app_id;
			$adddata['regist_id'] = $this->_auth->getAuthData('id');
			$adddata['code'] = self::generateUuid();

			$this->_smarty->assign('adic', $adddata['code']);
			$this->_smarty->assign('view_ic', $appinfo['code']);

			$cust_body = $this->_smarty->fetch('customer_cancel_mail.tpl');
			$cust_subject = $title_mail . 'のキャンセルを承りました';
			$adddata['subject'] = $cust_subject;
			$adddata['memo'] = $cust_body;

			$adddata['recieve'] = 1;
			$adddata['noreply'] = 1;
			$adddata['auto_send'] = 1;
			$adddata['add'] = 'cancel';

			$this->set_postdata($adddata);
			$this->saveAppAdd();

			$arg = [];
			$arg['univ_id'] = $_SESSION['config']['univ_id'];
			$arg['regist_id'] = $this->_auth->getAuthData('id');

//自動返信メール送信
			self::send_mail($init_coopname, $replymail, $email, $cust_subject, $cust_body, $arg);

//生協側へメール送信

			$admarg = [];
			if ($cc) {
				$admarg['cc'] = $cc;
			}

			$order_subject = '【キャンセル】' . $regist_code . '（' . $title_mail . '）';
			$order_body = $this->_smarty->fetch('order_cancel_mail.tpl');
			self::send_mail($name, $email, $init_ordermail, $order_subject, $order_body, $admarg);

//ログのセット
			$logdata['kind'] = 'cancel_' . $appinfo['component'];
			if ($appinfo['part']) {
				$logdata['kind'] = '_' . $appinfo['part'];
			}
			$logdata['target_id'] = $this->_app_id;
			$this->setLogdata($logdata);
			$this->insertLog();

			$this->_pdo->commit();
		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception('データベース処理に失敗しました。', 1);
		}
	}

	public function deleteCreditCard() {

		if ($this->_postdata['cust_id']) {
			$this->deleteCreditCardPayjp();
		} else if ($this->_postdata['cust_id_veritrans']) {
			$this->deleteCreditCardVeritrans();
		} else {
			throw new Exception('パラメータが不正です。', 1);
		}

		$logdata['kind'] = "delete_creditcard";
		$logdata['username'] = $this->_auth->getUsername();

		$this->setLogdata($logdata);

		$this->insertLog();

	}

	public function addCreditCard() {

		if ($this->_paymentdata['cust_id']) {

			$this->_charge = $this->setBaseCreditCardPayjp();
			$this->execUserPayjp();

		} else if ($this->_paymentdata['cust_id_veritrans']) {
			$this->addCreditCardVeritrans();
		} else {
			throw new Exception('パラメータが不正です。', 1);
		}

		$logdata['kind'] = "add_creditcard";
		$logdata['username'] = $this->_auth->getUsername();

		$this->setLogdata($logdata);

		$this->insertLog();

	}

}
?>
