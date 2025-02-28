<?php
try {

	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->completeAppRemindEnd();
	exit();
} catch (Exception $e) {
	$appCreateRegist::return2First();
}
exit();
?>
