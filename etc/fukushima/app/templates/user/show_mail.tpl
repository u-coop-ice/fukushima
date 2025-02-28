{capture assign="header_insert"}
{literal}
<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<link type="text/css" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" rel="stylesheet" media="screen,print" />


<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />

<script type="text/javascript">
//<[!CDATA[

$(function(){
var active;
{/literal}
{if $now_add_id}
active = {$now_add_id};
{/if}
{literal}
var index = $("#accordion h4").index($("#add"+active));
if(isNaN(index)){index='false';}
	$("#accordion").accordion({
	header: "h4",
	heightStyle: "content",
	collapsible: true,
	active: index
	});
});

$(function(){

	$("#mailForm").bind('submit',function(){

	var json =$(this).serializeArray();
	$.ajax({
	url:"./?mode=edit_mail",
	type: "post",
	data: json,
	cache	: false,
	async : false,
	success: function(){
	$.fancybox({
	width: 700,
	height: 600,
	href:"./?mode=edit_mail",
	type: "iframe"
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

{assign var="page_title" value="生協との連絡履歴"}

{include file='header.tpl'}

{if $deleted}
<p class="note deleted">メールを削除しました。</p>
{/if}

{adds per_page=100 regist_id=$regist['id']}
{assign var=view_app_id value=$add_app_id}
{if $add_header}
<div id="accordion">
{/if}
<h4 id="add{$add['id']}" class="{if $add['send']}send{/if}"><a class="accordion-content">{$add['subject']}&nbsp;&nbsp;[{$add['regist_date']}]</a></h4>
<div>

{if $add['app_component']}
<p class="right">お申し込み・お問い合わせ：
{get_app_info app_id=$add['app_id']}
<a href="{$init_url}app/user/?mode=show_app&ic={$add['app_code']}" target="_blank">{$app['regist_code']}</a>
</p>
{/if}


<p class="pad_l">{$add['memo']|nl2br}</p>
</div><!-- div -->
{if $add_footer}
</div><!-- accordion -->

{if !$add['noreply'] || $add['noreply']%2 == 0}
<form id="mailForm" method="post" action="{$self}?mode=edit_mail">
<input type="hidden" name="add_id" value="{$now_add_id}" />
{if $add['app_id']}
<input type="hidden" name="app_id" value="{$add['app_id']}" />
{/if}
{if $add['root_id']}
<input type="hidden" name="root_id" value="{$add['root_id']}" />
{/if}
<button class="btn btn-primary" type="submit" name="edit_mail" value="返信する"><i class="fa fa-fw fa-edit"></i>返信する</button>
</form>
{/if}

{/if}
{/adds}


<br />

{if $no_add}
<p class="alert alert-info">送信履歴が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">送信履歴の読み込みに失敗しました。</p>
{/if}


<p><a class="btn btn-primary" href="./?mode=list_mail"><i class="fa fa-chevron-left"></i> 連絡一覧に戻る</a></p>

{include file='footer.tpl'}


