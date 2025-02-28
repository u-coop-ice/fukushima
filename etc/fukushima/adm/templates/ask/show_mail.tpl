{capture assign="header_insert"}
{literal}


<link type="text/css" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />

<script type="text/javascript">
//<[!CDATA[

$(function(){
{/literal}
var active = {$now_add_id};
{literal}
var index = $("#accordion h4").index($("#add"+active));

	$("#accordion").accordion({
	header: "h4",
	heightStyle: "content",
	collapsible: true,
	active: index
	});
});

$(function(){

	$("#mailForm").submit(function(){

	var json =$(this).serializeArray();
	$.ajax({
	url:"./?mode=edit_mail",
	type: "post",
	data: json,
	cache	: false,
	async	: false,
	success: function(){
	$.fancybox({
	width: $('body').innerWidth()*0.8,
	height: $('body').innerHeight()*0.9,
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

{assign var="page_title" value="お問い合せ内容・システムメール作成"}

{include file='header.tpl'}


<div id="thread">
<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="note deleted">メールを削除しました。</p>
{/if}

{adds per_page=100}
{assign var=view_app_id value=$add['app_id']}
{if $add_header}
<div id="accordion">
{/if}
<h4 id="add{$add['id']}" class="{if $add['send']}send{/if}"><a>{$add['subject']}&nbsp;&nbsp;[{$add['regist_date']}]{if $add['cover']}&nbsp;&nbsp;{$add['cover']}{/if}</a></h4>


<div>
{if $add['app_component']}
<p class="right">お申し込み・お問い合わせ：
{get_app_info app_id=$add['app_id']}
{if $add['app_component']=="shopping"}
<a href="{$init_url}adm/shopping/?mode=show_order&app_id={$add['app_id']}" target="_blank">{$app['regist_code']}</a>
{else}
<a href="{$init_url}adm/{$add['app_component']}/?mode=show_app&app_id={$add['app_id']}" target="_blank">{$app['regist_code']}</a>
{/if}
</p>
{/if}
{if $add['target']}
<p class="pad_l">[対象物件]<br />
{$add['target']}</p>
{/if}
{if $add['purpose']}
<p class="pad_l">[お問い合わせ内容]<br />
{$add['purpose']}</p>
{/if}

<p class="pad_l">{$add['memo']|nl2br}</p>
</div><!-- div -->
{if $add_footer}
</div><!-- accordion -->

{if $add['user_status']==1}
{if $add['noreply']<9}
<div class="center">
<form id="mailForm" method="post" action="{$self}?mode=edit_mail">
<input type="hidden" name="add_id" value="{$now_add_id}" />
<input type="hidden" name="regist_id" value="{$add['regist_id']}" />

{if $add['app_id']}
<input type="hidden" name="app_id" value="{$add['app_id']}" />
{/if}

{if $add['root_id']}
<input type="hidden" name="root_id" value="{$add['root_id']}" />
{/if}

<p class="left"><button class="btn btn-primary" type="submit" name="edit_mail" value="返信メールを作成する" size="20"><i class="fa fa-edit fa-fw"></i>返信メールを作成する</button></p>
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

{if $add['user_status']!=1}
<p><span class="tag gray">登録ユーザーではないためシステムメールを利用できません。</span></p>
<p>メールソフトで直接メールもしくは電話対応をお願いします。</p>
{/if}

{regists rid=$add['regist_id']}
<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">登録基本情報</th></tr>
<tr><th>ID</th>
<td>{if $regist['status']==1}<span class="prc">{$regist['username']}{else}<span class="tag">非登録ユーザー</span>{/if}</td>
<tr><th>最終更新日</th><td>{$regist['date']}</td></tr>
<tr><th>登録日</th><td>{$regist['regist_date']}</td></tr>


{if $regist['status']<0}
<tr><th class="mh" colspan="2">基本情報</th></tr>
{include file='regist_email.tpl'}
{include file='regist_name.tpl'}
{include file='regist_student_phone.tpl'}

{else}
{include file='regist_union.tpl'}
{/if}
</table>


<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
</table>

{/regists}

<p><a class="btn btn-primary" href="{if $url_query}{$url_query}{else}./?mode=list_mail{/if}"><i class="fa fa-chevron-left"></i> 送信履歴に戻る</a></p>

<div class="contact">
<form id="updateForm" method="post" action="{$self}?mode=update_mail">
<table class="inputForm">
<tr><th class="mh" colspan="2">生協管理</th></tr>
<tr><th>内部メモ</th><td>
<textarea name="treat" id="treat" class="form-control" >{if $add['root_id']}{adds add_id=$add['root_id']}{$add['treat']}{/adds}{else}{adds add_id=$now_add_id}{$add['treat']}{/adds}{/if}</textarea>
{if $add['date_treat']}最終更新日時: {$add['date_treat']}{/if}
</td></tr>

<tr><th>対応状況</th><td>
<div class="checkbox">
{if $add['noreply']<9}<label><input type="checkbox" name="noreply" value="9" /> スレッドを返信不可にして<span class="tag min navy">対応済</span>にする</label>{else}<label><input type="checkbox" name="noreply" value="2" />スレッドを返信可にして<span class="tag min yellow">対応途中</span>にする</label>{/if}
</div>
</td></tr>
</table>

<input type="hidden" name="add_id" value="{$now_add_id}" />
{if $add['root_id']}
<input type="hidden" name="root_id" value="{$add['root_id']}" />
{/if}
<p class="center"><button type="submit" class="btn btn-primary" name="update_mail" value="生協管理を更新する"><i class="fa fa-fw fa-check"></i>生協管理を更新する</button></p>

</form>
</div>


{if $no_add}
<p class="ind">送信履歴が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="ind">送信履歴の読み込みに失敗しました。</p>
{/if}

{include file='footer.tpl'}
