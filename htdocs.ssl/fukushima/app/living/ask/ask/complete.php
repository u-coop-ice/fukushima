<?php

if ($askdata['complete'] || !is_array($askdata)) {
	HTTP_Session2::set('askdata', null);
	header("Location: $init_url");
}
reset($askdata);
while (list($field, $value) = each($askdata)) {
	$smarty->assign('post_' . $field, $value);
}

// 変更完了画面表示する
$smarty->assign('msg', '入力内容の確認メールを送信しました。<br/ >しばらく経ってもメールが届かない場合は、迷惑メールフォルダなどに紛れ込んでいる場合があります。また、携帯アドレスをご登録されている場合は、携帯電話のメール受信設定を確認してください。なお、生協へは送信されていますので再送の必要はありません。');
$tmpl = 'complete.tpl';
$smarty->assign('msg_title', '送信が完了しました');
$smarty->assign('complete', 1);

$steps[1] = 'cleared';
$steps[2] = 'cleared';
$steps[3] = 'now';
$smarty->assign('step', $steps);

// フォームへ移動してきた場合
//	$tmpl = 'step1.tpl';

$askdata = array('complete' => 1);
HTTP_Session2::set('askdata', $askdata);

$smarty->display($tmpl);
exit();
?>
