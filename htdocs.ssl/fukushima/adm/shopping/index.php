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

	$cat = new adminShoppingDB();
	$categoryList = $cat->getShoppingCategoryList();
	$smarty->assign('categoryList', $categoryList);

	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = array('welcome' => 1,
		'list_item' => 1,
		'edit_item' => 1,
		'save_item' => 1,
		'delete_item' => 1,
		'delete_image' => 1,

		'list_category' => 1,
		'edit_category' => 1,
		'save_category' => 1,
		'delete_category' => 1,
		'list_subcategory' => 1,
		'edit_subcategory' => 1,
		'save_subcategory' => 1,
		'delete_subcategory' => 1,
		'list_sub2category' => 1,
		'edit_sub2category' => 1,
		'save_sub2category' => 1,
		'delete_sub2category' => 1,
		'list_order' => 1,
		'save_order' => 1,
		'save_capture' => 1,
		'save_cancel' => 1,
		'show_order' => 1,
		'edit_order' => 1,
		'save_order_ship' => 1,
		'save_order_regist' => 1,
		'list_payment' => 1,
		'save_payment' => 1,
		'list_paid_completed' => 1,
		'list_nopaid' => 1,
		'list_exported_no_treatment' => 1,
		'update_app_status' => 1,
		'sendmail_paid_completed' => 1,
		'sendmail_nopaid' => 1,
		'edit_excel' => 1,
		'edit_excel_dev' => 1,
		'edit_excel_jp' => 1,
		'edit_excel_paid' => 1,
		'export_excel' => 1,
		'export_excel_dev' => 1,
		'export_excel_paid' => 1,
		'export_excel_jp' => 1,
		'export_word' => 1,
		'show_config' => 1,
		'edit_config' => 1,
		'save_config' => 1,
		'select_category' => 1,
/*		'update_db' => 1,*/

		'dialog_compose_item' => 1,
		'list_stock_log' => 1,
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
