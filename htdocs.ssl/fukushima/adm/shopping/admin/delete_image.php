<?php
// 削除する商品のIDを得る
$item_id = intval($_POST['item_id']);
$index = intval($_POST['index']);

$tbl_image = array('image');

$tbl_images[$index] = $tbl_image[$index];

$upload_path = DOMAIN . '/app/' . COMPONENT . '/images/';

// 画像の登録をNULL化する
if ($item_id) {

	$del = new setUploadGcs();
	$del->set_upload_path($upload_path);
	$del->set_item_id($item_id);
	$del->set_tbl('sp_item');
	$del->set_tbl_image($tbl_images);

	$del->execDeleteImage();
// 画像ファイルを削除する

} else {
	$errmsg = '商品のIDが不正です。';
}

//ログの書き込み

$logdata['process'] = 'delete_item_image';
$logdata['app_id'] = $item_id;

$log = new adminShoppingDB();
$log->setAdminAuth($auth);
$log->set_postdata($logdata);

$log->saveAdminLog();

$errmsg = $smarty->getTemplateVars('errmsg');

$result['index'] = $index;

if ($errmsg) {
	$result['errmsg'] = $errmsg;
}
echo json_encode($result);
exit();
?>
