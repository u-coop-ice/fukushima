<?php
$id = intval($_GET['uid']);
if ($id) {
	$smarty->assign('user_id', $id);
}

$smarty->display('edit_password.tpl');
?>
