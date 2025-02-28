<?php
function smarty_function_get_card_info_payjp($params, &$smarty) {
	$card_id = $params['card_id'];
	$cust_id = $params['cust_id'];

	require_once "Classes/payjp.class.php";
	$cd = new \shopping\payjp\webCharge();

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
		$api_key = $smarty->getConfigVars('payjp_api');
	default:

	}

	$cd->setApi_key($api_key);
	$cd->setCard_id($card_id);
	$cd->setCustomer_id($cust_id);
	$card = $cd->getCard();

	if (is_array($card['err'])) {
		$smarty->assign('card_errmsg', $card['err']['errmsg']);
	}

	$smarty->assign('card', $card);

}
?>
