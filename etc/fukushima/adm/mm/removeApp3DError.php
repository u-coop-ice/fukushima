<?php
set_time_limit(0);

$present_dir = (dirname(__FILE__));

if (!preg_match('/\/$/', $present_dir)) {
	$present_dir .= '/';
}

$etc_dir = preg_replace('/\/mm/', "", $present_dir);
$rootpath = preg_replace('/\/etc\//', "/htdocs.ssl/", $etc_dir);

set_include_path($rootpath . '/admin' . PATH_SEPARATOR .
	$rootpath . '/lib' . PATH_SEPARATOR .
	get_include_path());

if (!count($config)) {
	$config = parse_ini_file($etc_dir . '/config/config.php', true);
}

// ライブラリの組み込み
// ライブラリの組み込み
require_once $rootpath . 'lib/classLoader.class.php';
$classLoader = new ClassLoader();
$classLoader->registerDir($rootpath . 'lib/Classes');
$classLoader->registerDir($rootpath . 'lib/Classes/trait');

$dbuser = $config['dbuser'];
$dbpass = $config['dbpass'];
$dbhost = $config['dbhost'];
$database = $config['database'];
$dbsocket = $config['dbsocket'];
$dbsocket_repl = $config['dbsocket_repl'];

// データベースに接続
$pdo = adminConfigDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket);
if ($dbsocket_repl) {
	$pdo_repl = adminConfigDB::initDB($dbuser, $dbpass, $dbhost, $database, $dbsocket_repl);
} else if ($dbhost_repl) {
	$pdo_repl = adminConfigDB::initDB($dbuser, $dbpass, $dbhost_repl, $database, $dbsocket);
} else {
	$pdo_repl = $pdo;
}

try {
	$pdo->beginTransaction();
	$adm = new adminShoppingDB();
	$adm->removeApp3DError();
	$pdo->commit();
} catch (Exception $e) {
	echo $e->getMessage();
	$pdo->rollback();
}

exit();
?>