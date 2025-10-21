<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT" />
<title>{$init_pagetitle} 管理画面 :: {$init_coopname}</title>



<link rel="shortcut icon" href="/favicon.ico">

<!-- jquery.js -->
<script type="text/javascript" src="/js/jquery/jquery-2.1.4.min.js"></script>

<link rel="stylesheet" href="/js/jquery/jquery.flexnav/jquery.flexnav.newlife.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.flexnav/jquery.flexnav.tabnav.js"></script>
<script type="text/javascript" src="/js/jquery/hoverIntent.js"></script>

<link rel="stylesheet" href="/css/import.css" />
<link rel="stylesheet" href="/{$smarty.const.ADM_DIR}css/import.css?20201005" type="text/css" media="screen,print" />
<script src="/css/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(function() {
	var topBtn = $('#page2top');
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
});


$(function(){
	$('.btn-copy-clipboard').on('click',function(){
		let copy = $(this).text();
		navigator.clipboard.writeText(copy);
		alert('クリップボードに保存しました。')
	})
});

</script>

<style type="text/css">
#global_tab #tab ul.flexnav > li a {
	padding: 10px 8px 10px;
}
</style>

{$header_insert}
</head>

<body>

<div id="wrapper">

<div id="pagebody">

{include file="header_wrapper.tpl"}

<div id="contentheader" class="container">

<!-- breadcrumb -->
<div id="breadcrumb">
<a href="{$init_url}adm/">HOME</a>&nbsp;&gt;&nbsp;<a href="{$init_url}adm/{$smarty.const.COMPONENT}/">{$init_pagetitle}</a>
</div><!-- /breadcrumb -->

</div><!-- contentheader -->

<div class="clear"></div>

<div id="content" class="container">

<div id="container">


{if $show_menu}
<div id="sub" class="left">




{include file="sidecolumn_ask.tpl"}
{include file="sidecolumn_entry.tpl"}
{include file="sidecolumn_reserve.tpl"}
{include file="sidecolumn_member.tpl"}
{include file="sidecolumn_living.tpl"}
{include file="sidecolumn_regist.tpl"}
{include file="sidecolumn_shopping.tpl"}
{include file="sidecolumn_mm.tpl"}
{include file="sidecolumn_master.tpl"}




<div class="sidecolumn navi">
<dl>

<dd><a href="{$self}?mode=logout" ><i class="fa fa-fw fa-sign-out"></i>サインアウト</a></dd>
</dl>

</div><!-- sidecolumn -->
{* /$show_menu *}
</div>{* sub *}
{/if}

<div id="main" class="left">
<div id="main-inner">


<h3 class="top">{$init_pagetitle} 管理画面</h3>


