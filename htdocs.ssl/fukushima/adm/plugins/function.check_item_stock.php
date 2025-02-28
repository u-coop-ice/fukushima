<?php
function smarty_function_check_item_stock($params, &$smarty) {

	try {

		$app = new appShoppingDB;
		$app->set_shopping_item_id(intval($params['item_id']));
		$stock_error = $app->checkItemStock();

	} catch (Exception $e) {
		echo $e->getMessage();
		$stock_error = 0;
	}
	$smarty->assign('stock_error', $stock_error);
}
?>
