{capture assign="header_insert"}
{literal}

<script type="text/javascript">
window.onload=function(){
   window.addEventListener("keydown",reloadoff,false);
 }
 function reloadoff(evt){
   evt.preventDefault();
}
</script>

{/literal}
{/capture}

{* ページタイトル 開始 *}
{capture assign="page_title"}{$init_pagetitle}（ユーザー登録完了）{/capture}
{* ページタイトル 終了 *}


{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

<h4>{$page_title}</h4>

<p>{$post['email']}さま</p>
<p class="alert alert-success">{$init_coopname}サイトへのユーザー登録が完了しました。</p>
<p>下記リンクから{$init_coopname}にアクセスください。</p>
<br>

{if $reffer['reffer']}

<p class=""><span class="red">お申込みは完了しておりません。「お申込みを続ける」から必要項目を入力しお申込みを完了させてください。</p>

<form name="login" method="post" action="/app/{$reffer['reffer']}/{if $reffer['part']}{$reffer['part']}/{/if}{if $reffer['cd']}?cd={$reffer['cd']}{else if $reffer['md']}?mode={$reffer['md']}{/if}">
<input type="hidden" name="username" id="username" value="{$post['email']}" />
<input type="hidden" name="password" id="password" value="{$post['password2']}" />
<p><label for="rememberme"><input data-role="none" type="checkbox" id="rememberme" name="rememberme" value="1" checked="checked" />自動的にサインイン</label></p>
<button class="btn btn-primary" type="submit" name="login" value="お申込みを続ける">お申込みを続ける<i class="fa fa-fw fa-chevron-right"></i></button>

</form>
{else}
<form name="login" method="post" action="{$init_url}">
<input type="hidden" name="username" id="username" value="{$post['email']}" />
<input type="hidden" name="password" id="password" value="{$post['password2']}" />
<p><label for="rememberme" ><input data-role="none" type="checkbox" id="rememberme" name="rememberme" value="1" checked="checked" />自動的にサインイン</label></p>
<button class="btn btn-primary" type="submit" name="login" value="{$init_coopname}へサインイン" >{$init_coopname}へサインイン<i class="fa fa-fw fa-chevron-right"></i></button>
</form>
{/if}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
