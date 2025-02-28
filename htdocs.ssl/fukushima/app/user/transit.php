<?php

//クライアントのIPアドレス取得

$ip = $_SERVER['REMOTE_ADDR'];

$allow = array(
	'127.0.0.1',
	'61.202.140.13',
	'104.198.116.50',
	'35.194.99.52',
);

$sh = $_SERVER['SERVER_NAME'];
/*
if ($sh != "newlife.u-coop.or.jp") {
$result = array('username' => null, 'result' => 9);
echo json_encode($result);
exit();
}
 */

if (!in_array($ip, $allow)) {
	$result = array('username' => null, 'result' => 9);
	echo json_encode($result);
	exit();
}

require_once '../../adm/lib/set_path.php';

require_once 'Auth/Auth.php';
require_once 'HTTP/Session2.php';
require_once 'Net/UserAgent/Mobile.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

if ($is_login) {
	header("Location:" . $init_coopurl);
	exit();
}

if ($_POST['username']) {

//ユーザー重複チェック

	$ck = new setInheritDB();
	$ck->set_postdata($_POST);
	$ck->inheritUser();
	exit();
} else {
	$result = array('username' => null, 'result' => 9);
	echo json_encode($result);
	exit();
}

?>
