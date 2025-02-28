<?php

try {

	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$postdata = $rgst->removeRegist();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		$smarty->display('remove_account.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'アカウントの処理に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}

exit();
?>
