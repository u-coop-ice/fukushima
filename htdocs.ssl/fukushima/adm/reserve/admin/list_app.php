<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

// ページ選択用のクエリの設定

$url_queries = array('mode=list_app');
$return_queries = array('mode=show_calendar');
// URLに日付が指定されている

$category_id = intval($_GET['category_id']);
if ($category_id) {
	$smarty->assign('view_category_id', $category_id);
	array_push($url_queries, 'category_id=' . $category_id);
	array_push($return_queries, 'category_id=' . $category_id);
}

$adm = new adminReserveDB;
$adm->set_category_id($category_id);
$category = $adm->getEntryCategory();
$smarty->assign('category', $category);

$year = intval($_GET['year']);
if ($year) {
	$smarty->assign('view_year', $year);
	array_push($url_queries, 'year=' . $year);
	array_push($return_queries, 'year=' . $year);
}
$month = intval($_GET['month']);
if ($month) {
	$smarty->assign('view_month', $month);
	array_push($url_queries, 'month=' . $month);
	array_push($return_queries, 'month=' . $month);
}
$day = intval($_GET['day']);
if ($day) {
	$smarty->assign('view_day', $day);
	array_push($url_queries, 'day=' . $day);
}

$time = stripslashes($_GET['time']);
if ($time) {
	$smarty->assign('view_time', $time);
	array_push($url_queries, 'time=' . $time);
}

if (isset($_GET['archived'])) {
	$smarty->assign('view_archived', 1);
	array_push($url_queries, 'archived=1');
}

// 検索機能用
$search_word = urldecode($_GET['search_word']);
if ($search_word) {
	$smarty->assign('view_search_word', $search_word);
	array_push($url_queries, "search_word=" . $search_word);
}

$url_query = implode('&', $url_queries);
$return_query = '?' . implode('&', $return_queries);

$smarty->assign('url_query', $url_query);

if (isset($_GET['page'])) {
	$smarty->assign('query', $url_query . '&page=' . intval($_GET['page']));
}

$smarty->assign('return_query', $return_query);

$_SESSION[COMPONENT] = $url_query;

// ページを表示
$smarty->display('list_app.tpl');
?>
