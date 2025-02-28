<?php

try {
	$pdo->beginTransaction();
	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$postdata = $rgst->saveRegistPassword();
	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	switch ($e->getCode()) {
	case 9:
		$smarty->display('edit_password.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', '基本情報の保存に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}
header("Location: $self?mode=show_regist&saved=1");
exit();

?>
