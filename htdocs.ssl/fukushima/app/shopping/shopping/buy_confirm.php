<?php
// ログインしてなくて、ユーザー登録なしで注文する以外は、ログインのページに移動する

$shipdata = HTTP_Session2::get('shipdata');
$custdata = HTTP_Session2::get('custdata');

$shipdata = (array) $shipdata;

HTTP_Session2::set('refferdata', null);

require_once "./lib/selectPriceClass.php";

if (isset($_GET['no_user'])) {
	$shipdata['no_user'] = intval($_GET['no_user']);
	HTTP_Session2::set('shipdata', $shipdata);
	HTTP_Session2::set('custdata', $custdata);
}

$smarty->assign('no_user', $shipdata['no_user']);

if (!$is_login && $shipdata['no_user'] != 1) {
	$smarty->display("login.tpl");
	exit();
}

// 購入確認表示モードをセット
$smarty->assign('now_mode', 'buy_confirm');

try {
	$ap = new appShoppingDB();
	$ap->setAuth($userAuth);
	$ap->set_shipdata($shipdata);
	$ap->set_session_cart((array) $cart);
	$ap->saveAppShopping();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:

		switch ($ap->get_step()) {
		case 1:
		case 2:
			$smarty->display('view_cart.tpl');
			break;
		case 3:
			$smarty->display('shop_step2.tpl');
			break;
		case 4:
			$smarty->display('shop_step3.tpl');
			break;
		case 9:
			$smarty->display('view_cart.tpl');
			break;
		default:
			$smarty->display('view_cart.tpl');
			break;
		}

	}
}

exit();

?>
