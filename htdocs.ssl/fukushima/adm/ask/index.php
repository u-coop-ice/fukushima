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

	$modes = array('welcome' => 1,
		'list_mail' => 1,
		'show_mail' => 1,
		'edit_mail' => 1,
		'update_mail' => 1,
		'save_mail' => 1,
		'show_config' => 1,
		'edit_config' => 1,
		'save_config' => 1,
		'list_category' => 1,
		'edit_category' => 1,
		'save_category' => 1,
		'delete_category' => 1,

	);
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'list_mail';
// ページ選択用のクエリの設定
		$_GET['noreply'] = [1, 2];
		$_GET['add'] = 'ask';
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
