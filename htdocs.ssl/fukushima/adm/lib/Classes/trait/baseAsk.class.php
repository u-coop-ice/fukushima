<?php
Trait baseAsk {

	public function get_ask_code() {
		return $this->_ask_code;
	}
	private function updateBaseAsk($_fields, $_fields_must) {

		$this->checkPostAskCode();

		$statusdata = $this->execSanitize($_fields, $_fields_must);

		$statusdata['code'] = $this->_ask_code;

		$this->set_postdata($statusdata);
		$this->set_tbl($this->_pfx . 'ask');
		$this->set_fields($_fields);
		$this->set_where(['code' => 'text']);
		$this->updateTable();

//ログの書き込み
		$this->_kind = "update_ask";
		$logdata['process'] = $this->_kind;
		$logdata['kind'] = $this->_kind;
		$logdata['component'] = COMPONENT;
		$logdata['app_id'] = null;
		$logdata['value'] = json_encode($statusdata);
		$logdata['username'] = $this->_auth->getUsername();
		$logdata['auth_username'] = $this->_auth->getUsername();
		$this->setLogdata($logdata);
		$this->insertLog();

	}

	public function saveBaseAsk() {

		if (isset($_POST['confirm']) || isset($_POST['reinput1']) || isset($_POST['submit'])) {

			$postdata = HTTP_Session2::get('postdata');

			if ($postdata['complete'] == 1) {
				self::return2First();
				exit();
			}

			if (isset($_POST['confirm'])) {
				$postdata = $this->execSanitize($this->_fields_ask, $this->_fields_ask);
				HTTP_Session2::set('postdata', $postdata);
			}
// 表示するページの選択
			if (count($this->_input_error)) {
// 登録内容にエラーがあったら、入力のページを再度表示
				$tmpl = 'step1.tpl';

			} else {

// 登録内容の確認の場合
				if ($_POST["confirm"]) {
					$tmpl = 'confirm.tpl';
				}
// 再入力の場合
				else if ($_POST['reinput1']) {
					$tmpl = 'step1.tpl';
				}
			}

			if (isset($_POST['submit'])) {

				try {
					$this->_pdo->beginTransaction();

//募集情報追加データ
					$fields = $this->_fields_ask;
					$fields['regist_id'] = 'integer';
					$postdata['regist_id'] = $this->_auth->getAuthdata('id');
					$fields['regist_date'] = 'text';
					$postdata['regist_date'] = date('Y-m-d H:i:s');

					$fields['code'] = 'text';
					$postdata['code'] = Text_Password::create(8, 'unpronounceable', 'alphanumeric');

					$this->set_postdata($postdata);
					$this->set_tbl($this->_pfx . 'ask');
					$this->set_fields($fields);

					$this->insertTable();

					$postdata['ask_id'] = $this->get_last_insertId();

					$infocode = $this->_smarty->getTemplateVars('infocode');
					$init_pagetitle = $this->_smarty->getTemplateVars('init_pagetitle');

					$init_ordermail = $this->_smarty->getTemplateVars('init_ordermail');
					if ($_SESSION['config']['component'][COMPONENT]['store_ordermail']) {
						$init_ordermail = $_SESSION['config']['component'][COMPONENT]['store_ordermail'];
					}

					$init_errormail = $this->_smarty->getTemplateVars('init_errormail');
					$init_coopname = $this->_smarty->getTemplateVars('init_coopname');

					$infocode = $infocode . '-ASK';

					$regist_code = $infocode . ":" . date("Ymd") . "-" . sprintf("%04d", $postdata['ask_id']); //受付番号の番号作成
					$this->_smarty->assign('regist_code', $regist_code);

					$postdata['name'] = $this->_auth->getAuthdata('name');
					$this->_smarty->assign('regist_name', $this->_auth->getAuthdata('name'));

					if ($postdata['name'] != $this->_auth->getAuthdata('cover')) {
						$postdata['name'] .= ' ' . $this->_auth->getAuthdata('cover');
					}

					$this->_smarty->assign('post', $postdata);

					$cust_body = $this->_smarty->fetch('customer_mail.tpl');
					$order_body = $this->_smarty->fetch('order_mail.tpl');
					$cust_subject = '【' . $init_pagetitle . '】お問い合わせを承りました';

					$replymail = "DO_NOT_REPLY@u-coop.or.jp";

					self::send_mail($init_coopname, $replymail, $this->_auth->getAuthdata('email'), $cust_subject, $cust_body);

					$order_subject = '【お問い合わせ】' . $postdata['title'] . '::' . $init_pagetitle;

					self::send_mail($postdata['name'], $this->_auth->getAuthdata('email'), $init_ordermail, $order_subject, $order_body);
// 登録完了ページを表示する

					$logdata['kind'] = 'ask';
					$logdata['username'] = $this->_auth->getUsername();
					$logdata['target_id'] = $postdata['ask_id'];

					$this->setLogdata($logdata);
					$this->setLog();

					$this->_pdo->commit();
					HTTP_Session2::set('postdata', $postdata);

					header("Location: $self?mode=complete");
					exit();

				} catch (Exception $e) {
					$this->_pdo->rollBack();
					throw new Exception("Database Error,Rollback!! " . $e->getMessage(), 1);
				}

			}

		} else {
			self::return2First();
		}
		$this->_smarty->assign('post', $postdata);
		$this->_smarty->display($tmpl);
		exit;

	}

}
?>
