<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}
// ページ選択用のクエリの設定

$url_query = 'mode=list_regist';

// URLにappが指定されている
$app = htmlspecialchars($_GET['app'], 3, "UTF-8");
if ($app) {
	$smarty->assign('view_app', $app);
	$url_query .= '&app=' . $app;
}

// URLにstausが指定されている
$status = intval($_GET['status']);
if ($status) {
	$smarty->assign('view_status', $status);
	$url_query .= '&status=' . $status;
}

if (isset($_GET['dm'])) {
	$view_dm = intval($_GET['dm']);
	$smarty->assign('view_dm', $view_dm);
	$url_query .= '&dm=' . $view_dm;
}

// 検索機能用
$searchword = htmlspecialchars($_GET['searchword'], 3, "UTF-8");
if ($searchword) {
	$smarty->assign('view_searchword', $searchword);
	$url_query .= '&searchword=' . urlencode($searchword);
}

$smarty->assign('url_query', $url_query);

// ページを表示
$smarty->display('list_regist.tpl');
?>
