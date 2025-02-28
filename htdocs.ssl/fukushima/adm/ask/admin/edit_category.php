<?php
$category_id = intval($_GET['category_id']);
if ($category_id) {
	$smarty->assign('view_category_id', $category_id);
} else {
	$smarty->assign('new_cat', 1);
}
$smarty->assign('saved', $_GET['saved']);
$smarty->display('edit_category.tpl');
?>
