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
{capture assign="page_title"}メール受信確認{/capture}
{* ページタイトル 終了 *}


{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



<h4>送信が完了しました。</h4>

<p class="alert alert-success">現在、仮登録中です。</p>
<p>入力いただいたアドレスに送信したメールに記載されたURLに10分以内にアクセスし、<br />
ユーザー登録を完了させてください。</p>
<div class="box">
<h4>【メールが届かない！？】</h4>
<ul class="tri">
<li>入力されたメールアドレスが間違っている場合があります。再度ご登録ください。</li>
<li>ドメイン指定受信機能をご利用の場合は、メールが届かない場合があります。「u-coop.or.jp」ドメインの指定後、再度ご登録ください。</li>
<li>迷惑メールに判別されている可能性もあります。迷惑メールフォルダ等をご確認ください。</li>
</ul>
</div>

<p><a class="btn btn-primary" href="{$init_coopurl}"><i class="fa fa-fw fa-reply"></i>{$init_coopname}に戻る</a>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
