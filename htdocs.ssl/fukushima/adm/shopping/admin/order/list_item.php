<?php
require_once 'HTTP/Session2.php';

$cart = HTTP_Session2::get('cart' . PART);

if (count($cart['items'])) {
	$cart_item_id = array_column($cart['items'], 'id');
}
$smarty->assign('cart_item_id', $cart_item_id);

$tmpl = "list_item.tpl";

$shipdata = HTTP_Session2::get('shipdata');

$smarty->assign('post', $shipdata);
$smarty->assign('view_category_id', $shipdata['category_id']);

$smarty->display($tmpl);
?>
