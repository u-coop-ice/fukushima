{* ページタイトル 開始 *}
{capture assign="page_title"}{$init_pagetitle}（アカウント基本内容の確認）{/capture}
{* ページタイトル 終了 *}
{capture assign="header_insert"}
<script type="text/javascript">
//<![CDATA[
$(function () {
	$('#theForm').submit(function(){
		$(this).find(':submit').button('loading');
	});
});
//]]>
</script>
{/capture}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


<p>入力内容をご確認ください。入力内容を修正したい場合は、「戻って修正する」のボタンをクリックしてください。</p>

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">アカウント情報</th></tr>
<tr><th>アカウント名</th><td><span class="prc">{$post['email']}</span></td></tr>
<tr><th>パスワード</th><td>{$post['password2']|regex_replace:"/[a-zA-Z0-9_]/":"*"}</td></tr>

<tr><th class="mh" colspan="2">ユーザー情報について</th></tr>
{include file="conf_name.tpl"}
{*<tr><th>大学名</th><td>{$init_univname}</td></tr>*}
{*<tr><th>入学年度</th><td><span class="prc">{$post['year']}</span>年度</td></tr>*}
{*include file="conf_dept.tpl"*}
{*include file="conf_membership.tpl"*}
{*include file="conf_new_add.tpl"*}
{*include file="conf_student_phone.tpl"*}
{*include file="conf_mobilephone.tpl"*}
{*
<tr><th class="mh" colspan="2">実家（帰省先）について</th></tr>
{include file="conf_address.tpl"}
{include file="conf_phonenumber.tpl"}
</tr>
*}
</table>

<form id="theReturn" action="{$self}?mode=confirm_end" method="post" enctype="x-www-form-urlencoded">
<input class="btn btn-primary" type="submit" name="reinput2" value="戻って修正する" />
</form>

<div class="box">


<form id="theForm" action="{$self}?mode=confirm_end" method="post" enctype="x-www-form-urlencoded">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<p><button class="btn btn-block btn-success" type="submit" name="submit" value="この内容でユーザー登録を完了する"><i class="fa fa-fw fa-check"></i>この内容でユーザー登録を完了する</button></p>
</div>
</div>
<p class="center"><strong class="red">上記メールアドレス宛に本登録完了メールを送信します。</strong><br />
なお、ご登録いただいたメールアドレス、パスワードは変更できます。</p>
</form>

</div>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
