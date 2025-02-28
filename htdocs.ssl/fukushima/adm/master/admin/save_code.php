<?php

try {
	$pdo->beginTransaction();
	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->saveCode();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
if (isset($_POST['submited'])) {
	header("Location: $self?mode=list_code&univ_id=" . $adm->get_univ_id() . "&saved=1");
} else {
	header("Location: $self?mode=edit_code&id=" . $adm->get_code_id() . "&univ_id=" . $adm->get_univ_id() . "&name=" . $adm->get_name() . "&saved=1");
}
exit();

?>
