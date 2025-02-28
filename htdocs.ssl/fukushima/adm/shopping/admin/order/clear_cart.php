<?php
// カートの商品を削除する
$cart['items'] = array();
$cart['methods'] = array();
HTTP_Session2::set('cart' . PART, $cart);
// カート表示のページに移動する
header("location: ${self}?mode=view_cart&cleared=1");
exit();
?>
