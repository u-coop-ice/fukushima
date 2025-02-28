<?php

$postdata = array();

$postdata['regist_id'] = intval($_POST['regist_id']);
$postdata['app_id'] = intval($_POST['app_id']);
$postdata['regist_status'] = intval($_POST['regist_status']);
$postdata['category_id'] = intval($_POST['category_id']);

$result = [];

try {
	$upd = new adminAjaxDB;
	$upd->setAdminAuth($auth);
	$upd->set_category_id($postdata['category_id']);
	$upd->set_regist_id($postdata['regist_id']);
	$upd->set_app_id($postdata['app_id']);
	$upd->set_skip_auth_check();
	$upd->correctApp();

} catch (Exception $e) {
	$result['errmg'] = $e->getMessage();
}

echo json_encode($result);

exit();

/*

$cinfo = new setDB();

$cinfo->set_category_id($postdata['category_id']);
$category = $cinfo->get_category_info();

$methods = json_decode($category['method'], true);

if ($postdata['regist_status'] == -9) {
$methods['email']['use'] = 2;
}

$method = array();

foreach ($methods as $key => $value) {
if ($key != 'extra') {
if ($value['use']) {
$method[$key] = $value['sort'];
}
} else {
foreach ($value as $k => $v) {
if ($v['use']) {
$method[$key . $k] = $v['sort'];
}
}
}
}
asort($method);

$mt = new setDB();
$mt->set_methods($methods);
$fields = $mt->get_fields_input();

$fields_sql = $mt->get_fields_sql();

foreach ($fields['all'] as $field => $v) {
$value = strip_tags($_POST[$field]);
$value = mb_convert_kana($value, "KV", "UTF-8");
$postdata[$field] = htmlspecialchars($value, 3, 'UTF-8');
}

//新住所のオプション

if ($methods['new_add']['use'] == 2) {
if ($postdata['new_add']) {
$fields['must'][3] = array_diff_key($fields['must'][3], array(
'new_zipcodef' => 'integer', 'new_zipcodes' => 'integer', 'new_pref' => 'text',
'new_addressf' => 'text',
'student_phone1' => 'text',
'student_phone2' => 'text',
'student_phone3' => 'text')
);
}
}

$fields_must = array_merge($fields['must'][2], $fields['must'][3], $fields['must'][4]);

foreach ($fields_must as $field => $v) {
if ($postdata[$field] == '') {
$smarty->assign($field . '_err', 1);
$smarty->assign('err', 1);
}
}

// メルアド入力確認

if ($postdata["email"] != "") {
if (!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $postdata["email"])) {
$smarty->assign(no_email . '_err', 1);
$smarty->assign('err', 1);
}
}

//半角数字check
$fields_num = array('zipcodef', 'zipcodes', 'code_branch', 'account');
foreach ($fields_num as $field) {
if ($postdata[${field}] && !preg_match("/^[0-9]+$/", $postdata[${field}])) {
$smarty->assign('no_num_' . $field . '_err', 1);
$smarty->assign('err', 1);
}
}

//電話番号生成
$phones = array('mobilephone', 'phonenumber', 'parent_mobile', 'parent_com_phone', 'student_phone');
foreach ($phones as $phone) {
if (!in_array($phone, $method)) {continue;}
$temp = array();
for ($i = 1; $i <= 3; $i++) {
if ($postdata[$phone . $i]) {
array_push($temp, $postdata[$phone . $i]);
}
}
if (count($temp)) {
$ptemp = implode("-", $temp);
$postdata[$phone] = $ptemp;
}
}

//birthday生成

if ($method['age']) {
$postdata['birthday'] = $postdata['birth_year'] . sprintf("%02d", $postdata['birth_month']) . sprintf("%02d", $postdata['birth_day']);
}

//membership生成
if ($method['membership']) {
$postdata['membership'] = $postdata['membership1'] . $postdata['membership2'] . $postdata['membership3'];
}

$up = new setDB();

$up->set_fields($fields_sql);
$up->set_postdata($postdata);
$up->set_tbl('regist');
$up->updateTable();

//ログの書き込み
$log = new adminDB();

$logdata['process'] = 'update_regist';
$logdata['auth_username'] = $auth_username;
$logdata['value'] = json_encode($postdata);

$log->set_logdata($logdata);
$log->insertAdminLog();

$error = array();
if ($smarty->getTemplateVars('errmsg')) {
$error = array('err' => 1);
}
echo json_encode($error);

exit();
// 編集のページを再度表示する
//header("Location: $self?mode=show_app&aid=" . $postdata['id'] . "&changed=1");
 */

?>
