<?php
// すでにログイン
if ($is_login) {
$smarty->assign('url_query', '');
$tmpl = 'item_list.tpl';
} else {
// URLの後につけるクエリ
$smarty->assign('url_query', 'mode=normal_login');
// ログインのページを表示する
$tmpl = 'login.tpl';
}
?>
