<?php

require_once '../lib/set_path.php';

// Smartyオブジェクトの作成
require_once 'initialize.php';

// ライブラリの組み込み
set_include_path('admin' . PATH_SEPARATOR .
	'../lib' . PATH_SEPARATOR .
	get_include_path());

$config = parse_ini_file(ETC_DIR . ADM_DIR . 'config/config.php', true);

$options = [
	CURLOPT_SSL_VERIFYPEER => FALSE, // オレオレ証明書対策
	CURLOPT_SSL_VERIFYHOST => FALSE,
];
$params = [
	'add_code' => 'e011d499e792f604ce2eb30b00f2c156',
	'email' => 'shirota@tohoku.u-coop.or.jp',
	'event' => 'bounce',
	'ip' => '168.245.114.219',
	'response' => '250 Ok: queued as 22DF469',
	'sg_event_id' => 'ZGVsaXZlcmVkLTAtNDcyMzI3Ni1IaXlJSHlDaFNucXI0SktSS0VUb2R3LTA',
	'sg_message_id' => 'HiyIHyChSnqr4JKRKETodw.filterdrecv-p3iad2-fdf5ff85d-plhgf-18-6035F548-C.0',
	'smtp-id' => '<HiyIHyChSnqr4JKRKETodw@ismtpd0008p1hnd1.sendgrid.net>',
	'timestamp' => 1614148937,
	'tls' => 0,
	'univ_id' => 1,
	'regist_id' => 1,
	'webhook' => 'stdClass Object
(
    [add_code] => e011d499e792f604ce2eb30b00f2c156
    [email] => shirota@tohoku.u-coop.or.jp
    [event] => delivered
    [ip] => 168.245.114.219
    [response] => 250 Ok: queued as 22DF469
    [sg_event_id] => ZGVsaXZlcmVkLTAtNDcyMzI3Ni1IaXlJSHlDaFNucXI0SktSS0VUb2R3LTA
    [sg_message_id] => HiyIHyChSnqr4JKRKETodw.filterdrecv-p3iad2-fdf5ff85d-plhgf-18-6035F548-C.0
    [smtp-id] => <HiyIHyChSnqr4JKRKETodw@ismtpd0008p1hnd1.sendgrid.net>
    [timestamp] => 1614148937
    [tls] => 0
    [univ_id] => 1
    [regist_id] => 1
)
',
];

$defaults = [
	CURLOPT_URL => $config['init_url'] . 'adm/whk/?auth=ca1052233f81c8428800852705cd0908',
	CURLOPT_POST => true,
	CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
	CURLOPT_POSTFIELDS => json_encode($params),
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_PORT => 443,
];

try {

	$ch = curl_init();
	curl_setopt_array($ch, ($options + $defaults));
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);

	$errno = curl_errno($ch);
	$error = curl_error($ch);
	curl_close($ch);
	if (CURLE_OK !== $errno) {
		throw new Exception($error, $errno);
	}

} catch (Exception $e) {
	echo $e->getMessage();
	echo $e->getCode();
}

echo $output;

exit();
?>