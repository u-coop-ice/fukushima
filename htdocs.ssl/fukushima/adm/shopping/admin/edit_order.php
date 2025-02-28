<?php
// 注文IDを変数に設定

$view_order_id = intval($_GET['app_id']);
$smarty->assign('view_order_id', $view_order_id);

$captured = intval($_GET['captured']);
$smarty->assign('captured', $captured);

if ($_SESSION['shopping']['url_query']) {
	$smarty->assign("url_query", $_SESSION['shopping']['url_query']);
}

$methods['address']['use'] = 2;
$methods['phonenumber']['use'] = 2;
$smarty->assign("methods", $methods);

// ページを表示
$smarty->display('edit_order.tpl');
?>
