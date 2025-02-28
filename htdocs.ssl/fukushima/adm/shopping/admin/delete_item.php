<?php
// 削除する商品のIDを得る
$id = intval($_POST['item_id']);

try {
	$pdo->beginTransaction();

	$del = new adminShoppingDB();
	$del->setAdminAuth($auth);
	$del->set_shopping_item_id($id);
	$del->deleteShoppingItem();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '商品の削除に失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

// 商品一覧のページを再度表示する
header("Location: $self?mode=list_item&deleted=1");

?>
