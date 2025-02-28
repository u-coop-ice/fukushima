<?php
// ページ選択用のクエリの設定
$rankList = $smarty->getTemplateVars("rankList");

try {
	$adm = new adminRegistDB;
	$adm->setAdminAuth($auth);
	$adm->exportSpreadSheet();

} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
}

exit();

?>
