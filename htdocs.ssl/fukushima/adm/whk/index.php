<?php

$hash_auth = "ca1052233f81c8428800852705cd0908";
$hash = addslashes($_GET['auth']);

if ($hash_auth != $hash) {
	die('Invalid acccess error.');
}

require_once '../lib/set_path.php';

$init = parse_ini_file(ETC_DIR . ADM_DIR . 'config/config.php', true);

define('SENDGRID_API_KEY', $init['sendgrid_api_key']);
$dbuser = $init['dbuser'];
$dbpass = $init['dbpass'];
$dbhost = $init['dbhost'];
$database = $init['database'];
$dbsocket = $init['dbsocket'];
$dbsocket_repl = $init['dbsocket_repl'];

global $pdo, $pdo_repl;

// データベースに接続
$pdo = adminWebhookDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket);
if ($dbsocket_repl) {
	$pdo_repl = adminWebhookDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket_repl);
} else {
	$pdo_repl = $pdo;
}

//初期設定読み込み

$whk = new adminWebhookDB;
$whk->set_config(['univ_id' => $init['univ_id']]);
$whk->setSessionConfig();

try {
	$whk->saveWebhook();

} catch (Exception $e) {

}

exit();
?>