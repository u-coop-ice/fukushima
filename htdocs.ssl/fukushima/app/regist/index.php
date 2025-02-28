<?php
require_once '../../adm/lib/set_path.php';

require_once 'initialize.php';

// Smartyオブジェクトの作成
require_once 'userSmarty.php';

if ($userAuth->getAuth()) {
	appCreateRegistDB::return2First();
	exit;
}

$smarty->assign('post', array());

/*
if ($_SERVER['HTTPS'] != "on") {
$smarty->assign('page_title', 'エラー');
$smarty->assign('errmsg', '不正なアクセスです。');
$smarty->display('error.tpl');
exit();
}
 */

$postdata = HTTP_Session2::get('postdata');

//生協の設定取得
/*
$cp = new entryDB();
$cp->set_domain(COOP_DOMAIN);
$initdata = $cp->getCoopInfo();

$tmp = reset($initdata);
$auth1 = $tmp['travel']['auth'];
 */

// モードの初期化
$modes = array('welcome' => 1,
	'step1' => 1,
	'step2' => 1,
	'confirm' => 1,
	'regist' => 1,
	'confirm_end' => 1,
	'regist_end' => 1,
	'complete' => 1,
	'complete_end' => 1,
	'remind' => 1,
	'remind_email' => 1,
	'complete_remind' => 1,
	'complete_remind_end' => 1,
	'change_password' => 1,
	'confirm_password' => 1,
);
// URLでモードが設定されていなければ、「input」のモードにする
if (!isset($_GET['mode'])) {
// セッション初期化
	$postdata = [];
	HTTP_Session2::set('postdata', $postdata);

	$refferdata = [];
	if (HTTP_Session2::get('refferdata')) {
		$refferdata = HTTP_Session2::get('refferdata');
	}
	if (isset($_GET['reffer'])) {

		$reffer = addslashes($_GET['reffer']);
		if ($refferdata['reffer'] != $reffer) {
			$refferdata = [];
			$refferdata["reffer"] = $reffer;
		}

		if (isset($_GET['part'])) {
			$refferdata["part"] = addslashes($_GET['part']);
		}
		if (isset($_GET['md'])) {
			$refferdata["md"] = addslashes($_GET['md']);
		}
		if (isset($_GET['cd'])) {
			$refferdata["cd"] = addslashes($_GET['cd']);
		}
		HTTP_Session2::set('refferdata', $refferdata);

	}

	$_GET['mode'] = 'step1';
}
$mode = htmlspecialchars($_GET['mode'], 3, 'UTF-8');
$smarty->assign('mode', $mode);

if ($mode == "step2" || $mode == "confirm_end") {
	$methods['name']['use'] = 2;
//	$methods['dept']['use'] = 1;
	//	$methods['address']['use'] = 2;
	//	$methods['new_add']['use'] = 2;
	//	$methods['student_phone']['use'] = 2;
	//	$methods['phonenumber']['use'] = 2;
	//	$methods['membership']['use'] = 1;

	$smarty->assign('methods', $methods);
}

$stepsFile[COMPONENT] = array(
	'step1' => 'regist',
	'step2' => 'regist',
	'confirm' => 'regist',
	'regist' => 'regist',
	'confirm_end' => 'regist',
	'regist_end' => 'regist',
	'complete' => 'regist',
	'complete_end' => 'regist',
	'remind' => 'remind',
	'remind_email' => 'remind',
	'validate_password' => 'remind',
	'change_password' => 'remind',
	'confirm_password' => 'remind',
);
$smarty->assign('stepsFile', $stepsFile);

// モードに応じたページを表示
if ($modes[$_GET['mode']]) {
	$smarty->assign('show_menu', 1);
	require_once 'regist/' . $_GET['mode'] . '.php';
}
// 存在しないモードを指定された場合はエラーを表示
else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'そのようなモードはありません。');
	$smarty->display('error.tpl');
}
?>
