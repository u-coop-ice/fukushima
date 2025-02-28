<?php
// 削除するカテゴリーのIDを得る
$group_id = intval($_POST['id']);

try {
	$pdo->beginTransaction();

	$del = new adminMmDB();
	$del->setAdminAuth($auth);
	$del->set_mail_group_id($group_id);
	$del->deleteMailGroup();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベースの処理に失敗ました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

// カテゴリー一覧のページを再度表示する
header("Location: $self?mode=list_group&deleted=1");
?>
