<?php

$saved = intval($_GET['saved']);
$smarty->assign('saved', $saved);

$registList = $smarty->getTemplateVars('registList');

array_pop($registList);

$smarty->assign('registList', $registList);

// 記事編集ページを表示する

$tmpl = 'step1.tpl';

if (!$_GET['continue']) {
	$custdata = [];
	$shipdata = [];
	$cart['items'] = [];
	HTTP_Session2::set('cart' . PART, $cart);
	HTTP_Session2::set('custdata', $custdata);
	HTTP_Session2::set('shipdata', $shipdata);
}

if ($custdata["regist_id"]) {
	$shipdata["regist_id"] = $custdata["regist_id"];
	$shipdata["category_id"] = $custdata["category_id"];

	HTTP_Session2::set('shipdata', $shipdata);
	$smarty->assign("view_category_id", $custdata["category_id"]);
	$tmpl = 'list_item.tpl';
} else if ($custdata["no_user"]) {

	$shipdata = $custdata;

	HTTP_Session2::set('shipdata', $shipdata);
	$smarty->assign("view_category_id", $custdata["category_id"]);
	$tmpl = 'list_item.tpl';
}
$smarty->display($tmpl);

?>
