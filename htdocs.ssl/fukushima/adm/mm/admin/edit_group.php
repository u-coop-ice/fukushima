<?php
$id = intval($_GET['group_id']);

if ($id) {
	$smarty->assign('view_group_id', $id);
} else {
	$smarty->assign('new_group', 1);
}
$smarty->assign('saved', $_GET['saved']);
$smarty->display('edit_group.tpl');
?>
