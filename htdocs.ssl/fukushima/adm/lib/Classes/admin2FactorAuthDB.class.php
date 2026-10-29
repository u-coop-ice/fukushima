<?php
require_once ROOT_DIR . ADM_DIR . 'lib/composer/vendor/autoload.php';

class admin2FactorAuthDB extends commonDB {

	use baseFunction;
	use execAdminLog;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() { /* デストラクタ */}

	private $_secret    = null;
	private $_inputdata = [];

	const _AUTH_TITLE = "管理";
	const _TERM_FAIL  = 10; // 分間にサインイン失敗;
	const _TIMES_FAIL = 10; // サインイン失敗回数;

	public function check2FactorAuth() {

		$this->_inputdata['username'] = '';
		$this->_inputdata['password'] = '';

		if (isset($_REQUEST['user_name'])) {
			$this->_inputdata['username'] = addslashes($_REQUEST['user_name']);
		}
		if (isset($_REQUEST['password'])) {
			$this->_inputdata['password'] = addslashes($_REQUEST['password']);
		}

		if (!$this->_inputdata['username']) {
			throw new Exception("管理ユーザーが入力されていません", 1);
		}
		if (!$this->_inputdata['password']) {
			throw new Exception("パスワードが入力されていません", 1);
		}

		$this->_ga = new PHPGangsta_GoogleAuthenticator();

		if (isset($_POST["onecode"]) && isset($_POST["onecode"]) != "") {

			return $this->validate1timeCode();

		} else {
			return $this->getAdminSecret();
		}

	}

	private function getAdminSecret() {
		global $init_coopname;

		$_SESSION["secret_2factor"] = '';
		$_SESSION["secret_pfx2"] = '';

		$sql = <<< HERE
SELECT `username`,`password`,`secret`,`locked` FROM `init_user` WHERE `username` = :username

HERE;

		try {
			$res = $this->_pdo_repl->prepare($sql);
			$res->bindParam(':username', $this->_inputdata['username'], PDO::PARAM_STR);
			$res->execute();
			$authdata = $res->fetch();
		} catch (PDOException $e) {
			throw new Exception("DB接続エラー" . $e->getMessage(), 1);
		}

//validate
		if (!is_array($authdata)) {

			$logdata = [
				'username' => $this->_inputdata['username'],
				'process' => 'signin',
				'memo' => 'no account',
				'result' => 0,
			];

			$this->set_postdata($logdata);
			$this->saveAdminLog();

			throw new Exception("管理ユーザーの設定が不正です", 1);
		} else if (!$authdata['password']) {

			$logdata = [
				'username' => $this->_inputdata['username'],
				'process' => 'signin',
				'memo' => 'no password',
				'result' => 0,
			];

			$this->set_postdata($logdata);
			$this->saveAdminLog();

			throw new Exception("管理ユーザーの設定が不正です", 1);
		}

		if ($authdata['locked'] == 1) {
			$logdata = [
				'username' => $this->_inputdata['username'],
				'process' => 'signin',
				'memo' => 'locked',
				'result' => 0,
			];

			$this->set_postdata($logdata);
			$this->saveAdminLog();

			throw new Exception("この管理ユーザーは無効化されています", 1);
		}

		if (!password_verify($this->_inputdata['password'], $authdata['password'])) {

			$locked = $this->setAdminUserLocked();

			if ($locked) {
				$logdata = [
					'username' => $this->_inputdata['username'],
					'process' => 'signin',
					'memo' => 'locked',
					'result' => 0,
				];
				$this->set_postdata($logdata);
				$this->saveAdminLog();

				throw new Exception("この管理ユーザーは無効化されました", 1);
			}

			$logdata = [
				'username' => $this->_inputdata['username'],
				'process' => 'signin',
				'memo' => 'invalid',
				'result' => 0,
			];
			$this->set_postdata($logdata);
			$this->saveAdminLog();

			throw new Exception("管理ユーザー名とパスワードの組み合わせが違います", 1);
		}

		if ($authdata['secret'] == "") {
			$secret = $this->_ga->createSecret();
			$_SESSION["secret_2factor"] = $secret;
			$qrCodeUrl = $this->_ga->getQRCodeGoogleUrl($init_coopname . self::_AUTH_TITLE . ': ' . $this->_inputdata['username'], $secret);
			$authdata['qrcodeurl'] = $qrCodeUrl;
			$authdata['new_secret'] = $secret;
		} else {
			$_SESSION["secret_2factor"] = $authdata['secret'];
		}

// QRコードのURLを生成する

		return $authdata;

	}

	private function setAdminUserLocked() {

		$times = 0;
		$locked = 0;

		$sql = <<< HERE
SELECT COUNT(id) FROM admin_log WHERE `process` = "signin"

AND `value` = 'invalid'
AND `auth_username` = :username

HERE;

		$sql .= " AND `date` + INTERVAL " . self::_TERM_FAIL . " MINUTE > NOW()";
		$sql .= " HAVING COUNT(`id`) + 1 >= " . self::_TIMES_FAIL;

		try {
			$res = $this->_pdo_repl->prepare($sql);
			$res->bindParam(':username', $this->_inputdata['username'], PDO::PARAM_STR);
			$res->execute();
			$times = $res->fetchColumn();
		} catch (PDOException $e) {
			throw new Exception("DB接続エラー" . $e->getMessage(), 1);
		}

		if ($times) {

			$this->_postdata = [];
			$this->_postdata['username'] = $this->_inputdata['username'];
			$this->_postdata['locked'] = 1;

			$this->_where = ['username' => 'text'];
			$this->_fields = ['locked' => 'integer'];
			$this->_tbl = 'init_user';
			$this->updateTable();
			$locked = 1;
		}

		return $locked;

	}

	private function validate1timeCode() {
		$checkResult = false;
		$is_valid = false;
		$onecode = "";

		$onecode = $_POST["onecode"];

		if (!isset($_SESSION['secret_2factor']) || !$_SESSION['secret_2factor']) {
			throw new Exception("不正なアクセスです", 1);
		}

		if (!preg_match('/\d{6}/', $onecode)) {
			throw new Exception("認証コードが不正です", 1);
		}
		$is_valid = true;

		$checkResult = $this->_ga->verifyCode($_SESSION['secret_2factor'], $onecode, 2); // 2 = 2*30sec clock tolerance

		if (!$checkResult) {

			$logdata = [
				'auth_username' => $this->_inputdata['username'],
				'process' => 'onetimecode',
				'memo' => 'invalid',
				'result' => 0,
			];

			$this->set_postdata($logdata);
			$this->saveAdminLog();

			throw new Exception("認証に失敗しました", 1);
		} else {

			if (isset($_POST['new']) && $_POST['new'] == 1) {
// init_userのupdate

				$sql = <<< HERE
UPDATE init_user SET `secret`=:secret WHERE `username` = :username

HERE;

				try {
					$res = $this->_pdo->prepare($sql);
					$res->bindParam(':username', $this->_inputdata['username'], PDO::PARAM_STR);
					$res->bindParam(':secret', $_SESSION['secret_2factor'], PDO::PARAM_STR);
					$res->execute();
				} catch (PDOException $e) {
					throw new Exception("DB接続エラー", 1);
				}

			}

			$logdata = [
				'auth_username' => $this->_inputdata['username'],
				'process' => 'onetimecode',
				'memo' => 'valid',
				'result' => 1,
			];

			$this->set_postdata($logdata);
			$this->saveAdminLog();

		}
		$result = $this->_inputdata;
		$result['valid'] = $checkResult;
		return $result;
	}

}
?>