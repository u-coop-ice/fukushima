<?php

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$smarty->assign('saved', $_GET['saved']);
// 記事編集ページを表示する

HTTP_Session2::set('changedata', array());

$smarty->display('edit_card.tpl');

?>
