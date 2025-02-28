<?php

define('SMARTY_RESOURCE_CHAR_SET', 'UTF-8'); // Smarty3ではテンプレートの文字コードを定義必須

$agent = Net_UserAgent_Mobile::singleton(); //UserAgent情報組み込み

if ($agent->isNonMobile()) {

	$career = 1;

	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($useragent, 'iPod') !== false || strpos($useragent, 'iPhone') !== false || strpos($useragent, 'Android') !== false || strpos($useragent, 'BlackBerry') !== false || strpos($useragent, 'iPad') !== false) {
		$career = 0;
	}

	if (defined('PART')) {

		class MySmarty extends Smarty {
			function __construct() {
				parent::__construct();

				$this->setTemplateDir(array(
					ETC_DIR . APP_DIR . 'templates/' . COMPONENT . '/' . PART
					, ETC_DIR . APP_DIR . 'templates/' . COMPONENT
					, ETC_DIR . APP_DIR . 'templates/' . COMPONENT . '/common'
					, ETC_DIR . APP_DIR . 'templates/common'
					, ETC_DIR . ADM_DIR . 'templates/union'));
				$this->setCompileDir('/var/cache/smarty/' . DOMAIN . '/' . APP_DIR . 'templates_c/' . COMPONENT);
				$this->setConfigDir(ETC_DIR . ADM_DIR . 'config');
				$this->addPluginsDir(ROOT_DIR . ADM_DIR . 'plugins'); // ユーザー定義のプラグインディレクトリ追加
			}
		}

	} else {

		class MySmarty extends Smarty {
			function __construct() {
				parent::__construct();

				$this->setTemplateDir(array(
					ETC_DIR . APP_DIR . 'templates/' . COMPONENT
					, ETC_DIR . APP_DIR . 'templates/' . COMPONENT . '/common'
					, ETC_DIR . APP_DIR . 'templates/common'
					, ETC_DIR . ADM_DIR . 'templates/union'));
				$this->setCompileDir('/var/cache/smarty/' . DOMAIN . '/' . APP_DIR . 'templates_c/' . COMPONENT);
				$this->setConfigDir(ETC_DIR . ADM_DIR . 'config');
				$this->addPluginsDir(ROOT_DIR . ADM_DIR . 'plugins'); // ユーザー定義のプラグインディレクトリ追加
			}
		}
	}

	$smarty = new MySmarty();

}

initialize();

// 登録ページのファイル名
$self = 'index.php';
$smarty->assign('self', $self);

// セッションの開始 Cookieを持てないDocomoブラウザ対応
if ($agent->isDocomo()) {
	ini_set('session.use_cookies', '0');
	ini_set('session.use_only_cookies', '0');
	HTTP_Session2::useCookies(false);
//			header('Content-Type: application/xhtml+xml');
	// session.use_trans_sidを有効にする必要がある。
	ini_set('session.use_trans_sid', '1');

	output_add_rewrite_var(session_name(), session_id());

} else {
	HTTP_Session2::useCookies(true);
}

// データベースに接続
$pdo = appAuthDB::initDB($dbuser_regist, $dbpass_regist, $dbhost, $database, $dbsocket);
if ($dbsocket_repl) {
	$pdo_repl = appAuthDB::initDB($dbuser_regist, $dbpass_regist, $dbhost, $database, $dbsocket_repl);
} else {
	$pdo_repl = $pdo;
}
$smarty->assign('pdo', $pdo);
$smarty->assign('pdo_repl', $pdo_repl);

$appauth = new appAuthDB;
$userAuth = $appauth->get_userAuth();
$component = $appauth->get_component();

if (CURRENT != 'app') {
	HTTP_Session2::set('category_code', '');
}

$smarty->assign('component', $component);
$smarty->assign('career', $career);

?>