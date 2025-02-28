<?php

// URLから記事のIDを得る
$regist_id = intval($_GET['rid']);
// IDが指定されていれば、それを変数view_entry_idに設定する

if ($regist_id) {
	$smarty->assign('view_regist_id', $regist_id);
} else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'UTLが不正です。');
	$smarty->display('error.tpl');
	exit();
}

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$smarty->assign('saved', $_GET['saved']);
// 記事編集ページを表示する
$smarty->display('show_regist.tpl');

?>
