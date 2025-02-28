<?php
function smarty_function_get_token_info($params, &$smarty) {
	$token_id = $params['token_id'];
	$webpay_api = $smarty->getConfigVars('webpay_api');
	$webpay_url = $smarty->getConfigVars('webpay_url');

	require_once "webCharge.class.php";

	$token = new webCharge();

	$token->setApi($webpay_api);
	$token->setApiBase($webpay_url);
	$token->setToken_id($token_id);

	$tokens = $token->getTokenInfo();

//	$smarty->assign('token_expire_time', date("Y-m-d H:i:s", $tokens->expire_time));
	$smarty->assign('token_type', $tokens->card->type);
	$smarty->assign('token_last4', $tokens->card->last4);
	$smarty->assign('token_exp_month', $tokens->card->exp_month);
	$smarty->assign('token_exp_year', $tokens->card->exp_year);
	$smarty->assign('token_name', $tokens->card->name);
//	$smarty->assign('token_errmsg', $tokens['token_errmsg']);

}
?>
