<?php
// ページ選択用のクエリの設定

$sent = intval($_GET['sent']);
$smarty->assign('sent', $sent);

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
}

$sort_order = intval($_GET['sort_order']);
if (intval($_POST['sort_order'])) {
	$sort_order = intval($_POST['sort_order']);
}
$smarty->assign('view_sort_order', $sort_order);

$get_searchword = urldecode($_GET['searchword']);

// 検索機能用
$searchword = htmlspecialchars($_POST['searchword'], ENT_QUOTES, 'UTF-8');
if ($searchword) {
	$smarty->assign('view_searchword', $searchword);
} else if ($get_searchword) {
	$smarty->assign('view_searchword', $get_searchword);

}

$query = 'mode=list_exported_no_treatment';

$queries = array();

if ($smarty->getTemplateVars('view_searchword')) {
	array_push($queries, 'searchword=' . urlencode($smarty->getTemplateVars('view_searchword')));
}

if (isset($sort_order)) {
	array_push($queries, 'sort_order=' . urlencode($sort_order));
}
if ($page) {
	array_push($queries, 'page=' . $page);
}
if (count($queries)) {
	$query .= '&' . implode('&', $queries);
}

$smarty->assign('url_query', $query);

$_SESSION['url_query'] = $query;

// ページを表示
$smarty->display('list_exported_no_treatment.tpl');
?>
