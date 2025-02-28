<?php
$result = [];

if (isset($_POST['regist_id'])) {
	$postdata['regist_id'] = intval($_POST['regist_id']);
}

try {
	$upd = new adminAjaxDB;
	$upd->setAdminAuth($auth);
	$upd->set_regist_id($postdata['regist_id']);
	$upd->saveAdminUnsubscribeMail();

} catch (Exception $e) {
	$result['errmg'] = $e->getMessage();
}

echo json_encode($result);
exit();
?>
