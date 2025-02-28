<?php
// 記事が削除された場合は、そのことを変数に設定する

$smarty->assign('saved', $_GET['saved']);
// ページを表示
$smarty->display('edit_site_setting.tpl');
?>
