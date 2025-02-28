<?php
$subcategory_id = intval($_GET['subcategory_id']);
if ($subcategory_id) {
	$smarty->assign('view_subcategory_id', $subcategory_id);
} else {
	$smarty->assign('new_scat', 1);
}
$smarty->assign('saved', $_GET['saved']);
$smarty->display('edit_subcategory.tpl');
?>
