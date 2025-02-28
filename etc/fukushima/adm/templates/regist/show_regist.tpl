{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<![CDATA[
//]]>
</script>

<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>


<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />


<script>
//<![CDATA[


$(function(){

	$(".mailForm").submit(function(){

	var json =$(this).serializeArray();
	$.ajax({
	url:"../ask/?mode=edit_mail",
	type: "post",
	data: json,
	cache	: false,
	async	: false,
	success: function(){
	$.fancybox({
	width: $('body').innerWidth()*0.8,
	height: $('body').innerHeight()*0.9,
	href:"../ask/?mode=edit_mail",
	type: "iframe"
	});
		}
	});
	return false;
	});
});

//]]>
</script>

<script type="text/javascript" src="../ajax/js/updateSubscribeMail.js"></script>

{/literal}
{/capture}

{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}



<h4>登録内容</h4>

{regists onregist=1}

{* 編集権限 *}

<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">登録基本情報</th></tr>

{include file="regist_username.tpl"}

</table>


{get_check_membership regist_id=$regist['id']}

<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">大学・受験内容</th></tr>
{include file='regist_year.tpl'}
{include file='regist_univ.tpl'}
{*include file='regist_exam.tpl'*}
{include file='regist_dept.tpl'}
{*include file='regist_examnumber.tpl'*}


{include file='regist_union.tpl'}
<tr><th class="mh" colspan="2">メール配信</th></tr>
<tr><th>ニュースレーター・生協からのお知らせ</th><td>{$dmList[$regist['dm']|default:0]}
	<span><a class="btn btn-primary btn-sm update_subscribe_mail" app_id={$regist['id']}><i class="fa fa-fw fa-envelope-o"></i> 配信設定の変更</a></span>
</td></tr>

</table>

<br />
<form action="javascript:history.back();">
<input class="btn btn-primary" type="submit" name="submit" value="前のページ" />
</form>


{/regists}
<br />

{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_regist}
<p class="note">記事が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">記事の読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
