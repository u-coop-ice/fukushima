<?php
class appAskDB extends commonDB {

	use baseSendmail;
	use baseFunction;
	use baseApp;
	use checkApp;
	use checkAppAdd;
	use checkEntryCategories;
	use execRegist;
	use execAppAdd;
	use execApp;
	use execLog;
	use extendAuth;
	use checkGoogleRecaptcha;

	const PROJECT_ID = 'uc-kimachi';
	const GOOGLE_APPLICATION_CREDENTIALS = '/etc/cloud_sql_proxy/uc-kimachi-7f32e4c241c4.json';
	const SITEKEY = "6LdPsVkiAAAAAERpusAKz8RbQ29wLoFrjsWQSoUo";

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function saveAppAsk() {

		if (isset($_POST["confirm"]) && isset($_POST["reinput1"]) && isset($_POST["regist"])) {
			throw new Exception("不正なアクセスです。", 1);
		}

		$askdata = HTTP_Session2::get('askdata');

		if (isset($_POST["confirm"])) {

			$step = 1;
			$fields = [];
			$fields_sp1m = [
				'subject' => 'text',
				'memo' => 'text',
			]; //ask必須

			if (!$this->_auth->checkAuth()) {

				$fields_anonymous =
					[
					'email' => 'text',
					'name' => 'text',
					'student_phone' => 'text',
				];

				$fields_all = array_merge($fields_anonymous, $fields_sp1m);
				$fields_must = array_merge($fields_anonymous, $fields_sp1m);

				$askdata['username'] = 'anonymous' . time();
				$askdata['status'] = -9;

				if ($_POST['category_id']) {
					$askdata['category_id'] = intval($_POST['category_id']);
				}

			} else {

				if (isset($_POST['rate'])) {

					$rate = intval($_POST['rate']);
					switch ($rate) {
					case 1:
						$fields_sp1m['app_id'] = 'integer';
						$askdata['category_id'] = '';
						break;
					case 0:
						$fields_sp1m['category_id'] = 'integer';
						$askdata['app_id'] = '';
						break;
					}

				}

				$fields_all = $fields_sp1m;
				$fields_must = $fields_sp1m;
			}

			$this->set_postdata($askdata);
			$askdata = $this->execSanitize($fields_all, $fields_must);

			$fields_sql = $this->get_fields_sql();
			$fields_sql_app = $this->get_fields_sql_app();

			HTTP_Session2::set('fields_sql', $fields_sql);
			HTTP_Session2::set('askdata', $askdata);

			if (is_null($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			} else if (!count($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			}
			reset($askdata);
			$this->_smarty->assign('post', $askdata);

			if (isset($_POST["g-recaptcha-response"]) && !$this->_auth->checkAuth()) {

				try {
					$this->create_assessment(addslashes($_POST["g-recaptcha-response"]));
				} catch (Exception $e) {
					switch ($e->getCode()) {
					case 9:
						$this->_smarty->assign('err', 1);
						throw new Exception($e->getMessage(), 9);
						break;
					default:
						$this->_smarty->assign('page_title', 'エラー');
						$this->_smarty->assign('errmsg', $e->getMessage());
						$this->_smarty->display('error.tpl');
						exit();
					}
				}
			}


			throw new Exception("入力内容確認", 8);

		} else if (isset($_POST["reinput1"])) {

			if (is_null($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			} else if (!count($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			}
			reset($askdata);
			$this->_smarty->assign('post', $askdata);

			throw new Exception("戻って修正", 9);

		} else if (isset($_POST["regist"])) {

			if (is_null($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			} else if (!count($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			}

			try {
				$this->_pdo->beginTransaction();

				if (!$this->_auth->checkAuth()) {

					$fields_sql = HTTP_Session2::get('fields_sql');

					$askdata['status'] = -9;
					$this->set_postdata($askdata);
					$this->saveRegist($fields_sql);
					$askdata['regist_id'] = $this->get_last_insertId();

				} else {
					$askdata['regist_id'] = $this->_auth->getAuthData('id');
				}

				$askdata['recieve'] = 1;
				$askdata['noreply'] = 1;
				$askdata['add'] = 'ask';
				$askdata['code'] = self::generateUuid();

				$this->_smarty->assign('adic', $askdata['code']);

				$this->set_postdata($askdata);
				$this->saveAppAdd();

				$askdata['add_id'] = $this->get_last_insertId();

//自動返信メール送信

				if ($this->_auth->checkAuth()) {
					if ($this->_auth->getAuthData('namef')) {
						$askdata['namef'] = $this->_auth->getAuthData('namef');
						$askdata['nameg'] = $this->_auth->getAuthData('nameg');

						$this->_smarty->assign('post_namef', $askdata['namef']);
						$this->_smarty->assign('post_nameg', $askdata['nameg']);

						$name = $askdata['namef'] . ' ' . $askdata['nameg'];
					} else {
						$name = $this->_auth->getUsername();
					}

					$email = $this->_auth->getAuthData('email');

				} else {
					$email = $askdata['email'];
					$name = $askdata['namef'] . ' ' . $askdata['nameg'];
				}

//生協管理用メールアドレスを取得する。

				$init_ordermail = $_SESSION['config']['email'];

				if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
					$init_ordermail = $_SESSION['config']['component'][COMPONENT]['store_ordermail'];
				}

				$infocode = $_SESSION['config']['component'][COMPONENT]['infocode'];
				$init_pagetitle = $_SESSION['config']['component'][COMPONENT]['title'];

				$arg = [];
				$cc = '';

				if ($askdata['app_id']) {
					$this->set_app_id($askdata['app_id']);
					$appinfo = $this->getAppinfo();

					$this->_smarty->assign('regist_code', $appinfo['regist_code']);
					$this->_smarty->assign('app_code', $appinfo['code']);
					$this->_smarty->assign('app_component', $appinfo['component']);

					$cc = $this->getCcEmail($appinfo, null);

				} else if ($askdata['category_id']) {

					$cc = $this->getCcEmail(null, null, $askdata['category_id']);
				}

				if ($cc) {
					$arg['cc'] = $cc;
				}

				$subject = $askdata['subject'];

				$this->_smarty->assign("name", $name);
				$this->_smarty->assign("post", $askdata);

				$mail_body = $this->_smarty->fetch("order_mail.tpl");

				$cust_subject = 'お問い合わせを承りました';
				$order_subject = $subject . '【お問い合わせ】';

//自動返信メール
				$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

				$replymail = $_SESSION['config']['donotreply_email'];
				$cust_body = $this->_smarty->fetch("customer_mail.tpl");

				self::send_mail($name, $email, $init_ordermail, $order_subject, $mail_body, $arg);
//		send_mail($name, $email, 'shirota@u-coop.jp', $order_subject, $mail_body);

//自動返信メール送信
				self::send_mail($init_coopname, $replymail, $email, $cust_subject, $cust_body);

				$logdata['kind'] = 'ask';
				$logdata['app_add_id'] = $askdata['add_id'];
				$logdata['username'] = $this->_auth->getUsername();
				$this->setLogdata($logdata);
				$this->insertLog();

				$this->_pdo->commit();

				HTTP_Session2::set('askdata', $askdata);
				$self .= '?mode=complete';
				header("Location: $self");
				exit();

			} catch (Exception $e) {
				$this->_pdo->rollBack();
				throw new Exception("データベースの処理に失敗しました", 1);
			}

		}

	}

	public function returnAppAdd() {

		if (isset($_POST['send'])) {
			throw new Exception("Error Invalid Accessno", 1);
		}

		$result = [];

		$maildata['app_id'] = intval($_POST['app_id']);
		$maildata['add_id'] = intval($_POST['add_id']);
		$maildata['regist_id'] = $this->_auth->getAuthData('id');
		$maildata['root_id'] = intval($_POST['root_id']);

		$maildata['subject'] = trim($_POST['mail_subject']);
		$maildata['subject'] = htmlspecialchars($maildata['subject'], 3, "UTF-8");
		$maildata['subject'] = mb_convert_kana($maildata['subject'], "KV");

		$maildata['memo'] = trim($_POST['mail_body']);
		$maildata['memo'] = htmlspecialchars($maildata['memo'], 3, "UTF-8");
		$maildata['memo'] = mb_convert_kana($maildata['memo'], "KV");

		$maildata['recieve'] = 1;
		$maildata['add'] = 'mail';
		$maildata['regist_date'] = date('Y-m-d H:i:s');

		if (!$maildata['memo'] || !$maildata['subject']) {
			throw new Exception("Error Invalid input data", 1);
		}

		if (!$maildata['root_id']) {
			$maildata['root_id'] = $maildata['add_id'];
		}

		$sql = 'SELECT `add` as `add`,`admin_user_id`,`category_id` FROM app_add WHERE ( id = :add_id OR root_id = :root_id ) AND `send` = 1 ORDER BY id DESC LIMIT 1';

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':add_id', (int) $maildata["root_id"], PDO::PARAM_INT);
			$res->bindValue(':root_id', (int) $maildata["root_id"], PDO::PARAM_INT);
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("Error Database access", 1);
		}
		$addinfo = $res->fetch();

		// カテゴリーのデータを初期化する

		if ($addinfo['add']) {
			$maildata['add'] = $addinfo['add'];
		}
		if ($addinfo['admin_user_id']) {
			$maildata['admin_user_id'] = $addinfo['admin_user_id'];
		}
		if ($addinfo['category_id']) {
			$maildata['category_id'] = $addinfo['category_id'];
		}
		if ($maildata['app_id']) {
			$this->set_app_id($maildata['app_id']);
			$appinfo = $this->getAppInfo();

			$this->_smarty->assign('regist_code', $appinfo['regist_code']);
			$this->_smarty->assign('app_code', $appinfo['code']);

			$cc = $this->getCcEmail($appinfo, $addinfo['admin_user_id'], $addinfo['category_id']);

		}

//CODEの作成
		$adic = self::generateUuid();
		$maildata['code'] = $adic;
		$this->_smarty->assign('adic', $adic);

		$this->set_postdata($maildata);
		$this->saveAppAdd();

		$maildata['add_id'] = $this->_add_id;

//スレッド更新

		if ($maildata['root_id']) {

			$adddata['noreply'] = 2;

			$adddata['id'] = $maildata['root_id'];
			$adddata['root_id'] = $maildata['root_id'];

			$this->set_postdata([
				':noreply' => $adddata['noreply'],
				':root_id' => $adddata['root_id'],
				':id' => $this->_add_id,

			]);

			$this->updateAddNoreply();

		}

		$logdata['value'] = json_encode($maildata);

		$logdata['kind'] = 'send_mail';
		$logdata['app_add_id'] = $maildata['add_id'];
		$logdata['username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

		$init_ordermail = $_SESSION['config']['email'];
		$replymail = $_SESSION['config']['donotreply_email'];
		$subject = $maildata['subject'];

		$result['send'] = 1;
		$arg = [];
		if ($maildata['admin_user_id']) {
			$arg['auth_user_id'] = $maildata['admin_user_id'];
		}
		if ($appinfo['component']) {
			$arg['component'] = $appinfo['component'];
		}
		$arg['regist_id'] = $registinfo['id'];
		$arg['add_code'] = $adic;
		if ($cc) {
			$arg['cc'] = $cc;
		}

		if ($this->_auth->getAuthData('namef')) {
			$name = $this->_auth->getAuthData('namef') . ' ' . $this->_auth->getAuthData('nameg');
		} else {
			$name = $this->_auth->getUsername();
		}

		$this->_smarty->assign('name', $name);
		$this->_smarty->assign('adid', $maildata['add_id']);

		$maildata['memo'] = htmlspecialchars_decode($maildata['memo']);
		$this->_smarty->assign('mail_body', $maildata['memo']);

		$mail_body = $this->_smarty->fetch("mail_body.tpl");

//		self::send_mail($name, $this->_auth->getAuthData('email'), $init_ordermail, $subject, $mail_body, $arg);
		self::send_mail($name, $replymail, $init_ordermail, $subject, $mail_body, $arg);

		return $result;
	}

	public function saveAppLivingAsk() {

		if (isset($_POST["confirm"]) && isset($_POST["reinput1"]) && isset($_POST["regist"])) {
			throw new Exception("不正なアクセスです。", 1);
		}

		$askdata = HTTP_Session2::get('askdata');

		if (isset($_POST["confirm"])) {

			$step = 1;
			$fields_all = [
				'target' => 'text',
				'memo' => 'text',
			];
			$fields_sp1m = [
				'subject' => 'text',
				'purpose' => 'text',
			]; //ask必須

			if (!$this->_auth->checkAuth()) {

				$fields_anonymous =
					[
					'email' => 'text',
					'name' => 'text',
					'student_phone' => 'text',
				];

				$fields_all = array_merge($fields_all, $fields_anonymous, $fields_sp1m);
				$fields_must = array_merge($fields_anonymous, $fields_sp1m);

				$askdata['username'] = 'anonymous' . time();
				$askdata['status'] = -9;

			} else {
				$fields_all = array_merge($fields_all, $fields_sp1m, ['app_id' => 'integer']);
				$fields_must = $fields_sp1m;
			}

			$this->set_postdata($askdata);
			$askdata = $this->execSanitize($fields_all, $fields_must);

			$fields_sql = $this->get_fields_sql();
			$fields_sql_app = $this->get_fields_sql_app();

			HTTP_Session2::set('fields_sql', $fields_sql);
			HTTP_Session2::set('askdata', $askdata);

			if (is_null($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			} else if (!count($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			}
			reset($askdata);
			$this->_smarty->assign('post', $askdata);

			$this->setTmpl('confirm.tpl');
			$this->_smarty->display($this->_tmpl);
			exit();

		} else if (isset($_POST["reinput1"])) {

			if (is_null($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			} else if (!count($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			}
			reset($askdata);
			$this->_smarty->assign('post', $askdata);

			$this->setTmpl('step1.tpl');
			$this->_smarty->display($this->_tmpl);
			exit();

		} else if (isset($_POST["regist"])) {

			if (is_null($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			} else if (!count($askdata)) {
				throw new Exception("不正なアクセスです。", 1);
			}

			try {
				$this->_pdo->beginTransaction();

				if (!$this->_auth->checkAuth()) {

					$fields_sql = HTTP_Session2::get('fields_sql');

					unset($fields_sql['target']);
					unset($fields_sql['purpose']);

					$askdata['status'] = -9;
					$this->set_postdata($askdata);
					$this->saveRegist($fields_sql);
					$askdata['regist_id'] = $this->get_last_insertId();

				} else {
					$askdata['regist_id'] = $this->_auth->getAuthData('id');
				}

				$askdata['recieve'] = 1;
				$askdata['noreply'] = 1;
				$askdata['add'] = 'living';
				$askdata['code'] = self::generateUuid();

				$this->_smarty->assign('adic', $askdata['code']);

				if (is_array($askdata['purpose'])) {
					$askdata['purpose'] = json_encode($askdata['purpose']);
				}
				$this->set_postdata($askdata);
				$this->saveAppAdd();

				$askdata['add_id'] = $this->get_last_insertId();

//自動返信メール送信

				if ($this->_auth->checkAuth()) {
					if ($this->_auth->getAuthData('namef')) {
						$askdata['namef'] = $this->_auth->getAuthData('namef');
						$askdata['nameg'] = $this->_auth->getAuthData('nameg');

						$this->_smarty->assign('post_namef', $askdata['namef']);
						$this->_smarty->assign('post_nameg', $askdata['nameg']);

						$name = $askdata['namef'] . ' ' . $askdata['nameg'];
					} else {
						$name = $this->_auth->getUsername();
					}

					$email = $this->_auth->getAuthData('email');

				} else {
					$email = $askdata['email'];
					$name = $askdata['namef'] . ' ' . $askdata['nameg'];
				}

//生協管理用メールアドレスを取得する。

				$init_ordermail = $_SESSION['config']['email'];

				if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
					$init_ordermail = $_SESSION['config']['component'][COMPONENT]['store_ordermail'];
				}

				$infocode = $_SESSION['config']['component'][COMPONENT]['infocode'];
				$init_pagetitle = $_SESSION['config']['component'][COMPONENT]['title'];

				$arg = [];

				if ($askdata['app_id']) {
					$this->set_app_id($askdata['app_id']);
					$appinfo = $this->getAppinfo();

					$this->_smarty->assign('regist_code', $appinfo['regist_code']);
					$this->_smarty->assign('app_code', $appinfo['code']);
					$this->_smarty->assign('app_component', $appinfo['component']);

					$cc = $this->getCcEmail($appinfo);

					if ($cc) {
						$arg['cc'] = $cc;
					}

				}

				$subject = $askdata['subject'];

				$this->_smarty->assign("name", $name);

				if ($askdata['purpose']) {
					$askdata['purpose'] = json_decode($askdata['purpose'], true);
				}

				$this->_smarty->assign("post", $askdata);

				$this->_smarty->assign("email", $email);
				$mail_body = $this->_smarty->fetch("order_mail.tpl");

				$cust_subject = 'お問い合わせを承りました';
				$order_subject = $subject . '【お問い合わせ】';

				$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

//自動返信メール
				$replymail = $_SESSION['config']['donotreply_email'];
				$cust_body = $this->_smarty->fetch("customer_mail.tpl");

				self::send_mail($name, $email, $init_ordermail, $order_subject, $mail_body, $arg);
//		send_mail($name, $email, 'shirota@u-coop.jp', $order_subject, $mail_body);

//自動返信メール送信
				self::send_mail($init_coopname, $replymail, $email, $cust_subject, $cust_body);

				$logdata['kind'] = 'ask';
				$logdata['app_add_id'] = $askdata['add_id'];
				$logdata['username'] = $this->_auth->getUsername();
				$this->setLogdata($logdata);
				$this->insertLog();

				$this->_pdo->commit();

				HTTP_Session2::set('askdata', $askdata);
				$self .= '?mode=complete';
				header("Location: $self");
				exit();

			} catch (Exception $e) {
				$this->_pdo->rollBack();
				throw new Exception("データベースの処理に失敗しました", 1);
			}

		}

	}

	public function getRegistAppCount() {

		$sql = <<< HERE
SELECT id FROM app WHERE `regist_id` = :regist_id
AND `regist_date`+ INTERVAL 24 MONTH > NOW()
HERE;

		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':regist_id', $this->_auth->getAuthData('id'), PDO::PARAM_INT);
			$res->execute();
		} catch (PDOException $e) {
			// データベースアクセスに失敗したらエラーとする
			$error = "データ取得失敗";
		}

		$ct = $res->rowCount();

		return $ct;
	}

}
?>
