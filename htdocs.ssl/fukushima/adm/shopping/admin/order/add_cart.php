<?php
$item = [];
$item['item_id'] = intval($_POST['item_id']);
$item['num'] = intval($_POST['num']);

$item['cart1'] = htmlspecialchars($_POST['cart1'], 3, 'UTF-8');
$item['cart2'] = htmlspecialchars($_POST['cart2'], 3, 'UTF-8');
$item['cart3'] = htmlspecialchars($_POST['cart3'], 3, 'UTF-8');
$item['num'] = intval($_POST['num']);

try {
	$appadd = new adminShoppingOrderDB();
	$appadd->set_item($item);
	$appadd->set_session_cart((array) $cart);
	$cart = $appadd->addCart();
} catch (Exception $e) {

	$cart['cart_msg'] = $e->getMessage();

}

HTTP_Session2::set('cart' . PART, $cart);

exit();

?>
