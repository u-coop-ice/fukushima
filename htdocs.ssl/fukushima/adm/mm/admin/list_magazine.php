<?php
// 記事が削除された場合は、そのことを変数に設定する

$queries = array();
$url_query = 'mode=list_magazine';

$view_group_id = intval($_GET['group_id']);
$view_status = addslashes($_GET['status']);

if ($_GET['onetime'] == 1) {
	$view_onetime = 1;
}

$smarty->assign('view_group_id', $view_group_id);
$smarty->assign('view_status', $view_status);
$smarty->assign('view_onetime', $view_onetime);

if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

if (addslashes($_POST['searchword'])) {
	$searchword = trim(addslashes($_POST['searchword']));
	$smarty->assign('view_searchword', $searchword);
	array_push($queries, "searchword={$view_searchword}");
}

if ($view_group_id) {
	array_push($queries, "group_id={$view_group_id}");
} else if ($view_onetime) {
	array_push($queries, "onetime=1");
}
if ($view_status) {
	array_push($queries, "status={$view_status}");
}
if (count($queries)) {
	$url_query .= '&' . implode('&', $queries);
}

$smarty->assign('url_query', $url_query);

// ページを表示
$smarty->display('list_magazine.tpl');
?>
