<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="/favicon.ico">
<link rel="stylesheet" href="/css/import.css" />
<link rel="stylesheet" href="/adm/css/import.css" />
<title>{$init_pagetitle} 管理画面 :: {$init_coopname}</title>

<!-- jquery.js -->
<script type="text/javascript" src="/js/jquery/jquery-2.1.4.min.js"></script>

<link rel="stylesheet" href="/js/jquery/jquery.flexnav/jquery.flexnav.newlife.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.flexnav/jquery.flexnav.tabnav.js"></script>

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


$(function() {
    //    initialize FlexNav
    $(".flexnav ").flexNav();
});
</script>

<style type="text/css">
#global_tab #tab ul.flexnav > li a {
	padding: 10px 10px 10px;
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
<a href="{$init_url}adm/">HOME</a>&nbsp;&gt;&nbsp;<a href="{$init_url}adm/{$smarty.const.COMPONENT}/">ショッピング</a>&nbsp;&gt;&nbsp;{$page_title}
</div><!-- /breadcrumb -->

</div><!-- contentheader -->

<div class="clear">*</div>

<div id="content" class="container">

<div id="container">

<div id="sub" class="left">
{if $show_menu}
<div class="sidecolumn navi">

<div class="contact">新規受注データ登録モードです。</div>


<dl>
<dd><a href="./"><i class="fa fa-chevron-left"></i> ショッピング管理に戻る</a></dd>
<dd><a href="{$self}?mode=logout"><i class="fa fa-sign-out"></i> サインアウト</a></dd>
</dl>

</div><!-- sidecolumn -->

{/if}{* /$show_menu *}
</div>{* sub *}

<div id="main" class="left">
<div id="main-inner">

{*<h2 id="cat2_is_adm">{$page_title}</h2>*}

