{* ヘッダー部分の組み込み *}
{capture assign="header_insert"}
{literal}



<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>


<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>


<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>

<script type="text/javascript">

$(function(){

	var fm =$("#form")
	var act = fm.attr("action");

fm.validationEngine('attach', {
	'promptPosition' : "inline",
	'onValidationComplete': function(form, status){
if (status == true){
	$.fancybox.showLoading();
	$.ajax({
	url: act,
	type: "post",
	data: fm.serializeArray(),
	cache: false,
	async: false,
	dataType: "json"
	}).done(function(e){
		if (e.errmsg){
		$.fancybox.hideLoading();
		alert('保存に失敗しました。'+e.errmsg);
		return false;
		} else {
		parent.$.fancybox.close();
		parent.location.reload();
		$.fancybox.hideLoading();
		return false;
		}
		}).fail(function(e){
		$.fancybox.hideLoading();
		console.log(e);
		alert('保存に失敗しましたよ。');
		return false;
		});
}

  }
});



});

</script>

{/literal}
{/capture}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="/js/jquery/jquery-2.1.4.min.js"></script>

<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="/css/base.css" />
<link rel="stylesheet" href="/css/fontawesome4/css/font-awesome.min.css" />


{$header_insert}

<style type="text/css">
body {
	width: 200px;
	text-align: left;
	padding:0;
}
h4 {
	margin: 0;
	font-weight: bold;
	font-size: 130%;
	line-height: 1.2;
	letter-spacing: 0;
	color: #3b536b;
	text-decoration: none;
}
</style>
</head>

<body>
{*include file='preview_header.tpl'*}

<h4 class="top">メール配信の編集</h4>

{if $view_regist_id}
{regists rid=$view_regist_id}

<form id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="./?mode=save_subscribe_mail">

<div class="form-group">
<label class="col-sm-3 control-label">生協からのお知らせ配信設定</label>
<div class="col-sm-9">
<div class="radio">
{html_radios options=$dmList name="dm" selected=$regist['dm']|default:0}
</div>
</div>
</div>

<p><button class="btn btn-primary" type="submit" value="保存する">保存する</button></p>

<input type="hidden" id="regist_id" name="regist_id" value="{$regist['id']}" />
</form>
{/regists}
{/if}

{if $db_error}
<p class="error">ユーザーの読み込みに失敗しました。</p>
{/if}

{* フッター部分の組み込み *}
{*include file='preview_footer.tpl'*}

</body>
</html>

