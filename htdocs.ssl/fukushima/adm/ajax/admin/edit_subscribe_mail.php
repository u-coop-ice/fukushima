<?php
if (isset($_GET['regist_id'])) {
	$view_regist_id = intval($_GET['regist_id']);
	$smarty->assign("view_regist_id", $view_regist_id);
}
$smarty->display('edit_subscribe_mail.tpl');
?>
