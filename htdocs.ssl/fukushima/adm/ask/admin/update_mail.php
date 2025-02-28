<?php

$add_id = intval($_POST['add_id']);

$root_id = intval($_POST['root_id']);

try {
	$ad = new adminAskDB();
	$ad->setAdminAuth($auth);
	$ad->set_add_id($add_id);
	$ad->updateAppAdd();

	$smarty->assign('url_query', "./?mode=list_mail");

	if ($_SESSION['ask']['url_query']) {
		$smarty->assign('url_query', "./?" . $_SESSION['ask']['url_query']);
	}

//	$smarty->display('show_mail.tpl');

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'URLが不正です。');
	$smarty->display('error.tpl');
	exit();

}
// 編集のページを再度表示する
header("Location: $self?mode=show_mail&add_id=" . $add_id . "&saved=1");

exit();
