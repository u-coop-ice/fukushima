<?php

// URLから記事のIDを得る
$app_id = intval($_GET['app_id']);
// IDが指定されていれば、それを変数view_app_idに設定する

if ($app_id) {
	$smarty->assign('view_app_id', $app_id);

	if (isset($_GET['archived'])) {
		$smarty->assign('view_archived', 1);
	}

	$ap = new adminEntryDB;
	$ap->set_app_id($app_id);
	$appinfo = $ap->getAppInfoArranged();

	$smarty->assign('app', $appinfo);
	$smarty->assign('methods', $appinfo['methods']);
	$smarty->assign('method', $appinfo['method']);
	$smarty->assign('extras', $appinfo['extras']);

}
// IDが指定されていなければ、新規記事を作成するモードにする
else {
	$smarty->assign('new', 1);
}

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$smarty->assign('saved', $_GET['saved']);
// 記事編集ページを表示する
$smarty->display('show_app.tpl');
exit();
?>
