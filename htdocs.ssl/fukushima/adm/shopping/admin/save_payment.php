<?php

$payment = [];

$paiddata['app_id'] = intval($_POST['app_id']);
$paiddata['payment_confirmed'] = intval($_POST['payment_confirmed'][$paiddata['app_id']]);

$paiddata['date'] = date('Y-m-d H:i:s');
$paiddata['payment'] = intval($_POST['payment']);

if (isset($_POST['date_returned'][$paiddata['app_id']])) {
	$paiddata['date_returned'] = $_POST['date_returned'][$paiddata['app_id']];
	$fields['date_returned'] = 'text';
	$paiddata['memo'] = $paiddata['date_returned'];
} else if (isset($_POST['date_paid'][$paiddata['app_id']])) {
	$paiddata['date_paid'] = $_POST['date_paid'][$paiddata['app_id']];
	$fields['date_paid'] = 'text';
	$paiddata['memo'] = $paiddata['date_paid'];
}

if (!$paiddata['payment_confirmed']) {
	$payment['errmsg'] = 1;
	echo json_encode($payment);

	exit();
}

try {

//トランザクション開始

	$pdo->beginTransaction();

	if ($paiddata['app_id']) {
		//DBへ書き込み

		$paiddata['auth_username'] = $auth_username;
		$paiddata['id'] = $paiddata['app_id'];

		$set = new adminShoppingDB();
		$set->setAdminAuth($auth);
		$set->set_app_id($paiddata['app_id']);
		$set->set_postdata($paiddata);

		$payment = $set->savePayment();
	}

	$pdo->commit();
	echo json_encode($payment);
	exit();

} catch (Exception $e) {
	$pdo->rollBack();
	$payment['errmsg'] = $e->getMessage();
	$payment['err'] = 2;
	echo json_encode($payment);
	exit();

}

exit();

?>
