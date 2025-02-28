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

if (isset($shipdata['complete'])) {
	unset($shipdata['complete']);
}
if (isset($shipdata['app_id'])) {
	unset($shipdata['app_id']);
	unset($shipdata['response_contents']);
}

HTTP_Session2::set('shipdata', $shipdata);

//不具合引き起こしそうなセッションを削除
HTTP_Session2::set('postdata', []);

require_once "./lib/selectPriceClass.php";

$namespace = '\\shopping\\' . PART . '\\price';
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

// カート表示モードをセット
$smarty->assign('now_mode', 'view_cart');
// カートの内容を表示する
$tmpl = 'view_cart.tpl';
?>
