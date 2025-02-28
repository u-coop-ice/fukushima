<?php

require_once '../../adm/lib/set_path.php';

require_once 'Auth/Auth.php';
require_once 'HTTP/Session2.php';
require_once 'Net/UserAgent/Mobile.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

$userdata = HTTP_Session2::get('userdata');

if ($is_login) {
	$smarty->assign('login', 1);
}
$smarty->display('login_modal.tpl');

?>
