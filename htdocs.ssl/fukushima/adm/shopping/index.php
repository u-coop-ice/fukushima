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

	$modes = ['welcome' => 1,
		'list_item' => 7,
		'edit_item' => 7,
		'save_item' => 7,
		'delete_item' => 7,
		'delete_image' => 7,

		'list_category' => 7,
		'edit_category' => 7,
		'save_category' => 7,
		'delete_category' => 7,
		'list_subcategory' => 7,
		'edit_subcategory' => 7,
		'save_subcategory' => 7,
		'delete_subcategory' => 7,
		'list_sub2category' => 7,
		'edit_sub2category' => 7,
		'save_sub2category' => 7,
		'delete_sub2category' => 7,
		'list_order' => 1,
		'save_order' => 7,
		'save_capture' => 7,
		'save_cancel' => 7,
		'show_order' => 1,
		'edit_order' => 7,
		'save_order_ship' => 7,
		'save_order_regist' => 7,
		'list_payment' => 1,
		'save_payment' => 7,
		'list_paid_completed' => 1,
		'list_nopaid' => 1,
		'list_exported_no_treatment' => 1,
		'update_app_status' => 7,
		'sendmail_paid_completed' => 7,
		'sendmail_nopaid' => 7,
		'edit_excel' => 7,
		'edit_excel_dev' => 7,
		'edit_excel_jp' => 7,
		'edit_excel_paid' => 7,
		'export_excel' => 7,
		'export_excel_dev' => 7,
		'export_excel_paid' => 7,
		'export_excel_jp' => 7,
		'export_word' => 1,
		'show_config' => 1,
		'edit_config' => 9,
		'save_config' => 9,
		'select_category' => 1,
/*		'update_db' => 1,*/

		'dialog_compose_item' => 7,
		'list_stock_log' => 1,

		'check_category_name' => 1,

	];
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'welcome';
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
