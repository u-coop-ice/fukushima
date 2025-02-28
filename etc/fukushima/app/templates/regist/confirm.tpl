{* ページタイトル 開始 *}
{capture assign="page_title"}アカウント登録（メールアドレス確認）{/capture}
{* ページタイトル 終了 *}

{capture assign="header_insert"}
<script type="text/javascript">
//<![CDATA[
$(function () {
	$('#theForm').submit(function(){
		$(this).find(':submit').button('loading');
	});
});
//]]>
</script>
{/capture}


{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


<p>入力内容をご確認ください。入力内容を修正したい場合は、「入力内容を修正」のボタンをクリックしてください。</p>

{if $page_title}<h4>{$page_title}</h4>{/if}

<div class="form-horizontal">
<div class="form-group">

<label class="col-sm-3 control-label">E-mail</label>
<div class="col-sm-9">
<p class="form-control-static">{$post['email']}</p>
</div>
</div>
</div>

<form id="returnForm" action="{$self}?mode=confirm" method="post" enctype="x-www-form-urlencoded">
<p class=""><button class="btn btn-primary" type="submit" name="reinput1" value="戻ってを修正"><i class="fa fa-fw fa-reply"></i>戻って修正</button></p>
</form>

<form id="theForm" action="{$self}?mode=confirm" method="post" enctype="x-www-form-urlencoded">

<div class="contact">
<div class="row">
<div class="col-sm-8 col-sm-offset-2"><p><button class="btn btn-success btn-block" type="submit" name="submit" value="受信確認メールを送信する" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>ただいま送信中です" autocomplete="off">受信確認メールを送信する<i class="fa fa-fw fa-chevron-right"></i></button></p>
</div>
</div>
<div class="clear"></div>

<p>登録されたメールアドレス宛に、アカウント登録申請フォームのURLアドレスをお送りしますので、届き次第アカウント登録申請をを行ってください。しばらく経ってもメールが届かない場合は、メールアドレスをご確認後、再度ご登録ください。</p>
</div>
</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
