<?php
// ページ選択用のクエリの設定

$statusOrderList = $smarty->getTemplateVars('statusOrderList');

$statusOrderList = array('all' => '') + $statusOrderList;

$smarty->assign('statusOrderList', $statusOrderList);

$url_queries = array("mode=list_order");

if ($_POST['status'] != "all") {

	if (isset($_POST['status'])) {
		$view_status = intval($_POST['status']);

	} else if (isset($_GET['status'])) {
		$view_status = intval($_GET['status']);
	}
	if (isset($view_status)) {
		$smarty->assign('view_status', $view_status);
		array_push($url_queries, "status={$view_status}");
	}
}

if (isset($_POST['searchword'])) {
	$view_searchword = addslashes($_POST['searchword']);

} else if (isset($_GET['searchword'])) {
	$view_searchword = addslashes($_GET['searchword']);
}

if ($view_searchword) {
	$smarty->assign('view_searchword', $view_searchword);
	array_push($url_queries, "searchword=" . urlencode($view_searchword));
}

if ($_POST['regist_date']) {
	$view_regist_date = addslashes($_POST['regist_date']);

} else if (isset($_GET['regist_date'])) {
	$view_regist_date = addslashes($_GET['regist_date']);
}

if (isset($view_regist_date)) {
	$smarty->assign('view_regist_date', $view_regist_date);
	array_push($url_queries, "regist_date=" . urlencode($view_regist_date));
}

if (isset($_REQUEST['category_id']) && is_numeric($_REQUEST['category_id'])) {
	$view_category_id = intval($_REQUEST['category_id']);
	$smarty->assign('view_category_id', $view_category_id);
	array_push($url_queries, "category_id=" . $view_category_id);
}

$url_query = implode('&', $url_queries);

$smarty->assign('url_query', $url_query);

if (isset($_GET['page'])) {
	$view_page = intval($_GET['page']);
	$url_query .= '&page=' . $view_page;
}

$_SESSION['shopping']['url_query'] = $url_query;

$smarty->display('list_order.tpl');
?>
