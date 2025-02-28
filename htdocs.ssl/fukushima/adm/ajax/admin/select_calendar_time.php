<?php

$set_date = htmlspecialchars($_POST["date"], 3, 'UTF-8');

$pre_date = htmlspecialchars($_POST["pre_date"], 3, 'UTF-8');
$pre_time = htmlspecialchars($_POST["pre_time"], 3, 'UTF-8');

$selected = htmlspecialchars($_POST["selected"], 3, 'UTF-8');
$category_id = intval($_POST["category_id"]);
$component = addslashes($_POST["component"]);

if ($set_date == $pre_date) {
	if ($pre_date && $pre_time) {
		$pre = new adminAjaxDB();
		$pre->set_category_id($category_id);
		$pre->set_component($component);
		$pre->set_cometime($pre_time);
		$pre->set_comedate($pre_date);
		$pre_scd = $pre->get_my_select();

	}
}

$sc = new adminAjaxDB();
$sc->set_category_id($category_id);
$sc->set_component($component);
$sc->set_selected($selected);
$sc->set_comedate($set_date);
if (isset($pre_scd) && $pre_scd) {
	$sc->set_pre_scd($pre_scd);
}
$select = $sc->getOptionTime();
echo ($select);
?>
