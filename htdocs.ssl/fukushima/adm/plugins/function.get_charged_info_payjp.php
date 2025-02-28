<?php
function smarty_function_get_charged_info_payjp($params, &$smarty) {
	$charged_id = $params['charged_id'];

	require_once "Classes/payjp.class.php";
	$charge = new \shopping\payjp\webCharge();
	$api_key = $params['api_key'];
	$charge->setApi_key($api_key);
	$charge->setCharged_id($charged_id);

	$charged = $charge->getChargedInfo();

	$smarty->assign('charged_expire_time', date("Y-m-d H:i:s", $charged->expired_at));
	$smarty->assign('charged_type', $charged->card->brand);
	$smarty->assign('charged_last4', $charged->card->last4);
	$smarty->assign('charged_exp_month', $charged->card->exp_month);
	$smarty->assign('charged_exp_year', $charged->card->exp_year);
	$smarty->assign('charged_name', $charged->card->name);
	$smarty->assign('charged_paid', $charged->paid);
	$smarty->assign('charged_refunded', $charged->refunded);
	$smarty->assign('charged_amount', $charged->amount);
	$smarty->assign('charged_amount_refunded', $charged->amount_refunded);
	$smarty->assign('charged_amount_real', $charged->amount - $charged->amount_refunded);

	$smarty->assign('charged_refund_reason', $charged->refund_reason);
	$smarty->assign('charged_captured', $charged->captured);
	$smarty->assign('charged_captured_time', date("Y-m-d H:i:s", $charged->captured_at));

	if (is_array($charged['err'])) {
		$smarty->assign('charged_errmsg', $charged['err']['errmsg']);
	}

	if ($charged->paid) {

		if ($charged->captured) {
			if ($charged->amount_refunded) {

				if ($charged->amount_refunded == $charged->amount) {
					$charged_status = 9;
				} else {
					$charged_status = 8;

				}

			} else {
				$charged_status = 1;
			}
		} else {
			if ($charged->amount_refunded) {

				if ($charged->amount_refunded == $charged->amount) {
					$charged_status = -9;

				} else {
					$charged_status = -1;

				}

			} else {
				$charged_status = 0;
			}
		}
	}

	$smarty->assign('charged_status', $charged_status);

}
?>
