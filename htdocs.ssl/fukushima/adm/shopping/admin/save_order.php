<?php
$app_id = intval($_POST['id']);

try {
	$pdo->beginTransaction();
	$ad = new adminShoppingDB();
	$ad->setAdminAuth($auth);
	$ad->set_app_id($app_id);
	$ad->changeStatusApp();

	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=show_order&app_id=" . $ad->get_app_id() . "&saved=1");
exit();

?>
