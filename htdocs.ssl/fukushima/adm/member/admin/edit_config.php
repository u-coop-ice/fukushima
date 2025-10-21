<?php

$saved = intval($_GET['saved']);
$smarty->assign('saved', $saved);

// 記事編集ページを表示する
$smarty->display('edit_config.tpl');

?>
