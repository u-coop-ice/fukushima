<?php
class appRegistDB extends commonDB {

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	use baseFunction;
	use baseSendmail;
	use appInit;
	use baseRegist {
		baseRegist::execSanitize insteadof baseFunction;
	}
	use execAppAdd;
	use extendAuth;
	use execSignOut;
	use execLog;

	public function saveRegist() {
		$this->setKind('update_regist');
		$this->saveBaseRegist($this->_fields_regist, $this->_fields_regist_must);
	}

	public function saveRegistPassword() {
		$this->setKind('update_password');
		$this->saveBasePassword();
	}

	public function saveRegistTmpEmail() {

		$postdata = HTTP_Session2::get('postdata');

		if ($postdata['complete']) {
			self::return2First();
			exit();
		}

		$this->_skip_emailcfrm = 1;
		$this->setKind('process_update_email');
		$this->saveBaseTmpEmail();

		$this->_smarty->assign('page_title', 'メールアドレス変更');

		$this->_smarty->assign('errmsg', '新しいアドレスに受信確認メールを送信しました。<br/ ><strong class="red em14">【！】メールアドレスの変更は完了していません。</strong>受信確認後、メールアドレスの変更が完了します。<br/ >しばらく経ってもメールが届かない場合は、メールアドレス、およびメール受信設定を確認後、再度変更手続きを行って下さい。');
		$this->completeBase();
	}

	public function updateRegistEmail() {
		$this->setKind('update_email');
		$this->updateBaseEmail();
	}

	public function removeRegist() {
		$this->setKind('remove_regist');
		$this->removeBaseRegist();
	}

	public function saveAppUnsubscribeMail() {

		try {
			$this->_pdo->beginTransaction();
			$this->saveBaseUnsubscribeMail();

//生協側へメール送信
			if ($this->_unsubscribe_mail) {

				$replymail = $_SESSION['config']['donotreply_email'];
				$init_coopname = $this->_smarty->getTemplateVars('init_coopname');
				$init_ordermail = $_SESSION['config']['email'];

				$namef = $this->_auth->getAuthData('namef');
				$nameg = $this->_auth->getAuthData('nameg');
				$username = $this->_auth->getUsername();

				if ($namef) {
					$name = $namef . ' ' . $nameg;
				} else {
					$name = $username;
				}

				$this->_smarty->assign('entry_namef', $namef);
				$this->_smarty->assign('entry_nameg', $nameg);
				$this->_smarty->assign('entry_username', $username);

				$order_subject = '【配信停止手続き】' . $this->_auth->getAuthData('email');
				$order_body = $this->_smarty->fetch('order_unsubscribe_mail_complete.tpl');

				self::send_mail($name, $this->_auth->getAuthdata('email'), $init_ordermail, $order_subject, $order_body);
			}
			$this->_pdo->commit();

			$this->_auth->setAuthData('dm', $this->_unsubscribe_mail);

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception('データベースへの処理に失敗しました。', 1);
		}

	}

	public function directAppUnsubscribeMail() {

		try {
			$this->_pdo->beginTransaction();
			$this->directBaseUnsubscribeMail();

// 変更完了メールを送信する

			$cust_body = $this->_smarty->fetch('customer_unsubscribe_mail_complete.tpl');
			$cust_subject = 'お知らせメール配信停止手続きが完了しました';

			$replymail = $_SESSION['config']['donotreply_email'];
			$init_coopname = $this->_smarty->getTemplateVars('init_coopname');
			$init_ordermail = $_SESSION['config']['email'];

//登録メール送信
			self::send_mail($init_coopname, $replymail, $this->_auth->getAuthData('email'), $cust_subject, $cust_body);

//生協側へメール送信

			$namef = $this->_auth->getAuthData('namef');
			$nameg = $this->_auth->getAuthData('nameg');
			$username = $this->_auth->getUsername();

			if ($namef) {
				$name = $namef . ' ' . $nameg;
			} else {
				$name = $username;
			}

			$this->_smarty->assign('entry_namef', $namef);
			$this->_smarty->assign('entry_nameg', $nameg);
			$this->_smarty->assign('entry_username', $username);

			$order_subject = '【配信停止手続き】' . $this->_auth->getAuthData('email');
			$order_body = $this->_smarty->fetch('order_unsubscribe_mail_complete.tpl');

			self::send_mail($name, $this->_auth->getAuthdata('email'), $init_ordermail, $order_subject, $order_body);

//app_addへの登録

			$adddata['send'] = 1;
			$adddata['noreply'] = 1;
			$adddata['auto_send'] = 1;
			$adddata['add'] = 'unsubscribe_mail';
			$adddata['code'] = self::generateUuid();
			$adddata['subject'] = $cust_subject;
			$adddata['memo'] = $cust_body;

			$this->_smarty->assign('adic', $askdata['code']);

			$this->set_postdata($adddata);
			$this->saveAppAdd();

			$this->_pdo->commit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception('データベースへの処理に失敗しました。', 1);
		}

	}

}
?>
