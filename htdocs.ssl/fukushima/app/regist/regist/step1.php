<?php

if (isset($_GET['email'])) {
	$entrydata['email'] = urldecode($_GET['email']);
	$entrydata['email'] = htmlspecialchars($entrydata['email'], 3, 'UTF-8');
	$smarty->assign('post', $entrydata);
}

$steps = array(1 => "now");
$smarty->assign('steps', $steps);
$smarty->display('step1.tpl');
?>
