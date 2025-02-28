{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
//<[!CDATA[
$(function(){
	$("#theForm").validationEngine({
	promptPosition: 'inline'
	});
});

function submitCheck() {
return confirm('退会処理を完了してよろしいですか？\nこの操作は取り消せません。');
}
//]]>
</script>



{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}退会手続き{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


{* 記事編集フォーム 開始 *}


{if $saved}
<p class="note">変更を保存しました。</p>
{/if}


<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=remove_username" onsubmit="return submitCheck();">

<p class="pad_l">{$init_coopname}サイトのアカウントを削除しようとしています。削除すると、当サイトへの申込情報などが確認できなくなり、アカウント情報が失われます。この内容について理解して手続きを行ってください。
</p>

<h4>アカウント情報</h4>

<div class="form-group">
<label class="col-sm-3 control-label">アカウント</label>
<div class="col-sm-9"><p class="form-control-static">{$regist['username']}</p></div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">パスワード<span class="label label-danger">必須</span></label>
<div class="col-sm-9"><input type="password" id="password" name="password" value="{$post['password']}" class="form-control validate[required,custom[onlyLetterNumber]]" />
{if $error['not_password']}<span class="must_view">*パスワードが違います</span>{/if}
{if $error['no_han_password']}<span class="must_view">*半角英数で入力してください</span>{/if}
</div>
</div>
<h4>退会理由</h4>

<div class="form-group">
<label class="col-sm-3 control-label">理由<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
{foreach from=$reasonList key=k item=v}
{if $k>0}
<div class="radio">
<label for="reason{$k}" >
<input type="radio" name="reason" id="reason{$k}" class="validate[required]" value="{$k}" {if $post['reason']==$k}checked="checked"{/if} /> {$v}</label>
</div>
{/if}
{/foreach}
{if $error['reason']}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">詳細をご記入ください</label>
<div class="col-sm-9"><textarea id="reason_memo" name="reason_memo" class="form-control" >{$post['reason_memo']}</textarea></div>
</div>

<div class="box">
<h5>継続中のお申込み・ご注文がある場合は、それらの内容を当サイトから確認できなくなることにご留意ください。退会することでお申込みを取消（キャンセル）することにはなりません。</h5>

<div class="form-group">
<p class="center checkbox"><label for="responsibility" ><input type="checkbox" id="responsibility" name="responsibility" value="1"  {if $post['responsibility']}checked="checked"{/if} class="validate[required]" />継続中のお申込み・ご注文内容を確認できなくなることを理解しました。</label></p>
</div>
<p class="center"><input class="btn btn-primary" type="submit" name="submit" value="アカウントを削除し退会する" /></p>
</div>
</form>


{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_regist}
<p class="alert-info">登録が見当たりません。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
