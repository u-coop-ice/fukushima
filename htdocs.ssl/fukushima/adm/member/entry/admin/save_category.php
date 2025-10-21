<?php

try {
	$pdo->beginTransaction();
	$adm = new adminEntryDB();
	$adm->setAdminAuth($auth);

	$adm->saveEntryCategory();
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=edit_category&category_id=" . $adm->get_category_id() . "&saved=1");

exit();

?>
