<?php
// 削除するカテゴリーのIDを得る
if (isset($_POST['category_id'])) {
	$condition['category_id'] = intval($_POST['category_id']);
}
if ($_POST['term1']) {
	$condition['term1'] = addslashes($_POST['term1']);
}
if ($_POST['term2']) {
	$condition['term2'] = addslashes($_POST['term2']);
}

if (COMPONENT == "entry") {
	if (!$condition['category_id']) {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'アーカイブ化のためのパラメーターが不正です。');
		$smarty->display('error.tpl');
		exit();
	}
}

// カテゴリの登録をアーカイブ化する
$instance = 'admin' . ucfirst(COMPONENT) . 'DB';

try {
	$pdo->beginTransaction();

	$acv = new $instance;
	$acv->setAdminAuth($auth);
	$acv->set_condition($condition);
	$acv->saveArchived();

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '登録データのアーカイブ化に失敗しました。');
	$smarty->display('error.tpl');
	exit();
}

$query = "mode=list_app";
if ($condition['category_id']) {
	$query .= "&category_id=" . $condition['category_id'];
}
// 記事一覧のページを再度表示する
header("Location: ${self}?${query}");
exit();
?>
