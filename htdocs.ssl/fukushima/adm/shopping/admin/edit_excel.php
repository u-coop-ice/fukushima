<?php

// URLにuniv_idが指定されている
$univ_id = intval($_GET['univ_id']);
if ($univ_id) {
    $smarty->assign('view_univ_id', $univ_id);
				$url_query .= '&univ_id='.$univ_id;
} else {
    $smarty->assign('no_auth', 1);
}


// ページ選択用のクエリの設定
$smarty->assign('url_query', 'mode=export_excel');

// 絞り込み
$data_mst = array('' => 'すべて表示','ask'=>'お問い合わせ','request' => '資料請求');

$smarty->assign('data_mst', $data_mst);


// ページを表示
$smarty->display('edit_excel.tpl');

?>
