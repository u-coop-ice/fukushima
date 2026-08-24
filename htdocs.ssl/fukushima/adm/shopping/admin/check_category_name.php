<?php

try {

	$adm = new adminShoppingDB();
	$adm->setAdminAuth($auth);
	$arrayToJs = $adm->duplicateCategoryName();
} catch (Exception $e) {
	$arrayToJs[1] = false;
}
echo json_encode($arrayToJs); // RETURN ARRAY WITH success
exit();
?>
