<?php
require_once '../../adm/lib/set_path.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

$pair = [];
$pair = [
	$smarty->getConfigVars('veritrans_api') => $smarty->getConfigVars('veritrans_secret_api'),
];

/*
# ベリトランスペイメントゲートウェイからの入金通知電文を取得
$headers = apache_request_headers();

$messagebody = file_get_contents('php://input');

//HMAC値とハッシュ計算結果の判定でアクセス改ざんチェックを行う。
$content_mac = $headers['content-hmac'] . "\n";
$content_mac .= $messagebody . "\n";

file_put_contents('/var/cache/smarty/newlife/content_hmac.txt', $content_mac, FILE_APPEND);
 */

/*
------------------------------------------*/
$headers['content-hmac'] = "h=HmacSHA256;s=A100000000000001069951cc;v=41d5a48043dc365e7aad145ee57b8108cd6a2786e23c3b0977981bd78eda5cb0";

$messagebody = "numberOfNotify=1&pushTime=20240208105438&pushId=16548499&orderId0000=FKFR-ODR-20240509-0006-c59NHOyI&vResultCode0000=G012A00100000000&txnType0000=AuthorizeConfirm&mpiMstatus0000=success&cardMstatus0000=success&dummy0000=1";

/*
------------------------------------------*/

try {

	$hash = adminWebhookDB::getHmac($pair, (string) $headers['content-hmac'], (string) $messagebody);
	echo $hash;
} catch (Exception $e) {
	# 読み込めないので 500 を応答
	header("HTTP/1.0 500 Internal Server Error\r\n");
	header("Content-Type: text/html\r\n\r\n");
	exit();
}
?>