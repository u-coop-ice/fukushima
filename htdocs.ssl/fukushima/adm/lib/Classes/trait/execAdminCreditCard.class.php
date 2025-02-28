<?php
trait execAdminCreditCard {

	protected $_paymentdata;
	protected $_regist_code;

	public function saveCapture() {
		global $init_coopname;

		$target = "charge";

		$this->_app_ids = $_REQUEST['app_id'];

		if (!is_array($this->_app_ids)) {
			throw new Exception("パラメーターが不正です。", 1);
		}
		if (!count($this->_app_ids)) {
			throw new Exception("パラメーターが不正です。", 1);
		}

		$this->_app_ids = array_map('intval', $this->_app_ids);

		$postdata['amount'] = [];
		if (isset($_REQUEST['amount'])) {
			$postdata['amount'] = $_REQUEST['amount'];
			if (count($postdata['amount'])) {
				$postdata['amount'] = array_map('intval', $postdata['amount']);
			}
		}

		$postdata['charged_id'] = $_REQUEST['charged_id'];

		$postdata['charged_id'] = array_map('strip_tags', $postdata['charged_id']);

		$this->set_postdata($postdata);
		$sends = $this->getAppPayments();

		$replymail = $_SESSION['config']['donotreply_email'];

		foreach ($sends as $i => $send) {

			$this->_app_id = $send['app_id'];

			$send = $this->execCardCharge($send, $target);

			if ($send['skip'] == 1) {continue;}

//課金完了のメール送信
			$this->_smarty->assign('regist_namef', $send['namef']);
			$this->_smarty->assign('regist_nameg', $send['nameg']);
			$this->_smarty->assign('view_app_id', $send['app_id']);
			$this->_smarty->assign('view_order_id', $send['app_id']);
			$this->_smarty->assign('app_status', $send['app_status']);
			$this->_smarty->assign('regist_code', $send['regist_code']);

			$to = $send['email'];

//CODEの作成
			$adic = self::generateUuid();
			$send['code'] = $adic;
			$this->_smarty->assign('adic', $adic);

			$this->_smarty->assign('post_amount', $send['amount']);
			$this->_smarty->assign('just_captured', $send['just_captured']);

			$send['send'] = 1;
			$send['noreply'] = 9;
			$send['date'] = date('Y-m-d H:i:s');
			$subject = 'クレジットカード決済のご利用確認が完了いたしました';

			$send['process'] = 'save_capture';
			$send['memo'] = $this->_smarty->fetch('shop_charged_mail.tpl');
			$send['add'] = 'save_capture';

			$send['sendmail_paid_completed'] = 1;
			$send['id'] = $send['app_id'];
			$send['subject'] = htmlspecialchars_decode($subject, ENT_QUOTES);

			$arg['univ_id'] = $send['univ_id'];
			$arg['regist_id'] = $send['regist_id'];
			$arg['add_code'] = $send['code'];

			$send['memo'] = self::removeLineFeed($send['memo']);
			$cust_body = htmlspecialchars_decode($send['memo'], ENT_QUOTES);
			$cust_body .= $this->_smarty->fetch('shop_mail_footer.tpl');

			self::send_mail($init_coopname, $replymail, $to, $subject, $cust_body, $arg);

			$ordermail = $_SESSION['config']['email'];

			if ($send['app'] == 'shopping') {
				$this->set_shopping_subcategory_id($send['category_id']);
				$init_category = $this->getShoppingCategory();
				$ordermail = $init_category['ordermail'];
				$this->_smarty->assign('init_category', $init_category);
			}

			self::send_mail($init_coopname, $replymail, $ordermail, '（コピー）' . $subject, "【ユーザーへ送信した内容のコピーです。】\n\n" . $cust_body);

			$paiddata = [];

			$paiddata['memo'] = $send['date_paid'];
			$paiddata['payment_confirmed'] = $send['amount'];

//課金情報の更新
			$this->set_postdata($paiddata);
			$this->savePayment();
//ログの更新
			$logdata['process'] = 'save_capture';
			$logdata['value'] = $send['amount'];
			$logdata['app_id'] = $this->_app_id;

			$this->set_postdata($logdata);
			$this->saveAdminLog();

			$this->updateOptSendmail();

			$this->set_postdata($send);
			$this->saveAppAdd();

		}

	}

	public function saveRefund() {
		global $init_coopname;

		$target = "refund";

		$this->_app_ids = $_REQUEST['app_id'];

		if (!is_array($this->_app_ids)) {
			throw new Exception("パラメーターが不正です。", 1);
		}
		if (!count($this->_app_ids)) {
			throw new Exception("パラメーターが不正です。", 1);
		}

		$this->_app_ids = array_map('intval', $this->_app_ids);

		$postdata['amount'] = [];
		if (isset($_REQUEST['amount'])) {
			$postdata['amount'] = $_REQUEST['amount'];
			if (count($postdata['amount'])) {
				$postdata['amount'] = array_map('intval', $postdata['amount']);
			}
		}

		$postdata['charged_id'] = $_REQUEST['charged_id'];

		$postdata['charged_id'] = array_map('strip_tags', $postdata['charged_id']);

		$this->set_postdata($postdata);
		$sends = $this->getAppPayments();

		$replymail = $_SESSION['config']['donotreply_email'];

		foreach ($sends as $i => $send) {

			$this->_app_id = $send['app_id'];

			$send = $this->execCardCharge($send, $target);

			if ($send['skip'] == 1) {continue;}

//課金完了のメール送信
			$this->_smarty->assign('regist_namef', $send['namef']);
			$this->_smarty->assign('regist_nameg', $send['nameg']);
			$this->_smarty->assign('view_app_id', $send['app_id']);
			$this->_smarty->assign('view_order_id', $send['app_id']);
			$this->_smarty->assign('app_status', $send['app_status']);
			$this->_smarty->assign('regist_code', $send['regist_code']);

			$to = $send['email'];

//CODEの作成
			$adic = self::generateUuid();
			$send['code'] = $adic;
			$this->_smarty->assign('adic', $adic);

			$this->_smarty->assign('post_amount', $send['amount']);

			$send['send'] = 1;
			$send['noreply'] = 9;
			$send['date'] = date('Y-m-d H:i:s');
			$subject = 'クレジットカード決済の返金処理が完了いたしました';

			$subject_sub = '下記のご注文に関してご利用いただきましたクレジットカードでの課金取消（返金）を行いました。';

//VCS
			if ($send['payment'] == 6) {
				$subject = 'コンビニ払いの決済取消が完了いたしました';
				$subject_sub = '下記のご注文へのコンビニ払いの決済を取り消しました。発行済みの受付番号は無効になります。';
			}

			$this->_smarty->assign('subject', $subject);
			$this->_smarty->assign('subject_sub', $subject_sub);

			$send['process'] = 'save_cancel';
			$this->_smarty->assign('post_amount', $send['amount'] * (-1));

			$send['memo'] = $this->_smarty->fetch('shop_cancelled_mail.tpl');
			$send['add'] = 'save_cancel';

			$send['sendmail_paid_completed'] = 1;
			$send['id'] = $send['app_id'];
			$send['subject'] = htmlspecialchars_decode($subject, ENT_QUOTES);

			$arg['univ_id'] = $send['univ_id'];
			$arg['regist_id'] = $send['user_id'];
			$arg['add_code'] = $send['code'];

			$send['memo'] = self::removeLineFeed($send['memo']);
			$cust_body = htmlspecialchars_decode($send['memo'], ENT_QUOTES);
			$cust_body .= $this->_smarty->fetch('shop_mail_footer.tpl');

			self::send_mail($init_coopname, $replymail, $to, $subject, $cust_body, $arg);

			$ordermail = $_SESSION['config']['email'];

			if ($send['app'] == 'shopping') {
				$this->set_shopping_subcategory_id($send['category_id']);
				$init_category = $this->getShoppingCategory();
				$ordermail = $init_category['ordermail'];
				$this->_smarty->assign('init_category', $init_category);
			}

			self::send_mail($init_coopname, $replymail, $ordermail, '（コピー）' . $subject, "【ユーザーへ送信した内容のコピーです。】\n\n" . $cust_body);

			$paiddata = [];

			$paiddata['memo'] = $send['date_paid'];
			$paiddata['payment_confirmed'] = $send['amount'];

//課金情報の更新
			$this->set_postdata($paiddata);
			$this->savePayment();
//ログの更新
			$logdata['process'] = 'save_cancel';
			$logdata['value'] = $send['amount'];
			$logdata['app_id'] = $this->_app_id;

			$this->set_postdata($logdata);
			$this->saveAdminLog();

			$this->updateOptSendmail();

			$this->set_postdata($send);
			$this->saveAppAdd();

		}

	}

	public function saveAdjust() {
		global $site_coopname;

		$this->_app_id = intval($_REQUEST['app_id']);

		if (!$this->_app_id) {
			throw new Exception("パラメーターが不正です。", 1);
		}

		if (isset($_REQUEST['payment_confirmed'])) {
			$fields_payment['memo'] = 'text';
			$fields_payment['payment_confirmed'] = 'integer';
			$fields_payment['payment'] = 'integer';

			foreach ($fields_payment as $field => $v) {
				$value = strip_tags($_POST[$field]);
				$value = mb_convert_kana($value, "nKV");
				if ($v == "integer") {
					$postdata[$field] = intval($value);
				} else {
					$postdata[$field] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
				}
			}

			$postdata['memo'] = substr($postdata['memo'], 0, 19);
			$postdata['date'] = $postdata['memo'];

		}

//appの更新、、payment_logの追加

		$this->set_postdata($postdata);
		$this->savePayment();

//ログの書き込み

		$logdata['process'] = 'save_adjust';
		$logdata['app_id'] = $this->_app_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

	private function recieveReportVeritrans() {

		foreach ($_POST as $_key => $_value) {
			$key = htmlspecialchars($_key, 3, 'UTF-8');
			$value = htmlspecialchars($_value, 3, 'UTF-8');

			//// ヘッダ情報
			// 通知件数
			if (strcmp($key, 'numberOfNotify') == 0) {
				$this->_numberOfNotify = $value;
			}
			// 送信時刻
			if (strcmp($key, 'pushTime') == 0) {
				$this->_pushTime = $value;
			}
			// 識別ID
			if (strcmp($key, 'pushId') == 0) {
				$this->_pushId = $value;
			}
			// 速報・確報フラグ
			if (strcmp($key, 'fixed') == 0) {
				$this->_fixed = $value;
			}

			//// 明細情報
			// フィールド名と連番を取得する
			if (preg_match('/^([^0-9]+)([0-9]{4})$/', $key, $m) == false) {
				continue;
			}
			$arrRecords[$m[2]][$m[1]] = $value;
		}

// ここまでで正常な通信かを確認
		if ($this->_numberOfNotify == null || $this->_pushTime == null || $this->_pushId == null) {
			throw new Exception("Error send data from veritrans!!", 1);
		}

		if (!is_array($arrRecords)) {
			throw new Exception("Error send data from veritrans!!", 1);
		}
		if (!count($arrRecords)) {
			throw new Exception("Error send data from veritrans!!", 1);
		}

// recievedの生データをDBに保存しておく。

		$fields = array(
			'pushId' => 'text',
			'pushTime' => 'text',
			'numberOfNotify' => 'integer',
			'orderId' => 'text',
			'charged_id' => 'text',
			'cvsType' => 'text',
			'receiptNo' => 'text',
			'receiptDate' => 'integer',
			'rcvAmount' => 'integer',
			'dummy' => 'integer',

			'mpiMstatus' => 'text',
			'cardMstatus' => 'text',
			'vResultCode' => 'text',

		);

		$this->set_fields($fields);

		foreach ($arrRecords as $key => $record) {

			$this->set_tbl('webhook_veritrans');
			$data = [];

			$data = $record;
			$data['charged_id'] = $record['orderId'];
			$data['pushId'] = $this->_pushId;
			$data['pushTime'] = $this->_pushTime;
			$data['numberOfNotify'] = $this->_numberOfNotify;

			$this->set_postdata($data);
			$this->insertTable();

		}
		$this->set_fields([]);

		return $arrRecords;
	}

	public function saveRecievedReportVeritrans() {

		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			throw new Exception("invalid Access!!", 1);}

		$records = $this->recieveReportVeritrans();

/*		$pfx2s = $this->getPfx2s();*/

		$this->_app_ids = [];
		$postdata = [];
		$postdata['amount'] = [];
		$postdata['charged_id'] = [];
		$postdata['date_paid'] = [];
		$postdata['coop_code'] = [];

//		$postdata['pfx2'] = [];
		//		$postdata['coop_code'] = [];

		foreach ($records as $key => $record) {

			$data = [];
			$data = $record;
			$data['charged_id'] = $record['orderId'];
			$data['pushId'] = $this->_pushId;
			$data['pushTime'] = $this->_pushTime;
			$data['numberOfNotify'] = $this->_numberOfNotify;

			if (!preg_match('/^NL/', $data['orderId'])) {
				continue;
			}

			$data['coop_code'] = substr($data['orderId'], 2, 2);

			if ($_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['code'] != $data['coop_code']) {
				continue;
			}

//eventごと処理

//			$pfx2 = $pfx2s[$data['coop_code']]['pfx2'];

			$sql = <<< HERE
SELECT SUM(log.value) as sum,app.id as app_id FROM {$this->_pfx2}app as app
LEFT JOIN {$this->_pfx2}payment_log as log ON app.id = log.app_id
WHERE app.charged_id = ?

HERE;

			try {
				$res = $this->_pdo_repl->prepare($sql);
				$res->execute(array($data['orderId']));
			} catch (PDOException $e) {
				die('Database treatment error.');
				exit();
			}

			$pay = $res->fetch();
			if (!$pay['app_id']) {continue;}
			array_push($this->_app_ids, $pay['app_id']);
			array_push($postdata['amount'], $data['rcvAmount']);
			array_push($postdata['charged_id'], $data['charged_id']);
			array_push($postdata['coop_code'], $data['coop_code']);
			array_push($postdata['date_paid'], $data['receiptDate']);
		}

//		global $site_coopname;

		$target = "recieved";

		$this->set_postdata($postdata);
		$sends = $this->getAppPayments();

		$replymail = $_SESSION['config']['donotreply_email'];
		if (count($sends)) {
			foreach ($sends as $i => $send) {

				$this->_app_id = $send['app_id'];

//			$send = $this->execCardCharge($send, $target);

				if ($send['skip'] == 1) {continue;}

//課金完了のメール送信
				$this->_smarty->assign('entry_namef', $send['namef']);
				$this->_smarty->assign('entry_nameg', $send['nameg']);

				$this->_smarty->assign('post_name', $send['namef'] . ' ' . $send['nameg']);
				$this->_smarty->assign('post_namef', $send['namef']);
				$this->_smarty->assign('post_nameg', $send['nameg']);

				$this->_smarty->assign('view_app_id', $send['app_id']);
				$this->_smarty->assign('app_status', $send['app_status']);
				$this->_smarty->assign('app_app', $send['app']);
				$this->_smarty->assign('regist_code', $send['regist_code']);

				$to = $send['email'];

//CODEの作成
				$adic = md5($send['regist_code'] . $to . time() . mt_rand());
				$send['code'] = $adic;

//生協ごとの設定を呼び出し
				//$site_coopname
				//$ordermail

				$site_coopname = $_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['coopname'];
				$this->_smarty->assign('site_coopname', $site_coopname);
				$this->_smarty->assign('site_domain', $_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['domain']);

				$ordermail = $_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['ordermail'];

				if ($send['app'] == 'stay') {
					if ($_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['travel_ordermail']) {
						$ordermail = $_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['travel_ordermail'];
					}
				} else if ($send['app'] == 'order') {
					if ($send['app_sub']) {
						$this->set_app_sub($send['app_sub']);
						$categoryinfo = $this->selectOrderCategory();
						if ($categoryinfo['ordermail']) {
							$ordermail = $categoryinfo['ordermail'];
						}

						if ($categoryinfo['name_public']) {
							$this->_smarty->assign('category_name', $categoryinfo['name_public']);
						}

					}

				} else if ($send['app'] == 'menkyo') {
					if ($_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['menkyo_ordermail']) {
						$ordermail = $_SESSION['initdata'][$_SESSION['coop']["auth"]]['travel']['menkyo_ordermail'];
					}
				}

				$this->_smarty->assign('adic', $adic);
				$this->_smarty->assign('app_code', $send['app_code']);
				$this->_smarty->assign('regist_code', $send['regist_code']);

				$this->_smarty->assign('post_amount', $send['amount']);
				$this->_smarty->assign('just_captured', $send['just_captured']);

				$send['send'] = 1;
				$send['noreply'] = 9;
				$send['date'] = date('Y-m-d H:i:s');
				$subject = 'コンビニ払いの入金を確認しました';

				$send['process'] = 'save_recieved';
				$send['memo'] = $this->_smarty->fetch('shop_recieved_mail.tpl');
				$send['add'] = 'save_recieved';

				$send['sendmail_paid_completed'] = 1;
				$send['id'] = $send['app_id'];
				$send['subject'] = htmlspecialchars_decode($subject, ENT_QUOTES);

				$arg['univ_id'] = $send['univ_id'];
				$arg['user_id'] = $send['user_id'];
				$arg['add_code'] = $send['code'];

				$send['memo'] = self::removeLineFeed($send['memo']);
				$cust_body = htmlspecialchars_decode($send['memo'], ENT_QUOTES);
				$cust_body .= $this->_smarty->fetch('shop_mail_footer.tpl');

				send_mail($site_coopname, $replymail, $to, $subject, $cust_body, $arg);

				$arg_order = [];
				if (self::_admin_email) {
					$arg_order['cc'] = self::_admin_email;
				}

				send_mail($site_coopname, $replymail, $ordermail, '（コピー）' . $subject, "【ユーザーへ送信した内容のコピーです。】\n\n" . $cust_body, $arg_order);

				$this->set_app($send['app']);
				$this->setMessage("【ユーザーへ送信した内容のコピーです。】\n\n" . $cust_body);
				$this->throwAtSlack();

				$paiddata = [];

				$paiddata['memo'] = $send['date_paid'];
				$paiddata['payment_confirmed'] = $send['amount'];

//課金情報の更新
				//免許だけstatusなど更新
				if ($send['app'] == "menkyo") {
					$paiddata['status'] = 1;
					$paiddata['visible'] = 1;
				}

				$this->set_postdata($paiddata);
				$this->savePayment();
//ログの更新
				$logdata['process'] = 'save_recieved';
				$logdata['value'] = $send['amount'];
				$logdata['app_id'] = $this->_app_id;

				$this->set_postdata($logdata);
				$this->saveAdminLog();

				$this->updateOptSendmail();

				$this->set_postdata($send);
				$this->saveAppAdd();

				if ($send['app'] != "menkyo") {continue;}

				$this->set_regist_code($regist_code);
				$this->set_app_dir('menkyo');
				$this->createMenkyoPDF();
				$storename = $this->getStoreName();
				$school_email = $this->getSchoolEmail();

				$this->_smarty->assign('storename', $storename);

				$order_content = $this->getOrderContent();
				$this->_smarty->assign('order_content', htmlspecialchars_decode($order_content, ENT_QUOTES));

//クーポンリンクのメール送信
				$cust_body = $this->_smarty->fetch('shop_menkyo_pdf_mail.tpl');

				$cust_subject = '「自動車教習所申込書」をダウンロードしてください';

//app_addへの登録
				$adddata = [];
				$adddata['app_id'] = $this->_app_id;
				$adddata['user_id'] = $send['user_id'];
				$adddata['subject'] = $cust_subject;
				$adddata['memo'] = $cust_body;
				$adddata['send'] = 1;
				$adddata['noreply'] = 9;
				$adddata['code'] = md5($regist_code . $to . time() . 'create_pdf' . $to);
				$adddata['add'] = "create_menkyo_pdf";
				$adddata['date'] = date('Y-m-d H:i:s');

				$this->set_postdata($adddata);
				$this->saveAppAdd();

				$add_id = $this->get_last_insertId();
				$this->_smarty->assign("adid", $add_id);

				$arg['univ_id'] = $send['univ_id'];
				$arg['user_id'] = $send['user_id'];
				$arg['add_code'] = $adddata['code'];

//自動返信メール
				$cust_body .= $this->_smarty->fetch('shop_mail_footer.tpl');

				send_mail($site_coopname, $replymail, $to, $cust_subject, $cust_body, $arg);

//教習所への受注メール配信
				if ($school_email) {
					$school_subject = '【大学生協】入学前特典付き「運転免許」WEB申込者情報のご連絡';
					$school_body = $this->_smarty->fetch('school_menkyo_mail.tpl');

					send_mail('大学生協事業連合東北地区', $replymail, $school_email, $school_subject, $school_body);
				}

			} // foreach sends
		}
	}

	private function execCardCharge($send, $target) {

		if (!$send['charged_id']) {
			$send['skip'] = 1;
			return;
		}

		if ($send['test_mode'] == 1) {
			define('CREDIT_TEST_MODE', 1);
		}

		switch ($send['payment']) {
		case 4: // PAY.JP
			$charge = new \shopping\payjp\webCharge();
			$charge->setApi_key($send['api_key']);
			$card['charged_id'] = $send['charged_id'];

			switch ($target) {
			case "charge":

				if (isset($send['amount'])) {
					if ($send['amount'] > 0) {
						$card['amount'] = $send['amount'];
					} else if ($send['amount'] < 0) {
						throw new Exception("実売上の金額の設定が不正です", 1);
					}
				}
				$charge->setCard($card);

				$response = $charge->capture();

				$send['date_paid'] = date("Y-m-d H:i:s", $response->captured_at);

				$send['amount'] = $response->amount;
				if ($response->amount_refunded) {
					$send['amount'] -= $response->amount_refunded;
				} else {
					$send['just_captured'] = 1;
				}
				break;

			case "refund":

				if (isset($send['amount'])) {
					if ($send['amount'] < 0) {
						$card['amount'] = $send['amount'] * (-1);
					} else if ($send['amount'] > 0) {
						throw new Exception("返金金額の設定が不正です", 1);
					}
				}
				$charge->setCard($card);

				$response = $charge->refund();
				$send['date_paid'] = date("Y-m-d H:i:s", time());

			}
			if (is_array($response['err'])) {
				$this->_smarty->assign('card_err', $response['err']['errmsg']);
				$this->_smarty->assign('view_app_id', $send['app_id']);
				throw new Exception($response['err']['errmsg'], 1);
			}

			break;

		case 5: // Veritrans
			$charge = new \shopping\veritrans\webCharge();
			$charge->setApi_key($send['api_key'], $send['api_secret_key'], $send['test_mode']);

			$card['charged_id'] = $send['charged_id'];

			switch ($target) {
			case "charge":

				$card['amount'] = $send['amount'];
				$charge->setCard($card);

				$captured = $charge->capture();
				$send['date_paid'] = date("Y-m-d H:i:s", strtotime($captured['charged_date']));

				if ($send['price_total'] == $send['amount']) {
					$send['just_captured'] = 1;
				}
				break;
			case "refund":
				$card['amount'] = $send['amount'] * (-1);
				$charge->setCard($card);

				$cancelled = $charge->cancel();
				$send['date_paid'] = date("Y-m-d H:i:s", strtotime($cancelled['cancel_date']));

				break;
			}
			if ($this->_smarty->getTemplateVars('err')) {
				$this->_smarty->assign('card_err', $this->_smarty->getTemplateVars('card_err'));
				$this->_smarty->assign('view_app_id', $send['app_id']);
				throw new Exception($this->_smarty->getTemplateVars('card_err'), 1);
			}
			break;
		case 6: // Veritrans CVS
			$charge = new \shopping\veritrans\webCharge();
			$charge->setApi_key($send['api_key'], $send['api_secret_key'], $send['test_mode']);

			$card['charged_id'] = $send['charged_id'];

			switch ($target) {
			case "refund":
				$charge->setCard($card);

				$cancelled = $charge->cancelCvs();
				$send['date_paid'] = date("Y-m-d H:i:s", strtotime($cancelled['cancel_date']));

				break;
			case "recieved":
				break;
			}
			if ($this->_smarty->getTemplateVars('err')) {
				$this->_smarty->assign('card_err', $this->_smarty->getTemplateVars('card_err'));
				$this->_smarty->assign('view_app_id', $send['app_id']);
				throw new Exception($this->_smarty->getTemplateVars('card_err'), 1);
			}
			break;
		default:
			$send['skip'] = 1;
			break;
		}

		return $send;
	}

	private function getAppPayments() {

		$postdata = $this->_postdata;

		foreach ($this->_app_ids as $i => $app_id) {
			$pfx2 = null;
			$this->_app_id = $app_id;
			if ($postdata['pfx2'][$i]) {
				$this->_pfx2 = $postdata['pfx2'][$i];
			}
			if ($postdata['coop_code'][$i]) {
				$this->_coop_code = $postdata['coop_code'][$i];
			}
			$sends[$i] = $this->getAppPayment();
			if (isset($postdata['amount'][$i])) {
				$sends[$i]['amount'] = $postdata['amount'][$i];
			}
			if ($postdata['pfx2'][$i]) {
				$sends[$i]['pfx2'] = $postdata['pfx2'][$i];
			}
			if ($postdata['coop_code'][$i]) {
				$sends[$i]['coop_code'] = $postdata['coop_code'][$i];
			}
			if ($postdata['date_paid'][$i]) {
				$sends[$i]['date_paid'] = date("Y-m-d H:i:s", strtotime($postdata['date_paid'][$i]));
			}
//			$this->_user_univ_id = $sends[$i]['univ_id'];
			//			$sends[$i]['regist_code'] = $this->getAppRegistNumber();

		}
//		$this->_user_univ_id = null;
		return $sends;
	}

	public function set_paymentdata($_paymentdata) {
		$this->_paymentdata = $_paymentdata;
	}
	public function set_regist_code($_regist_code) {
		$this->_regist_code = $_regist_code;
	}

// カード決済情報の格納
	private function calcCardPayment() {
		if ($this->_sanitized['payment'] == 4) {
			//PAY.JP処理

			if (isset($_POST['chgCardInfo'])) {
				unset($this->_sanitized['payjp-token']);
			}

			if ($_POST['payjp-token']) {
				$this->_sanitized['payjp-token'] = addslashes($_POST['payjp-token']);
			} else if ($_POST['payjp-card_id']) {
				$this->_sanitized['card_id'] = addslashes($_POST['payjp-card_id']);
			}

			if (isset($_POST['regist_card'])) {
				$this->_sanitized['regist_card'] = 1;
			}
			if (!$this->_sanitized['token_id']) {
				unset($this->_sanitized['regist_card']);
			}

			if ($this->_userAuth->getAuthData('cust_id')) {
				if (!isset($_POST['cust_id_error'])) {
					$this->_sanitized['cust_id'] = $this->_userAuth->getAuthData('cust_id');
				}

			}

			if (!$this->_sanitized['payjp-token'] && !$this->_sanitized['card_id']) {
				$this->_smarty->assign('card_err', 1);
				$this->_smarty->assign('err', 1);
			}
			if (isset($this->_sanitized['jpo'])) {
				unset($this->_sanitized['jpo']);
			}

		} else if ($this->_sanitized['payment'] == 5) {
			//veritrans処理
			if ($_POST['token_id']) {
				$this->_sanitized['token_id'] = addslashes($_POST['token_id']);
				$this->_sanitized['req_card_number'] = addslashes($_POST['req_card_number']);
			} else {
				$this->_smarty->assign('card_err', 1);
				$this->_smarty->assign('err', 1);
			}

			if (isset($_POST['jpo'])) {
				$this->_sanitized['jpo'] = addslashes($_POST['jpo']);
			}
		}

	}

	public function setCharges() {

		switch ($this->_paymentdata['payment']) {
		case 4:
			$this->execCreditCardPayjp();
			break;
		case 5:
			$this->execCreditCardVeritrans();
			break;
		default:
			$this->_paymentdata['token_id'] = null;
			$this->_paymentdata['payjp-token'] = null;
			$this->_paymentdata['req_card_number'] = null;
			$this->_paymentdata['charged_id'] = null;
			$this->_paymentdata['api_key'] = null;
			$this->_paymentdata['api_secret_key'] = null;
			$this->_paymentdata['test_mode'] = null;
			break;
		}
		return $this->_paymentdata;
	}

	private function recievedMpiVeritransUser($_record, $_appinfo) {

		$this->_app_id = $_appinfo['id'];

		switch ($_appinfo['app']) {
		case "order":
		case "stay":
			$send = $this->getAppPayment();
			break;
		case "menkyo":
			$send = $this->getAppMenkyo();
			break;
		}

		if (!is_array($send)) {return;}

		if ($_record['mpiMstatus'] == 'success' && $_record['cardMstatus'] == 'success') {

			$log_id = $this->checkEntryLogProcess('card_success_payment_app');

			if (is_numeric($log_id)) {return;}

			$initdata = $_SESSION['initdata'];
			$init_ordermail = $initdata[$send['univ_id']]['travel']['ordermail'];
			$univ_code = $initdata[$send['univ_id']]['travel']['code'];
			$this->_coop_code = $univ_code;

			$init_coopname = $initdata[$send['univ_id']]['travel']['coopname'];

			$this->_smarty->assign('site_coopname', $init_coopname);
			$this->_smarty->assign('site_domain', $initdata[$send['univ_id']]['travel']['domain']);

			switch ($send['app']) {
			case "stay":
				if (isset($initdata[$univ_id]['travel']['travel_ordermail']) && $initdata[$send['univ_id']]['travel']['travel_ordermail']) {
					$init_ordermail = $initdata[$send['univ_id']]['travel']['travel_ordermail'];
				}
				break;
			case "order":
				$this->_app = $send['app'];
				$this->_app_sub = $send['app_sub'];
				$categoryinfo = $this->selectOrderCategory();

//カテゴリごとのメール設定
				if ($categoryinfo['ordermail']) {
					$init_ordermail = $categoryinfo['ordermail'];
				}

				$this->_smarty->assign('init_order_mail_add1', $categoryinfo['mail_add1']);
				$this->_smarty->assign('init_order_mail_add2', $categoryinfo['mail_add2']);

				$this->_smarty->assign('category_name', $categoryinfo['name_public']);

				break;
			}

// 注文完了メールを送信する

			$regist_code = $this->getAppRegistNumber();
			$this->_smarty->assign('regist_code', $regist_code);

			$this->_smarty->assign('app_id', $send['app_id']);
			$this->_smarty->assign('app_code', $send['app_code']);

			$name = $send['namef'] . ' ' . $send['nameg'];

			$this->_smarty->assign('post_dept', $send['dept']);
			$this->_smarty->assign('post_exam', $send['exam']);
			$this->_smarty->assign('post_name', $name);

			$this->_smarty->assign('post_payment', $send['payment']);
			$this->_smarty->assign('post_phonenumber', $send['phonenumber']);

			$this->_smarty->assign('post_app', $send['app']);

			$this->_smarty->assign('view_app_ic', $send['app_code']);
			$this->_smarty->assign('view_app_id', $send['app_id']);

//メールタイトル生成
			$title_mail = "お支払い手続きが完了しました";
			$this->_smarty->assign('title_mail', $title_mail);

			$this->_smarty->assign('post_namef', $send['namef']);
			$this->_smarty->assign('post_nameg', $send['nameg']);
			$this->_smarty->assign('auth_user_id', $send['user_id']);

//_app_addへの追加

			$adddata['add'] = 'payment_app';
			$adddata['user_id'] = $send['user_id'];

//CODEの作成

			$adic = self::generateUuid();
			$adddata['code'] = $adic;

			$this->_smarty->assign('adic', $adic);
			$this->_smarty->assign('user', 1);

			$cust_body = $this->_smarty->fetch('../user/customer_payment_app_mail.tpl');
			$cust_body = self::removeLineFeed($cust_body);

			$cust_subject = $title_mail;

			$adddata['memo'] = $cust_body;
			$adddata['subject'] = $cust_subject;
			$adddata['send'] = 1;
			$adddata['noreply'] = 1;
			$adddata['date'] = date('Y-m-d H:i:s');

			$this->set_postdata($adddata);
			$this->saveAppAdd();

			$replymail = "DO_NOT_REPLY@u-coop.or.jp";

			$arg = [];
			if ($send['email_sub']) {
				$arg['cc'] = setOrderDB::calcArrayCc($send['email_sub']);
			}

			$arg['univ_id'] = $send['univ_id'];
			$arg['user_id'] = $send['user_id'];
			$arg['add_code'] = $adddata['code'];

//自動返信メール送信
			$cust_body .= $this->_smarty->fetch('../user/customer_payment_app_mail_footer.tpl');
			self::send_mail($init_coopname, $replymail, $send['email'], $cust_subject, $cust_body, $arg);

			$this->_smarty->assign('view_app_id', $send['app_id']);

//生協側へメール送信

			$order_subject = '【決済完了】' . $regist_code;
			$order_body = $this->_smarty->fetch('../user/order_payment_app_mail.tpl');
			$order_body = self::removeLineFeed($order_body);

			self::send_mail($name, $replymail, $init_ordermail, $order_subject, $order_body);

			$this->_app = $send['app'];
			$this->setMessage($order_body);
			$this->throwAtSlack();

//ログのセット

			$logdata['process'] = 'card_success_payment_app';
			$logdata['username'] = $send['email'];
			$logdata['value'] = $_record['vResultCode'];
			$logdata['app_id'] = $this->_app_id;
			$this->set_postdata($logdata);
			$this->saveEntryLog();

		} else {

//charged_idが残っているかどうか判定

			if (isset($_appinfo['charged_id']) && $_appinfo['charged_id'] = '') {return;}

//appからcharged_id・api情報を削除

			$this->_user_id = $send['user_id'];
			$this->removeAppChargedId();

			$logdata['process'] = 'card_error_payment_app';
			$logdata['username'] = $send['email'];

			$logdata['result'] = 0;
			$logdata['app_id'] = $this->_app_id;
			$logdata['value'] = $_record['vResultCode'];
			$this->set_postdata($logdata);
			$this->saveEntryLog();

		}

	}

	private function recievedMpiVeritrans($_record, $_appinfo) {

		if ($_record['mpiMstatus'] == 'success' && $_record['cardMstatus'] == 'success') {
//決済OKなので、status→0に更新、受注メール送信

			$send = $this->change3DAppComplete($_appinfo);

			$_appinfo['status'] = $send['status'];
			$_appinfo['app_count'] = $send['app_count'];

			$_appinfo['regist_code'] = preg_replace("/0000$/", sprintf("%04d", intval($_appinfo['app_count'])), $_appinfo['regist_code']);

			$this->_smarty->addTemplateDir(ETC_DIR . APP_DIR . 'templates/' . $_appinfo['component']);

			$this->sendMailShopping($_appinfo);

			$logdata['kind'] = 'push_mpi_success_' . $_appinfo['component'];
			$logdata['username'] = 'webhook';
			$logdata['result'] = 1;
			$logdata['target_id'] = $_appinfo['id'];
			$this->setLogdata($logdata);
			$this->insertLog();

		} else {

//決済失敗なので、status→-9に更新、在庫戻す

			$this->returnStock($_appinfo);

// 本人認証エラーがあったら、入力のページを再度表示

			$logdata['kind'] = 'push_mpi_failure_' . $_appinfo['component'];
			$logdata['username'] = 'webhook';
			$logdata['result'] = 0;
			$logdata['target_id'] = $_appinfo['id'];
			$this->setLogdata($logdata);
			$this->insertLog();

		}

	}

	public function saveRecievedMpiVeritrans() {

		require_once 'Classes/veritrans.class.php';

		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			throw new Exception("invalid Access!!", 1);
		}

		$records = $this->recieveReportVeritrans();

		$this->_app_ids = [];
		$postdata = [];
		$postdata['amounts'] = [];
		$postdata['charged_id'] = [];
		$postdata['date_paid'] = [];
		$postdata['coop_code'] = [];

		foreach ($records as $key => $record) {

			if (!isset($record['orderId']) || !$record['orderId']) {continue;}

			try {

				$this->_pdo->query("SET innodb_lock_wait_timeout=60;");
				$this->_pdo->beginTransaction();

				$this->_app_charged_id = $record['orderId'];
				$this->_app_id = null;
				$this->_for_update = 1;
				$appinfo = $this->getAppInfo();

				if (!$appinfo['id']) {
					throw new Exception("No app_id", 1);
				}

//全旅クレカ決済判定
				if ($appinfo['payment'] != 5) {
					throw new Exception("No Veritrans", 1);
				}

//status判定
				switch (intval($appinfo['status'])) {
				case -1:
					$this->recievedMpiVeritrans($record, $appinfo);
					break;
				case 0:
				case 1:
// 代行入力〜ユーザーページからの支払は未開発
//					$this->recievedMpiVeritransUser($record, $appinfo);
					break;
				}

				$this->_pdo->commit();

			} catch (Exception $e) {
				$this->_pdo->rollBack();
			}

		} //foreach $records

	}

}
?>