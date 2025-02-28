<?php
if (intval($_GET['add_id'])) {
	$add_id = intval($_GET['add_id']);
	$smarty->assign('now_add_id', $add_id);
}
$smarty->assign('saved', $_GET['saved']);

try {
	$ad = new adminAskDB();
	$ad->setAdminAuth($auth);
	$ad->set_add_id($add_id);
	$ad->showAppAdd();

	$smarty->assign('url_query', "./?mode=list_mail");

	if ($_SESSION['ask']['url_query']) {
		$smarty->assign('url_query', "./?" . $_SESSION['ask']['url_query']);
	}

	$smarty->display('show_mail.tpl');

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'URLが不正です。');
	$smarty->display('error.tpl');
	exit();

}
?>
