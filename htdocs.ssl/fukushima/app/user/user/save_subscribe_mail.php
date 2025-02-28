<?php
// ユーザー名と登録コードを得る
$unsubscribe_mail = intval($_POST['dm']);

try {

	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$rgst->set_unsubscribe_mail($unsubscribe_mail);
	$rgst->saveAppUnsubscribeMail();

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

