{* ヘッダー部分の組み込み *}
{capture assign="header_insert"}
{literal}



<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>


<style type="text/css">
div.error {
	color: #E74C34;
  border-radius: 4px;
	background-color: #FFFFFF;
	border: 2px solid #E74C34;
	padding:0.5em 1em;
	margin: 1em 0;
}
</style>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript">
$(function(){
		$('#errmsg').hide();

$("#formID").validationEngine({
 'promptPosition':'inline'
  ,'ajaxFormValidationMethod':'post'
});

	var act = $("#formID").attr("action");

	$("#formID").submit(function(){

	var passwd =$("#formID").serializeArray();

	$.ajax({
	url: act,
	type: "post",
	data: passwd,
	cache: false,
	async: false,
	success: function(err){
		 errs = $.parseJSON(err);
		if (errs.flag){		
		$('#errmsg').html(errs.msg).show();
		parent.$.fancybox.update();
}
		},
	error: function(){
		$('#errmsg').html('通信エラー').show();
		return false;
		}
	});


	if (errs.flag==0){
	parent.$.fancybox.close();
		parent.$('#msg').html(errs.msg).show();
}
//	parent.location.reload();
	return false;

	});
	return false;

	});


</script>

{/literal}
{/capture}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/js/jquery/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css" type="text/css"/>

{$header_insert}
</head>

<body style="font-size:small;text-align:left;">
{*include file='preview_header.tpl'*}

<div id="errmsg" class="alert alert-danger none"></div>

<form id="formID" method="post" enctype="multipart/form-data" action="{$init_url}adm/master/?mode=save_password">

{users id=$user_id}
<div class="form-group">
<label>ID</label>
<span class="form-control-static">{$user['username']}</span>
</div>
<div class="form-group">
<label>新パスワード</label>
<input type="password" id="password_new" name="password_new" value="" class="form-control validate[required,minSize[8],maxSize[16],custom[onlyLetterNumber]]" placeholder="半角英数8文字以上">
</div>
<div class="form-group">
<label>新パスワード（確認）</label>
<input type="password" name="password_cfrm" value="" class="form-control validate[required,minSize[8],maxSize[16],equals[password_new],custom[onlyLetterNumberSp]]" placeholder="確認のため入力ください">
</div>
{/users}

<input type="hidden" name="id" value="{$user_id}">
<p><button class="btn btn-primary" type="submit" value="パスワードを変更する">パスワードを変更する</button></p>


</form>


{if $db_error}
<p class="error">ユーザーの読み込みに失敗しました。</p>
{/if}

{* フッター部分の組み込み *}
{*include file='preview_footer.tpl'*}

</body>
</html>

