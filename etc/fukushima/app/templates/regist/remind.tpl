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


{* ページタイトル 開始 *}
{capture assign="page_title"}パスワードを忘れた方へ{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}

<h4>{$page_title}</h4>
<div class="alert alert-info">
<p>ご登録いただいたメールアドレスをご入力いただき、【メールを送信する】ボタンを押してください。ご入力いただきましたメールアドレス宛にパスワード変更手続きのメールを送信いたします。</p>
</div>

<form id="theForm" class="form-horizontal" action="{$self}?mode=remind_email" method="post" enctype="x-www-form-urlencoded">

<div class="form-group">
<label class="control-label col-sm-3">E-mail<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="email" name="email" id="email" maxlength="128" class="form-control input-lg validate[required,custom[email]]" value="{$post['email']}"/>
{if $error['no_email']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
{if $error['not_email']}<span class="must_view">*該当するメールアドレスがございませんでした。ご確認の上、再度ご入力ください。</span>{/if}
{if $error['email']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<p><button class="btn btn-primary" type="submit" name="remind" value="送信する"><i class="fa fa-fw fa-envelope-o"></i>メールを送信する</button></p>
</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}

