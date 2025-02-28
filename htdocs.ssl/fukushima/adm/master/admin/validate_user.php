<?php
try {
	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$result = $adm->validAdminUser();

} catch (Exception $e) {
	$e->getMessage();
}

echo json_encode($result); // RETURN ARRAY WITH success
exit();
?>