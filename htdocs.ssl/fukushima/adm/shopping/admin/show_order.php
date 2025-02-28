<?php
// 注文IDを変数に設定
$view_order_id = intval($_GET['app_id']);
$smarty->assign('view_order_id', $view_order_id);

if (!$view_order_id) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なURLです');
	$smarty->display('error.tpl');
	exit();
}

$statusOrderList = $smarty->getTemplateVars('statusOrderList');

unset($statusOrderList[-1]);
unset($statusOrderList[-9]);
$smarty->assign('statusOrderList', $statusOrderList);

$captured = intval($_GET['captured']);
$smarty->assign('captured', $captured);

if ($_SESSION['shopping']['url_query']) {
	$smarty->assign("url_query", $_SESSION['shopping']['url_query']);
}

// ページを表示
$smarty->display('show_order.tpl');
?>
