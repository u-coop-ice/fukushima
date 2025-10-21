<?php
// ページ選択用のクエリの設定
$smarty->assign('url_query', 'mode=export_excel');

// ページを表示
$smarty->display('edit_excel.tpl');

?>
