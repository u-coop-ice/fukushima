<?php

//申込完了を踏んでいるか判定
$shipdata = HTTP_Session2::get('shipdata');

if (!$shipdata['complete']) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです(s)。');
	$smarty->display('error.tpl');
}

// 変更完了画面表示する
$smarty->assign('msg', '');
$tmpl = 'complete.tpl';
$smarty->assign('msg_title', '登録が完了しました');
$smarty->assign('complete', 1);
// フォームへ移動してきた場合
//	$tmpl = 'step1.tpl';

HTTP_Session2::set('shipdata', []);

$smarty->display($tmpl);
exit();
?>
