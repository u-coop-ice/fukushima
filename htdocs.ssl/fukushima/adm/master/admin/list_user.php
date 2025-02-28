<?php
// 記事が削除された場合は、そのことを変数に設定する
if (intval($_GET['deleted'])) {
	$smarty->assign('deleted', 1);
}
if (intval($_GET['saved'])) {
	$smarty->assign('saved', 1);
}

$list_auth = $auth_admin;

unset($list_auth['univ']);
unset($list_auth['master']);
unset($list_auth['adm']);
$smarty->assign('list_auth', $list_auth);

// ページを表示
$smarty->display('list_user.tpl');
?>
