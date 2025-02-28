<?php
class adminAskDB extends commonDB {

	use adminAuth;
	use checkRegist;
	use checkApp;
	use checkAppAdd;
	use execAskCategories;
	use checkEntryCategories;
	use execShoppingCategories;
	use baseFunction;
	use baseSendmail;
	use baseApp;
	use execConfig;
	use execAppAdd;
	use execAdminLog;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	public function showAppAdd() {

		if (!$this->_add_id) {
			throw new Exception("Error no add_id.", 1);
		}

		$addinfo = $this->getAppAddInfo();

		if ($addinfo["root_id"]) {
			$this->_smarty->assign('view_root_id', $addinfo["root_id"]);
		} else {
			$this->_smarty->assign('view_root_id', $this->_add_id);
		}

//既読フラグの更新
		if ($addinfo["recieve"] && !$addinfo["read"]) {

			$readdata = ['id' => $this->_add_id, 'read' => 1];
			$this->_where = ['id' => 'integer'];
			$this->set_fields(['read' => 'integer']);
			$this->set_postdata($readdata);
			$this->set_tbl('app_add');

			$this->updateTable();

			$logdata['process'] = 'show_add';
			$logdata['value'] = $this->_add_id;

			$this->set_postdata($logdata);
			$this->saveAdminLog();

		}

	}

	public function sendAppAdd() {
		global $init_coopname;
		if (!isset($_POST['test']) && !isset($_POST['send'])) {
			throw new Exception("Error Invalid Access", 1);
		}

		$result = [];
		$opt_test = intval($_POST['test']);

		$maildata['app_id'] = intval($_POST['app_id']);
		$maildata['add_id'] = intval($_POST['add_id']);
		$maildata['regist_id'] = intval($_POST['regist_id']);
		$maildata['root_id'] = intval($_POST['root_id']);
		$maildata['noreply'] = intval($_POST['noreply']);

		$this->_smarty->assign('noreply', $maildata['noreply']);

//		$regist_status = intval($_POST['regist_status']);

		$maildata['subject'] = htmlspecialchars(trim($_POST['mail_subject']), 3, 'UTF-8');
		$maildata['memo'] = htmlspecialchars(trim($_POST['mail_body']), 3, 'UTF-8');
		$maildata['cover'] = htmlspecialchars(trim($_POST['cover']), 3, 'UTF-8');
		$maildata['send'] = 1;
		$maildata['add'] = 'mail';

		if ($maildata['root_id']) {
			$this->set_add_id($maildata['root_id']);
		} else if ($maildata['add_id']) {
			$this->set_add_id($maildata['add_id']);
			$maildata['root_id'] = $maildata['add_id'];
		}

		if ($maildata['regist_id']) {
			$this->set_regist_id($maildata['regist_id']);
		}

		if ($this->_add_id) {
			$addinfo = $this->getAppAddInfo();
			$maildata['add'] = $addinfo['add'];
			if ($maildata['app_id']) {
				if ($addinfo['component']) {
					$maildata['component'] = $addinfo['component'];
					if ($addinfo['part']) {
						$maildata['part'] = $addinfo['part'];
					}
				}
			}

			if ($addinfo['category_id']) {
				$maildata['category_id'] = $addinfo['category_id'];
			}

			$this->set_regist_id($addinfo['regist_id']);
		} else {
			$maildata['add'] = 'mail';
			if (!$maildata['regist_id']) {
				throw new Exception("Error No Regist", 1);
			}
			$this->set_regist_id($maildata['regist_id']);
		}

		$registinfo = $this->getRegistInfo();

		if ($registinfo['status'] != 1) {
			throw new Exception("Error No Regist", 1);
		}

		$this->_smarty->assign('regist_status', $registinfo['status']);

		if ($opt_test == 0) {

//CODEの作成
			$adic = self::generateUuid();
			$maildata['code'] = $adic;
			$this->_smarty->assign('adic', $adic);

//送信前にフッターを追加しない
			//			$maildata['memo'] .= $this->_smarty->fetch('mail_footer.tpl');
			$maildata['admin_user_id'] = $this->_adminAuth->getAuthData('id');

			$this->set_postdata($maildata);
			$this->saveAppAdd();

			$result['add_id'] = $this->_add_id;

//スレッド更新

			if ($maildata['root_id']) {

				$adddata['noreply'] = 2;
				if ($maildata['noreply']) {
					$adddata['noreply'] = $maildata['noreply'];
				}

				$adddata['id'] = $maildata['root_id'];
				$adddata['root_id'] = $maildata['root_id'];

				$this->set_postdata([
					':noreply' => $adddata['noreply'],
					':root_id' => $adddata['root_id'],
					':id' => $this->_add_id,

				]);

				$this->updateAddNoreply();

			}

			$logdata['process'] = 'send_add';
			$logdata['value'] = json_encode($maildata);

			$this->set_postdata($logdata);
			$this->saveAdminLog();

		} else {
//			$maildata['memo'] .= $this->_smarty->fetch('mail_footer.tpl');
		}

		$init_ordermail = $_SESSION['config']['email'];
		$replymail = $_SESSION['config']['donotreply_email'];
		$subject = $maildata['subject'];

		if ($opt_test == 1) {
			$result['test'] = 1;
			$subject = '【テスト】' . $maildata['subject'];

			if ($this->_adminAuth->getAuthData('email')) {
				$email = $this->_adminAuth->getAuthData('email');
			} else {
				$email = $init_ordermail;
			}
		} else {
			$email = $registinfo['email'];
			$result['send'] = 1;
			$arg = [];
			$arg['admin_user_id'] = $this->_adminAuth->getAuthData('id');
			$arg['component'] = COMPONENT;
			if ($maildata['component']) {
				$arg['component'] = $maildata['component'];
				if ($maildata['part']) {
					$arg['part'] = $maildata['part'];
				}
			}
			$arg['regist_id'] = $registinfo['id'];
			$arg['add_code'] = $adic;
			$arg['univ_id'] = $_SESSION['config']['univ_id'];
		}

		$maildata['memo'] .= $this->_smarty->fetch('mail_footer.tpl');

		$maildata['memo'] = htmlspecialchars_decode($maildata['memo']);

		self::send_mail($init_coopname, $replymail, $email, $subject, $maildata['memo'], $arg);

		if ($opt_test == 0) {

			$maildata['memo'] = "【管理システムからユーザーへ送信した内容のコピーです。】\n\n" . $maildata['memo'];

			$admarg['cc'] = $this->_adminAuth->getAuthData('email');

			self::send_mail($init_coopname, $replymail, $init_ordermail, "(コピー)" . $subject, $maildata['memo'], $admarg);
		}

		return $result;
	}

	public function updateAppAdd() {

		if (!$this->_add_id) {
			throw new Exception("Error no add_id.", 1);
		}

		$addinfo = $this->getAppAddInfo();

		$fields_sql_add = [
			'treat' => 'text',
			'noreply' => 'integer',
		];

		$adddata = $this->execSanitize($fields_sql_add, []);

		$adddata['date_treat'] = date('Y-m-d H:i:s');
		$fields_sql_add['date_treat'] = 'text';

		$adddata['id'] = $this->_add_id;
		if (!$addinfo['root_id']) {
			$adddata['root_id'] = $this->_add_id;
			$adddata['id'] = $this->_add_id;
		} else {
			$adddata['id'] = $addinfo['root_id'];
			$adddata['root_id'] = $addinfo['root_id'];
		}

		$this->set_fields($fields_sql_add);
		$this->set_postdata($adddata);
		$this->set_where(['id' => 'integer']);
		$this->set_tbl('app_add');

		$this->updateTable();

		$this->set_postdata([
			':noreply' => $adddata['noreply'],
			':root_id' => $adddata['root_id'],
			':id' => $this->_add_id,

		]);
		$this->updateAddNoreply();

		$logdata['process'] = 'save_add_noreply';
		$logdata['value'] = $this->_add_id;

		$this->set_postdata($logdata);
		$this->saveAdminLog();

	}

}
