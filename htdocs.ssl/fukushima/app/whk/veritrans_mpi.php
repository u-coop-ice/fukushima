<?php
require_once '../../adm/lib/set_path.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

$pair = [];
$pair = [
	$smarty->getConfigVars('veritrans_api') => $smarty->getConfigVars('veritrans_secret_api'),
];

# ベリトランスペイメントゲートウェイからの入金通知電文を取得
$headers = apache_request_headers();

$messagebody = file_get_contents('php://input');

//HMAC値とハッシュ計算結果の判定でアクセス改ざんチェックを行う。
$content_mac = $headers['content-hmac'] . "\n";
$content_mac .= $messagebody . "\n";

//file_put_contents('/var/cache/smarty/newlife/content_hmac.txt', $content_mac, FILE_APPEND);

/*
------------------------------------------*/
/*
$headers['content-hmac'] = "h=HmacSHA256;s=A100000000000001069951cc;v=dcbea53462b37f69aa6d488f319b42113ac88a96093b95f61401862672f44408";

$messagebody = "numberOfNotify=1&pushTime=20240208105438&pushId=16548499&orderId0000=NLCP-ORDER-20240216-uzLGOG1l&vResultCode0000=G012A00100000000&txnType0000=AuthorizeConfirm&mpiMstatus0000=success&cardMstatus0000=success&dummy0000=1";
 */

/*
------------------------------------------*/
try {

	adminWebhookDB::checkHmac($pair, (string) $headers['content-hmac'], (string) $messagebody);

	if (!headers_sent()) {
		header("HTTP/1.1 200 OK\r\n");
		header("Content-type: text/html\r\n\r\n");
		print "Push data Accepted.\n";
	}

} catch (Exception $e) {
	# 読み込めないので 500 を応答
	header("HTTP/1.0 500 Internal Server Error\r\n");
	header("Content-Type: text/html\r\n\r\n");
	print $e->getMessage();
	exit();
}

sleep(10); //push通知が即時なので、12秒待つ

/*
------------------------------------------*/
/*
$mbs = explode('&', $messagebody);

$posts = [];
foreach ($mbs as $mb) {

$ms = explode('=', $mb);
$posts[$ms[0]] = $ms[1];
}
$_POST = $posts;

// CLIでのチェック用変数上書き
$_SERVER["REQUEST_METHOD"] = "POST";
 */
/*
------------------------------------------*/

try {

	$dd = new adminWebhookDB();
	$dd->saveRecievedMpiVeritrans();

} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

exit();
?>