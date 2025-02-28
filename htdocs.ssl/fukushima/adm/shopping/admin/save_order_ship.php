<?php
$app_id = intval($_POST['app_id']);

try {
	$pdo->beginTransaction();
	$ad = new adminShoppingDB();
	$ad->setAdminAuth($auth);
	$ad->set_app_id($app_id);
	$ad->updateAppShip();

	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=edit_order&app_id=" . $ad->get_app_id() . "&saved=1");

exit();
?>