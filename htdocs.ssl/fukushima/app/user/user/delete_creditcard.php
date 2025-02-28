<?php
// 削除するカテゴリーのIDを得る
$changedata['cust_id'] = $userAuth->getAuthData('cust_id');
$changedata['card_id'] = addslashes($_POST['card_id']);

try {
	$pdo->beginTransaction();

	$del = new appUserDB();
	$del->setAuth($userAuth);
	$del->set_site_api_key($smarty->getConfigVars('payjp_api_test'));
	$del->set_postdata($changedata);
	$del->deleteCreditCard();

	$pdo->commit();

} catch (Exception $e) {
	$pdo = rollBack();
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
header("Location: $self?mode=edit_creditcard&deleted=1");

exit();

?>
