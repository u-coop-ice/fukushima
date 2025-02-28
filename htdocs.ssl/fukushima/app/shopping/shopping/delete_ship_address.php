<?php

$refferdata = HTTP_Session2::get('refferdata');

$addressdata = [];

$addressdata['id'] = intval($_POST['address_id']);

try {
	$pdo->beginTransaction();
	$del = new appShoppingDB();
	$del->setAuth($userAuth);
	$del->set_ship_address_id($addressdata['id']);
	$del->invisibleAppShip();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'アドレスの削除に失敗しました。');
	$smarty->display('error.tpl');
	exit();
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
	header("Location: $self?mode=list_ship_address&deleted=1");
	exit();
}

?>
