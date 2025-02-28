{* ページのタイトル *}
{if !$page_title}
{strip}
{capture assign='page_title'}
{/capture}

{capture assign='breadcrumb'}
{/capture}
{/strip}
{/if}


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT" />
<title>{$page_title} :: {$init_pagetitle} :: {$init_coopname}</title>

<link rel="stylesheet" href="/css/import.css" />
<link rel="stylesheet" href="/adm/css/import.css" />


<!-- jquery.js -->
<script type="text/javascript" src="/js/jquery/jquery-2.1.4.min.js"></script>

<script type="text/javascript" src="/css/bootstrap/js/bootstrap.min.js"></script>


<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>


{$header_insert}

{literal}

<style type="text/css">
body {
	background-image:none;
}

#wrapper {
	width: 100%;
	min-width: 700px;
	background-image:none;
}
#content {
	width: 94%;
	padding:5px;
	margin: 0 auto;
}
</style>


{/literal}

</head>

<body>
<div id="wrapper">

{if $init_pagetitle}<h3>{$init_pagetitle}</h3>{/if}

{if $page_title}<h4>{$page_title}</h4>{/if}

