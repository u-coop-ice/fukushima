<?php

// ユーザー名と登録コードを得る
$username = htmlspecialchars($_GET['username'], 3, 'EUC-JP');
$code = htmlspecialchars($_GET['code'], 3, 'EUC-JP');
// 仮登録されているかどうかをチェックする
$sql = <<< HERE
select id,email from ${pfx}customer
where username = ? and regist_code = ?

HERE;
$type = array('text', 'text');
$data = array($username, $code);
$sth = $pdo->prepare($sql, $type);
$res = $sth->execute($data);
if (PEAR::isError($res)) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'データベース処理が正しく行われませんでした。');
	$smarty->display('error.tpl');
	exit();
}
$res_data = $res->fetchRow();

if ($res_data['id']) {

	$smarty->assign('post_id', $res_data['id']);
	$smarty->assign('post_email', $res_data['email']);
	$smarty->assign('post_username', $username);

	$tmpl = 'change_password.tpl';

} else {
	// 不正なアクセス、もしくはすでにパスワード変更済みの場合
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
}

?>
