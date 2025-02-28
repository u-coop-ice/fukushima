<?php

if (intval($_GET['return'])) {
	$opt_return = 1;
	$smarty->assign('opt_return', $opt_return);
}

require_once 'HTTP/Session2.php';

$adddata = HTTP_Session2::get('adddata');

if (count($_POST)) {

	if (isset($_POST['regist_id'])) {
		$adddata = array();
		$adddata['regist_id'] = intval($_POST['regist_id']);
	}

	if (isset($_POST['app_id'])) {
		$app_id = intval($_POST['app_id']);
		$adddata["app_id"] = $app_id;
	} else {
		unset($adddata["app_id"]);
	}

	if (isset($_POST['add_id'])) {
		$add_id = intval($_POST['add_id']);
		$adddata["add_id"] = $add_id;
	} else {
		unset($adddata["add_id"]);
	}

	if (isset($_POST['root_id'])) {
		$root_id = intval($_POST['root_id']);
		$adddata["root_id"] = $root_id;
	} else {
		unset($adddata["root_id"]);
	}

	if ($_POST['mail_subject']) {
		$mail_subject = $_POST['mail_subject'];
		$adddata["mail_subject"] = $_POST['mail_subject'];
	} else {
		unset($adddata["mail_subject"]);
	}

	if ($_POST['arrange']) {
		$adddata["arrange"] = intval($_POST['arrange']);
	}

	HTTP_Session2::set('adddata', $adddata);

}

$smarty->assign('view_arrange', $adddata["arrange"]);

$smarty->assign('view_app_id', $adddata["app_id"]);
$smarty->assign('view_add_id', $adddata["add_id"]);

if ($adddata["root_id"]) {
	$smarty->assign('view_root_id', $adddata["root_id"]);
} else if ($adddata["add_id"]) {
	$smarty->assign('view_add_id', $adddata["add_id"]);
}

if ($adddata["mail_subject"]) {
	$smarty->assign("mail_subject", $adddata["mail_subject"]);
}

$smarty->assign('view_regist_id', $adddata["regist_id"]);

//返信数を計算
try {
	$adm = new adminAskDB;
	$adm->setAdminAuth($auth);
	if ($adddata["app_id"]) {
		$adm->set_app_id($adddata['app_id']);
		$appinfo = $adm->getAppInfo();
		$smarty->assign('view_app_id', $adddata["app_id"]);
		$smarty->assign('regist_code', $appinfo['regist_code']);
	}

	if ($adddata['root_id']) {
		$adm->set_root_id($adddata['root_id']);
	}
	if ($adddata['add_id']) {
		$adm->set_add_id($adddata['add_id']);
	}
	if ($adddata['regist_id']) {
		$adm->set_regist_id($adddata['regist_id']);
	}

	$returndata = $adm->getReturnAddInfo();

} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
if ($adddata['mail_subject']) {
	$returndata['subject'] = $adddata['mail_subject'];
}

if ($adddata['arrange']) {
	$returndata['arrange'] = $adddata['arrange'];
}

$smarty->assign('return', $returndata);
$smarty->display('edit_mail.tpl');

/*
if ($adddata["app_id"]) {

$sql = 'select component as component from app where id = ' . $adddata["app_id"];
try {
$res = $pdo->query($sql);
} catch (PDOException $e) {
//		var_dump($e);
// データベースアクセスに失敗したらエラーとする
$smarty->assign('db_error', 1);
exit();
}
// カテゴリーのデータを初期化する
$aps = $res->fetch();
}

$smarty->assign('app_component', $aps['component']);

HTTP_Session2::set('adddata', $adddata);

//返信数を計算
if ($adddata["root_id"]) {
$sql = 'select count(id) as ct from app_add where root_id = ' . $adddata["root_id"];
try {
$res = $pdo->query($sql);
} catch (PDOException $e) {
// データベースアクセスに失敗したらエラーとする
$smarty->assign('db_error', 1);
exit();
}
// カテゴリーのデータを初期化する
$data = $res->fetch();
$smarty->assign("ct", $data["ct"]);
}

$smarty->display('edit_mail.tpl');
 */

?>
