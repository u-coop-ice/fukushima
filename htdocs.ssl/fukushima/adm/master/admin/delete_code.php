<?php
try {
	$pdo->beginTransaction();

	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->deleteCode();

	$pdo->commit();

} catch (Exception $e) {

	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');

}

// カテゴリー一覧のページを再度表示する
header("Location: $self?mode=list_code&univ_id=" . $adm->get_univ_id() . "&deleted=1");
exit();

?>
