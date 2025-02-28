<?php
function smarty_function_get_customer_info_veritrans($params, &$smarty) {
	$customer_id = $params['cust_id'];

	require_once "Classes/veritrans.class.php";
	$wc = new \shopping\veritrans\webCharge();

/*
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
 */

	$api_key = $smarty->getConfigVars('veritrans_api');
	$api_secret_key = $smarty->getConfigVars('veritrans_secret_api');
	$params['test_mode'] = intval($params['test_mode']);

	$wc->setApi_key($api_key, $api_secret_key, $params['test_mode']);
	$wc->setCustomer_id($customer_id);

	$cardList = $wc->getCustomerInfo();
	if (is_array($cardList['err'])) {
		$smarty->assign('cust_errmsg', $cardList['err']['errmsg']);
		return;
	}

	$smarty->assign('cardList', $cardList);

}
?>
