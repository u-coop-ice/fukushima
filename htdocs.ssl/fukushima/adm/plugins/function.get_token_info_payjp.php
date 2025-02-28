<?php
function smarty_function_get_token_info_payjp($params, &$smarty) {
	$token_id = $params['token_id'];

	require_once "Classes/payjp.class.php";
	$token = new \shopping\payjp\webCharge();

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

	$token->setApi_key($api_key);
	$token->setToken_id($token_id);
	$tokens = $token->getTokenInfo();

	if (is_array($tokens['err'])) {
		$smarty->assign('token_errmsg', $tokens['err']['errmsg']);
	}

//	$smarty->assign('token_expire_time', date("Y-m-d H:i:s", $tokens->expire_time));
	$smarty->assign('token', $tokens->card);

}
?>
