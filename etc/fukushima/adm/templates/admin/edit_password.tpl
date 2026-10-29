{* ヘッダー部分の組み込み *}
{literal}



<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/adm/master/js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript">
$(function(){
		$('#errmsg').hide();

	$("#formPW").validationEngine('attach',{
	'promptPosition':'inline',
	'ajaxFormValidationMethod':'post',
	'onValidationComplete': function(form, status){
		if (status === true){
	var passwd =$("#formPW").serializeArray();

	$.ajax({
	url: "/adm/?mode=save_password",
	type: "post",
	data: passwd,
	cache: false,
	async: false,
	dataType: 'json'
	}).done(function(err){
		if (err.flag){
		$('#errmsg').html(err.msg).show();
		} else {
			alert('パスワードを変更しました。');
		$('#editModal').modal('hide');
		}
	}).fail(function(e){
		$('#errmsg').html('通信エラー'+console.log(e)).show();
		return false;
	});
	return false;
	}
}
});

});

</script>

{/literal}

<div id="errmsg" class="alert alert-danger none"></div>

<form id="formPW" method="post" enctype="multipart/form-data">

<div class="form-group row">
<label class="col-sm-3 control-label">ID</label>
<div class="col-sm-9">
<span class="form-control-static">{$auth_username}</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-3 control-label">新パスワード</label>
<div class="col-sm-9">
<input type="password" id="password_new" name="password_new" value="" class="form-control validate[required,minSize[8],maxSize[16],custom[onlyLetterNumber]]" placeholder="半角英数8文字以上">
</div>
</div>
<div class="form-group row">
<label class="col-sm-3 control-label">新パスワード（確認）</label>
<div class="col-sm-9">
<input type="password" id="password_cfrm" name="password_cfrm" value="" class="form-control validate[required,minSize[8],maxSize[16],equals[password_new],custom[onlyLetterNumberSp]]" placeholder="確認のため入力ください">
</div>
</div>

<input type="hidden" name="id" value="{$user['id']}">
<p><button class="btn btn-primary" type="submit" value="パスワードを変更する">パスワードを変更する</button></p>


</form>


{if $db_error}
<p class="error">ユーザーの読み込みに失敗しました。</p>
{/if}
