<?php
try {
	$pdo->beginTransaction();
	$ad = new adminShoppingDB();
	$ad->setAdminAuth($auth);
	$ad->saveShoppingSubcategory();

	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=edit_subcategory&subcategory_id=" . $ad->get_shopping_subcategory_id() . "&saved=1");
exit();

$id = intval($_POST['id']);

$fields = array(
	'name' => 'text',
	'description' => 'text',
	'flag_drink' => 'integer',
	'open_date' => 'text',
	'limit_date' => 'text',
	'visible' => 'integer',
	'sort_order' => 'integer',
	'term_start' => 'text',
	'term_end' => 'text',
	'intervals' => 'integer',
	'parent_id' => 'integer',
	'return_message' => 'text',
);
$fields_m = array();

$fields_all = array_merge($fields, $fields_m);

$fields_must = $fields_m;

foreach ($fields_all as $field => $v) {
	$value = $_POST[$field];
	$value = mb_convert_kana($value, "KV");
	$postdata[$field] = htmlspecialchars($value, 3, "UTF-8");
}

/*
foreach ($fields_must as $field=>$v) {
if ($postdata[${field}] == '') {
$smarty->assign($field . '_err', 1);
$smarty->assign('err', 1);
}
}
 */

require_once 'shoppingDB.class.php';

$subcat = new shoppingDB();

// 新規カテゴリーの場合

if (!$id) {
	if ($init_category['flag_send']) {

		$postdata['term_start'] = '';
		$postdata['term_end'] = '';
		$postdata['term_intervals'] = '';

	}

	$subcat->set_fields($fields_all);
	$subcat->set_postdata($postdata);
	$subcat->set_tbl('sp_subcategory');

	$subcat->insertTable();

	$id = $subcat->get_last_insertId();

}
// 既存カテゴリーの場合
else {

	$fields_all['id'] = 'integer';
	$postdata['id'] = $id;

	$subcat->set_fields($fields_all);
	$subcat->set_postdata($postdata);
	$subcat->set_tbl('sp_subcategory');

	$subcat->updateTable();
}

//ログの書き込み
$log = new adminDB();

$logdata['process'] = 'save_subcategory';
$logdata['auth_username'] = $auth_username;
$logdata['value'] = $id;

$log->set_logdata($logdata);
$log->insertAdminLog();

// 新規カテゴリーの場合は、保存されたカテゴリーのIDを調べる

// 編集のページを再度表示する
header("Location: $self?mode=edit_subcategory&sid=" . $id . "&saved=1");
?>
