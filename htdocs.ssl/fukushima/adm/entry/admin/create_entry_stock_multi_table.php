<?php
try {

	$result = [];

	try {
		$adm = new adminEntryDB;
		$adm->create_entry_stock_multi_table();

	} catch (Exception $e) {
		throw new Exception($e->getMessage(), 1);
	}

} catch (Exception $e) {
	$result['error'] = 1;
	$result['errmsg'] = $e->getMessage();
}
echo json_encode($result);
exit();
?>
