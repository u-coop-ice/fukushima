<?php
try {
	$pdo->beginTransaction();
	$adm = new adminShoppingDB;
	$adm->setAdminAuth($auth);
	$adm->saveRefund();
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
}

if ($smarty->getTemplateVars('errmsg')) {
	header("Location: $self?mode=show_order&app_id=" . $adm->get_app_id() . "&cancelled=2");
} else {
	header("Location: $self?mode=show_order&app_id=" . $adm->get_app_id() . "&cancelled=1");
}
exit();

$postdata['app_id'] = $_POST['app_id'];
if (isset($_POST['amount'])) {
	$postdata['amount'] = $_POST['amount'];
}
$postdata['charged_id'] = $_POST['charged_id'];

$sql = <<< HERE
SELECT a.charged_id as `charged_id`,
a.`payment` as `payment`,
r.`email` as `email`,
r.`namef` as `namef`,
r.`nameg` as `nameg`,
r.`id` as `regist_id`,
r.`univ_id` as `univ_id`,
r.`status` as `status`,
a.`id` as `app_id`,
a.`status` as `app_status`,
a.`payment_confirmed` as `payment_confirmed`,
a.`date_returned` as `date_returned`,
c.infocode as category_infocode,
c.name as category_name,
c.ordermail as category_ordermail

 FROM app as a
LEFT JOIN regist as r ON a.regist_id = r.id
LEFT JOIN sp_category as c ON a.category_id = c.id

WHERE a.id = :app_id

HERE;

if (!count($postdata)) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'カード課金情報が見当たりません。');
	$smarty->display('error.tpl');
	exit();
}

try {
	$res = $pdo->prepare($sql);
	$res->execute(array(':app_id' => $postdata['app_id']));
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}

$app = $res->fetch();

if (!$app['charged_id']) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'カード課金情報が見当たりません。');
	$smarty->display('error.tpl');
	exit();
}

if ($app['payment'] == 4) {
	require_once "payjp.class.php";
	$ch = new \shopping\payjp\webCharge();

	$card['charged_id'] = $app['charged_id'];
	if (isset($postdata['amount']) && $postdata['amount'] < 0) {
		$card['amount'] = $postdata['amount'] * (-1);
	}

	$ch->setCard($card);

	$refund = $ch->refund();
	$app['date_paid'] = date("Y-m-d H:i:s", time());
	$app['amount'] = $postdata['amount'];

	if (is_array($refund['err'])) {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('card_err', $refund['err']['errmsg']);
		$smarty->assign('view_app_id', $app['app_id']);
		$smarty->display('show_order.tpl');
		exit();
	}
}

if ($smarty->getTemplateVars('err') == '') {

	$app['auth_username'] = $auth_username;
	$app['id'] = $app['app_id'];
	$app['payment_confirmed'] = $app['amount'];

	try {

//トランザクション開始

		$pdo->beginTransaction();

		if ($app['app_id']) {
			//DBへ書き込み

			$set = new shoppingDB();
			$set->set_postdata($app);

			$payment = $set->savePayment();

		}

		if (!$errmsg) {

//ログに書き込む

			$app['process'] = 'save_cancel';
			$app['value'] = $app['amount'];

			$setlog = new adminDB();
			$setlog->set_postdata($app);

			$setlog->insertAdminLog();

			$setOptSM = new shoppingDB();
			$setOptSM->set_app_id($app['app_id']);
			$payment = $setOptSM->updateOptSendmail();

		}
		$pdo->commit();

	} catch (Exception $e) {
		$pdo->rollBack();
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'カードの返金処理は成功しましたが、データベースの処理に失敗しました。');
		$smarty->assign('view_app_id', $app['app_id']);
		$smarty->display('show_order.tpl');
		exit();

	}

	require_once "send_mail.php";

	$smarty->assign('regist_namef', $app['namef']);
	$smarty->assign('regist_nameg', $app['nameg']);
	$smarty->assign('regist_status', $app['status']);
	$smarty->assign('view_app_id', $app['app_id']);
	$smarty->assign('app_status', $app['app_status']);

//CODEの作成
	$adic = md5($app['category_infocode'] . $app['email'] . time() . mt_rand());
	$app['code'] = $adic;
	$smarty->assign('adic', $adic);

	$app['send'] = 1;
	$app['auto_send'] = 1;
	$app['noreply'] = 1;
	$app['date'] = date('Y-m-d H:i:s');
	$app['subject'] = 'クレジットカード決済の返金処理が完了いたしました【' . $app["category_name"] . '】';

	$app['process'] = 'save_cancel';
	$smarty->assign('post_amount', $app['amount'] * (-1));
	$smarty->assign('category_name', $app['category_name']);

	$app['memo'] = $smarty->fetch('shop_cancelled_mail.tpl');
	$app['add'] = 'save_cancel';

	$app['sendmail_paid_completed'] = 1;

/*
$arg['univ_id'] = $app['univ_id'];
$arg['user_id'] = $app['user_id'];
$arg['add_code'] = $app['code'];
 */
	$replymail = "DO_NOT_REPLY@u-coop.or.jp";

	send_mail($init_coopname, $replymail, $app['email'], $app['subject'], $app['memo']);

	$init_ordermail = $smarty->getTemplateVars('init_ordermail');

	if ($app['category_ordermail']) {
		$init_ordermail = $app['category_ordermail'];
	}

	send_mail($init_coopname, $replymail, $init_ordermail, '【コピー】' . $app['subject'], "【newlifeシステムからユーザーへ送信した内容のコピーです。】\n\n" . $app['memo']);

//app_add

	$add = new setDB();

	$fields_add = array(
		'app_id' => 'integer',
		'regist_id' => 'integer',
		'subject' => 'text',
		'memo' => 'text',
		'add' => 'text',
		'send' => 'integer',
		'auto_send' => 'integer',
		'noreply' => 'integer',
		'code' => 'text',
		'date' => 'text',
	);

	$add->set_fields($fields_add);
	$add->set_tbl('app_add');

	$add->set_postdata($app);
	$add->insertTable();

}

// 再度表示する
if ($smarty->getTemplateVars('errmsg')) {
	header("Location: $self?mode=show_order&app_id=" . $app['app_id'] . "&cancelled=2");
} else {
	header("Location: $self?mode=show_order&app_id=" . $app['app_id'] . "&cancelled=1");
}
?>
