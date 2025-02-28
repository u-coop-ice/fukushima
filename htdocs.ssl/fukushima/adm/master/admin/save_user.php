<?php

try {
	$pdo->beginTransaction();
	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->saveAdminUser();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
if (isset($_POST['rewrited'])) {
	$location = "{$self}?mode=list_user&saved=1";
} else {
	$location = "{$self}?mode=edit_user&uid=" . $adm->get_edit_auth_user_id() . "&saved=1";
}

header("Location: {$location}");
exit();

?>
