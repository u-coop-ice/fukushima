<?php
// アドレスが削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

$url_queries = array('mode=list_email');

if (intval($_GET['group_id'])) {
	$view_group_id = intval($_GET['group_id']);
	$smarty->assign('view_group_id', $view_group_id);
	array_push($url_queries, 'group_id=' . $view_group_id);
}

if (addslashes($_POST['searchword'])) {
	$searchword = trim(addslashes($_POST['searchword']));
	$smarty->assign('view_searchword', $searchword);
	array_push($url_queries, 'searchword=' . urlencode($searchword));
}

$url_query = implode('&', $url_queries);

// ページ選択用のクエリの設定
$smarty->assign('url_query', $url_query);
// ページを表示
$smarty->display('list_email.tpl');
?>
