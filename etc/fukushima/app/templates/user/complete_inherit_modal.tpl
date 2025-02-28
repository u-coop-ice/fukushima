{* ヘッダー部分の組み込み *}
{capture assign="header_insert"}
{literal}


<style type="text/css">
html {
	width: auto;
	height: auto;
}

h3 {
	margin: 1em 0 0.5em 0;
	padding: 0 0 5px 0;
	color: #333;
	font-weight: normal;
	font-size: 140%;
	line-height: 1.2;
	letter-spacing: 0;
	text-transform: uppercase;
	text-decoration: none;
	border-bottom: 1px solid #b11216;
}
</style>

<script type="text/javascript" src="/js/jquery/jquery.cookie/jquery.cookie.js"></script>

<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>


<script type="text/javascript">
$(function(){

		$('#login_error').hide();

	var act = $("#formSignin").attr("action");

	var tmpURL = getTempURL();
//tmpURL = window.parent.location.href;

	$("#formSignin").submit(function(){
	    $("#login_error").removeClass('error').html('');
	if ($("#username").val().length < 1 || $("#password").val().length < 1) {
							$("#login_error").addClass('error').append('入力された内容が不正です。').show();
					return false;
	}



	$.fancybox.showLoading();
	var post =$("#formSignin").serializeArray();

	$.ajax({
	url: act,
	type: "post",
	data: post,
	cache: false,
	async: false,
	success: function(data){

		  var mdata = eval('('+data+')');
				if (mdata.msg){
					var msg = mdata.msg;
							$("#login_error").addClass('error').append(msg).show();
					$.fancybox.hideLoading();
					$.fancybox.update();
					return false;
				} else {
						$.cookie('_rmbm',mdata.rememberme,{expires: 30,path: '/'});
					$.fancybox.hideLoading();
					$.fancybox.close();
					top.location.href= tmpURL;
					return false;
				}
			},
		error : function(){
					$.fancybox.hideLoading();
					$("#login_error").addClass('error').append('通信エラーです。').show();
					$.fancybox.update();
					return false;
			}

	});

return false;


	});

return false;


	});


    function getTempURL() {
        var url   = window.parent.location.href;
        var tmpUrl = url.replace( /\?signout=1/g , "");
        return tmpUrl;
    }

$(function(){
$(".entry_step").on("click",function(){
	parent.$.fancybox.close();
	parent.$.fancybox("#entry_step1",{
		maxWidth: 600,
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
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1"> 

<script type="text/javascript" src="/js/jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.easing.1.3.js"></script>


<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="/css/fontawesome4/css/font-awesome.min.css" type="text/css" media="screen,print" />




{$header_insert}
</head>

<body style="text-align:left;">


{if $msg}<p class="alert alert-success">{$msg}</p>
{else if $errmsg}<p class="alert alert-danger">{$errmsg}</p>
{/if}

{if $result<8}
<div id="login_error" class="error msg">{$login_msg}</div>



<form id="formSignin" method="post" action="/app/signin/index.php">
<div class="form-group">
<label>ユーザーID</label>

<input type="hidden" name="username" id="username" class="form-control input-lg" value="{$username}" />
<p class="form-control-static">{$username}</p>
</div>
<div class="form-group">
<label>パスワード</label>
<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" />
</div>

<div class="checkbox">
<label for="rememberme" >
<input type="checkbox" id="rememberme" name="rememberme" value="1" checked="checked" />次回から自動でサインインする</label>
</div>

<p><input class="btn btn-success btn-block" type="submit" name="login" value="サインイン" /></p>


</form>
{/if}
</body>
</html>
