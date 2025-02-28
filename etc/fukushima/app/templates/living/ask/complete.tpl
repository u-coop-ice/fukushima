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
{capture assign="page_title"}お問い合わせ{/capture}
{* ページタイトル 終了 *}


{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


<p class="alert alert-success">{$msg_title}</p>
<h5>{if $auth_username}{$auth_username}{else}{$post_namef} {$post_nameg}{/if}様</h5>
<p class="pad_l">{$msg}</p>

<p><a class="btn btn-primary" href="{$init_url}"><i class="fa fa-fw fa-reply"></i>{$init_coopname}に戻る</a></p>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
