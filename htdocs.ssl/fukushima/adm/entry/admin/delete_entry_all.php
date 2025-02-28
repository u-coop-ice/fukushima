<?php
// ページ選択用のクエリの設定
$smarty->assign('url_query', 'mode=delete_entry_all');

// ページを表示
$smarty->display('delete_entry_all.tpl');

?>
