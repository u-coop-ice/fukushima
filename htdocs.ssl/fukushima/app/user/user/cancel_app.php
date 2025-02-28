<?php
// 削除するカテゴリーのIDを得る
$app_code = strip_tags($_POST['app_code']);

try {
	$cxl = new appUserDB();
	$cxl->setAuth($userAuth);
	$cxl->set_app_code($app_code);
	$cxl->cancelApp();
} catch (Exception $e) {
	switch ($e->getCode()) {

	case "9":

		break;
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お申込みの取消処理に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();

	}

}

header("Location: $self?mode=list_app&cancelled=1");
exit();

?>
