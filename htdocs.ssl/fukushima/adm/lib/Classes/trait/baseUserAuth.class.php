<?php
trait baseUserAuth {

	public function get_userAuth() {
		$this->userAuth();
		$this->userStrictCheckAuth();

		return $this->_userAuth;
	}

	protected $_expire = 60 * 60 * 12;
	protected $_idle = 60 * 60 * 1;

	public function set_expire(int $_expire) {
		$this->_expire = $_expire;
	}
	public function set_idle(int $_idle) {
		$this->_idle = $_idle;
	}

	public function setConnectDB($_dbuser, $_dbpass, $_dbhost, $_database, $_dbsocket = null) {
		$this->_db['dbuser'] = $_dbuser;
		$this->_db['dbpass'] = $_dbpass;
		$this->_db['database'] = $_database;
		$this->_db['dbhost'] = $_dbhost;
		$this->_db['dbsocket'] = $_dbsocket;
	}

	private function userAuth() {
// ログイン処理
		if ($this->_db['dbsocket']) {
			$dsn = 'mysql:unix_socket=' . $this->_db['dbsocket'] . ';dbname=' . $this->_db['database'] . ';';
		} else {
			$dsn = 'mysql:host=' . $this->_db['dbhost'] . ';dbname=' . $this->_db['database'] . ';';
		}

		$crypt = "password_hash";
		$options = array(
			'dsn' => $dsn,
			'db_user' => $this->_db['dbuser'],
			'db_password' => $this->_db['dbpass'],
			'usernamecol' => 'username',
			'passwordcol' => 'password',
			'table' => $this->_pfx . "regist",
			'db_fields' => '*',
			'cryptType' => $crypt,
			'auto_quote' => false,
		);

		function loginFunction($user, $status, $auth) {
			global $smarty;

			switch ($status) {
			case AUTH_IDLED:
			case AUTH_EXPIRED:
				$msg = '期限切れです。再度サインインしてください。';
				break;
			case AUTH_WRONG_LOGIN:
				$msg = 'ユーザー名かパスワードが正しくありません。';
				break;
			}
			if (intval($_GET['signout']) == 1) {
				$msg = 'サインアウトしました。';
			}

			$query = '';
			if ((isset($_GET['mode']) || isset($_GET['cd'])) && intval($_GET['signout']) != 1) {
				$query .= $_SERVER['QUERY_STRING'];
			}

			if (is_object($smarty)) {
				$smarty->assign('msg', $msg);
				$smarty->assign('query', $query);
			}
		}

		$this->_userAuth = new Auth('PDO', $options, 'loginFunction');

		$this->_userAuth->setSessionName($this->_pfx . DOMAIN . '_site');

		$this->_userAuth->setExpire($this->_expire);
		$this->_userAuth->setIdle($this->_idle);
		if ($this->_userAuth->checkAuth() && intval($_GET['signout']) == 1) {

			// ログアウト
			$this->setSignOut($this->_userAuth, 'signout');
			header("Location: " . $_SERVER['PHP_SELF']);
			exit();

		}
		$this->_userAuth->start();

		$is_login = $this->_userAuth->getAuth();

		$this->forcedAdminSignout();

		$this->replaceRememberme();
		$this->checkRememberme();

		if (!$_SESSION[$this->_pfx . 'mode']) {

			if (isset($_POST['username']) && $_POST['username']) {

				$logdata['kind'] = 'signin';
				$logdata['username'] = addslashes(trim($_POST['username']));
				$logdata['result'] = 0;
				if ($this->_userAuth->getAuth()) {
					$logdata['result'] = 1;
					$logdata['username'] = $this->_userAuth->getUsername();
				}
				$this->setLogdata($logdata);
				$this->setLog();

				$this->_smarty->assign('post', $logdata);
			}

		}

		$this->setUserAuthData();

	}

	public function forcedAdminSignout() {

		if ($this->_userAuth->getAuth()) {

			if ($_SESSION['admin_mode']) {
				unset($_SESSION['_auth_' . DOMAIN . '_adm']);
				unset($_SESSION['admin_mode']);
				session_regenerate_id();
			}
		}

	}

	private function userStrictCheckAuth() {

		if ($this->_userAuth->getAuth()) {

//アカウント変更時のデバイス間差違チェック

			$sql = <<< HERE
SELECT `id` FROM {$this->_pfx}regist WHERE `username` = ?
AND `status`=1
HERE;

			$data = array($this->_userAuth->getUsername());

			try {
				$res = $this->_pdo->prepare($sql);
				$res->execute($data);

			} catch (PDOException $e) {
//強制サインアウト処理
				$this->setSignOut($this->_userAuth, 'forced_signout');
				header("Location: " . $init_urls);
				exit();
			}
			$rt = $res->fetch();

			if (!$rt['id']) {
//強制サインアウト処理
				$this->setSignOut($this->_userAuth, 'forced_signout');
				header("Location: " . $init_url);
				exit();
			}

		}

		if ($this->_userAuth->checkAuth() && !$this->_userAuth->getAuthData('id')) {

			$this->setSignOut($this->_userAuth, 'forced_signout');
			header("Location: " . $init_url);
			exit();

		}

	}

	private function setUserAuthData() {

		global $is_login, $auth_username, $msg, $send_error;

		$is_login = $this->_userAuth->getAuth();
		$send_error = $this->_userAuth->getAuthData('send_error');

		$this->_smarty->assign('login', $this->_userAuth->getAuth());

		if ($this->_userAuth->getAuth()) {
			// ログインしていれば、ユーザーの情報をSmartyの変数に設定する
			$auth_id = $this->_userAuth->getAuthData('id');
			$this->_smarty->assign('auth_' . $this->_pfx . 'id', $this->_userAuth->getAuthData('id'));

			$auth_username = $this->_userAuth->getUsername();
			$this->_smarty->assign('auth_username', $username);

			$auth_email = $this->_userAuth->getAuthData('email');
			$this->_smarty->assign('auth_email', $auth_email);

			$auth_year = $this->_userAuth->getAuthData('year');
			$this->_smarty->assign('auth_year', $auth_year);

			$auth_name = $this->_userAuth->getAuthData("name");
			$auth_cover = $this->_userAuth->getAuthData("cover");

			$this->setSmartyUserData();
			$_SESSION[$this->_pfx . 'mode'] = 1;
		}
	}

	private function setSmartyUserData() {

		$registdata = $this->_userAuth->getAuthData();

		$registdata['username'] = $this->_userAuth->getUsername();
//電話番号変換
		//		$fields = ['telephone', 'fax', ''];
		foreach ($this->_fields_phonenumber as $field) {

			if ($registdata[$field]) {
				$tmp = self::explodePhonenumber($registdata[$field], $field);
				if (is_array($tmp)) {
					$registdata = array_merge($registdata, $tmp);
				}
			}
		}

		if ($registdata['membership']) {
			$registdata['membership1'] = substr($registdata['membership'], 0, 4);
			$registdata['membership2'] = substr($registdata['membership'], 4, 4);
			$registdata['membership3'] = substr($registdata['membership'], 8, 4);
		}

		if ($registdata['birthday']) {
			$registdata['birth_year'] = substr($registdata['birthday'], 0, 4);
			$registdata['birth_month'] = intval(substr($registdata['birthday'], 4, 2));
			$registdata['birth_day'] = intval(substr($registdata['birthday'], 6, 2));
		}

		$this->_smarty->assign('regist', $registdata);

	}

	public function get_component() {

		$this->selectInitConfig();

		$component = $_SESSION['config']['component'];

		$this->_smarty->assign('infocode', $component[COMPONENT]['infocode']);

		$this->_smarty->assign('init_pagetitle', $component[COMPONENT]['title']);

		if (CURRENT == "cmp") {
			$this->_smarty->assign('init_pagetitle', $component[COMPONENT]['title'] . '情報管理');
		}

		$this->_smarty->assign('component', $component);

		$this->_smarty->assign('init_ordermail', $_SESSION['config']['email']);

		$this->_smarty->assign('init_errormail', $_SESSION['config']['error_email']);
		if ($component[COMPONENT]['store_ordermail']) {
			$this->_smarty->assign('init_ordermail', $component[COMPONENT]['store_ordermail']);
		}

		return $component;
	}

}
?>
