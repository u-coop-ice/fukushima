<?php

$shipdata = HTTP_Session2::get('shipdata');

//$custdata = HTTP_Session2::get('custdata');

if (!count($shipdata)) {
	header("Location: ${self}");
	exit();
} else {
	$smarty->assign('post', $shipdata);
}

// ログインしていなければ、ログインのページへ移動する
if (!$is_login && $shipdata['no_user'] != '1') {
	header("Location: ${self}?mode=buy_login");
	exit();
}

try {
	$ap = new appShoppingDB();
	$ap->setAuth($userAuth);
	$ap->set_shipdata($shipdata);
	$ap->set_session_cart((array) $cart);
	$ap->saveAppShopping();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:

		$smarty->assign("postage", $shipdata['postage']);
		$smarty->assign("reduction", $shipdata['reduction']);
		$smarty->assign('total_price', $shipdata['total_price']);
		$smarty->assign('total_price_all', $shipdata['total_price_all']);

		$smarty->assign('is_item_exist', count($cart['items']));

		$smarty->assign('now_mode', 'buy_confirm');
		$smarty->assign('wc_errmsg', $e->getMessage());
		$smarty->display("shop_step3.tpl");
		break;

	case 8:
		$smarty->assign("postage", $shipdata['postage']);
		$smarty->assign("reduction", $shipdata['reduction']);
		$smarty->assign('total_price', $shipdata['total_price']);
		$smarty->assign('total_price_all', $shipdata['total_price_all']);

		$smarty->assign('is_item_exist', count($cart['items']));

		$smarty->assign('now_mode', 'view_cart');
		$smarty->assign('wc_errmsg', $e->getMessage());
		$smarty->display("view_cart.tpl");
		break;

	default:

		HTTP_Session2::set('shipdata', []);

		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', $e->getMessage());
		$smarty->display('error.tpl');
		exit();

	}
}

exit();

?>
