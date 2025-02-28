<?php
try {

	$appCreateRegist = new appCreateRegistDB;
	$appCreateRegist->completeAppCreateRegistSub();

} catch (Exception $e) {
	$appCreateRegist::return2First();
}
exit();
?>
