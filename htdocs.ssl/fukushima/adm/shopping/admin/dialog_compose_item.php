<?php

$index = intval($_GET['index']);
$smarty->assign('index', $index);
$item_id = null;
if (isset($_GET['item_id'])) {
	$item_id = intval($_GET['item_id']);
}
$smarty->assign('item_id', $item_id);
$smarty->display('dialog_compose_item.tpl');
?>
