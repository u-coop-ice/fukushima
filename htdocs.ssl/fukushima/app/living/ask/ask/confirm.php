<?php

if ($askdata['complete']) {
	HTTP_Session2::set('askdata', null);
	header("Location: ${site_url}index.php");
	exit();
}

try {
	$appAsk = new appAskDB;
	$appAsk->setAuth($userAuth);
	$appAsk->saveAppLivingAsk();
} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		$smarty->display('step1.tpl');
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
