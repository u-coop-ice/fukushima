{* ページのタイトル *}
{if !$page_title}
{strip}
{capture assign='page_title'}
{if $is_item}
{items}{$item['name']}{/items}
{elseif $is_subcategory}
{sp_subcategories id=$view_subcategory_id}
{$subcategory['denomination']}
{/sp_subcategories}
{elseif $is_category}
{else}
{/if}

{/capture}
{/strip}
{/if}
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


{include file="js_index.tpl"}

<title>{$init_category['denomination']}{if $page_title} : {$page_title}{/if} :: {$init_coopname}</title>
{$header_insert}

</head>

<body>
<div id="wrapper">
<div id="pagebody">

{*<div id="fix">
<p>ただ今システムアップデート中です。大変ご迷惑をおかけしますが、ご注文はしばらくお待ち下さい。<br />約1時間程度を予定しています。</p>
</div>*}


{include file="header_wrapper.tpl"}

<div id="container">

<div id="contentheader" class="container">

<!-- breadcrumb -->
<div id="breadcrumb">
<a href="{$init_coopurl}">HOME</a>&nbsp;&gt;&nbsp;<a href="{$init_coopurl}shopping">ショッピング</a>&nbsp;&gt;&nbsp;<a href="{$self}">{$init_category['denomination']}</a>{if $page_title}&nbsp;&gt;&nbsp;{$page_title}{/if}

</div><!-- /breadcrumb -->

</div><!-- contentheader -->

<div class="clear">*</div>


<div id="content" class="container">



<div id="main" class="left">
<div id="main-inner">

<h2>{$init_category['denomination']}</h2>


{if $changed}
<p class="alert alert-success">パスワードの変更が完了しサインインしました。</p>
{/if}
