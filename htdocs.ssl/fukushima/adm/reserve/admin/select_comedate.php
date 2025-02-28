<?php

$category_id = intval($_REQUEST['category_id']);
$condition['opt_cancelled'] = intval($_REQUEST['opt_cancelled']);

$select = "";
if ($category_id) {
	try {
		$adm = new adminReserveDB;
		$adm->set_category_id($category_id);
		$adm->set_condition($condition);
		$comedays = $adm->getArchiveAppComedate();

		if (count($comedays)) {
			$select = '<select class="form-control" name="comedate"><option value=""></option>';
			foreach ($comedays as $comeday) {
				$select .= '<option vale="' . $comeday['comedate'] . '">' . $comeday['comedate'] . '</option>';
			}
			$select .= '</select>';
		}

	} catch (Exception $e) {
		$result['error'] = $e->getMessage();
	}
}
$result['select'] = $select;

echo json_encode($result);
exit;

?>
