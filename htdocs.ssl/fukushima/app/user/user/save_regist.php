<?php
$refferdata = HTTP_Session2::get('refferdata');

try {
	$pdo->beginTransaction();

	$rgst = new appRegistDB;
	$rgst->setAuth($userAuth);
	$postdata = $rgst->saveRegist();

	$pdo->commit();
	HTTP_Session2::set('refferdata', []);

} catch (Exception $e) {
	$pdo->rollBack();
	switch ($e->getCode()) {
	case 9:

		$methods['dept']['use'] = 2;
		$methods['address']['use'] = 2;
		$methods['new_add']['use'] = 2;
		$methods['phonenumber']['use'] = 2;
		$methods['mobilephone']['use'] = 1;
		$methods['student_phone']['use'] = 1;
		$methods['name']['use'] = 2;
		$methods['membership']['use'] = 1;
		$methods['sex']['use'] = 1;
		$methods['age']['use'] = 1;

		$smarty->assign("methods", $methods);

		$smarty->display('edit_regist.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', '基本情報の保存に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}
if ($refferdata["component"]) {
	$url = "/app/" . $refferdata["component"] . "/";
	if ($refferdata["part"]) {
		$url .= $refferdata["part"] . "/";
	}
	if ($refferdata["self"]) {
		$url .= $refferdata["self"] . '.php';
	}
	if ($refferdata["mode"]) {
		$url .= "?mode=" . $refferdata["mode"];
	}

	header("Location: {$url}");
	exit();

} else {
	header("Location: $self?mode=show_regist&saved=1");
	exit();
}
?>
