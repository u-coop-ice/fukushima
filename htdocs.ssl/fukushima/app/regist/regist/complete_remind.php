<?php
try {

	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->completeAppRemind();
	exit();
} catch (Exception $e) {
	$appCreateRegist::return2First();
}
exit();
?>
