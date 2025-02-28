<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT" />
<meta name="robots" content="noindex,nofollow">
<meta name="format-detection" content="telephone=no"> 

<title>{$page_title} :: {$init_coopname}</title>

{include file="js_index.tpl"}

{$header_insert}
</head>

<body>

<div id="wrapper">

<div id="pagebody">

{include file="header_wrapper.tpl"}

<div id="container">

<div id="contentheader" class="container">

<!-- breadcrumb -->
<div id="breadcrumb">
{if $smarty.const.COMPONENT=="entry"}
<a href="{$init_coopurl}">HOME</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}
{else if $smarty.const.COMPONENT=="reserve"}
<a href="{$init_coopurl}">HOME</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}
{else if $smarty.const.COMPONENT=="transition"}
<a href="{$init_coopurl}">HOME</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}
{else if $smarty.const.COMPONENT=="mealcard"}
<a href="{$init_coopurl}">HOME</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}
{else if $smarty.const.COMPONENT=="ask"}
<a href="{$init_coopurl}">HOME</a>&nbsp;&gt;&nbsp;{$init_pagetitle}
{else if $smarty.const.COMPONENT=="htkt"}
<a href="{$init_coopurl}">HOME</a>&nbsp;&gt;&nbsp;<a href="./">{$init_pagetitle}</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}
{else}
<a href="{$init_coopurl}">HOME</a>&nbsp;&gt;&nbsp;<a href="{$self}">{$init_pagetitle}</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}
{/if}
</div><!-- /breadcrumb -->

</div><!-- contentheader -->

<div class="clear"></div>


<div id="content" class="container">



<div id="main" class="left">
<div id="main-inner">

{if $page_title!="サインイン"}
<h3 id="page-title" class="top">{$page_title}</h3>
{/if}

{if $stepsFile[$smarty.const.COMPONENT][$mode]}
{assign var="stepTPL" value="steps_{$stepsFile[$smarty.const.COMPONENT][$mode]}.tpl"}
{if $stepTPL}{include file=$stepTPL}{/if}
{/if}
