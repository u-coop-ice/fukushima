<?php
set_time_limit(360);

try {
	$pdo->beginTransaction();
	$ad = new adminShoppingDB();
	$ad->setAdminAuth($auth);
	$ad->saveShoppingItem();

	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=edit_item&item_id=" . $ad->get_shopping_item_id() . "&saved=1");
exit();

?>
