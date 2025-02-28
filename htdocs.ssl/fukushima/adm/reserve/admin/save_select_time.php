<?php

try {
	$adm = new adminReserveDB;
	$result = $adm->saveSelectTime();
} catch (Exception $e) {
	$result['error'] = $e->getMessage();
}

echo json_encode($result);
exit;

?>
