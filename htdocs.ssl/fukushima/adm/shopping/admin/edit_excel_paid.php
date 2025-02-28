<?php

// ページ選択用のクエリの設定
$smarty->assign('url_query', 'mode=export_excel_paid');

// ページを表示
$smarty->display('edit_excel_paid.tpl');

?>
