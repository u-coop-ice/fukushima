<?php

$url_query = "mode=list_mail";
$queries = array();

if (count($queries)) {
	$url_query .= '&' . implode('&', $queries);
}

if (isset($_GET['page'])) {
	$url_query .= "&page=" . intval($_GET['page']);
}

// ページ選択用のクエリの設定
$smarty->assign('url_query', $url_query);

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$smarty->assign('saved', intval($_GET['saved']));
$smarty->assign('cancelled', intval($_GET['cancelled']));
// 記事編集ページを表示する
$smarty->display('list_mail.tpl');

?>
