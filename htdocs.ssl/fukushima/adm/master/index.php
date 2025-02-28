<?php
require_once '../lib/set_path.php';

// Smartyオブジェクトの作成
require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {

	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = array('welcome' => 1,
		'list_user' => 1,
		'show_user' => 1,
		'edit_user' => 1,
		'save_user' => 1,
		'delete_user' => 1,
		'edit_password' => 1,
		'save_password' => 1,
		'validate_user' => 1,
		'validate_password' => 1,
		'edit_site_setting' => 1,
		'save_site_setting' => 1,
		'list_regist_log' => 1,
		'list_admin_log' => 1,
		'list_code' => 1,
		'save_code' => 1,
		'edit_code' => 1,
		'delete_code' => 1,
	);
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'welcome';
	}
	// モードに応じたページを表示
	if ($modes[$_GET['mode']]) {
		$smarty->assign('show_menu', 1);
		require_once 'admin/' . $_GET['mode'] . '.php';
	}
	// 存在しないモードを指定された場合はエラーを表示
	else {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'そのようなモードはありません。');
		$smarty->display('error.tpl');
	}
}
?>
