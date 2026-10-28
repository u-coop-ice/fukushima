<?php

$result = [];
try {
	$pdo->beginTransaction();

	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->set_auth_user_myself();
	$adm->resetAdminUserSecret();

	$pdo->commit();

} catch (Exception $e) {

	$pdo->rollBack();
	$result['error'] = $e->getMessage();
}

echo json_encode($result);
exit();
?>
