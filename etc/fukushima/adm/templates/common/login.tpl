{assign var='page_title' value='サインイン'}

{capture assign="header_insert"}
{literal}
<script type="text/javascript">

$(function(){
	$("#error_msg").text('').hide();


  $('#authForm').submit(function(){
	var act = '/adm/?mode=auth_1st_step';

	$.ajax({
	url: act,
	type: "post",
	data: $('#authForm').serializeArray(),
	cache: false,
	async: true,
	dataType: "json"
	}).done(function(e){
//		hideLoading();
		$("#error_msg").text(e.error).hide();

		if (e.error){
		$("#error_msg").text(e.error).show();
		return false;
		} else if (e.qrcodeurl){
			let qr = $('<img />').attr('src',e.qrcodeurl).addClass('img-thumbnail').addClass('center');
			$("#qrcode_url").append(qr);
			$("#qrcode_secret").append(e.new_secret).find('input').prop('disabled',false);
			$("#form-group_qrcodeurl").removeClass('hidden');
			$("#form-group_onecode").removeClass('hidden').find('input').prop('disabled',false);
			$("#notice").hide();
			$("#global_footer").css("position","relative");

		} else if (e.secret){
			$("#form-group_onecode").removeClass('hidden').find('input').prop('disabled',false).focus();
			$("#notice").hide();
		} else if (e.valid===true){
			let url = document.location.href.split(/[?#]/)[0];
			location.href = url;
			return false;
		}
		return false;
	}).fail(function(e){
		console.log(e);
//		hideLoading();
		alert('保存に失敗しましたよ。');
		return false;
		}
	);
	return false;
	});


});
</script>


{/literal}
{/capture}



{include file='header.tpl'}


<div class="login">
<div class="login-inner">
<div class="center">
<h5>
<div class="logo-icon"><i class="fa fa-cogs"></i></div>{$page_title}</h5>

<p id="error_msg" class="alert alert-danger">{$msg}</p>

<form id="authForm" method="post">

<div id="form-group_username" class="form-group">
<label>
<input type="text" name="user_name" id="username" class="form-control input-lg" placeholder="管理ユーザー名" value="{$post_username}"  />
</label>
</div>

<div id="form-group_password" class="form-group">
<label>
<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" />
</label>
</div>

<div class="mb-3 hidden form-group" id="form-group_qrcodeurl">
<p class="help-block em09">スマホ等の2段階認証アプリからQRコードを読み取り表示される数字6桁の番号を入力します。</p>
<div id="qrcode_url" class="mb-1"></div>
<div id="qrcode_secret" class="center user-select-all"><input type="hidden" name="new" value="1" disabled="disabled" /></div>
</div>

<div class="mb-3 hidden form-group" id="form-group_onecode">
<input class="form-control input-lg" type="tel" name="onecode" size="10" maxlength="6" placeholder="（認証コード）" disabled="disabled" />
</div>



<input class="btn btn-success btn-block" type="submit" name="login" value="サインイン" />
</form>


</div>
</div>

</div>
</div>


<div class="row">
<div class="col-sm-12">

<div id="notice">
<p class="help-block">管理画面へのサインインは2段階認証が必要になりました。認証システムアプリを使用していない場合は、事前に認証システムアプリ（Microsoft Authenticator、Google Authenticatorなど）をインストールしておいて下さい。</p>

<p class="help-block">管理アカウントでサインインできなくなったときは、事業連合HPGヘご連絡ください。</p>
</div>


</div>
</div>

<div class="clearfix"></div>

{include file='footer.tpl'}
