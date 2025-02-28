<?php
//サポセンフォームの注意書きを取得

// URLにuniv_idが指定されている
$univ_id = $smarty->getConfigVars('univ_id');
if ($univ_id) {
	$smarty->assign('view_univ_id', $univ_id);
	$url_query .= '&univ_id=' . $univ_id;
	$smarty->display('list_code.tpl');

}

?>
