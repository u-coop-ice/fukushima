<?php

// ページ選択用のクエリの設定
$smarty->assign('url_query', 'mode=export_excel_dev');

// ページを表示
$smarty->display('edit_excel_dev.tpl');

?>
