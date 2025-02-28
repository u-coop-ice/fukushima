<?php
$magazine_id = intval($_POST['id']);
$group_id = intval($_POST['group_id']);

if (addslashes($_POST['test'])) {$test = 1;}
if (addslashes($_POST['send'])) {$send = 1;}

try {
	$pdo->beginTransaction();
	$adm = new adminMmDB();
	$adm->setAdminAuth($auth);
	$adm->saveMailMagazine();

//テスト用送信先アドレス
	if ($test) {

		$magazine = $adm->getMagazine();

//システムの基本メールアドレス
		$test_email = $_SESSION['config']['email'];

//管理ユーザーのメールアドレス
		if ($auth->getAuthData('email')) {
			$test_email = $auth->getAuthData('email');
		}

		$mail4send = array(
			'namef' => 'テスト',
			'nameg' => '太郎',
		);

		$smarty->assign('mail4send', $mail4send);
		$smarty->assign('unsubscribe', $magazine['unsubscribe']);

		//エンティティ化解除
		$subject = $magazine['subject'];
		$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
		$body = $magazine['body'];
		$body = htmlspecialchars_decode($body, ENT_QUOTES);
		$signature = $magazine['signature'];
		$signature = htmlspecialchars_decode($signature, ENT_QUOTES);

		$smarty->assign('body', $body);
		$smarty->assign('signature', $signature);

		$mbody = $smarty->fetch('mail_body.tpl');
		$mbody .= $smarty->fetch('mail_footer.tpl');

		$subject_test = '【テスト】' . $subject;
		adminMmDB::send_mail($init_coopname, $_SESSION['config']['donotreply_email'], $test_email, $subject_test, $mbody);
	}

	$pdo->commit();

} catch (Exception $e) {
	$pdo->rollBack();
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('error.tpl');
	exit();
}
// 編集のページを再度表示する
header("Location: $self?mode=edit_magazine&magazine_id=" . $adm->get_mail_magazine_id() . "&saved=1");
exit();
?>
