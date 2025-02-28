<?php
// ページ選択用のクエリの設定
//$smarty->assign('url_query', 'mode=export_excel');

set_time_limit(360);

//変数の受け取り

//$condition['app_id'] = $_POST['app_id']; //配列で受け取り

if (!count($_POST['app_id'])) {
	header("Location: $self?mode=list_exported_no_treatment&error=1");
	exit();
}

$condition['app_id'] = array_map("intval", $_POST['app_id']);

//-------------------------------------------------------------------------------------

try {
	$ssd = new adminShoppingDB();
	$ssd->setAdminAuth($auth);
	$ssd->set_condition($condition);
	$pdo->beginTransaction();
	$ssd->updateAppStatus();
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '処理に失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

header("Location: $self?mode=list_exported_no_treatment&updated=1");
exit();

?>
