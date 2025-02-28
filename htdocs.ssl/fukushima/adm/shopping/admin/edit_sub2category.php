<?php
$sub2category_id = intval($_GET['sub2category_id']);
if ($sub2category_id) {
	$smarty->assign('view_sub2category_id', $sub2category_id);
} else {
	$smarty->assign('new_s2cat', 1);
}
$smarty->assign('saved', $_GET['saved']);
$smarty->display('edit_sub2category.tpl');
?>
