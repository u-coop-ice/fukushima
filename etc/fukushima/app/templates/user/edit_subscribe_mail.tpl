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
		promptPosition: 'inline',
		scrollOffset:200
	});
});

</script>

{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}メール配信設定の変更{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


{if $saved}
<p class="alert alert-success">変更を保存しました。</p>
{/if}


<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=save_subscribe_mail">

<p class="alert alert-info">{$init_coopname}が配信しているメールマガジン・生協からのお知らせの配信設定の変更が行えます。<br />各種お申込み・各種講座の登録などに関連したお知らせメールは対象とはなりません。予めご了承下さい。</p>


<div class="form-group">
<label class="col-sm-3 control-label">ニュースレーター・生協からのお知らせ</label>
<div class="col-sm-9">
<div class="radio">
{html_radios name="dm" options=$dmList checked=$regist['dm']|default:0}
</div>
{if $dm_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<p><button class="btn btn-primary" type="submit" name="submit" value="配信設定を変更する"><i class="fa fa-fw fa-check"></i>配信設定を変更する</button></p>
</form>




{* フッター部分の組み込み *}
{include file='footer.tpl'}
