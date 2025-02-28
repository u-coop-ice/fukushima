<?php
define('SMARTY_RESOURCE_CHAR_SET', 'UTF-8');
class AdmSmarty extends Smarty {
	function __construct() {
		parent::__construct();

		if (defined('PART')) {
			$this->setTemplateDir(ETC_DIR . ADM_DIR . 'templates/' . COMPONENT . '/' . PART);
			$this->addTemplateDir(array(ETC_DIR . ADM_DIR . 'templates/' . COMPONENT, ETC_DIR . ADM_DIR . 'templates/common', ETC_DIR . ADM_DIR . 'templates/union'));
		} else {

			$this->setTemplateDir(array(ETC_DIR . ADM_DIR . 'templates/' . COMPONENT, ETC_DIR . ADM_DIR . 'templates/common', ETC_DIR . ADM_DIR . 'templates/union'));
		}

		$this->setCompileDir('/var/cache/smarty/' . DOMAIN . '/' . ADM_DIR . 'templates_c/' . COMPONENT);
		$this->setConfigDir(ETC_DIR . ADM_DIR . 'config');
		$this->addPluginsDir(ROOT_DIR . ADM_DIR . 'plugins'); // ユーザー定義のプラグインディレクトリ追加
	}
}

$smarty = new AdmSmarty();

initialize();

// 管理ページのファイル名
$self = 'index.php';
$smarty->assign('self', $self);

// ログインフォームの表示用関数
function loginFunction($user, $status, $auth) {
	global $smarty;

	switch ($status) {
	case AUTH_IDLED:
	case AUTH_EXPIRED:
		$smarty->assign('msg', '期限切れです。再度サインインしてください。');
		break;
	case AUTH_WRONG_LOGIN:
		$smarty->assign('msg', 'ユーザー名かパスワードが正しくありません。');
		break;
	}
	if ($_GET['mode'] == 'logout') {
		$smarty->assign('msg', 'サインアウトしました。');
	}
	$query = '';
	if (isset($_GET['mode']) && $_GET['mode'] != 'logout') {
		$query .= '?' . $_SERVER['QUERY_STRING'];
	}
	$smarty->assign('query', $query);
	$smarty->display('login.tpl');
	exit();
}

// ログイン処理
if ($dbsocket) {
	$dsn = 'mysql:unix_socket=' . $dbsocket . ';dbname=' . $database . ';';
} else {
	$dsn = 'mysql:host=' . $dbhost . ';dbname=' . $database . ';';
}

$options = array(
	'dsn' => $dsn,
	'db_user' => $dbuser,
	'db_password' => $dbpass,
	'usernamecol' => 'username',
	'passwordcol' => 'password',
	'table' => "init_user",
	'db_fields' => '*',
	'cryptType' => 'password_hash',
	'auto_quote' => false,
);

$auth = new Auth('PDO', $options, 'loginFunction');

$auth->setSessionName(DOMAIN . '_adm');

$auth->setExpire(time() + 60 * 60);
$auth->setIdle(time() + 60 * 20);
if ($auth->checkAuth() && $_GET['mode'] == 'logout') {
	// ログアウト
	$auth->logout();
	// 管理者モードをオフにする
	$_SESSION['admin_mode'] = 0;
	$_SESSION['config'] = null;
}
$auth->start();

// データベースに接続
$pdo = adminConfigDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket);
if ($dbsocket_repl) {
	$pdo_repl = adminConfigDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket_repl);
} else if ($dbhost_repl) {
	$pdo_repl = adminConfigDB::initDB($dbuser, $dbpass, $dbhost_repl, $database, $dbsocket);
} else {
	$pdo_repl = $pdo;
}
$smarty->assign('pdo', $pdo);
$smarty->assign('pdo_repl', $pdo_repl);

if ($auth->getAuth()) {

//初回サインインの際はトップに戻す。
	if ($_SESSION['admin_mode'] == 0) {
		$_SESSION['admin_mode'] = 1;
		header("Location:$self");
		exit();
	}

	if (is_array($_SESSION['_auth_' . DOMAIN . '_site'])) {
		unset($_SESSION['_auth_' . DOMAIN . '_site']);
		unset($_SESSION['mode']);
		setcookie('_rmbm', $rememberme, 0, '/');
	}

	$smarty->assign('login', 1);
	// 管理者モードをオンにする
	$_SESSION['admin_mode'] = 1;

	// 管理者権限及び初期設定変数取得

	require_once 'init_config.php';

	$auth_username = $auth->getUsername();
	$auth_usermail = $auth->getAuthData("email");
	$auth_user_id = $auth->getAuthData("id");
	$auth_user_id = intval($auth_user_id);
	$smarty->assign('auth_usermail', $auth_usermail);

}

?>