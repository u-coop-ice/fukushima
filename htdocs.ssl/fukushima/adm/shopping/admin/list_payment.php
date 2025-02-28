<?php
// ページ選択用のクエリの設定

$url_queries = array("mode=list_payment");

if (isset($_POST['paid'])) {
	$view_paid = intval($_POST['paid']);

} else if (isset($_GET['paid'])) {
	$view_paid = intval($_GET['paid']);
}

if (isset($view_paid)) {
	$smarty->assign('view_paid', $view_paid);
	array_push($url_queries, "paid={$view_paid}");
}

if (isset($_POST['payment'])) {
	$view_payment = intval($_POST['payment']);

} else if (isset($_GET['payment'])) {
	$view_payment = intval($_GET['payment']);
}

if (isset($view_payment)) {
	$smarty->assign('view_payment', $view_payment);
	array_push($url_queries, "payment={$view_payment}");
}

if (isset($_POST['searchword'])) {
	$view_searchword = addslashes($_POST['searchword']);

} else if (isset($_GET['searchword'])) {
	$view_searchword = addslashes($_GET['searchword']);
}

if (isset($_POST['search_date_paid'])) {
	$view_date_paid = addslashes($_POST['search_date_paid']);

} else if (isset($_GET['date_paid'])) {
	$view_search_date_paid = addslashes($_GET['date_paid']);
}

if (isset($view_searchword)) {
	$smarty->assign('view_searchword', $view_searchword);
//	$smarty->assign('view_searchword_urlencode', urlencode($view_searchword));
	array_push($url_queries, "searchword=" . urlencode($view_searchword));
}

if (isset($view_date_paid)) {
	$smarty->assign('view_date_paid', $view_date_paid);
//	$smarty->assign('view_searchword_urlencode', urlencode($view_searchword));
	array_push($url_queries, "date_paid=" . urlencode($view_date_paid));
}

$url_query = implode('&', $url_queries);

$smarty->assign('url_query', $url_query);

if (isset($_GET['page'])) {
	$view_page = intval($_GET['page']);
	$url_query .= '&page=' . $view_page;
}

$_SESSION['shopping']['url_query'] = $url_query;

$smarty->display('list_payment.tpl');
?>
