<?php
// URLから商品のIDを得る
$item_id = intval($_GET['item_id']);
// IDが指定されていれば、それを変数view_item_idに設定する
if ($item_id) {
	$smarty->assign('view_item_id', $item_id);
}
// IDが指定されていなければ、商品を登録するモードにする
else {
	$smarty->assign('new', 1);
}

$smarty->assign('extraList', array(0 => " 使用しない", 1 => " 任意項目", 2 => " 必須項目"));

// 商品が保存されて再度編集ページが表示されるときには、
// 変数savedに1を設定する
$smarty->assign('saved', $_GET['saved']);
// 商品編集ページを表示する
$smarty->display('edit_item.tpl');
?>
