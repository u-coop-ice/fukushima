<?php
try {
	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->setAuth($userAuth);
	$appCreateRegist->saveAppRemind();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		$smarty->display('change_password.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'パスワード変更処理に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}

header("Location:{$self}?mode=complete_remind_end&username=" . urlencode($appCreateRegist->get_username()));
exit();

?>
