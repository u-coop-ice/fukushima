<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

// ページ選択用のクエリの設定

$url_query = 'mode=list_admin_log';

// URLにuniv_idが指定されている
$univ_id = intval($_GET['uid']);
if ($univ_id) {
	$smarty->assign('view_univ_id', $univ_id);
	$url_query .= '&uid=' . $univ_id;
}

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

// URLにcidが指定されている
$category_id = intval($_GET['cid']);
if ($category_id) {
	$smarty->assign('view_cat_id', $category_id);
	$url_query .= '&cid=' . $category_id;
}

// URLに日付が指定されている
$year = intval($_GET['year']);
if ($year) {
	$smarty->assign('view_year', $year);
	$url_query .= '&year=' . $year;
}
$month = intval($_GET['month']);
if ($month) {
	$smarty->assign('view_month', $month);
	$url_query .= '&month=' . $month;
}
$day = intval($_GET['day']);
if ($day) {
	$smarty->assign('view_day', $day);
	$url_query .= '&day=' . $day;
}

$time = stripslashes($_GET['time']);
if ($time) {
	$smarty->assign('view_time', $time);
	$url_query .= '&time=' . $time;
}

$smarty->assign('url_query', $url_query);

// ページを表示
$smarty->display('list_admin_log.tpl');

?>
