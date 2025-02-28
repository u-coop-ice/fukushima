<?php

if (!count($config)) {
	$config = parse_ini_file(ETC_DIR . '/adm/config/config.php', true);
}

$dbuser_regist = $config['dbuser_regist'];
$dbpass_regist = $config['dbpass_regist'];
$dbhost = $config['dbhost'];
$database = $config['database'];
$dbsocket = $config['dbsocket'];
$dbsocket_repl = $config['dbsocket_repl'];

require_once 'initialize.php';
require_once 'userSmarty.php';

//メッセージデータの取得
/*
if ($is_login) {

$mesdata = array($auth_user_id);

$sql = <<< HERE
SELECT COUNT(`id`) as ct FROM app_add
WHERE `send` = 1 AND IFNULL(`user_read`,0) < 1
AND `regist_id` = ?
HERE;

try {
$mes = $pdo_repl->prepare($sql);
$mes->execute($mesdata);
} catch (PDOException $e) {
return;
}

$app_add = $mes->fetch();
}
 */

?>