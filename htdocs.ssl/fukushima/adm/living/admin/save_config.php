<?php

try {

	$instance = 'admin' . ucfirst(COMPONENT) . 'DB';

	$ad = new $instance;
	$ad->setAdminAuth($auth);
	$ad->saveConfig();

	header("Location: $self?mode=edit_config&saved=1");

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '入力値が不正です' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

exit();

$fields = array(
	'store_ordermail' => 'text',
	'store_name' => 'text',
	'store_time' => 'text',
	'store_address' => 'text',
	'store_phonenumber' => 'text',
	'store_faxnumber' => 'text',
);

foreach ($fields as $field => $v) {

	$value = strip_tags($_POST[$field]);
	$value = mb_convert_kana($value, "K");
	$postdata[$field] = htmlspecialchars($value, 3, 'UTF-8');

/*
if ($postdata[$field] == '') {
$smarty->assign($field . '_err', 1);
$smarty->assign('err', 1);
}
 */

}

if ($smarty->getTemplateVars('err')) {

	reset($postdata);
	$smarty->assign('post', $postdata);

	$smarty->display('edit_config.tpl');
	exit();
}

//var_dump($postdata);

$config[COMPONENT] = array_merge($config[COMPONENT], $postdata);

$postdata['component'] = json_encode($config);
$postdata['univ_id'] = $smarty->getConfigVars('univ_id');

try {

	$pdo->beginTransaction();

	$set = new setDB();
	$set->set_postdata($postdata);
	$set->set_fields(array('component' => 'text'));
	$set->set_where(array('univ_id' => 'integer'));
	$set->set_tbl('init_config');
	$set->updateTable();

	$_SESSION['config']['component'] = $postdata['component'];
	$pdo->commit();

} catch (PDOException $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '設定の保存に失敗しました。');
	$smarty->display('error.tpl');
	exit();
}

//ログの書き込み
/*
$fields = array('app_id' => 'integer', 'process' => 'text', 'value' => 'text', 'auth_username' => 'text');
$logdata['process'] = 'save_site_setting';
$logdata['auth_username'] = $auth_username;

$log = new setDB();
$log->set_postdata($logdata);
$log->set_fields($fields);
$log->set_tbl('log');

$log->insertTable();

$_SESSION["univ_auth"] = NULL;
$_SESSION["auth_code"] = NULL;
 */
// 編集のページを再度表示する
header("Location: $self?mode=edit_config&saved=1");
?>
