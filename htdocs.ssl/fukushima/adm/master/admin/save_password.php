<?php
// ユーザパスワードのチェック
// ユーザパスワードのチェック
$err = [];
try {
	$pdo->beginTransaction();
	$adm = new adminMasterDB();
	$adm->setAdminAuth($auth);
	$adm->saveAdminPassword();
	$pdo->commit();

	$err['msg'] = 'パスワードを変更しました。';
	$err['flag'] = 0;

} catch (Exception $e) {
	$pdo->rollBack();
	$err['msg'] = $e->getMessage();
	$err['flag'] = 1;
}

echo json_encode($err);
exit();

?>