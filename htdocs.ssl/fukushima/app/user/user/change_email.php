<?php

try {

	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$postdata = $rgst->updateRegistEmail();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
	case 8:
	case 1:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', $e->getMessage());
		$smarty->display('error.tpl');
		exit();

	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', '基本情報の保存に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}

header("Location: $self?mode=show_regist&changed_email=1");
exit();

?>
