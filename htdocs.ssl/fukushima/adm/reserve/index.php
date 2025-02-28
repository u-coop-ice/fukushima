<?php
require_once '../lib/set_path.php';

// セッションを開始する
ini_set('session.use_only_cookies', 1);
session_start();

// ライブラリの組み込み

require_once 'initialize.php';
require_once 'admSmarty.php';

// URLクエリの変数化

if ($_SERVER['QUERY_STRING']) {
	$query = $_SERVER['QUERY_STRING'];
	$smarty->assign('query', $query);
}

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

		'show_calendar' => 1,
		'edit_calendar' => 1,
		'save_select_time' => 1,

		'edit_excel' => 1,
		'export_excel' => 1,
		'select_comedate' => 1,

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
		exit();
	}

}
?>
