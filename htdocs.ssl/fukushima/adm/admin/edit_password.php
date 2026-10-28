<?php

$user_id = intval($_GET['user_id']);
if ($user_id) {
	$smarty->assign('user_id', $user_id);
	$user = $auth->getAuthdata();
	$smarty->assign('user', $user);
}

$smarty->display('edit_password.tpl');
?>
