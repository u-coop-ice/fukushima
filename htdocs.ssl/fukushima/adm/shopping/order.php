<?php
require_once '../lib/set_path.php';

// セッションを開始する
ini_set('session.use_only_cookies', 1);
session_start();

// Smartyオブジェクトの作成
require_once 'initialize.php';
require_once 'admSmarty.php';

//テンプレートディレクトリの追加
$smarty->setTemplateDir([
	ETC_DIR . ADM_DIR . 'templates/' . COMPONENT . '/order',
	ETC_DIR . APP_DIR . 'templates/' . COMPONENT,
	ETC_DIR . APP_DIR . 'templates/common',
	ETC_DIR . ADM_DIR . 'templates/union',
	ETC_DIR . ADM_DIR . 'templates/common',
]);

$self = "./order.php";
$smarty->assign('self', 'order.php');

$shipdata = HTTP_Session2::get('shipdata');
$custdata = HTTP_Session2::get('custdata');

// ログイン済みの場合の処理
if ($auth->getAuth()) {

//category情報取得

	if ($shipdata['category_id']) {
		$ct = new adminShoppingOrderDB();
		$ct->set_shopping_category_id($shipdata['category_id']);
		$init_category = $ct->getShoppingCategory();
		$smarty->assign('init_category', $init_category);
	}

	$init_paymentList = json_decode($init_category['payment'], true);
	$smarty->assign('init_paymentList', $init_paymentList);

	$init_shipList = json_decode($init_category['opt_ship'], true);
	$smarty->assign('init_shipList', $init_shipList);

	if ($init_category['part']) {
		define('PART', $init_category['part']);
	}

	$cart = HTTP_Session2::get('cart' . PART);

	// モードの初期化

	$smarty->assign('mode', $_GET['mode']);

	$modes = array('welcome' => 1,
		'edit_order' => 1,
		'confirm' => 1,
		'regist' => 1,
		'complete' => 1,
		'add_cart' => 1,
		'view_cart' => 1,
		'clear_cart' => 1,
		'delete_cart_item' => 1,
		'change_num' => 1,
		'list_item' => 1,
		'save_order' => 1,
		'search_regist' => 1,
	);
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'edit_order';
	}
	// モードに応じたページを表示
	if ($modes[$_GET['mode']]) {
		$smarty->assign('show_menu', 1);
		require_once 'admin/order/' . $_GET['mode'] . '.php';
	}
	// 存在しないモードを指定された場合はエラーを表示
	else {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'そのようなモードはありません。');
		$smarty->display('error.tpl');
	}
}
?>
