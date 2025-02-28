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
{capture assign="page_title"}パスワード再発行手続き{/capture}
{* ページタイトル 終了 *}


{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

<p class="alert alert-success">送信が完了しました。</p>

<p>入力いただいたアドレスに送信したメールに記載されたURLにアクセスし、<br />
パスワードを変更してください。</p>
<br>

<p><a class="btn btn-primary" href="{$init_coopurl}"><i class="fa fa-fw fa-reply"></i>{$init_coopname}に戻る</a></p>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
