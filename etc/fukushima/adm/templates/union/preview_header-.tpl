{* ページのタイトル *}

{assign var="init_pagetitle" value="システムメール"}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT" />
<title>{$init_pagetitle} 管理画面 :: {$init_coopname}</title>
<!-- jquery.js -->
<script type="text/javascript" src="/js/jquery/jquery-1.8.3.min.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />

<link rel="shortcut icon" href="/images/favicon.ico" />

<link rel="stylesheet" href="{$init_url}css/import.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="{$init_url}adm/css/import.css" type="text/css" media="screen,print" />

<script type="text/javascript" src="/js/jquery/formalize/jquery.formalize.min.js"></script>
<link rel="stylesheet" href="/js/jquery/formalize/formalize_newlife.css" type="text/css" media="screen,print" />


{$header_insert}

{literal}

<style type="text/css">
#wrapper {
	width: 100%;
	min-width: 700px;
}
#content.pu {
	width: 94%;
	padding:20px;
}
</style>


{/literal}

</head>

<body>
<div id="wrapper">

<div id="content" class="pu">

<div id="container">

<div id="main">
<div id="main-inner">

<h3>{if $overwrite_pagetitle}{$overwrite_pagetitle}{else}{$init_pagetitle}{/if}</h3>

{if $page_title}<h4>{$page_title}</h4>{/if}

