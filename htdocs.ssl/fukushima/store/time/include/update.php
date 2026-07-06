<?php

require_once "/var/www/fukushima/etc/fukushima/storetime/config.php";
// ↑ここだけ環境に合わせて1回設定

// APIキー確認
if (!isset($_GET["key"]) || $_GET["key"] !== $API_KEY) {
	exit("forbidden");
}

// GAS API
$url = $API_URL . "?key=" . $API_KEY;

// 取得
$json = file_get_contents($url);

if ($json === false) {
	exit("API error");
}

// 保存
file_put_contents($CACHE_FILE, $json);

echo "updated";