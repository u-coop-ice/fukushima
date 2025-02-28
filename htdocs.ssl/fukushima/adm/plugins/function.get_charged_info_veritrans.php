<?php
function smarty_function_get_charged_info_veritrans($params, &$smarty) {

/*	if ($params['test_mode'] == 1) {
define('CREDIT_TEST_MODE', 1);
}
 */
	$params['test_mode'] = intval($params['test_mode']);

	$carddata['charged_id'] = $params['charged_id'];
	if (isset($params['last'])) {
		$carddata['isNewerTxn'] = $params['last'];
	}
	require_once "Classes/veritrans.class.php";
	$charge = new \shopping\veritrans\webCharge();
	$charge->setApi_key($params['api_key'], $params['api_secret_key'], $params['test_mode']);
	$charge->setCard($carddata);

	$charged = $charge->getChargedInfo();
	if (is_array($charged)) {
		if (!count($charged)) {
			$smarty->assign('card_err', 'カード決済の履歴がありません。');
			return;
		}
		foreach ($charged as $ch) {
			$order_info['expired'] = $ch->getOrderStatus();
			$properOrderInfo = $ch->getproperOrderInfo();
//cvs
			$order_info['cvs_type'] = $properOrderInfo->getcvsType(); // 受付番号

			$order_info['receipt_number'] = $properOrderInfo->getreceiptNo(); // 受付番号
			$order_info['amount'] = $properOrderInfo->getamount(); // 決済金額
			$order_info['payLimit'] = $properOrderInfo->getpayLimit(); // 支払期限
			$order_info['paidDatetime'] = $properOrderInfo->getpaidDatetime(); //入金受付日時

			$transactionInfos = $ch->getTransactionInfos();
			$transactionInfo = $transactionInfos->getTransactionInfo();

			if (isset($transactionInfo) && count($transactionInfo) > 0) {

				foreach ($transactionInfo as $i => $tr) {
					$properTransactionInfo = $tr->getProperTransactionInfo();
					$result[$i]['reqCardNumber'] = $properTransactionInfo->getreqCardNumber();
					$result[$i]['cardTransactionType'] = $properTransactionInfo->getCardTransactionType(); // 決済状態

					$result[$i]['reqJpoInformation'] = $properTransactionInfo->getReqJpoInformation(); // 決済状態

					$result[$i]['txnDatetime'] = $tr->getTxnDatetime();
					$result[$i]['amount'] = $tr->getAmount(); // 金額
					$result[$i]['command'] = $tr->getCommand(); // コマンド
					$result[$i]['mstatus'] = $tr->getMstatus(); // ステータスコード

//csv
					$result[$i]['cvsTxnType'] = $properTransactionInfo->getcvsTxnType(); //取引対象タイプ
					$result[$i]['startDatetime'] = $properTransactionInfo->getstartDatetime(); //取引日時

					if ($result[$i]['mstatus'] == 'success') {
						if ($result[$i]['cvsTxnType'] == "fix_capture") {
							$has_captured = 1;
						} else if ($result[$i]['cvsTxnType'] == "cancel_capture") {
							$has_expired = 1;
						} else if ($result[$i]['cvsTxnType'] == "cancel_authorize") {
							$has_expired = 1;
						}

						if ($result[$i]['cardTransactionType'] == "pa" || $result[$i]['cardTransactionType'] == "ac") {
							$has_captured = 1;
						} else if ($result[$i]['cardTransactionType'] == "va" || $result[$i]['cardTransactionType'] == "rad" || $result[$i]['cardTransactionType'] == "rae") {
							$has_expired = 1;
						}
						if ($result[$i]['cardTransactionType'] == "a") {
							$result[$i]['cardExpire'] = $ch->getProperOrderInfo()->getCardExpire();
							$result[$i]['expire_time'] = date('Y-m-d H:i:s', strtotime($result[$i]['txnDatetime']) + (60 * 60 * 24 * 60));
						}
					}
					$last_transaction = $result[$i]['cardTransactionType'];
					$last_transaction_cvs = $result[$i]['cvsTxnType'];
				}
			}
		}
	}

	if ($order_info['expired'] == "expired") {
		$has_expired = 1;
	}
/*
if (is_array($charged['err'])) {
$smarty->assign('charged_errmsg', $charged['err']['errmsg']);
}
if ($charged->paid) {

if ($charged->captured) {
if ($charged->amount_refunded) {

if ($charged->amount_refunded == $charges->amount) {
$charged_status = 9;

} else {
$charged_status = 8;

}

} else {
$charged_status = 1;
}
} else {
if ($charged->amount_refunded) {

if ($charged->amount_refunded == $charges->amount) {
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
 */
	$smarty->assign('order_info', $order_info);

	$smarty->assign('charged', $result);
	if ($has_expired) {
		$smarty->assign('has_expired', 1);
	} else if ($has_captured) {
		$smarty->assign('has_captured', 1);
	}

	$smarty->assign('last_transaction', $last_transaction);
	$smarty->assign('last_transaction_cvs', $last_transaction_cvs);

}
?>
