<?php

try {
	$pdo->beginTransaction();
	$adm = new adminMmDB();
	$adm->setAdminAuth($auth);
	$adm->saveMailGroup();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
// 編集のページを再度表示する
header("Location: $self?mode=edit_group&group_id=" . $adm->get_mail_group_id() . "&saved=1");
exit();
?>