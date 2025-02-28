{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}


<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>


<link type="text/css" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>


<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>


<script type="text/javascript">
//<[!CDATA[

$(function(){
var active ='';
//var index = $("#accordion h4").index($("#add"+active));

	$("#accordion").accordion({
	header: "h4",
	heightStyle: "content",
	collapsible: true,
	active: false
	});
});



$(function(){

	$(".mailForm").submit(function(){
	var action = $(this).attr('action');
	var json =$(this).serializeArray();
	$.ajax({
	url:action,
	type: "post",
	data: json,
	cache	: false,
	async	: false,
	success: function(){
	$.fancybox({
	width: $('body').innerWidth()*0.8,
	height: $('body').innerHeight()*0.9,
	href:action,
	type: "iframe"
	});
		}
	});
	return false;
	});
});

$(function(){

	$(".editForm").submit(function(){
	var action = $(this).attr('action');
	var json =$(this).serializeArray();
	$.ajax({
	url:action,
	type: "post",
	data: json,
	cache	: false,
	async	: false,
	success: function(){
	$.fancybox({
	width: $('body').innerWidth()*0.8,
	maxWidth: 720,
	href: action,
	type: "iframe",
	helpers: {
          overlay: {
            locked: false,
          }
        }
	});
		}
	});
	return false;
	});
});


//]]>
</script>


{/literal}
{/capture}

{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}


<div id="thread">

{adds app_id=$view_app_id}
{if $add_header}
<h4>このお申込みに紐付いたメール</h4>
<div id="accordion">
{/if}
<h4 id="add{$add['id']}" class="{if $add['send']}send{/if}"><a>{$add['subject']}&nbsp;&nbsp;[{$add['regist_date']}]{if $add['cover']}&nbsp;&nbsp;{$add['cover']}{/if}</a></h4>


<div>
{if $add['app_component']}
<p class="right">お申し込み・お問い合わせ：
<a href="{$init_url}adm/entry/?mode=show_app&aid={$add['app_id']}" target="_blank">{$app['regist_code']}</a>
</p>
{/if}
<p class="pad_l">{$add['memo']|nl2br}</p>
</div><!-- div -->
{if $add_footer}
</div><!-- accordion -->

{if $add['user_status']==1}
{if $add['noreply']<9}
<div class="center">
<form class="mailForm" method="post" action="{$init_url}adm/ask/?mode=edit_mail">
<input type="hidden" name="add_id" value="{$add['id']}" />
<input type="hidden" name="regist_id" value="{$add['regist_id']}" />

{if $add['app_id']}
<input type="hidden" name="app_id" value="{$add['app_id']}" />
{/if}

{if $add['root_id']}
<input type="hidden" name="root_id" value="{$add['root_id']}" />
{/if}

<p class=""><button class="btn btn-primary" type="submit" name="edit_mail" value="返信メールを作成する"><i class="fa fa-fw fa-edit"></i>返信メールを作成する</button></p>
</form>
</div>
{/if}

{if !$add['auto_send']}
<div id="nts" class="em12">
<span class="tag min {$reactColorList[$add['noreply']]}" title="{$reactList[$add['noreply']]}">{$reactList[$add['noreply']]}</span>
</div>
{/if}

{/if}
{/if}
{/adds}
</div>


<h4>登録内容</h4>
{if $app['cancelled']}
<p class="alert alert-info">このお申込みはすでにキャンセルされています。</p>
{/if}

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">お申込み情報</th></tr>
{foreach from=$method key=f item=v}

{if strpos($f, 'extra') !== false }

{include file="app_extra.tpl"}

{else}
{if $app['fields']['app'][$f]}
{include file="app_$f.tpl"}
{/if}
{/if}
{/foreach}
</table>

{if $app['admin_flag']}
<form method="post" id="appForm" class="editForm" action="{$self}?mode=edit_app">
<input type="hidden" name="app_id" value="{$app['id']}" />
<p class="right"><button class="btn btn-primary btn-sm" type="submit" name="submit" value="お申込み情報を編集する"><i class="fa fa-fw fa-edit"></i>お申込み情報を編集する</button></p>
</form>
{/if}

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">基本情報（最新の情報になります）</th></tr>
{regists regist_id=$app['regist_id']}

{include file="regist_username.tpl"}


{foreach from=$method key=f item=v}

{if $app['fields']['regist'][$f]}
{include file="regist_$f.tpl"}
{/if}

{/foreach}

{/regists}
</table>


{if $authority[$smarty.const.COMPONENT]['edit']}
{if $regist['status']==-9}
<form method="post" id="registForm" class="editForm" action="{$init_url}adm/ajax/?mode=edit_regist&regist_id={$app['regist_id']}&app_id={$app['id']}">
<p class="right"><button class="btn btn-primary btn-sm" type="submit" name="submit" value="登録情報を編集する"><i class="fa fa-fw fa-edit"></i>登録情報を編集する</button></p>
</form>
{/if}

{/if}

<br />
<form action="javascript:history.back();">
<button class="btn btn-primary" type="submit" name="submit" value="前のページ"><i class="fa fa-fw fa-reply"></i>前のページ</button>
</form>


<br />

{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_app}
<p class="alert alert-info">登録が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">記事の読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
