<?php
// 削除する登録のIDを得る
$app_id = intval($_POST['id']);
$query = addslashes($_POST['query']);

// 登録を削除する

try {
	$pdo->beginTransaction();

	$del = new adminEntryDB();
	$del->setAdminAuth($auth);
	$del->set_app_id($app_id);
	$del->deleteApp();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '登録データの削除に失敗しました。');
	$smarty->display('error.tpl');
	exit();
}

// 記事一覧のページを再度表示する
header("Location: ${self}?${query}&deleted=1");
?>
