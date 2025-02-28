<?php
// 削除する記事のIDを得る
$group_id = intval($_POST['group_id']);

try {
	$pdo->beginTransaction();

	$del = new adminMmDB();
	$del->setAdminAuth($auth);
	$del->set_mail_group_id($group_id);
	$del->deleteMailMagazineAll();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベースの処理に失敗ました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

header("Location: $self?mode=list_magazine&group_id=" . $group_id . "&deleted=1");
?>
