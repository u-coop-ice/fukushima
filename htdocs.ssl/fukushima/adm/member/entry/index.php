<?php
$domains = explode('/', $_SERVER['REQUEST_URI']);

define('COMPONENT', $domains[2]);
define('PART', $domains[3]);

define('ADM_PART', "entry");

require_once '../../lib/set_path.php';

require_once 'initialize.php';
require_once 'admSmarty.php';

// ログイン済みの場合の処理
if ($auth->getAuth()) {

	// モードの初期化

	$obj = 'admin' . ucfirst(COMPONENT) . ucfirst(PART) . 'DB';
	$cinfo = new $obj;
	$cinfo->set_component(COMPONENT);
	$cinfo->set_part(PART);
	$categoryinfo = $cinfo->getEntryCategory();

	$smarty->assign("category", $categoryinfo);
	$smarty->assign("part_pagetitle", $categoryinfo['denomination']);

	$smarty->assign('mode', $_GET['mode']);

	$modes = ['welcome' => 1,
		'list_app' => 1,
		'edit_app' => 1,
		'show_app' => 1,
		'save_app' => 1,
		'delete_app' => 1,

		'edit_category' => 1,
		'save_category' => 1,
		'delete_category' => 1,
		'delete_entry_all' => 1,
		'delete_all' => 1,
		'edit_excel' => 1,
		'export_excel' => 1,

		'edit_archived' => 1,
		'save_archived' => 1,

	];
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'list_app';
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
