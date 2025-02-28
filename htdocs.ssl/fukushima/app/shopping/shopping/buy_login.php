<?php
// すでにログインしていて、かつ商品がカートにあれば、レジに進む
if ($is_login && count($cart['items'])) {
	header("Location : ${self}?mode=buy_confirm");
	exit();
}
// URLの後につけるクエリ
$smarty->assign('query', 'mode=buy_confirm');
$smarty->assign('md', 'buy_confirm');

// ログインのページを表示する
$tmpl = 'login.tpl';
?>
