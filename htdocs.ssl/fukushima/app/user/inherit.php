<?php

require_once '../../adm/lib/set_path.php';

require_once 'Auth/Auth.php';
require_once 'HTTP/Session2.php';
require_once 'Net/UserAgent/Mobile.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

$userdata = HTTP_Session2::get('userdata');

if (!$_SESSION['config']['inherit']) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'この機能は現在利用できません。');
	$smarty->display('error_modal.tpl');
	exit();
}

if ($is_login) {
	header("Location:" . $init_coopurl);
} else {
	$smarty->display('inherit_modal.tpl');
}

?>
