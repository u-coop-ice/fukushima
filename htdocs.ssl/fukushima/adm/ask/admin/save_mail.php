<?php

$result = [];

try {
	$pdo->beginTransaction();
	$ad = new adminAskDB();
	$ad->setAdminAuth($auth);
	$result = $ad->sendAppAdd();

//	$smarty->display('show_mail.tpl');
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$result['error'] = $e->getMessage();

}

echo json_encode($result);
exit();

?>
