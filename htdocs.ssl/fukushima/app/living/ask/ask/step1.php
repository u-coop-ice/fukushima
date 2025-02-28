<?php

$refferdata = HTTP_Session2::get('refferdata');

if (isset($_POST['target'])) {
	$target = strip_tags($_POST['target']);
}
if ($target) {
	$askdata = [];
	$askdata['target'] = $target;
	HTTP_Session2::set('refferdata', $askdata);
} else {
	if (HTTP_Session2::get('refferdata')) {
		$refferdata = HTTP_Session2::get('refferdata');
		if (isset($refferdata['target'])) {
			$askdata['target'] = $refferdata['target'];
		}
	}
}
$smarty->assign('post', $askdata);

HTTP_Session2::set('askdata', $askdata);

// 記事編集ページを表示する
$smarty->display('step1.tpl');
exit();

?>
