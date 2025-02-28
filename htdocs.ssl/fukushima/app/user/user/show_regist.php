<?php

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
if (isset($_GET['saved'])) {$smarty->assign('saved', 1);}
$smarty->assign('changed_email', intval($_GET['changed_email']));

// 記事編集ページを表示する
$smarty->display('show_regist.tpl');

?>
