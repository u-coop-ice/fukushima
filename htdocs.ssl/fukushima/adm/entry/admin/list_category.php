<?php
$url_querys = array('mode=list_category');

// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

if (intval($_GET['archived'])) {
	$smarty->assign('view_archived', 1);
	array_push($url_querys, 'archived=1');
}

if (isset($_GET['search_word']) && ($_GET['search_word'])) {
	$view_search_word = trim($_GET['search_word']);
	$view_search_word = addslashes($view_search_word);
	$smarty->assign('view_search_word', $view_search_word);
	array_push($url_querys, 'search_word=' . urlencode($view_search_word));
}

$url_query = implode('&', $url_querys);

$smarty->assign('url_query', $url_query);

if (isset($_GET['page'])) {
	$url_query .= '&page=' . intval($_GET['page']);
}

$_SESSION[COMPONENT] = $url_query;

// ページを表示
$smarty->display('list_category.tpl');
?>
