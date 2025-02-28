<?php

$adddata = HTTP_Session2::get('adddata');

if (intval($_POST['add_id'])) {
	$add_id = intval($_POST['add_id']);
	$adddata = array();
	$adddata["add_id"] = $add_id;
}

if (intval($_POST['app_id'])) {
	$app_id = intval($_POST['app_id']);
	$adddata["app_id"] = $app_id;
}
if (intval($_POST['root_id'])) {
	$root_id = intval($_POST['root_id']);
	$adddata["root_id"] = $root_id;
}

$smarty->assign('view_app_id', $adddata["app_id"]);
$smarty->assign('view_add_id', $adddata["add_id"]);
$smarty->assign('view_root_id', $adddata["root_id"]);

HTTP_Session2::set('adddata', $adddata);

//返信数を計算

try {
	$appadd = new appAskDB();
	$appadd->setAuth($userAuth);
	$appadd->set_root_id($adddata['root_id']);
	$appadd->set_add_id($adddata['add_id']);

	$returndata = $appadd->getReturnAddInfo();

} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

$smarty->assign('return', $returndata);

$smarty->display('edit_mail.tpl');
?>
