{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
$(function(){
$("#theForm").validationEngine('attach',{
	'promptPosition' : "inline",
		scrollOffset:200

});
});
</script>

<script type="text/javascript" src="/js/jquery/jquery.autoKana/jquery.autoKana.js"></script>
<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>

<script type="text/javascript">


$(function($){
	$('#new_zipcodef').zip2addr({
	zip2:'#new_zipcodes',
	pref:'#new_pref',
	addr:'#new_addressf'
	})
	$('#zipcodef').zip2addr({
	zip2:'#zipcodes',
	pref:'#pref',
	addr:'#addressf'
	})

});

$(function(){
	$.fn.autoKana('#namef', '#kanaf', {
		katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#nameg', '#kanag', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#ship_namef', '#ship_kanaf', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#ship_nameg', '#ship_kanag', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
});

</script>


{/literal}
{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}{$init_pagetitle}（アカウント基本情報入力）{/capture}

{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}


<form id="theForm" class="form-horizontal" action="{$self}?mode=confirm_end" method="post" enctype="x-www-form-urlencoded">

<h4>アカウント設定</h4>
<p class="pad_l">サインインIDとして使用します。</p>

<div class="form-group">
<label class="control-label col-sm-3">アカウント名</label>
<div class="col-sm-9">
<input type="hidden" id="user_name" name="user_name" maxlength="128" value="{$post['user_name']|default:$post['email']}" />
<p class="form-control-static input-lg">{$post['user_name']|default:$post['email']}</p>
<span class="help-block">ユーザーアカウントは登録メールアドレスになります</span>
{if $error['user_name']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-3">パスワード<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" name="password2" id="password" maxlength="16" class="form-control input-lg validate[required,minSize[8],maxSize[16],custom[onlyLetterNumber]" value="{$post['password2']}" placeholder="（半角英数混合8〜16文字）"/>
{if $error['no_password']}<span class="must_view">*パスワードの形式が不正です</span>{/if}
{if $error['not_pass']}<span class="must_view">*パスワードが一致しません</span>{/if}
{if $error['password2']}<span class="must_view">*必須項目です</span>{/if}
{if $error['week_password']}<span class="must_view">{$password_message}</span>{/if}
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-3">
パスワード（確認）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" name="passwordcfrm" id="passwordcfrm" maxlength="16" class="form-control input-lg validate[required,minSize[8],maxSize[16],equals[password],custom[onlyLetterNumber]]" value="{$post['passwordcfrm']}"/>
{if $error['no_passwordCfrm']}<span class="must_view">*パスワードの形式が不正です</span>{/if}
{if $error['not_pass']}<span class="must_view">*パスワードが一致しません</span>{/if}
{if $error['passwordCfrm']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>


<h4>ユーザー情報設定</h4>
{include file="post_name.tpl"}
{*
<label>大学名</label>
<p class="form-control input-lg">{$init_univname}</p>
{include file="post_dept.tpl"}

{include file="post_membership.tpl"}
{include file="post_new_add.tpl"}
{include file="post_student_phone.tpl"}
<tr><th class="mh" colspan="2">実家について</th></tr>
{include file="post_address.tpl"}
{include file="post_phonenumber.tpl"}

*}

<div class="box">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">

<p><button class="submit btn btn-primary btn-block" type="submit" name="confirm" value="入力内容確認">入力内容確認<i class="fa fa-fw fa-chevron-right"></i></button></p>
</div>
</div>
</div>
</form>

{* フッター部分の組み込み *}
{include file='footer.tpl'}

