<?php
// 変更後の商品の個数を得る
$num = intval($_POST['num']);
// 変更する商品の番号を得る
$index = intval($_POST['index']);
// 個数が1未満ならエラーにする
if ($num < 1) {
	$cart['cart_msg'] = '個数を1個未満にすることはできません。';
}
// 商品の番号が正しくない場合
else if (!isset($cart['items'][$index])) {
	$cart['cart_msg'] = 'その番号の商品は登録されていません。';
}
// 商品の個数を変える
else {
	$cart['cart_msg'] = ($index + 1) . "番の商品の個数を変更しました。";
	$cart['items'][$index]['num'] = $num;
	HTTP_Session2::set('cart' . PART, $cart);
}
// 元のページに移動する
$now_mode = htmlspecialchars($_GET['now_mode'], 3, 'UTF-8');
header("location: {$self}?mode=${now_mode}");
exit();
?>
