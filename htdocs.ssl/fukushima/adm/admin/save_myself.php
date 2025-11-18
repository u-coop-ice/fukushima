<?php

try {
	$pdo->beginTransaction();
	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->set_auth_user_myself();
	$adm->saveAdminUser();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

$location = "{$self}?mode=edit_myself&saved=1";

header("Location: {$location}");
exit();

?>
