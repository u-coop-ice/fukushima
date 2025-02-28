<?php

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$smarty->assign('saved', intval($_GET['saved']));
$smarty->assign('cancelled', intval($_GET['cancelled']));
// 記事編集ページを表示する

$smarty->assign('url_query', 'mode=list_app');
$smarty->display('list_app.tpl');

?>
