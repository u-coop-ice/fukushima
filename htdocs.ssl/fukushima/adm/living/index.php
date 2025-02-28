<?php
require_once '../lib/set_path.php';
// セッションを開始する
ini_set('session.use_only_cookies', 1);
session_start();

// Smartyオブジェクトの作成
require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {

	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = array(
		'welcome' => 1,
		'show_config' => 1,
		'edit_config' => 1,
		'save_config' => 1,
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
