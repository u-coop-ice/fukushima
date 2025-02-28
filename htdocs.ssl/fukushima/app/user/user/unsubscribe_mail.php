<?php
// ユーザー名と登録コードを得る
$get_username = urldecode($_GET['username']);
$get_username = strip_tags($get_username);

try {

	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$rgst->set_get_username($get_username);
	$rgst->directAppUnsubscribeMail();

} catch (Exception $e) {
	switch ($e->getCode()) {
	case 9:
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', '基本情報の保存に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}

header("Location: $self?mode=show_regist&saved=1");
exit();

?>
