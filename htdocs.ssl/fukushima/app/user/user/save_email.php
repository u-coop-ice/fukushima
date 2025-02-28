<?php

try {

	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$postdata = $rgst->saveRegistTmpEmail();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		var_dump($smarty->getTemplateVars('error'));
		exit;
		$smarty->display('edit_email.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', '基本情報の保存に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}
?>
