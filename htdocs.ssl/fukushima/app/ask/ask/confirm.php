<?php

if ($askdata['complete']) {
	HTTP_Session2::set('askdata', null);
	header("Location: ${site_url}index.php");
	exit();
}

try {
	$appAsk = new appAskDB;
	$appAsk->setAuth($userAuth);
	$appAsk->saveAppAsk();
} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		$steps[1] = 'now';
		$smarty->assign('step', $steps);
		$smarty->display('step1.tpl');
		exit();
	case 8:
		$steps[1] = 'cleared';
		$steps[2] = 'now';
		$smarty->assign('step', $steps);
		$smarty->display('confirm.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お問い合わせ登録に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}
exit();

?>
