<?php

if ($postdata['complete']) {
	HTTP_Session2::set('postdata', null);
	header("Location: $init_coopurl");
}

reset($postdata);
$smarty->assign('post', $postdata);

// 変更完了画面表示する
$smarty->assign('msg', '入力内容の確認メールを送信しました。<br/ >しばらく経ってもメールが届かない場合は、迷惑メールフォルダなどに紛れ込んでいる場合があります。また、携帯アドレスをご登録されている場合は、携帯電話のメール受信設定を確認してください。なお、生協へは送信されていますので再送の必要はありません。');

$smarty->assign('step', array(1 => 'cleared', 2 => 'cleared', 3 => 'now'));

$tmpl = 'complete.tpl';
$smarty->assign('msg_title', '送信が完了しました');
$smarty->assign('complete', 1);
// フォームへ移動してきた場合
//	$tmpl = 'step1.tpl';

$postdata = array('complete' => 1);
HTTP_Session2::set('postdata', $postdata);

$smarty->display($tmpl);
exit();
?>
