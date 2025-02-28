<?php
$id = intval($_GET['uid']);
if ($id) {
	$smarty->assign('user_id', $id);
} else {
	$smarty->assign('new_user', 1);
}
$smarty->assign('saved', $_GET['saved']);

$list_auth = $auth_admin;

unset($list_auth['univ']);
unset($list_auth['master']);
unset($list_auth['adm']);
$smarty->assign('list_auth', $list_auth);

$smarty->display('edit_user.tpl');
?>
