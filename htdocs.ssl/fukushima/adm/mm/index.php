<?php
require_once '../lib/set_path.php';

require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {
	// 管理者モードをオンにする

	// モードの初期化
	$modes = array('welcome' => 1,
		'list_email' => 1,
		'save_email' => 1,
		'list_group' => 1,
		'edit_group' => 1,
		'save_group' => 1,
		'delete_group' => 1,
		'list_magazine' => 1,
		'show_magazine' => 1,
		'edit_magazine' => 1,
		'save_magazine' => 1,
		'delete_magazine' => 1,
		'delete_magazine_all' => 1,
		'delete_all_magazine' => 1,
	);
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'welcome';
	}

	// モードに応じたページを表示
	if ($modes[$_GET['mode']]) {
		$smarty->assign('mode', addslashes($_GET['mode']));
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
