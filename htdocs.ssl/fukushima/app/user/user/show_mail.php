<?php

if ($_GET['adic']) {
	$add_code = strip_tags($_GET['adic']);
}

try {
	$ad = new appAskDB();
	$ad->setAuth($userAuth);
	$ad->set_add_code($add_code);

	$addinfo = $ad->updateRead();

	$smarty->assign('view_root_id', $ad->get_root_id());

	$smarty->assign("now_add_id", $ad->get_add_id());

	$smarty->display('show_mail.tpl');
	exit();
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'URLが不正です。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
?>
