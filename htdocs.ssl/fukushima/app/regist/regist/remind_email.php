<?php
try {
	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->setAuth($userAuth);
	$appCreateRegist->sendAppRemind();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		print_r($smarty->getTemplateVars('error'));
		$smarty->assign('steps', $steps);
		$smarty->display('remind.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'パスワード変更処理に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}
header("Location:{$self}?mode=complete_remind");
exit();

?>
