<?php

$view_app_ic = htmlspecialchars($_GET['app_ic'],3,'UTF-8');
$smarty->assign('view_app_ic', $view_app_ic);

if (!$view_app_ic){
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
}


$smarty->display('show_order.tpl');
?>
