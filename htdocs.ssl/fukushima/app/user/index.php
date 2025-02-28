<?php
require_once '../../adm/lib/set_path.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

/*
if ($_SERVER['HTTPS'] != "on") {
$smarty->assign('page_title', 'エラー');
$smarty->assign('errmsg', '不正なアクセスです。');
$smarty->display('error.tpl');
exit();
}
 */

$userdata = HTTP_Session2::get('userdata');

if ($userAuth->checkAuth()) {

	// モードの初期化
	$modes = array(
		'show_regist' => 1,
		'edit_regist' => 1,
		'save_regist' => 1,
		'list_app' => 1,
		'list_mail' => 1,
		'cancel_app' => 1,
		'show_app' => 1,
		'show_mail' => 1,
		'show_order' => 1,
		'show_reserve' => 1,
		'edit_email' => 1,
		'save_email' => 1,
		'change_email' => 1,
		'edit_mail' => 1,
		'save_mail' => 1,
		'edit_password' => 1,
		'save_password' => 1,
		'edit_pass' => 1,
		'save_pass' => 1,
		'remove_account' => 1,
		'remove_username' => 1,
		'change_reserve' => 1,
		'confirm_change_reserve' => 1,
		'cancel_reserve' => 1,
		'confirm_cancel_reserve' => 1,
		'return_reserve' => 1,
		'confirm_return_reserve' => 1,
		'welcome' => 1,
		'membership' => 1,
		'unsubscribe_mail' => 1,
		'edit_subscribe_mail' => 1,
		'save_subscribe_mail' => 1,
		'edit_creditcard' => 1,
		'save_creditcard' => 1,
		'delete_creditcard' => 1,

		'delete_creditcard_veritrans' => 1,
		'save_creditcard_veritrans' => 1,
	);

// URLでモードが設定されていなければ、「step1」のモードにする

	$smarty->assign("complete", 1);

	if (!isset($_GET['mode'])) {
// セッション初期化
		$userdata = array();
		HTTP_Session2::set('userdata', $userdata);

		$_GET['mode'] = 'welcome';
		$smarty->assign('mode', 'welcome');
	}

	// モードに応じたページを表示
	if ($modes[$_GET['mode']]) {
//        $smarty->assign('show_menu', 1);

		$smarty->assign('mode', htmlspecialchars($_GET['mode'], 3, 'UTF-8'));

		$confirmList = array(
			'edit_regist' => 1,
			'edit_password' => 1,
			'edit_mail' => 1,
			'remove_account' => 1,
		);
		$smarty->assign('confirmList', $confirmList);

		require_once 'user/' . $_GET['mode'] . '.php';

	}

	// 存在しないモードを指定された場合はエラーを表示
	else {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'そのようなモードはありません。');
		$smarty->display('error.tpl');
		exit();
	}

} else {

	if ($mode == "change_email") {
		$smarty->assign('alertmsg', 'メールアドレス（サインイン用ユーザー名）の変更は完了していません。変更前のメールアドレスをユーザー名欄に入力してください。');
	}

//	$smarty->assign('query', $url_query);

	// モードの初期化
	$modes = array(
		'membership' => 1,
		'change_email' => 1,
	);

	if ($modes[$_GET['mode']]) {
		$smarty->assign('mode', htmlspecialchars($_GET['mode'], 3, 'UTF-8'));
		require_once 'user/' . $_GET['mode'] . '.php';
	} else {

		$smarty->display('login.tpl');
		exit();

	}

}

?>
