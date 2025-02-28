{* ヘッダー部分の組み込み *}
{assign var="init_pagetitle" value=""}

{capture assign="header_insert"}
{literal}

<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />


<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">

$(function(){

	var fm =$("#formID")
	var act = fm.attr("action");

	fm.validationEngine('attach', {
	'promptPosition' : "inline",
	'onValidationComplete': function(form, status){

	if (status == true){

	var confirm = window.confirm('入力された内容を送信します。');

	if(!confirm){
		return false;
	}

	var json =fm.serializeArray();

	$.fancybox.showLoading();
	$.ajax({
	url: act,
	type: "post",
	data: json,
	cache: false,
	async: false,
	dataType: "json"
	}).done(function(e){
			if (e.errmsg){
			$.fancybox.hideLoading();
			alert(e.errmsg);
			return false;
			} else {
			parent.$.fancybox.close();
			if (e.code){
			parent.location.href = "./?mode=show_mail&adic="+e.code;
			} else {
			parent.location.href = "./?mode=list_mail";
			}
			return false;
			}
		}).fail(function(e){
		$.fancybox.hideLoading();
		alert('通信エラーです。');
		return false;
		});
	}

	return false;

	}
	});

		return false;

});

</script>

<script type="text/javascript">

$(function(){
	$('.edit-close').on('click',function(){
	parent.$.fancybox.close();
	})
});

</script>



{/literal}
{/capture}


{include file='preview_header.tpl'}

<style type="text/css">

#wrapper {
	width: 100%;
	max-width: 700px;
	min-width: 100%;
	background-image:none;
	padding:0px;
	margin: 0 auto;
}
</style>


<div id="content">


<h4 class="top">メッセージの作成</h4>
<form id="formID" method="post" class="form-horizontal" action="./?mode=save_mail" enctype="multipart/form-data">

<div class="form-group">
<label class="control-label col-sm-3">件名</label>
<div class="col-sm-9">

<input type="hidden" id="mail_subject" name="mail_subject" value="{$return['subject']}" />
<p class="form-control-static">{$return['subject']}</p>
</div>

</div>
<div class="form-group">
<label class="control-label col-sm-3">本文</label>
<div class="col-sm-9">
<textarea id="mail_body" name="mail_body" class="form-control input-lg validate[required]" autofocus>



{$return['memo']|add_quote}
</textarea>
</div>
</div>

<div class="box center">
<p class=""><button class="btn btn-success btn-block" type="submit" name="send" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>ただいま送信中です。" value="1" autocomplete="off">この内容で送信<br class="visible-xs-block" />（この操作は取り消せません）</button></p>

<input type="hidden" name="app_id" value="{$view_app_id}" />
<input type="hidden" name="root_id" value="{if $view_root_id}{$view_root_id}{else}{$view_add_id}{/if}" />
<p class="center">ご利用のブラウザおよび通信環境によっては、送信完了まで時間がかかる場合がございます。<br />送信が完了するまでしばらくお待ちください。</p>
</div>

</form>
<div class="edit-close"><a class="btn btn-primary"><i class="fa fa-fw fa-times"></i>キャンセル</a></div>





{if $db_error}
<p>データベースからデータを読み込むのに失敗しました。</p>
{/if}

</div><!-- content -->

{* フッター部分の組み込み *}
{include file='preview_footer.tpl'}
