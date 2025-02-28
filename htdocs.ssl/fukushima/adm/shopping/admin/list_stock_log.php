<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

// ページ選択用のクエリの設定

$url_query = 'mode=list_stock_log';

// 検索機能用
$search_word = htmlspecialchars($_POST['search_word'], 3, 'UTF-8');
if ($search_word) {
	$smarty->assign('view_search_word', $search_word);
}

// URLにappが指定されている
$app = htmlspecialchars($_GET['app'], 3, 'UTF-8');
if ($app) {
	$smarty->assign('view_app', $app);
	$url_query .= '&app=' . $app;
}

$smarty->assign('url_query', $url_query);

// ページを表示
$smarty->display('list_stock_log.tpl');

?>
