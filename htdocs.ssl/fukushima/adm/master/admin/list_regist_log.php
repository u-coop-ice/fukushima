<?php

unset($_SESSION['url_query']);

$url_query = "mode=list_regist_log";
$queries = array();

$get_searchword = urldecode($_GET['searchword']);
$get_searchword = strip_tags($get_searchword);

if ($_GET['kind']) {
	$view_kind = strip_tags($_GET['kind']);
	$smarty->assign('view_kind', $view_kind);
}
// 検索機能用
$searchword = htmlspecialchars($_POST['searchword'], ENT_QUOTES, 'UTF-8');
if ($searchword) {
	$smarty->assign('view_search_word', $searchword);
} else if ($get_searchword) {
	$smarty->assign('view_search_word', $get_searchword);

}

if ($smarty->getTemplateVars('view_search_word')) {
	array_push($queries, 'searchword=' . urlencode($smarty->getTemplateVars('view_search_word')));
}

if (isset($view_kind)) {
	array_push($queries, 'kind=' . $view_kind);
}

if (count($queries)) {
	$url_query .= '&' . implode('&', $queries);
}

if (isset($_GET['page'])) {
	$url_query .= "&page=" . intval($_GET['page']);
}

// ページ選択用のクエリの設定
$smarty->assign('url_query', $url_query);

$_SESSION['url_query'] = $url_query;

$sql = <<< HERE
select regist_log.kind FROM ${pfx2}regist_log GROUP BY regist_log.kind

HERE;

try {
	$res = $pdo->prepare($sql);
	$res->execute($data);
} catch (PDOException $e) {
	var_dump($e);
	// データベースアクセスに失敗したらエラーとする
	$smarty->assign('db_error', 1);
	$repeat = false;
	return;
}

$kinds = array("" => "");
// カテゴリーを配列に読み込む
while ($kind = $res->fetch()) {
	array_push($kinds, $kind['kind']);
}

$smarty->assign('logKindList', $kinds);

// ページを表示
$smarty->display('list_regist_log.tpl');
?>
