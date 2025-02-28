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
	font-size: 130%;
	line-height: 1.2;
	letter-spacing: 0;
	text-transform: uppercase;
	text-decoration: none;
	border-bottom: 1px solid #b11216;
}
.rule_membership {
	height: 13em;
	overflow: auto;
	padding: 0.5em;
	margin: 0px;
	border:1px solid #CCCCCC;
}
</style>


<script type="text/javascript" src="/js/jquery/jquery.cookie/jquery.cookie.js"></script>

<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
$(function(){
	$("#agreement").on('click',function(){
		if ($(this).prop('checked')){
			$("#btn_transit").show();
			window.location.hash = "btn_transit";
		} else {
			$("#btn_transit").hide();
		}
	})
			$("#btn_transit").hide();
});


$(function() {
	$('#btn_transit').submit(function(){

if (confirm('受験生･新入生サポートサイトへ移動し、引き継ぐアカウントの認証を行います。')){
		$(this).find(':submit').button('loading');
} else {
	return false;
}
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

<script type="text/javascript" src="/css/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="/css/fontawesome4/css/font-awesome.min.css" type="text/css" media="screen,print" />


{$header_insert}
</head>

<body style="text-align:left;">
<p class="alert alert-info">{$init_coopname}サイト会員規約に同意した上で会員登録してください。</p>

{include file="../regist/agree_membership.tpl"}

<form id="btn_transit" action="{#init_newlifeurl#}{$smarty.const.COOP_DOMAIN}/app/user/transit.php">
<button class="btn btn-warning btn-block" type="submit" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>ページを読み込んでいます" autocomplete="off">次へ <i class="fa fa-chevron-right"></i></button>
</body>
</html>
