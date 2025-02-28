<?php
// ページ選択用のクエリの設定
$smarty->assign('url_query', 'mode=export_excel');

/*
$arc = new adminReserveDB;
$arc->set_before(30);
$calendar = $arc->get_calendar();

$dateList = array_column($calendar, 'date');
$smarty->assign('dateList', $dateList);
 */
// ページを表示
$smarty->display('edit_excel.tpl');

?>
