<?php

$rootpath = $_SERVER['DOCUMENT_ROOT'] . '/';
$domain = explode('/', $_SERVER['PHP_SELF']);

require_once $rootpath . 'adm/lib/set_path.php';
require_once 'signin.php';

$json = $appauth->returnSigninJSON();

header("Access-Control-Allow-Origin: ${config['init_url']}");
header('Content-type: text/plain');
header("Access-Control-Allow-Methods: POST");
echo json_encode($json);
exit;
?>