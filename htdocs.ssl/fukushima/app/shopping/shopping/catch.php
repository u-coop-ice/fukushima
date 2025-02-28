<?php
try {
//トランザクション開始
	$pdo->query("SET innodb_lock_wait_timeout=60;");
	$pdo->beginTransaction();

//申込完了を踏んでいるか判定
	$shipdata = HTTP_Session2::get('shipdata');

	$app = new appShoppingDB();
	$app->setAuth($userAuth);

	$send = $app->catchPayment3D();

	$pdo->commit();

} catch (Exception $e) {

	$shipdata['token_id'] = null;
	$shipdata['payjp-token'] = null;
	$shipdata['req_card_number'] = null;
	$shipdata['charged_id'] = null;
	$shipdata['api_key'] = null;
	$shipdata['api_secret_key'] = null;
	$shipdata['test_mode'] = null;
	$shipdata['receipt_number'] = null;
	$shipdata['payment_limit'] = null;
	$shipdata['jpo'] = null;
	$shipdata['org_number'] = null;
	$shipdata['customer_number'] = null;
	$shipdata['confirm_number'] = null;
	$shipdata['netbanking_url'] = null;
	$shipdata['response_contents'] = null;
	$shipdata['app_id'] = null;
	HTTP_Session2::set('shipdata', $shipdata);

	switch ($e->getCode()) {
	case '4':

		$pdo->commit();
		$request = $app->get_request();

//トランザクション開始
		try {
			$pdo->query("SET innodb_lock_wait_timeout=60;");
			$pdo->beginTransaction();

			$smarty->assign('card_err', $e->getMessage());
			$smarty->assign('card_err_code', $request['vResultCode']);
// 本人認証エラーがあったら、入力のページを再度表示

			$log = new appShoppingDB();
			$logdata['kind'] = 'card_error_' . COMPONENT;
			if ($userAuth->getUsername()) {
				$logdata['username'] = $userAuth->getUsername();
			} else {
				$logdata['username'] = $shipdata['email'];
			}
			$logdata['result'] = 0;
			$logdata['value'] = $smarty->getTemplateVars('card_err_code');
			$log->setLogdata($logdata);
			$log->insertLog();

			$pdo->commit();

		} catch (Exception $e) {
			$pdo->rollBack();
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', 'お申込みの処理に失敗しました。' . $e->getMessage());
			$smarty->display('error.tpl');
			exit();
		}

		$shipdata['total_price_all'] = $shipdata['price_total'];
		$smarty->assign('post', $shipdata);

		if (is_array($cart['items']) && count($cart['items']) > 0) {
			$tmpl = 'shop_step3.tpl';
		} else {
			$tmpl = 'error_catch.tpl';
		}

		$smarty->display($tmpl);
		exit();

		break;

	default:
		$pdo->rollBack();
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お申込みの処理に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}

}

// カートを空にする
$shipdata['complete'] = 1;
$cart['items'] = [];
$cart['methods'] = [];

HTTP_Session2::set('cart' . PART, $cart);
HTTP_Session2::set('shipdata', $shipdata);

$self .= '?mode=complete';
header("Location: $self");

exit();
?>
