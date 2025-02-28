<?php

$refferdata = HTTP_Session2::get('refferdata');

$addressdata = array();

$addressdata['id'] = intval($_POST['address_id']);

try {
	$pdo->beginTransaction();
	$rgst = new appShoppingDB;
	$rgst->setAuth($userAuth);
	$rgst->saveAppShip();
	$pdo->commit();
	HTTP_Session2::set('refferdata', []);

} catch (Exception $e) {
	$pdo->rollBack();
	switch ($e->getCode()) {
	case 9:
		$smarty->display('edit_ship_address.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'アドレス帳の保存に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}
}

if ($refferdata["component"]) {
	$url = "/app/" . $refferdata["component"] . "/";
	if ($refferdata["part"]) {
		$url .= $refferdata["part"] . "/";
	}
	if ($refferdata["mode"]) {
		$url .= "?mode=" . $refferdata["mode"];
	}

	header("Location: {$url}");
	exit();

} else {
	header("Location: $self?mode=list_ship_address&saved=1");
	exit();
}

?>
