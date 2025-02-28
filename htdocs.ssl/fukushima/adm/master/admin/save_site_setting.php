<?php

try {
	$pdo->beginTransaction();
	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->saveSiteSetting();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
header("Location: $self?mode=edit_site_setting&saved=1");
exit();

?>
