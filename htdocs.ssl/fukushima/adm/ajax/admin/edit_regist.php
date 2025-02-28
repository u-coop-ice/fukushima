<?php

require_once 'HTTP/Session2.php';

$smarty->addTemplateDir(array(ETC_DIR . APP_DIR . 'templates/common'));

$editdata = HTTP_Session2::get('editdata');

if (count($_GET)) {

	if (isset($_GET['app_id'])) {
		$app_id = intval($_GET['app_id']);
		$editdata = [];
		$editdata["app_id"] = $app_id;
	} else {
		unset($editdata["app_id"]);
	}
}

$upd = new adminAjaxDB;
$upd->set_skip_auth_check();
$upd->set_app_id($app_id);
$upd->setAppFields();

$smarty->assign('view_app_id', $editdata["app_id"]);

HTTP_Session2::set('editdata', $editdata);

$smarty->display('edit_regist.tpl');

?>
