{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
$(function(){
	$("#theForm").validationEngine({
	promptPosition : "inline",
	scrollOffset: 200,
	'ajaxFormValidationMethod': "post",
	'onValidationComplete': function(form, status){
		if (status === true){
		form.find(':submit').button('loading');
		return true;
		}
	}
	});
});
</script>

{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}メールアドレスの変更{/capture}
{* ページタイトル 終了 *}

{assign var='breadcrumb' value="<a href='{$init_coopurl}'>HOME</a> &gt; <a href='{$init_url}'>{$init_pagetitle}</a>  &gt; $page_title"}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}
<h4>{$page_title}</h4>



{if $saved}
<p class="saved">変更を保存しました。</p>
{/if}

<p class="alert alert-info">サインイン用登録アカウント（メールアドレス）も変更になります。</p>

<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=save_email">

<div class="form-group">
<label class="col-sm-3 control-label">アカウント</label>
<div class="col-sm-9">
<p class="form-control-static">{$regist['username']}</p>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">現在のメールアドレス</label>
<div class="col-sm-9">
<p class="form-control-static">{$regist['email']}</p>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">新しいメールアドレス<span class="label label-danger">必須</span></label>

<div class="col-sm-9">
<input type="email" id="email" name="email" value="{$post['email']}" class="form-control input-lg validate[required,custom[email]]" />
{if $error['no_email']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
{if $error['not_same_email']}<span class="must_view">*現在使用しているメールアドレスです</span>{/if}
{if $error['duplicate_email']}<span class="must_view">*このメールアドレスへは変更できません</span>{/if}
</div>
</div>

<p><button class="btn btn-primary" type="submit" name="submit" value="登録メールアドレスを変更する" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>ただいま送信中です" autocomplete="off"><i class="fa fa-fw fa-check"></i>登録メールアドレスを変更する</button></p>
</form>

{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_regist}
<p>登録が見当たりません。</p>
{/if}
{if $db_error}
<p>記事の読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
