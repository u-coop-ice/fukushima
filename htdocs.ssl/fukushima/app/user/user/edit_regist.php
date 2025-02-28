<?php

// 記事が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$refferdata = [];

if (isset($_GET['cmp'])) {
	$refferdata['component'] = addslashes($_GET['cmp']);
	if (isset($_GET['part'])) {
		$refferdata['part'] = addslashes($_GET['part']);
	}
}

if (isset($_GET['md'])) {
	$refferdata['mode'] = addslashes($_GET['md']);
}
$smarty->assign("reffer", $refferdata);
HTTP_Session2::set('refferdata', $refferdata);

$methods['dept']['use'] = 2;
$methods['address']['use'] = 2;
$methods['new_add']['use'] = 2;
$methods['phonenumber']['use'] = 2;
$methods['mobilephone']['use'] = 1;
$methods['student_phone']['use'] = 1;
$methods['name']['use'] = 2;
$methods['membership']['use'] = 1;
$methods['sex']['use'] = 1;
$methods['age']['use'] = 1;

$smarty->assign("methods", $methods);

$smarty->assign('saved', $_GET['saved']);

$refferdata = array();

if (isset($_GET['cmp'])) {
	$refferdata['component'] = addslashes($_GET['cmp']);
	if (isset($_GET['part'])) {
		$refferdata['part'] = addslashes($_GET['part']);
	}
	if (isset($_GET['self'])) {
		$refferdata['self'] = addslashes($_GET['self']);
	}
}

if (isset($_GET['md'])) {
	$refferdata['mode'] = addslashes($_GET['md']);
}
$smarty->assign("reffer", $refferdata);
HTTP_Session2::set('refferdata', $refferdata);

// 記事編集ページを表示する
$smarty->display('edit_regist.tpl');

?>
