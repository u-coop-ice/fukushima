<?php

unset($_SESSION['url_query']);

$url_query = "mode=list_mail";
$queries = array();

$get_searchword = urldecode($_GET['searchword']);

// 検索機能用
$searchword = htmlspecialchars($_POST['searchword'], 3, "UTF-8");
if ($searchword) {
	$smarty->assign('view_search_word', $searchword);
} else if ($get_searchword) {
	$smarty->assign('view_search_word', $get_searchword);

}

if ($smarty->getTemplateVars('view_search_word')) {
	array_push($queries, 'searchword=' . urlencode($smarty->getTemplateVars('view_search_word')));
}

if (isset($_GET['status'])) {
	$status = intval($_GET['status']);
	$smarty->assign('view_status', $status);
}
$noreplyList = array(1 => '未対応', 2 => '対応中', 3 => '対応済');
$smarty->assign('noreplyList', $noreplyList);

if (isset($_GET['noreply'])) {
	$view_noreply = array_map('intval', $_GET['noreply']);
}

if (is_array($view_noreply)) {
	$smarty->assign('view_noreply', $view_noreply);

	foreach ($view_noreply as $noreply) {
		array_push($queries, 'noreply[]=' . $noreply);
	}
}

if (isset($_GET['app'])) {

	$view_app = htmlspecialchars($_GET['app'], 3, 'UTF-8');

	$smarty->assign('view_app', $view_app);
	array_push($queries, "app=" . $view_app);
} else if (isset($_POST['app'])) {
	$view_app = htmlspecialchars($_POST['app'], 3, 'UTF-8');

	$smarty->assign('view_app', $view_app);
	array_push($queries, "app=" . $view_app);
} else if (isset($_GET['add'])) {
	$view_add = htmlspecialchars($_GET['add'], 3, 'UTF-8');
	$smarty->assign('view_add', $view_add);
	array_push($queries, "add=" . $view_add);
} else if (isset($_POST['add'])) {
	$view_add = htmlspecialchars($_POST['add'], 3, 'UTF-8');
	$smarty->assign('view_add', $view_add);
	array_push($queries, "add=" . $view_add);
}

if (isset($_GET['category_id'])) {
	$smarty->assign('view_category_id', intval($_GET['category_id']));
	array_push($queries, "category_id=" . intval($_GET['category_id']));
} else if (isset($_GET['no_category'])) {
	$smarty->assign('view_no_category', 1);
	array_push($queries, "no_category=1");
}

// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

if (count($queries)) {
	$url_query .= '&' . implode('&', $queries);
}

// ページ選択用のクエリの設定
$smarty->assign('url_query', $url_query);

if (isset($_GET['page'])) {
	$url_query .= "&page=" . intval($_GET['page']);
}

$_SESSION['ask']['url_query'] = $url_query;

// ページを表示
$smarty->display('list_mail.tpl');
?>
