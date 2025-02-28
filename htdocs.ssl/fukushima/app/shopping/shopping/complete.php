<?php

//申込完了を踏んでいるか判定
$shipdata = HTTP_Session2::get('shipdata');

if (!$shipdata['complete']) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです(s)。');
	$smarty->display('error.tpl');
}

if (count($shipdata) > 1) {
	$smarty->assign('post' . $field, $value);
}
// 変更完了画面表示する
$smarty->assign('msg', '入力内容の確認メールを送信しました。<br/ >しばらく経ってもメールが届かない場合は、迷惑メールフォルダなどに紛れ込んでいる場合があります。また、携帯アドレスをご登録されている場合は、携帯電話のメール受信設定を確認してください。なお、生協へは送信されていますので再送の必要はありません。');
$tmpl = 'buy_end.tpl';
$smarty->assign('msg_title', '送信が完了しました');
$smarty->assign('complete', 1);
// フォームへ移動してきた場合
//	$tmpl = 'step1.tpl';

HTTP_Session2::set('shipdata', []);

$smarty->display($tmpl);
exit();
?>
