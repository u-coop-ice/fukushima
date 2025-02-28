<?php

$config = parse_ini_file(ETC_DIR . 'adm/config/config.php', true);

$init_coopname = $config['init_coopname'];
$init_coopnameE = $config['init_coopnameE'];
$init_coopurl = $config['init_coopurl'];
$init_url = $config['init_url'];
$init_univname = $config['init_univname'];
$init_univurl = $config['init_univurl'];

define('UNIVNAME', $config['init_univname']);
define('UNIVURL', $config['init_univurl']);
define('COOPURL', $config['init_coopurl']);
define('COOPNAME', $config['init_coopname']);
define('COOPNAME_EN', $config['init_coopnameE']);
define('GOOGLE_CODE', $config['init_google_code']);
define('GOOGLE_CODE_M', $config['init_google_code_m']);
define('REQCOOP_CODE', $config['univ_id']);
define('HTTPS', $config['init_urls']);
define('HTTP', $config['init_urls']);

//キャリア別セッション取扱

// DeviceManagerクラス
require_once $rootpath . '../../php/DeviceManager.class.php';
$dm = new DeviceManager();
$career = $dm->getCareer();
$career2 = $dm->getCareer2();

// セッションの開始 Cookieを持てないDocomoブラウザ対応
if ($career2 == "docomo") {
	ini_set('session.use_cookies', '0');
	ini_set('session.use_only_cookies', '0');
// session.use_trans_sidを有効にする必要がある。
	ini_set('session.use_trans_sid', '1');

	output_add_rewrite_var(session_name(), session_id());

} else {
	ini_set('session.use_only_cookies', 1);
}

// セッションを開始する

session_start();

//DB接続とサインイン判定
require 'signin.php';

if ($is_login) {
	define('HTTP', $config['init_urls']);
} else {
	define('HTTP', $config['init_urls']);
}
//ページタイトル、パンくず、ページ上部警告設定読み込み
require 'title.php';

// 自前関数呼び出し
require_once 'mobile_image_retina.php';
require_once 'mobile_image_retina2.php';
require_once 'function.php';

require_once 'whatsnew_bootstrap.class.php';

//クッキーの読み出し スマフォでもPCサイトへ
if (isset($_COOKIE["switchUA"])) {

	$cookie_ua = $_COOKIE["switchUA"];
	if ($cookie_ua == "1") {
		$career = 1;
	}
}

if ($career == 1) {
	$charset = "UTF-8";
} else if ($career == 0) {
	$charset = "UTF-8";
} else {
// 自動変換処理

	mb_language("Japanese");
// ソース文字コード
	mb_internal_encoding("UTF-8");

// 出力文字コード
	mb_http_output("SJIS");
	header("Content-Type:text/html;charset=Shift_JIS");

//mb_output_handler で出力をフィルタリング
	ob_start("mb_output_handler");
	register_shutdown_function('ob_end_flush');

	$charset = "Shift_JIS";
	include 'mobile_xhtml_doctype.php';
	$doctype = mobile_xhtml_doctype();
}

include $rootpath . '/include/header.txt';

?>