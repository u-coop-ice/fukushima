<?php
// 商品が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}

$url_query = "mode=list_item";

if (intval($_GET['cid'])) {
	$smarty->assign('view_category_id', intval($_GET['cid']));
	$url_query .= "&cid=" . intval($_GET['cid']);
} else if (intval($_GET['scid'])) {
	$smarty->assign('view_subcategory_id', intval($_GET['scid']));
	$url_query .= "&scid=" . intval($_GET['scid']);
} else if (intval($_GET['s2cid'])) {
	$smarty->assign('view_sub2category_id', intval($_GET['s2cid']));
	$url_query .= "&s2cid=" . intval($_GET['s2cid']);
}

if (htmlspecialchars($_POST['search_word'], 3, 'UTF-8')) {
	$smarty->assign('view_search_word', htmlspecialchars($_POST['search_word'], 3, 'UTF-8'));
}

// ページ選択用のクエリの設定
$smarty->assign('url_query', $url_query);
// ページを表示
$smarty->display('list_item.tpl');
?>
