{* ヘッダー部分の組み込み *}
{capture assign="header_insert"}

{literal}



<style type="text/css">
html {
	width: auto;
	height: auto;
}

</style>

<script type="text/javascript" src="/js/jquery/jquery.cookie/jquery.cookie.js"></script>

<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
$(function(){

	$('#form_signin').find('input').prop('disabled',true);

	$('#login_error').hide();

	var act = $("#formSignin").attr("action");
	var tmpURL = getTempURL();

	$("#formSignin").submit(function(){
	$("#login_error").removeClass('error').html('');

	var post =$(this).serializeArray();
	var step = $(this).attr("data");
	post.push({name:"step",value:step});

//	if (!$("#user_check").prop('disabled')){
	if (step==1){
		if (post[0].value.length < 1) {
			return displayError('入力された内容が不正です。');
		}
	} else {
		if (post[0].value.length < 1 || post[1].value.length < 1) {
		return displayError('入力された内容が不正です。');
		}
	}

// userCheck
	$.fancybox.showLoading();

	$.ajax({
	url: act,
	type: "post",
	data: post,
	dataType: "json",
	cache: false,
	async: false
	}).done(function(d){
				if (d.msg){
					var msg = d.msg;
					displayError(msg);
					$.fancybox.hideLoading();
					$.fancybox.update();
					return false;
				} else if (step==1 && d.ct==1) {
					$('#form_signin').show().find('input').prop('disabled',false);
					$('#user_check').hide().find('input').prop('disabled',true);
					$('#username').prop('readonly',true);
					$('#password').focus();
					$("#formSignin").attr("data",2);
					var remind = $("#remindme").attr("href")
					$("#remindme").attr("href",remind+'&username='+encodeURI($("#username").val()));
					$.fancybox.hideLoading();
					$.fancybox.update();
					return false;
				} else if (step==2){
					if(d.signin){
					$.fancybox.hideLoading();
					$.fancybox.close();
					top.location.href= tmpURL;
					return false;
					} else {
					var msg = d.msg;
					displayError(msg);
					$.fancybox.hideLoading();
					$.fancybox.update();
					return false;
					}
				} else {
					$('#create_user').show();
					$('#username').prop('readonly',true);
					$('#user_check').hide().find('input').prop('disabled',true);
					appendQuery();
					$.fancybox.hideLoading();
					$.fancybox.update();
					return false;
				}
			}).fail(function(e){
				console.log(e);
					$.fancybox.hideLoading();
					displayError('通信エラーです。');
					$.fancybox.update();
					return false;
			});
	return false;
	});

	$("#return2step1").on('click',function(){
		$('#create_user').hide().prop('disabled',true);
		$('#user_check').show().prop('disabled',false);
		$('#username').prop('readonly',false);
	});

});

	function displayError(errmsg){
		$("#login_error").addClass('error').append(errmsg).show();
	return false;
}

    function detectTempURL() {
        var url   = location.href;
        parameters    = url.split("?");

        var paramsArray = [];
        for (var j=1;j<parameters.length;j++){
        params = parameters[j].split("&");

        for ( i = 0; i < params.length; i++ ) {
            neet = params[i].split("=");
            if (neet[0]!='logout'){
            paramsArray.push(neet[0]);
            paramsArray[neet[0]] = neet[1];
        	}
        }
    	}
        return paramsArray;
    }


    function getTempURL() {
    	var pa = detectTempURL();

		var tmpUrl = pa['tempURL'];

		var q = [];

		$.each(pa, function(k, qr) {
		if (qr!= 'tempURL' && pa[qr]){
	 	q.push(qr+'='+pa[qr]);
		}
		if (pa['mode']=='set_pack'){
	 	q.push('step2=1');
		}
		});

	if (q.length>0){
	var qs = q.join('&');
	tmpUrl += '?'+qs;
	}
	return tmpUrl;
}

	function appendQuery(){
	var email = $("#username").val();

    var pa = detectTempURL();
	var href= "{/literal}{$init_url}{literal}app/regist/"
	if (email){
		href += "?email="+encodeURIComponent(email);
	}

    dm = pa['tempURL'].split("/");

	if (dm[3]=='app' && dm[4]!=''){
	href += "&reffer=" + encodeURIComponent(dm[4]);
		if (dm[5] && dm[5]!='index.php'){
		href += "&part=" + encodeURIComponent(dm[5]);
		}
	}

	if (pa['mode']){
	href += "&md=" + encodeURIComponent(pa['mode']);
	}
	if (pa['cd']){
	href += "&cd=" + encodeURIComponent(pa['cd']);
	}

	$("#from2entry").attr("href",href);
	return;
	}


$(function(){
$(".entry_step").on("click",function(){
	var email = $("#username").val();

    var pa = detectTempURL();
	var href= "{/literal}{$SITE_URLS}{literal}app/regist/"
	if (email){
		href += "?email="+encodeURIComponent(email);
	}

    dm = pa['tempURL'].split("/");
	if (dm[4]=='app' && dm[5]!=''){
	href += "&reffer=" + encodeURIComponent(dm[5]);
	}

	if (pa['mode']){
	href += "&mode=" + encodeURIComponent(pa['mode']);
	}
	if (pa['lst']){
	href += "&lst=" + encodeURIComponent(pa['lst']);
	} else if (pa['cic']){
	href += "&cic=" + encodeURIComponent(pa['cic']);

	}

	var pw = window.parent;
	parent.$.fancybox.close();
	parent.$.fancybox.open({
	'type': 'iframe',
 	'width': pw.innerWidth*0.8,
	'minHeight': pw.height*0.6,
	'height': pw.height*0.8,
	'maxWidth': 600,
 	'href': href
 	});

	return false;
});
});

</script>

{/literal}
{/capture}
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex,nofollow">


<script type="text/javascript" src="/js/jquery/jquery-1.11.2.min.js"></script>

<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="/css/fontawesome4/css/font-awesome.min.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="/css/common.css" type="text/css" media="screen,print" />


{$header_insert}
</head>

<body style="text-align:left;background-color:#FBFBFB;">

<div id="login_error" class="alert alert-danger">{$login_msg}</div>

<form id="formSignin" role="form" data="1" method="post" action="{$init_url}app/signin/index.php">
<div class="form-group">
<label>サインイン／新規登録</label>
<input type="text" name="username" id="username" class="form-control input-lg" value="{$post_username}" placeholder="メールアドレス／アカウント" />
</div>


<div id="user_check"><button class="btn btn-primary" type="submit" name="user_check" value="続ける">続ける<i class="fa fa-fw fa-chevron-right"></i></button>


{if $init_inherit}
<h4>新入生サポートセンター･説明会･Tea-Partyなどのご予約で<i class="wf_newlife"></i>受験生・新入生サポートサイトにユーザー登録をされた方</h4>
<p><a class="btn btn-warning btn-block" href="/app/user/inherit.php">アカウント引継ぎ <i class="fa fa-chevron-right"></i></a></p>
{/if}

</div>
<div id="form_signin" class="none">
<div class="form-group">
<label>パスワード</label>
<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" />
</div>

<div class="checkbox">
<label for="rememberme" >
<input type="checkbox" id="rememberme" name="rememberme" value="1" checked="checked" />次回から自動でサインインする</label>
</div>

<p><input class="btn btn-success btn-block" type="submit" name="login" value="サインイン" /></p>


<p><a id="remindme" href="{$init_url}app/regist/?mode=remind" target="_TOP">パスワードを忘れた方はこちら <i class="fa fa-chevron-right"></i></a></p>
</div>

</form>


<div id="create_user" class="none">
{*if $auth_set['entry']*}

<p><a id="from2entry" class="btn btn-success btn-block" href="{$init_url}app/entry/" target="_top">新規登録はこちらから<i class="fa fa-fw fa-chevron-right"></i></a></p>
<p class="help-block">上記メールアドレスで新規ユーザー登録を行います。</p>
{*else}
<p class="alert alert-danger">現在、新規ユーザーの登録を停止しています。</p>
{/if*}

{if $init_inherit}
<h4>新入生サポートセンター･説明会･Tea-Partyなどのご予約で<i class="wf_newlife"></i>受験生・新入生サポートサイトにユーザー登録をされた方</h4>
<p><a class="btn btn-warning btn-block" href="/app/user/inherit.php">アカウント引継ぎ <i class="fa fa-chevron-right"></i></a></p>
{/if}

<p><a class="btn btn-primary" id="return2step1"><i class="fa fa-fw fa-chevron-left"></i>戻る</a></p>
</div>
</body>
</html>
