<?php
$magazine_id = intval($_GET['magazine_id']);
if ($magazine_id) {
	$smarty->assign('view_magazine_id', $magazine_id);
} else {
	$smarty->assign('new_magazine', 1);
}
$smarty->assign('saved', $_GET['saved']);
$smarty->display('edit_magazine.tpl');
?>
