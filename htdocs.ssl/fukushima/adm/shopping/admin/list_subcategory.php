<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
    $smarty->assign('deleted', 1);
}

// ページを表示
$smarty->display('list_subcategory.tpl');
?>
