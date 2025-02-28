<?php
//サポセンフォームの注意書きを取得

// URLにidが指定されている
$code_id = intval($_GET['id']);

if ($code_id) {
    $smarty->assign('view_code_id', $code_id);
				$url_query .= '&id='.$code_id;
} else {
    $smarty->assign('new_code', 1);
}

		$code_univ_id = intval($_GET['univ_id']);
		$smarty->assign('view_univ_id', $code_univ_id);
		$code_name = intval($_GET['name']);
		$smarty->assign('view_code_name', $code_name);


$smarty->assign('saved',intval($_GET['saved']));


$smarty->display('edit_code.tpl');
?>

