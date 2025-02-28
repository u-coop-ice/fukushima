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
	scrollOffset: 200
});
});
</script>

{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}パスワードの再設定{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

<h4>{$page_title}</h4>

{if $saved}
<p class="alert alert-success">変更を保存しました。</p>
{/if}


<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=confirm_password">

<div class="form-group">
<label class="control-label col-sm-3">アカウント</label>
<div class="col-sm-9">
<p class="form-control-static">{$post['username']|default:$regist['username']}</p>
<input type="hidden" name="user_name" value="{$post['username']|default:$regist['username']}" />
<input type="hidden" name="tmp_code" value="{$post['tmp_code']|default:$regist['tmp_code']}" />
</div>
</div>

<div class="form-group">

<label class="control-label col-sm-3">新しいパスワード<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" id="password" name="password" value="{$post['password']}" class="form-control input-lg validate[required,minSize[8],maxSize[16],custom[onlyLetterNumber]]" placeholder="(半角英数8〜16文字)" />
{if $error['password']}<p><span class="must_view">*入力必須項目です</span></p>{/if}
{if $error['not_password_length']}<p><span class="must_view">*パスワードの形式が不正です</span></p>{/if}
{if $error['no_password_alnum']}<p><span class="must_view">*半角英数で入力してください</span></p>{/if}
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-3">新しいパスワード（確認）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="password" id="passwordcfrm" name="passwordcfrm" value="{$post['passwordcfrm']}"  class="form-control input-lg validate[required,minSize[8],maxSize[16],equals[password],custom[onlyLetterNumber]]" />
{if $error['no_same_password']}<p><span class="must_view">*パスワードが一致しません</span></p>{/if}
</div>
</div>

<p><button class="btn btn-success" type="submit" name="submit" value="パスワードを再設定する"><i class="fa fa-fw fa-key"></i>パスワードを再設定する</button></p>
</form>

<br />


{* フッター部分の組み込み *}
{include file='footer.tpl'}
