<?php

require_once '../../adm/lib/set_path.php';

require_once 'Auth/Auth.php';
require_once 'HTTP/Session2.php';
require_once 'Net/UserAgent/Mobile.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

$errmsgList = array(
	-9 => '受験生・新入生サポートサイトで登録されているメールアドレスで、すでに' . $init_coopname . 'サイトのユーザーアカウントをお持ちです。',
	9 => '通信エラーが発生しました。',
	10 => '不正なURLです。',
);
$msgList = array(
	1 => 'アカウントの引き継ぎが完了しました。「受験生・新入生サポートサイト」のアカウントと同じパスワードでサインイン下さい。');

if ($is_login) {
	$userAuth->logout();
	$_SESSION['user_mode'] = 0;
	session_destroy();
	setcookie('_rmbm', '', time() - 3600 * 24 * 30, '/');
}

$username = addslashes($_GET['username']);
$result = intval($_GET['result']);

if (!$username || !$result) {$result = 10;}
$smarty->assign('username', $username);
$smarty->assign('errmsg', $errmsgList[$result]);
$smarty->assign('msg', $msgList[$result]);
$smarty->assign('result', $result);

//ログの書き込み
if ($result == 1) {

	$logdata['kind'] = 'inherit';
	$logdata['username'] = $username;
	$logdata['result'] = 1;
	$log = new setDB();
	$log->set_logdata($logdata);
	$log->insertLog();
}

$smarty->display('complete_inherit_modal.tpl');

?>
