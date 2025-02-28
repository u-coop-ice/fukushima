{* ページタイトル 開始 *}
{capture assign="page_title"}{$category['denomination']} 入力内容確認{/capture}
{* ページタイトル 終了 *}

{capture assign="header_insert"}
<script type="text/javascript">
//<![CDATA[
$(function () {
	$('#theForm').submit(function(){
	if(window.confirm('入力した内容を送信してよろしいですか? \nこの操作は取り消せません。')){
		$(this).find(':submit').button('loading');
	} else {
		return false;
	}
	});
});
//]]>
</script>
{/capture}



{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">{$category['denomination']}</th></tr>

<tr><th>{$category['comedate_title']|default:"ご来場予定日"}</th><td>{$post['comedate']}</td></tr>
<tr><th>{$category['cometime_title']|default:"予定時間"}</th><td>{$post['cometime']}</td></tr>


<tr><th class="mh" colspan="2">メールアドレス</th></tr>
<tr>
<th>E-mail</th>
<td>
{if $login}{$regist['username']}{else}{$post['email']}{/if}
</td></tr>
<tr><th class="mh" colspan="2">基本情報</th></tr>

{$html}
</table>

<form method="post" enctype="" action="{$self}?mode=confirm">
<button class="btn btn-primary" type="submit" name="reinput" value="1"><i class="fa fa-fw fa-chevron-left"></i>入力内容を修正</button>
</form>

<div class="box">
<form id="theForm" method="post" enctype="" action="{$self}?mode=confirm">
<p class="center"><strong class="red">以上の内容でよろしければ、下のボタンをクリックしてください</strong></p>

<div class="row">
<div class="col-sm-8 col-sm-push-2">
<button class="btn btn-success btn-block" type="submit" name="register" value="1" data-loading-text="送信中" autocomplete="off"><i class="fa fa-fw fa-check"></i>この内容で送信しお申込みを確定する</button>
</div>
</div>

<p class="center"><strong class="em09 blue">お客様の通信環境その他の要因により、画面切り替わりまでしばらく時間がかかることがあります。</strong></p>
</form>
</div>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
