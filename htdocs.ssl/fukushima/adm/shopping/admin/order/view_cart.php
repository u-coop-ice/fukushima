<?php

// カート処理のメッセージがあれば、それをSmartyの変数にセットし、
// セッションから削除する
if (isset($cart['cart_msg'])) {
	$smarty->assign('cart_msg', $cart['cart_msg']);
	unset($cart['cart_msg']);
	HTTP_Session2::set('cart' . PART, $cart);
}
// カートの内容が削除されていれば、そのことをSmartyの変数にセットする
if ($_GET['cleared'] == '1') {
	$smarty->assign('cleared', 1);
}

$shipdata = HTTP_Session2::get('shipdata');

if ($init_category['part']) {
	require_once "../../app/shopping/lib/selectPriceClass.php";

	$namespace = '\\shopping\\' . $init_category['part'] . '\\price';
	if (!class_exists($namespace)) {
		$namespace = '\\shopping\\common\\price';
	}

	$ps = new $namespace;

	$ps->set_postdata($shipdata);

	$ps->set_cart($cart);
	$ps->calc_price();

	$cart = $ps->get_cart();

	HTTP_Session2::set('cart' . PART, $cart);

	$postage = $ps->get_postage();
	$reduction = $ps->get_reduction();
	$total_price = $ps->get_price();

	$smarty->assign("postage", $postage);
	$smarty->assign("reduction", $reduction);
	$smarty->assign('total_price', $total_price);
	$smarty->assign('total_price_all', $total_price + $postage - $reduction);

	$shipdata['postage'] = $postage;
	$shipdata['reduction'] = $reduction;
	$shipdata['total_price'] = $total_price;
	$shipdata['total_price_all'] = $total_price + $postage - $reduction;
	HTTP_Session2::set('shipdata', $shipdata);
}
// カート表示モードをセット
$smarty->assign('now_mode', 'view_cart');
// カートの内容を表示する
$tmpl = 'view_cart.tpl';

$smarty->display($tmpl);
?>
