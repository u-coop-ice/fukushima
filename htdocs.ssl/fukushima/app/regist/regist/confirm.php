<?php
try {

	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->saveAppCreateRegistSub();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		$steps[1] = "now";
		$smarty->assign('steps', $steps);
		$smarty->display('step1.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'ユーザー登録に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}
exit();

?>