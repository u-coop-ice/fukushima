<?php
require_once '../lib/set_path.php';

require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {

	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = ['welcome' => 1,
		'list_app' => 1,
		'edit_app' => 7,
		'show_app' => 7,
		'save_app' => 7,
		'delete_app' => 7,
		'list_category' => 1,
		'edit_category' => 7,
		'save_category' => 7,
		'delete_category' => 7,
		'delete_entry_all' => 7,
		'delete_all' => 7,
		'edit_excel' => 7,
		'export_excel' => 7,

		'edit_archived' => 7,
		'save_archived' => 7,

		'create_entry_stock_multi_table' => 1,

	];
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'list_category';
	}
	// モードに応じたページを表示
	if (isset($modes[$_GET['mode']]) && $modes[$_GET['mode']]) {

		$authority = $smarty->getTemplateVars('authority');

		if ($authority[COMPONENT][0] >= $modes[$_GET['mode']]) {

			$smarty->assign('show_menu', 1);
			require_once 'admin/' . $_GET['mode'] . '.php';

		} else {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', 'この操作に対する管理ユーザー権限がありません。');
			$smarty->display('error.tpl');
		}

	}
	// 存在しないモードを指定された場合はエラーを表示
	else {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'そのようなモードはありません。');
		$smarty->display('error.tpl');
	}
}
?>
