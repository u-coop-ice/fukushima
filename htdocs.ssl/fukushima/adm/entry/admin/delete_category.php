<?php
// 削除するカテゴリーのIDを得る
$category_id = intval($_POST['id']);
$query = addslashes($_POST['query']);

// カテゴリーを削除する

try {
	$pdo->beginTransaction();

	$del = new adminEntryDB();
	$del->setAdminAuth($auth);
	$del->set_category_id($category_id);
	$del->deleteEntryCategory();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'カテゴリの削除に失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

// カテゴリー一覧のページを再度表示する
if ($query) {
	header("Location: ${self}?${query}&deleted=1");
} else {
	header("Location: $self?mode=list_category&deleted=1");
}

exit();

?>
