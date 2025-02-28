<?php
require_once '../lib/set_path.php';

// Smartyオブジェクトの作成
require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {
	// 管理者モードをオンにする
	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = array(
		'welcome' => 1,
		'edit_subscribe_mail' => 1,
		'save_subscribe_mail' => 1,

		'edit_regist' => 1,
		'save_regist' => 1,

		'search_regist' => 1,

		'select_app_comedate' => 1,
		'select_app_cometime' => 1,

		'preview_form' => 1,
		'select_calendar_time' => 1,

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
