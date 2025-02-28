<?php
try {

	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->saveAppCreateRegist();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		$steps[1] = "cleared";
		$steps[2] = "cleared";
		$steps[3] = "cleared";
		$steps[4] = "now";
		$smarty->assign('steps', $steps);
		$smarty->display('step2.tpl');
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