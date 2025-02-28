<?php
// 変更する商品の番号を得る
$index = intval($_POST['index']);
// 商品の番号が正しくない場合
if (!isset($cart['items'][$index])) {
	$cart['cart_msg'] = 'その番号の商品は登録されていません。';
}
// 商品をカートから削除する
else {
	$cart['cart_msg'] = ($index + 1) . "番の商品を削除しました。";
	array_splice($cart['items'], $index, 1);
	HTTP_Session2::set('cart' . PART, $cart);
}
// 元のページに移動する
$now_mode = htmlspecialchars($_GET['now_mode'], 3, 'UTF-8');
header("location: {$self}?mode=${now_mode}");
exit();
?>
