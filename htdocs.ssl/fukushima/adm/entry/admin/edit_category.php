<?php

$category_id = intval($_GET['category_id']);
$copy = intval($_GET['copy']);

$smarty->assign('copy', $copy);

try {
	$adm = new adminEntryDB();
	$adm->set_category_id($category_id);
	$category = $adm->getEntryCategory();

//	$category['method'] = json_decode($category['method'], true);
	//	$category['stock_multi'] = json_decode($category['stock_multi'], true);

/*
if (count($category['method'])) {

$method = [];

//		$smarty->assign("methods", $category['method']); //項目のテンプレート発行

foreach ($category['method'] as $key => $value) {
if ($key != 'extra') {
$method[$key] = $value['sort'];
} else {
foreach ($value as $k => $v) {
$method[$key . $k] = $v['sort'];
}
}
}

asort($method);
$smarty->assign('method', $method);

$result = "";

while (list($key, $value) = each($method)) {
$result .= "sort_" . $key . ",";
if (preg_match('/^extra/', $key)) {
$k = intval(substr($key, 5));
$extras[$key]['k'] = $k;

if ($methods['extra'][$k]['select']) {

$select = trim($methods['extra'][$k]['select']);
$select = preg_replace('/\n|\r\n/', "\n", $select);

$extras[$key]['list'] = explode("\n", $select);
}
}

}
$smarty->assign("result", $result);
$smarty->assign('extras', $extras);

}
 */

	$smarty->assign("result", $adm->get_result_category());
	$smarty->assign("method", $adm->get_method_category());
	$smarty->assign('extras', $adm->get_extras_category());

	$smarty->assign('category', $category);

	$smarty->assign('view_category_id', $category_id);

} catch (Exception $e) {

	$sql = "SELECT MAX(sort_order) AS ct FROM entry_category";

	$adm->set_sql($sql);
	$cat = $adm->selectTable();

	$category = ['id' => 0,
		'denomination' => '',
		'ordermail' => '',
		'pressmail' => '',
		'description' => '',
		'sort_order' => $cat['ct'] + 1];

	$category['method'] = [
		'sex' => array('use' => 0)
		, 'number' => array('use' => 0)
		, 'membership' => array('use' => 0)
		, 'univ' => array('use' => 0)
		, 'schoolyear' => array('use' => 0)
		, 'graduateyear' => array('use' => 0)
		, 'dept' => array('use' => 0)
		, 'age' => array('use' => 0)
		, 'major' => array('use' => 0)
		, 'new_add' => array('use' => 0)
		, 'address' => array('use' => 0)
		, 'student_phone' => array('use' => 0)
		, 'mobilephone' => array('use' => 0)
		, 'phonenumber' => array('use' => 0)
		, 'parent_name' => array('use' => 0)
		, 'bank' => array('use' => 0)
		, 'creditcard' => array('use' => 0)
		, 'ship_address' => array('use' => 0)
		, 'memo' => array('use' => 0)
		, 'agree' => array('use' => 0),
	];
	$smarty->assign('category', $category);
	$smarty->assign('new_cat', 1);
}

$smarty->assign('saved', $_GET['saved']);
$smarty->display('edit_category.tpl');
?>
