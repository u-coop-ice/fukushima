{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>

<script>
$(function(){
$("#theForm").validationEngine({
	promptPosition:"inline",
	scrollOffset:200
});
});
</script>

<script type="text/javascript" src="/js/jquery/jquery.autoKana/jquery.autoKana.js"></script>
<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>
<script type="text/javascript">
$(function($){
	$('#zipcodef').zip2addr({
	zip2:'#zipcodes',
	pref:'#pref',
	addr:'#addressf'
	}),
	$('#new_zipcodef').zip2addr({
	zip2:'#new_zipcodes',
	pref:'#new_pref',
	addr:'#new_addressf'
	}),
	$('#ship_zipcodef').zip2addr({
	zip2:'#ship_zipcodes',
	pref:'#ship_pref',
	addr:'#ship_addressf'
	})


$.fn.autoKana('#namef', '#kanaf', {katakana:true});
$.fn.autoKana('#nameg', '#kanag', {katakana:true});

});
</script>

{/literal}
{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}{$category['denomination']}{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}

<form id="theForm" class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded" action="{$self}?mode=confirm">


{if $category['js']}
<script type="text/javascript">
{$category['js']}
</script>
{/if}

<div class="panel panel-default">
<div class="panel-heading">
{$category['denomination']}
</div>
<div class="panel-body">
{$category['description_web']|nl2br}
</div>
</div>


<h4 class="page-header">メールアドレス<span class="em08">（お申し込み控えのメールをお送りいたします）</span></h4>

{if $login}
<div class="form-group">
<label class="control-label col-sm-3">E-mail</label>
<div class="col-sm-9">
<p class="form-control-static">
{$auth_username} <span><a class="btn btn-primary" href="{$init_url}app/user/?mode=show_regist">登録情報の編集</a></span>
</p>
</div>
</div>
{else}

<div class="form-group">
<label class="control-label col-sm-3">E-mail<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="email" name="email" class="form-control input-lg validate[required,custom[email]" value="{$post['email']}" />
{if $email_err=="1"}<span class="must_view">*入力必須項目です</span>{/if}
{if $no_email_err=="1"}<span class="must_view">*E-mailアドレスが不正です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-3">E-mail<span class="em08">（確認）</span><span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="emailcfrm" name="emailcfrm" maxlength="64" class="form-control input-lg validate[required,custom[email],equals[email]]" value="{$post['emailcfrm']}" />
{if $emailcfrm_err=="1"}<span class="must_view">*入力必須項目です</span>{/if}
{if $no_emailcfrm_err=="1"}<span class="must_view">*E-mail（確認）アドレスが不正です</span>{/if}
{if $nonemail_err=="1"}<span class="must_view">*E-mailアドレスが一致していません。</span>{/if}
</div>
</div>
{/if}

<h4 class="page-header">入力項目</h4>

{$html}

<input type="hidden" id="code" name="code" value="{$post['code']}" />
<div class="box">
<div class="row">
<div class="col-sm-8 col-sm-push-2">
<button class="submit btn btn-primary btn-block" type="submit" name="confirm" value="1">入力内容を確認する<i class="fa fa-fw fa-chevron-right"></i></button>
</div></div>
</div>
</form>
{* メール編集フォーム 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}

