<?php

$postdata = array();

$postdata['treat'] = htmlspecialchars($_POST['treat'], 3, "UTF-8");
$postdata['app_id'] = intval($_POST['app_id']);

$fields = array('treat' => 'text');

$instance = 'admin' . ucfirst(COMPONENT) . 'DB';

try {
	$ch = new $instance;
	$ch->setAdminAuth($auth);
	$ch->set_app_id($postdata['app_id']);
	$ch->changeStatusApp();
} catch (Exception $e) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベースの処理に失敗しました。' . $e->getMessage());
	$smarty->display('error.tpl');
	exit();

}

// 編集のページを再度表示する
header("Location: $self?mode=show_app&app_id=" . $ch->get_app_id() . "&changed=1");

?>
