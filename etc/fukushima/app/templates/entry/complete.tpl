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
{capture assign="page_title"}{$category['denomination']} 送信完了{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

<p class="alert alert-success">送信が完了しました。</p>

{if $post['namef']}<p>{$post['namef']} {$post['nameg']}様</p>{/if}
<p>{$category['denomination']}
を承りました。<br>
入力いただいたアドレスに送信完了メールを送信しました。<br />
<br />
しばらく経ってもメールが届かない場合は、迷惑メールフォルダなどに紛れ込んでいる場合があります。また、携帯アドレスをご登録されている場合は、携帯電話のメール受信設定を確認してください。なお、生協へは送信されていますので再送の必要はありません。
</p>
<br>

<p><a class="btn btn-primary" href="{$init_coopurl}"><i class="fa fa-fw fa-reply"></i>トップページに戻る</a></p>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
