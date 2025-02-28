<?php
// 削除するカテゴリーのIDを得る

$sub2category_id = intval($_POST['sub2category_id']);

try {
	$pdo->beginTransaction();

	$del = new adminShoppingDB();
	$del->setAdminAuth($auth);
	$del->set_shopping_sub2category_id($sub2category_id);
	$del->deleteShoppingSub2category();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'サブカテゴリの削除に失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

// カテゴリー一覧のページを再度表示する
if ($query) {
	header("Location: ${self}?${query}&deleted=1");
} else {
	header("Location: $self?mode=list_sub2category&deleted=1");
}

exit();
?>
