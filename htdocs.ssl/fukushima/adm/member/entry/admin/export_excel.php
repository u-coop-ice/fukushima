<?php

set_time_limit(360);

$condition['category_id'] = intval($_POST['category_id']);
$condition['opt_cancelled'] = intval($_POST['opt_cancelled']);
$condition['opt_archived'] = intval($_POST['opt_archived']);
$condition['opt_regist'] = intval($_POST['opt_regist']);
$condition['opt_component'] = strip_tags($_POST['opt_component']);

try {
	$ex = new adminEntryDB;
	$ex->set_condition($condition);
	$ex->exportSpreadSheet();

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出しに失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	$smarty->assign('url_query', 'mode=edit_excel');
	exit();
}

exit();

// ページを表示

?>
