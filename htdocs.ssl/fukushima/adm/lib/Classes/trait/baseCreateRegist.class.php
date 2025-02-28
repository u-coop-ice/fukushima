<?php
Trait baseCreateRegist {

	public function saveBaseCreateRegist($fields, $fields_must) {

		if (isset($_POST['confirm']) || isset($_POST['reinput2']) || isset($_POST['submit'])) {

			$postdata = HTTP_Session2::get('postdata');

			if (isset($_POST['confirm'])) {
				$this->_target = "regist_confirm_end";
				$_postdata = $this->execSanitize($fields, $fields_must);

				$postdata = array_merge($postdata, $_postdata);
				$postdata['fields_sql'] = $this->_fields_sql;
				HTTP_Session2::set('postdata', $postdata);
			}
			if (isset($_POST['confirm']) || isset($_POST['reinput2'])) {

// 表示するページの選択
				if (count($this->_input_error)) {
// 登録内容にエラーがあったら、入力のページを再度表示
					throw new Exception("Input Error" . $e->getMessage(), 9);
				} else {

// 登録内容の確認の場合
					if ($_POST["confirm"]) {
						$steps[1] = "cleared";
						$steps[2] = "cleared";
						$steps[3] = "cleared";
						$steps[4] = "cleared";
						$steps[5] = "now";
						$this->_smarty->assign('steps', $steps);

						$tmpl = 'confirm_end.tpl';
					}
// 再入力の場合
					else if ($_POST['reinput2']) {
						$steps[1] = "cleared";
						$steps[2] = "cleared";
						$steps[3] = "cleared";
						$steps[4] = "now";
						$this->_smarty->assign('steps', $steps);
						$tmpl = 'step2.tpl';
					}
					$this->_smarty->assign('post', $postdata);
					$this->_smarty->display($tmpl);
					exit();
				}
			} else if (isset($_POST['submit'])) {

				try {
					$this->_pdo->beginTransaction();

//既存ユーザーチェック
					$this->set_where(['username' => 'text', 'status' => 'integer']);
					$this->set_postdata(['username' => $postdata['email'], 'status' => 1]);
					$this->set_tbl($this->_pfx . 'regist');
					$existdata = $this->selectTable();

					if ($existdata['id']) {
						throw new Exception("すでに登録済みです", 1);
					}

					$fields_sql = $postdata['fields_sql'];

					if (!$this->_pfx) {
						unset($fields_sql['name']);
						$fields_sql['univ_id'] = 'integer';
						$postdata['univ_id'] = $_SESSION['config']['univ_id'];
					}

					$fields_sql = array_merge($fields_sql, [

						'username' => 'text',
						'email' => 'text',
						'status' => 'integer',
						'remote_addr' => 'text',
						'remote_host' => 'text',
						'user_agent' => 'text',
						'regist_date' => 'text',
						'password' => 'text',
						'tmp_update_password' => 'integer',
					]);

//投稿者の環境変数を取得
					$postdata['remote_addr'] = getenv('REMOTE_ADDR');
					$postdata['remote_host'] = getenv('REMOTE_HOST');
					$postdata['user_agent'] = getenv('HTTP_USER_AGENT');
					$postdata['status'] = 1;
					$postdata['username'] = $postdata['email'];
					$postdata['regist_date'] = date('Y-m-d H:i:s');
					$postdata['tmp_update_password'] = 1;

					if ($this->_pfx == '') {
						$postdata['rank'] = 1;
						$fields_sql['rank'] = 'integer';
					}

					if (!$postdata['password']) {
//パスワード生成
						$postdata['password_row'] = Text_Password::create(8, 'unpronounceable', 'alphanumeric');
						$this->_smarty->assign('post_password_row', $postdata['password_row']);

						$postdata['password'] = password_hash($postdata['password_row'], PASSWORD_DEFAULT);
					} else {
						$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
					}
					$this->set_fields($fields_sql);
					$this->set_postdata($postdata);
					$this->set_tbl($this->_pfx . 'regist');
					$this->insertTable();

					$subdata['status'] = 2;
					$subdata['email'] = $postdata['email'];
					$this->set_fields(['status' => 'integer']);
					$this->set_where(['email' => 'text']);
					$this->set_postdata($subdata);
					$this->set_tbl($this->_pfx . 'regist_sub');
					$this->updateTable();

					$postdata['regist_id'] = $this->get_last_insertId();
					$this->_smarty->assign('regist_id', $postdata['regist_id']);

					$infocode = $this->_smarty->getTemplateVars('infocode');
					$init_coopname = $this->_smarty->getTemplateVars('init_coopname');
					$init_pagetitle = $this->_smarty->getTemplateVars('init_pagetitle');

					$init_ordermail = $_SESSION['config']['email'];

					if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
						$init_ordermail = $_SESSION['config']['component'][COMPONENT]['store_ordermail'];
					}

					$infocode = $infocode . '-RGST';

					$regist_code = $infocode . ":" . date("Ymd") . "-" . sprintf("%04d", $postdata['regist_id']); //受付番号の番号作成
					$this->_smarty->assign('regist_code', $regist_code);
					$this->_smarty->assign('post', $postdata);

					$cust_body = $this->_smarty->fetch('customer_mail_end.tpl');
					$order_body = $this->_smarty->fetch('order_mail.tpl');
					$cust_subject = $init_pagetitle . 'ユーザー登録を承りました';

					$replymail = $_SESSION['config']['donotreply_email'];

					self::send_mail($init_coopname, $replymail, $postdata['email'], $cust_subject, $cust_body);

					$order_subject = $regist_code . '【' . $init_pagetitle . '】';

					if ($postdata['name']) {
						$name = $postdata['name'];
					} else if ($postdata['namef']) {
						$name = $postdata['namef'] . ' ' . $postdata['nameg'];
					} else {
						$name = $postdata['email'];
					}

					if ($postdata['cover'] && $postdata['name'] != $postdata['cover']) {
						$name .= ' ' . $postdata['cover'];
					}

					self::send_mail($name, $postdata['email'], $init_ordermail, $order_subject, $order_body);
// 登録完了ページを表示する

//ログの書き込み
					$logdata = [];
					$logdata['kind'] = 'regist';
					$logdata['value'] = json_encode($postdata);
					$logdata['username'] = $postdata['email'];
					$this->setLogdata($logdata);
					$this->setLog();

					$this->_pdo->commit();

					header("Location: $self?mode=complete_end");
					exit();

				} catch (Exception $e) {
					$this->_pdo->rollBack();
					throw new Exception("Database Error " . $e->getMessage(), 1);
				}

			}

		} else {
			throw new Exception("不正なアクセスです。", 1);
		}
	}

	public function saveBaseCreateRegistSub() {

		$fields = [
			'email' => 'text',
			'emailcfrm' => 'text',
			'agreement' => 'integer',
		];

		$fields_must = [
			'email' => 'text',
			'emailcfrm' => 'text',
			'agreement' => 'integer',
		];

		if ($this->_skip_emailcfrm) {
			unset($fields_must['emailcfrm']);
			unset($fields['emailcfrm']);
		}

		if (isset($_POST['confirm']) || isset($_POST['reinput1']) || isset($_POST['submit'])) {

			$postdata = HTTP_Session2::get('postdata');

			if ($postdata['complete'] == 1) {
				self::return2First();
				exit();
			}

			if (isset($_POST['confirm'])) {
				$this->_target = "regist_confirm";
				$postdata = $this->execSanitize($fields, $fields_must);
				HTTP_Session2::set('postdata', $postdata);
			}

			$this->_smarty->assign('post', $postdata);

			if (isset($_POST['confirm']) || isset($_POST['reinput1'])) {

// 表示するページの選択
				if (count($this->_input_error)) {
// 登録内容にエラーがあったら、入力のページを再度表示
					throw new Exception("Input Error" . $e->getMessage(), 9);
				} else {

// 登録内容の確認の場合
					if ($_POST["confirm"]) {
						$steps[1] = "cleared";
						$steps[2] = "now";
						$this->_smarty->assign('steps', $steps);

						$tmpl = 'confirm.tpl';
					}
// 再入力の場合
					else if ($_POST['reinput1']) {
						$steps[1] = "now";
						$this->_smarty->assign('steps', $steps);
						$tmpl = 'step1.tpl';
					}

					$this->_smarty->display($tmpl);
					exit();
				}
			} else if (isset($_POST['submit'])) {

				try {
					$this->_pdo->beginTransaction();

					unset($fields['agreement']);
					unset($fields['emailcfrm']);
					$fields = array_merge($fields, ['code' => 'text',
						'remote_addr' => 'text',
						'remote_host' => 'text',
						'user_agent' => 'text',
						'status' => 'integer',
						'ssid' => 'text',
					]);

//投稿者の環境変数を取得
					$postdata['remote_addr'] = getenv('REMOTE_ADDR');
					$postdata['remote_host'] = getenv('REMOTE_HOST');
					$postdata['user_agent'] = getenv('HTTP_USER_AGENT');
					$postdata['status'] = 0;
					$postdata['ssid'] = session_id();

					$code = md5(ROOT_DIR . 'org' . time() . $postdata['email']);
					$postdata['code'] = $code;
					$this->_smarty->assign('code', $code);

					$this->set_fields($fields);
					$this->set_postdata($postdata);
					$this->set_tbl($this->_pfx . 'regist_sub');
					$this->insertTable();

					$init_coopname = $this->_smarty->getTemplateVars('init_coopname');
					$init_pagetitle = $this->_smarty->getTemplateVars('init_pagetitle');

					$cust_body = $this->_smarty->fetch('customer_mail.tpl');
					$cust_subject = $init_pagetitle . '（本登録をお願いします）';

					$replymail = "DO_NOT_REPLY@u-coop.or.jp";

//sendgridのバウンスをクリア
					try {
						$sg = new setAccessSendgrid();

						$sg->set_email($postdata['email']);
						$sg->clearBounces();
					} catch (Exception $e) {
						throw new Exception("Mail Sever Error " . $e->getMessage(), 9);
					}

//仮登録メール送信
					self::send_mail($init_coopname, $replymail, $postdata['email'], $cust_subject, $cust_body);

//ログの書き込み
					$logdata = [];
					$logdata['kind'] = 'regist_sub';
					$logdata['value'] = json_encode($postdata);
					$logdata['username'] = $postdata['email'];
					$this->setLogdata($logdata);
					$this->setLog();

					$this->_pdo->commit();

					header("Location: $self?mode=complete");
					exit();

				} catch (Exception $e) {
					$this->_pdo->rollBack();
					throw new Exception("Database Error,Rollback!! " . $e->getMessage(), 1);
				}
			}
		} else {
			throw new Exception("Invalid access!!", 1);
		}

	}

	public function accessBaseCreateRegist() {

		$registdata = $this->checkStatusRegistSub();

// 仮登録されているかどうかをチェックする

		$this->_smarty->assign('post', $registdata);
		HTTP_Session2::set('postdata', $registdata);

		$steps[1] = "cleared";
		$steps[2] = "cleared";
		$steps[3] = "cleared";
		$steps[4] = "now";
		$this->_smarty->assign('steps', $steps);

		$tmpl = 'step2.tpl';
		$this->_smarty->display($tmpl);
	}

	private function checkStatusRegistSub() {
// ユーザー名と登録コードを得る
		$_code = self::my_htmlspecialchars($_GET['code']);

		if (!$_code) {
			throw new Exception("不正なアクセスです", 1);
		}
		try {
			$this->_pdo->beginTransaction();

			$sql = <<< HERE
SELECT * FROM {$this->_pfx}regist_sub
WHERE code = :code AND date > (NOW() - INTERVAL 10 MINUTE)

HERE;
			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindValue(':code', $_code, PDO::PARAM_STR);
				$res->execute();
			} catch (PDOException $e) {
				throw new Exception("データベース処理に失敗しました。", 1);
			}

			$registdata = $res->fetch();

			$file_sess = session_save_path() . '/sess_' . $registdata['ssid'];
			if (file_exists($file_sess)) {
				$sess = file_get_contents($file_sess);
				$sess = unserialize($sess);

				if (isset($sess['refferdata'])) {
					HTTP_Session2::set('refferdata', $sess['refferdata']);
				} else {
					HTTP_Session2::set('refferdata', null);
				}
			}

			if (!$registdata) {
				throw new Exception("不正なアクセスです", 1);
			} else if ($registdata['status'] == 2) {
				throw new Exception("すでに登録済みです", 1);
			} else {
				$registdata['status'] = 1;
				$this->set_fields(['status' => 'integer']);
				$this->set_where(['code' => 'text']);
				$this->set_postdata(['status' => $registdata['status'], 'code' => $_code]);
				$this->set_tbl($this->_pfx . 'regist_sub');
				$this->updateTable();
			}

//ログの書き込み
			$logdata = [];
			$logdata['kind'] = 'regist_recieved';
			$logdata['value'] = json_encode($registdata);
			$logdata['username'] = $registdata['email'];
			$this->setLogdata($logdata);
			$this->setLog();

			$this->_pdo->commit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception($e->getMessage(), 1);
		}
		return $registdata;
	}

	public function completeBaseCreateRegistSub() {
		$postdata = HTTP_Session2::get('postdata');
		if (isset($postdata['complete']) && $postdata['complete']) {
			throw new Exception("不正なアクセスです。", 9);
		}

		$this->_smarty->assign('post', $postdata);
		HTTP_Session2::set('postdata', ['complete' => 1]);

		$steps[1] = "cleared";
		$steps[2] = "cleared";
		$steps[3] = "now";
		$this->_smarty->assign('steps', $steps);

		$this->_smarty->display('complete.tpl');
		exit();
	}

	public function completeBaseCreateRegist() {
		$postdata = HTTP_Session2::get('postdata');
		if (isset($postdata['complete']) && $postdata['complete']) {
			throw new Exception("不正なアクセスです。", 9);
		}

		$this->_smarty->assign('post', $postdata);
		HTTP_Session2::set('postdata', ['complete' => 1]);

		$steps[1] = "cleared";
		$steps[2] = "cleared";
		$steps[3] = "cleared";
		$steps[4] = "cleared";
		$steps[5] = "cleared";
		$steps[6] = "now";
		$this->_smarty->assign('steps', $steps);

		$this->_smarty->display('complete_end.tpl');
		exit();
	}

	public function completeBaseRemind() {
		$this->setTmpl('complete_remind.tpl');
		$this->completeBase();
	}

	public function completeBaseRemindEnd() {

		$postdata['username'] = urldecode(trim($_GET['username']));
		$postdata['username'] = addslashes($postdata['username']);

		$this->_smarty->assign('post', $postdata);

		$this->_smarty->display('complete_remind_end.tpl');
		exit();
	}

	private function sendBaseRemind() {
		if ($this->_auth->checkAuth()) {
			self::return2First();
		}

		if (!isset($_POST["remind"])) {
			throw new Exception("不正なアクセスです", 1);
		}
		$fields = ['email' => 'text'];
		$this->_target = 'remind';
		$this->_skip_emailcfrm = 1;
		$postdata = $this->execSanitize($fields, $fields);

		//登録メール有無の判定
		$this->duplicateUsername($postdata['email']);
		if ($this->_input_error['duplicate_email']) {

			$code = md5($this->_smarty->getConfigVars('salt') . time() . $postdata['email']);
			$this->_smarty->assign('code', $code);

			$this->set_tbl($this->_pfx . 'regist');
			$this->set_where(['username' => 'text']);
			$this->set_fields(['tmp_code' => 'text', 'tmp_date' => 'text']);
			$this->set_postdata(['tmp_code' => $code, 'tmp_date' => date("Y-m-d H:i:s"), 'username' => $postdata['email']]);
			$this->updateTable();

			$cust_body = $this->_smarty->fetch('remind_mail.tpl');
			$cust_subject = 'パスワード変更をお願いします';

			$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

			$replymail = $_SESSION['config']['donotreply_email'];

//仮登録メール送信
			self::send_mail($init_coopname, $replymail, $postdata['email'], $cust_subject, $cust_body);

			$logdata['kind'] = 'send_remind';
			$logdata['username'] = $postdata['email'];
			$logdata['result'] = 1;
			$this->setLogdata($logdata);
			$this->setLog();

		}

	}

	private function accessBaseRemind() {
		if ($this->_auth->checkAuth()) {
			self::return2First();
		}
		$registdata = $this->checkRemindRegist();

		$logdata['kind'] = 'access_remind';
		$logdata['username'] = $registdata['username'];
		$logdata['result'] = 1;
		$this->setLogdata($logdata);
		$this->setLog();

		$this->_smarty->assign('regist', $registdata);
		$this->_smarty->display('change_password.tpl');
	}

	private function checkRemindRegist() {
// ユーザー名と登録コードを得る
		$_code = self::my_htmlspecialchars($_GET['code']);
		if (!$_code) {
			throw new Exception("不正なアクセスです", 1);
		}

		$sql = <<< HERE
SELECT * FROM {$this->_pfx}regist
WHERE tmp_code = :code AND tmp_date > (NOW() - INTERVAL 1 HOUR)

HERE;
		try {
			$res = $this->_pdo->prepare($sql);
			$res->bindValue(':code', $_code, PDO::PARAM_STR);
			$res->execute();
		} catch (PDOException $e) {
			throw new Exception("データベース処理に失敗しました。", 1);
		}

		$registdata = $res->fetch();
		if (!$registdata) {
			throw new Exception("URLは無効です。", 1);
		}
		return $registdata;
	}

	private function saveBaseRemind() {

		if ($this->_auth->checkAuth()) {
			self::return2First();
		}

		$fields = [
			'tmp_code' => 'text',
			'user_name' => 'text',
			'password' => 'text',
			'passwordcfrm' => 'text',
		];
		$this->_target = 'save_remind';
		$postdata = $this->execSanitize($fields, $fields);

		$this->_username = $postdata['user_name'];
		try {
			$this->_pdo->beginTransaction();
			$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);

			$sql = <<< HERE
UPDATE {$this->_pfx}regist
 SET `password`=:password,`tmp_code` = NULL,`tmp_date` = NULL
WHERE `tmp_code` = :tmp_code AND `username` = :username

HERE;
			try {
				$res = $this->_pdo->prepare($sql);
				$res->bindValue(':password', $postdata['password'], PDO::PARAM_STR);
				$res->bindValue(':tmp_code', $postdata['tmp_code'], PDO::PARAM_STR);
				$res->bindValue(':username', $postdata['user_name'], PDO::PARAM_STR);
				$res->execute();
			} catch (PDOException $e) {
				throw new Exception("データベース処理に失敗しました。" . $e->getMessage(), 1);
			}

			$logdata['kind'] = 'save_remind';
			$logdata['username'] = $postdata['user_name'];
			$logdata['result'] = 1;
			$this->setLogdata($logdata);
			$this->setLog();

			$this->_pdo->commit();

		} catch (Exception $e) {
			$this->_pdo->rollBack();
			throw new Exception("Database Error " . $e->getMessage(), 1);
		}

	}

	public function get_username() {
		return $this->_username;
	}
}
?>
