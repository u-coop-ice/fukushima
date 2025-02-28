<?php
require_once '../../adm/lib/set_path.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

if ($_SERVER['HTTPS'] != "on") {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
}

//SUB_DIRの指名
$request_uris = explode('/', $_SERVER['REQUEST_URI']);
$app_part = $request_uris[3];

switch ($app_part) {
case 'admin':
case '':
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
	break;
}

define('PART', $app_part);
if (defined('PART')) {
//	$self .= PART . '/';
}
$smarty->assign('self', $self);

//配送フラグの取得

$ct = new appShoppingDB();
$init_category = $ct->getShoppingCategory();

if (!$init_category) {

	$init_category['error'] = 1;
	$init_category['denomination'] = "エラー";

	$smarty->assign('init_category', $init_category);

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
}

$smarty->assign('init_category', $init_category);

$init_paymentList = json_decode($init_category['payment'], true);
$smarty->assign('init_paymentList', $init_paymentList);

$init_shipList = json_decode($init_category['opt_ship'], true);
$smarty->assign('init_shipList', $init_shipList);

$paymentJpoList = $smarty->getTemplateVars('paymentJpoList');
$smarty->assign('paymentJpoList_json', json_encode($paymentJpoList));

// URLのパラメータを得る
$category_id = intval($_GET['category_id']);
$subcategory_id = intval($_GET['subcategory_id']);
$sub2category_id = intval($_GET['sub2category_id']);
$item_uuid = addslashes(trim($_GET['item_uuid']));
$is_first = 1;
foreach ($_GET as $key => $value) {
	if ($key != 'signout') {
		$query .= ($is_first) ? '' : '&amp;';
		$is_first = 0;
		$query .= $key . "=" . urlencode($value);
	}
}

$cart = HTTP_Session2::get('cart' . PART);

$smarty->assign('query', $query);

//$shoppingdata = HTTP_Session2::get('shoppingdata');

// カートに商品が入っているかどうかを設定
$smarty->assign('item_in_cart', count($cart['items']));
$cart_item_id = array();
if (count($cart['items'])) {
	$cart_item_id = array_column($cart['items'], 'id');
}
$smarty->assign('cart_item_id', $cart_item_id);

// URLでモードが設定されていなければ、「step1」のモードにする
if (isset($_GET['mode'])) {
	$mode = htmlspecialchars($_GET['mode'], 3, 'UTF-8');
	$smarty->assign("mode", $mode);
}

if ($mode) {

// モードの初期化
	$modes = array(
		'add_cart' => 1,
		'view_cart' => 1,
		'change_num' => 1,
		'delete_cart_item' => 1,
		'clear_cart' => 1,
		'normal_login' => 1,
		'buy_login' => 1,
		'buy_confirm' => 1,
		'buy_end' => 1,
		'redirect' => 1,
		'catch' => 1,
		'complete' => 1,
		'list_ship_address' => 1,
		'edit_ship_address' => 1,
		'save_ship_address' => 1,
		'delete_ship_address' => 1,
		'usage' => 1,
		'low' => 1,
	);

// モードに応じたページを表示
	if ($modes[$mode]) {

		$stepsFile[COMPONENT] = array(
			'step1' => 'ask',
			'confirm' => 'ask',
			'complete' => 'ask',
		);
		$smarty->assign('stepsFile', $stepsFile);
		require_once COMPONENT . '/' . $mode . '.php';
	}
// 存在しないモードを指定された場合はエラーを表示
	else {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'そのようなモードはありません。');
		$smarty->display('error.tpl');
		exit();
	}

} else {

	$queries = array();

	// カテゴリーが指定されている場合
	if ($category_id) {
		$smarty->assign('view_category_id', $category_id);
		$smarty->assign('is_category', 1);
		array_push($queries, "category_id=$category_id");
		$tmpl = 'item_list.tpl';
	} else if ($subcategory_id) {
		$smarty->assign('view_subcategory_id', $subcategory_id);
		$smarty->assign('is_subcategory', 1);
		array_push($queries, "subcategory_id=$subcategory_id");
		$tmpl = 'item_list.tpl';
	} else if ($sub2category_id) {
		$smarty->assign('view_sub2category_id', $sub2category_id);
		$smarty->assign('is_sub2category', 1);
		array_push($queries, "sub2category_id=$sub2category_id");
		$tmpl = 'item_list.tpl';
	}
	// 商品のIDが指定されている場合
	else if ($item_uuid) {
		$smarty->assign('view_item_uuid', $item_uuid);
		$smarty->assign('is_item', 1);
		$tmpl = 'item.tpl';
	}
	// 条件が指定されていない場合
	else {
		$smarty->assign('is_main', 1);
		$tmpl = 'item_list.tpl';
//        $tmpl = 'main.tpl';
	}

	if (htmlspecialchars($_POST['search_word'], 3, 'UTF-8')) {
		$smarty->assign('view_search_word', htmlspecialchars($_POST['search_word'], 3, 'UTF-8'));
		array_push($queries, "sw=" . urlencode(htmlspecialchars($_POST['search_word'], 3, 'UTF-8')));
	} else if (htmlspecialchars($_GET['search_word'], 3, 'UTF-8')) {
		$smarty->assign('view_search_word', htmlspecialchars($_GET['search_word'], 3, 'UTF-8'));
		array_push($queries, "search_word=" . urlencode(htmlspecialchars($_GET['sw'], 3, 'UTF-8')));
	}

	if (count($queries)) {
		$smarty->assign('url_query', implode("&", $queries));
	}

}

$smarty->display($tmpl);

exit();

?>
