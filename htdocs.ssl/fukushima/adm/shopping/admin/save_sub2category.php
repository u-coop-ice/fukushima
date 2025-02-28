<?php
try {
	$pdo->beginTransaction();
	$ad = new adminShoppingDB();
	$ad->setAdminAuth($auth);
	$ad->saveShoppingSub2category();

	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=edit_sub2category&sub2category_id=" . $ad->get_shopping_sub2category_id() . "&saved=1");
exit();

$postdata['id'] = intval($_POST['id']);

$fields = array(
	'name' => 'text',
	'description' => 'text',
	'limit_date' => 'text',
	'visible' => 'integer',
	'sort_order' => 'integer',
	'subcategory_id' => 'integer',
);
$fields_m = array();

$fields_all = array_merge($fields, $fields_m);

$fields_must = $fields_m;

foreach ($fields_all as $field => $v) {
	$value = strip_tags($_POST[$field]);
	$value = mb_convert_kana($value, "KV");
	$postdata[$field] = $value;
}

require_once 'shoppingDB.class.php';

$subcat = new shoppingDB();

// 新規カテゴリーの場合
if (!$postdata['id']) {
	$subcat->set_fields($fields_all);
	$subcat->set_postdata($postdata);
	$subcat->set_tbl('sp_sub2category');

	$subcat->insertTable();

	$id = $subcat->get_last_insertId();

}
// 既存カテゴリーの場合
else {
	$postdata['id'] = $postdata['id'];
	$subcat->set_fields($fields_all);
	$subcat->set_postdata($postdata);
	$subcat->set_tbl('sp_sub2category');

	$subcat->updateTable();
}

//ログの書き込み
$log = new adminDB();

$logdata['process'] = 'save_sub2category';
$logdata['auth_username'] = $auth_username;
$logdata['value'] = $postdata['id'];

$log->set_logdata($logdata);
$log->insertAdminLog();

// 編集のページを再度表示する
header("Location: $self?mode=edit_sub2category&s2cid=" . $postdata['id'] . "&saved=1");
?>
