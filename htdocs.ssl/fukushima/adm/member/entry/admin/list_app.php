<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

// ページ選択用のクエリの設定

$url_querys = array('mode=list_app');

// URLにcat_idが指定されている
$category_id = intval($_GET['category_id']);
if ($category_id) {
	$smarty->assign('view_category_id', $category_id);
	array_push($url_querys, 'category_id=' . $category_id);
}

if (isset($_GET['archived'])) {
	$smarty->assign('view_archived', 1);
	array_push($url_querys, 'archived=1');
}

// 検索機能用
$search_word = urldecode($_GET['search_word']);
if ($search_word) {
	$smarty->assign('view_search_word', $search_word);
	array_push($url_querys, "search_word=" . $search_word);
}

$url_query = implode('&', $url_querys);

$smarty->assign('url_query', $url_query);

if (isset($_GET['page'])) {
	$smarty->assign('query', $url_query . '&page=' . intval($_GET['page']));
}

// ページを表示
$smarty->display('list_app.tpl');
?>
