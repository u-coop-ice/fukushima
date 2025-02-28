<?php
// 削除するカテゴリーのIDを得る
$id = intval($_POST['id']);
$query = addslashes($_POST['query']);

try {
	$pdo->beginTransaction();

	$del = new adminMmDB();
	$del->setAdminAuth($auth);
	$del->set_mail_magazine_id($id);
	$del->deleteMailMagazine();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベースの処理に失敗ました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

// カテゴリー一覧のページを再度表示する
header("Location: $self" . $query . "&deleted=1");
?>
