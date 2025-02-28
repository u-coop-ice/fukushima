<?php
function smarty_function_get_customer_info_payjp($params, &$smarty) {
	$customer_id = $params['cust_id'];

	require_once "Classes/payjp.class.php";
	$wc = new \shopping\payjp\webCharge();

	switch (COMPONENT) {
	case 'shopping':

		$ct = new appShoppingDB;
		$init_category = $ct->getShoppingCategory();

		if ($init_category['test_mode'] == 1) {
			$api_key = $smarty->getConfigVars('payjp_api_test');
		} else {
			$api_key = $smarty->getConfigVars('payjp_api');
		}

		break;
	default:
		$api_key = $smarty->getConfigVars('payjp_api_test');

	}

	$wc->setApi_key($api_key);
	$wc->setCustomer_id($customer_id);

	$customer = $wc->getCustomerInfo();
//	var_dump($cards);

	if (is_array($customer['err'])) {
		$smarty->assign('cust_errmsg', $customer['err']['errmsg']);
		return;
	}

	$smarty->assign('customer', $customer);
	$smarty->assign('cards', $customer->cards->data);

/*
$smarty->assign('cust_type', $card->brand);
$smarty->assign('cust_last4', $card->last4);
$smarty->assign('cust_exp_month', $card->exp_month);
$smarty->assign('cust_exp_year', $card->exp_year);
$smarty->assign('cust_name', $card->name);
 */

}
?>
