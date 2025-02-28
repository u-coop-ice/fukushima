<?php

try {

	$instance = 'admin' . ucfirst(COMPONENT) . 'DB';

	$ad = new $instance;
	$ad->setAdminAuth($auth);
	$ad->saveConfig();

	header("Location: $self?mode=edit_config&saved=1");

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '入力値が不正です');
	$smarty->display('error.tpl');
	exit();

}

exit();
?>
