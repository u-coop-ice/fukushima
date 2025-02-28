{* ページタイトル 開始 *}
{capture assign="page_title"}お問い合わせ{/capture}
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

<p>入力内容をご確認ください。入力内容を修正したい場合は、「入力内容を修正」のボタンをクリックしてください。</p>
<table class="inputForm" cellspacing="0">
<col style="width: 30%;" />
<col style="width: 70%;" />

{if !$login}

<tr><th class="mh" colspan="2">入力内容の確認</th></tr>
{include file="conf_email.tpl"}
<tr><th class="mh" colspan="2">基本情報</th></tr>
{include file="conf_name.tpl"}
{include file="conf_student_phone.tpl"}
{/if}


<tr>
<tr><th class="mh" colspan="2">お問い合わせ内容</th></tr>
<tr>
<th>お問い合わせ件名</th>
<td>
{$post['subject']}
</td>
</tr>
<tr>
<th>対象物件</th>
<td>
{if $post['target']}{$post['target']}{/if}
</td>
</tr>
<th>お問い合わせ内容</th>
<td>
<p>{if $post['purpose']|@count}
{$post['purpose']|implode:"/"}
{/if}</p>
{if $post['memo']}<div class="contact">{$post['memo']|nl2br}</div>{/if}
</td>
</tr>
</table>

<form id="returnForm" action="{$self}?mode=confirm" method="post" enctype="x-www-form-urlencoded">
<button class="btn btn-primary" type="submit" name="reinput1" value="入力内容を修正"><i class="fa fa-fw fa-chevron-left"></i>入力内容を修正</button>
</form>

<div class="box">
<div class="center">
<form id="theForm" action="{$self}?mode=confirm" method="post" enctype="x-www-form-urlencoded">
<p><strong class="red">以上の内容でよろしければ、下のボタンをクリックしてください</strong></p>
<div class="row">
<div class="col-sm-8 col-sm-offset-2"><button class="btn btn-success btn-block" type="submit" name="regist" data-loading-text="送信中" autocomplete="off" value="この内容で送信する"><i class="fa fa-fw fa-check"></i>この内容で送信する</button></div></div>
<p><strong class="em09 blue">お客様の通信環境その他の要因により、画面切り替わりまでしばらく時間がかかることがあります。</strong></p>
</form>
</div>
</div>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
