<?php
require_once '../lib/set_path.php';

require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {

	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = array('welcome' => 1,
		'list_app' => 1,
		'edit_app' => 1,
		'show_app' => 1,
		'save_app' => 1,
		'delete_app' => 1,
		'list_category' => 1,
		'edit_category' => 1,
		'save_category' => 1,
		'delete_category' => 1,
		'delete_entry_all' => 1,
		'delete_all' => 1,
		'edit_excel' => 1,
		'export_excel' => 1,

		'edit_archived' => 1,
		'save_archived' => 1,

	);
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'list_category';
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
