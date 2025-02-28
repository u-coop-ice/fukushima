<?php
try {
	$pdo->beginTransaction();
	$adm = new adminShoppingDB;
	$adm->setAdminAuth($auth);
	$adm->saveCapture();
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
}

// 再度表示する
if ($smarty->getTemplateVars('errmsg')) {
	header("Location: $self?mode=show_order&app_id=" . $adm->get_app_id() . "&captured=2");
} else {
	header("Location: $self?mode=show_order&app_id=" . $adm->get_app_id() . "&captured=1");
}

exit();

?>
