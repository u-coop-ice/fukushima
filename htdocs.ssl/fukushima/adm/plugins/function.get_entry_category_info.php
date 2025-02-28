<?php
function smarty_function_get_entry_category_info($params, &$smarty) {

	$cat = new appEntryDB();
	$cat->set_skip_auth_check();
	$cat->set_category_id($params['category_id']);
	if ($params['component']) {
		$cat->set_component($params['component']);
	}
	$category = $cat->getEntryCategory();
	$smarty->assign('category', $category);

}
?>
