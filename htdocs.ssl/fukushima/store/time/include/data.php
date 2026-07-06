<?php

require_once "/var/www/fukushima/etc/fukushima/storetime/config.php";
// ↑ここだけ環境に合わせて1回設定

$api = $API_URL . "?key=" . $API_KEY;

$file = $CACHE_FILE;
$cache_time = $CACHE_TIME;

$json = "";

/* キャッシュがあり更新時間内なら使用 */
if (file_exists($file)) {
	$json = file_get_contents($file);
} else {
	$json = '{"error":true}';
}

header('Content-Type: application/json; charset=utf-8');
echo $json;