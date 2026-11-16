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
	ETC_DIR . ADM_DIR . 'templates/common',
	ETC_DIR . APP_DIR . 'templates/' . COMPONENT,
	ETC_DIR . APP_DIR . 'templates/common',
	ETC_DIR . ADM_DIR . 'templates/union',
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

	$modes = ['welcome' => 5,
		'edit_order' => 5,
		'confirm' => 5,
		'regist' => 5,
		'complete' => 5,
		'add_cart' => 5,
		'view_cart' => 5,
		'clear_cart' => 5,
		'delete_cart_item' => 5,
		'change_num' => 5,
		'list_item' => 5,
		'save_order' => 5,
		'search_regist' => 1,
	];
	// URLでモードが設定されていなければ、「welcome」のモードにする
	if (!isset($_GET['mode'])) {
		$_GET['mode'] = 'edit_order';
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
