<?php

$result = [];

try {
	$pdo->beginTransaction();
	$ad = new appAskDB();
	$ad->setAuth($userAuth);
	$result = $ad->returnAppAdd();
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$result['errmsg'] = $e->getMessage();

}

echo json_encode($result);
exit();

?>
