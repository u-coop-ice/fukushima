<?php

$changedata = HTTP_Session2::get('changedata');

if ($changedata['complete']) {
	HTTP_Session2::set('changedata', null);
	header("Location:$self");
	exit();
}

if (!$_POST['token_id']) {
	HTTP_Session2::set('errmsg', 'カード情報が入力されていません。');
	header("Location: $self?mode=edit_creditcard");
	exit();
}

$changedata['cust_id_veritrans'] = $userAuth->getAuthData('cust_id_veritrans');
$changedata['token_id'] = addslashes($_POST['token_id']);

try {
	$pdo->beginTransaction();

	$add = new appUserDB();
	$add->setAuth($userAuth);
	$add->set_site_api_key($smarty->getConfigVars('veritrans_api'), $smarty->getConfigVars('veritrans_secret_api'));
	$add->set_paymentdata($changedata);
	$add->addCreditCard();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
header("Location: $self?mode=edit_creditcard&saved=1");

exit();

?>
