<?php

//申込完了を踏んでいるか判定
$shipdata = HTTP_Session2::get('shipdata');

if (isset($shipdata['complete']) && $shipdata['complete']) {
	HTTP_Session2::set('shipdata', null);
	header("Location: " . $init_url);
	exit();
} else if (empty($shipdata)) {
	HTTP_Session2::set('shipdata', null);
	header("Location: " . $init_url);
	exit();
}

if (!isset($shipdata['response_contents']) || !$shipdata['response_contents']) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです(s)。');
	$smarty->display('error.tpl');
}
echo $shipdata['response_contents'];
exit();
?>
