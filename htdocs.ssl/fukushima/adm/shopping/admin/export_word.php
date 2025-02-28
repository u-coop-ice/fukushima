<?php

try {
	$adm = new adminShoppingDB();
	$adm->exportWord();
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '書き出しに失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}

exit();

?>
