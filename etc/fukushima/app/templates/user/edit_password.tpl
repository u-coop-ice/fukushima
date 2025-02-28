{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>

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
{capture assign="page_title"}パスワードの変更{/capture}
{* ページタイトル 終了 *}

{assign var='breadcrumb' value="<a href='{$init_coopurl}'>HOME</a> &gt; <a href='{$init_url}'>{$init_pagetitle}</a>  &gt; $page_title"}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}
<h4>{$page_title}</h4>



{if $saved}
<p class="saved">変更を保存しました。</p>
{/if}

<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=save_password">

<div class="form-group">
<label class="col-sm-3 control-label">アカウント</label>
<div class="col-sm-9">
<p class="form-control-static">{$regist['username']}</p>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">現在のパスワード<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" id="password_cur" name="password_cur" value="{$post['password_cur']}" class="form-control input-lg validate[required,custom[onlyLetterNumber]]" />
{if $error['the_same_password']}<p><span class="must_view">*現在のパスワードと同じです</span></p>{/if}
{if $error['not_password']}<p><span class="must_view">*パスワードが違います</span></p>{/if}
{if $error['no_password_cur_alnum']}<p><span class="must_view">*半角英数で入力してください</span></p>{/if}
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">新しいパスワード<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" id="password_new" name="password_new" value="{$post['password_new']}" class="form-control input-lg validate[required,minSize[8],maxSize[16],custom[onlyLetterNumber]]" placeholder="（半角英数8〜16文字）" />
{if $error['the_same_password']}<p><span class="must_view">*現在のパスワードと同じです</span></p>{/if}
{if $error['no_same_password']}<p><span class="must_view">*パスワードが一致しません</span></p>{/if}
{if $error['no_password_new_alnum']}<p><span class="must_view">*半角英数で入力してください</span></p>{/if}
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">新しいパスワード（確認）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" id="passwordcfrm" name="passwordcfrm" value="{$post['passwordcfrm']}"  class="form-control input-lg validate[required,minSize[8],maxSize[16],equals[password_new],custom[onlyLetterNumber]]" />
{if $error['no_same_password']}<p><span class="must_view">*パスワードが一致しません</span></p>{/if}
{if $error['no_passwordcfrm_alnum']}<p><span class="must_view">*半角英数で入力してください</span></p>{/if}
</div>

</div>

<p><button class="btn btn-primary" type="submit" name="submit" value="パスワードを変更する" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>ただいま送信中です" autocomplete="off"><i class="fa fa-key fa-fw"></i>パスワードを変更する</button></p>
</form>


{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_regist}
<p class="alert alert-danger">登録が見当たりません。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
