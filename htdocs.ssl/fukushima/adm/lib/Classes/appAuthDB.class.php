<?php
class appAuthDB extends commonDB {

	public function __construct() {
		parent::__construct();
		global $dbsocket, $database, $dbhost, $dbuser_regist, $dbpass_regist;
		$this->setConnectDB($dbuser_regist, $dbpass_regist, $dbhost, $database, $dbsocket);
	}
	public function __destruct() { /* デストラクタ */}

	use baseFunction;
	use baseUserAuth;
	use checkInitConfig;
	use execSignOut;
	use execRememberMe;
	use execLog;

	public function returnSigninJSON() {
		$json = [];
		$sid = session_id();

		if (!isset($_POST['step'])) {
			$json['msg'] = '不正なアクセスです。';
			return $json;
		}
		if (!isset($_POST['username'])) {
			$json['msg'] = '不正なアクセスです。';
			return $json;
		}

		$username = trim($_POST['username']);
		$this->_username = addslashes($username);

		$step = intval($_POST['step']);
		if ($step == 1) {
			if (!self::checkFormatEmail($this->_username)) {
				$json['msg'] = 'メールアドレスの形式が不正です。';
			} else {
				$json = $this->checkExistUser();
			}
		} else if ($step == 2) {

			$this->replaceRememberme();

			$logdata['kind'] = 'signin';
			$logdata['username'] = $this->_username;
			$logdata['result'] = $this->_userAuth->checkAuth();

			if (is_object($this->_smarty)) {
				$this->_msg = $this->_smarty->getTemplateVars('msg');
			}

			if ($logdata['result']) {
				setcookie('_signin', '', 0, '/' . COOP_DOMAIN . '/');
				setcookie('_signin', 1, time() + 10, '/' . COOP_DOMAIN . '/');
			}

			$this->setLogdata($logdata);
			$this->setLog();

			$json = [
				'msg' => $this->_msg,
				'uid' => $this->_userAuth->getAuthData('id'),
				'sid' => $sid,
				'signin' => $this->_userAuth->checkAuth(),
			];

		}
		return $json;
	}

	private function checkExistUser() {

		if ($this->_username) {

			$sql = <<< HERE

SELECT COUNT(`username`) as ct
FROM regist where `username` = :username and `status` = :status

HERE;

			try {
				$res = $this->_pdo_repl->prepare($sql);
				$res->execute([':username' => $this->_username, ':status' => 1]);
				$rd = $res->fetch();
			} catch (PDOException $e) {
				$errmsg = "データベースアクセスに失敗しました。";
			}
		} else {
			$errmsg = "メールアドレスを入力してください。";
		}

		$json = array('msg' => $errmsg, 'ct' => $rd['ct']);

		$logdata['kind'] = 'check_user';
		$logdata['username'] = $this->_username;
		$logdata['result'] = $rd['ct'];

		$this->setLogdata($logdata);
		$this->setLog();

		return $json;
	}

}
?>
