{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.2.0.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.2.0.min.js"></script>

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){
$(".date").AnyTime_picker(
{ format: "%Y-%m-%d" } );
})

$(function(){
	$('.reset').each(function(){
		$(this).on('click',function(){
			$(this).parent('td').find('input').val('');
		});
	});
});

$(function(){
$("#archivedForm").validationEngine({
promptPosition : "inline"
});
});
//]]>
</script>


<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('登録データをアーカイブします。この操作は取り消せません。');
}
//]]>
</script>

<style type="text/css">
.AnyTime-win {
	z-index: 999;
}

</style>

{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="登録データのアーカイブ化"}

{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}</h4>
<p class="pad_l">登録データをアーカイブ化し登録一覧や登録番号をリセットします。登録の削除は行いませんので、システム内にデータは残ります。</p>


{* 絞り込み *}
<h5>データの絞り込み条件</h5>
<form id="archivedForm" method="post" action="{$self}?mode=save_archived" onsubmit="return deleteCheck();">
<table class="inputForm">
<tr><th>カテゴリ</th>
<td>{$init_pagetitle}
{if $smarty.const.COMPONENT=="entry"}
<select name="category_id" class="form-control validate[required]">
<option value="">（カテゴリを選択）</option>
{categories no_archived=1 component=$smarty.const.COMPONENT}
<option value="{$category['id']}">{$category['denomination']}</option>
{/categories}
</select>
{else if $smarty.const.COMPONENT=="member"}
{categories no_archived=1 component=$smarty.const.COMPONENT part=$smarty.const.PART}
> {$category['denomination']}
<input type="hidden" name="category_id" value="{$category['id']}" />
{/categories}
{/if}
</td>
</tr>
<tr>
<th>登録期間</th>
<td>
<div class="pull-left"><input class="form-control datepicker date" type="text" id="term1" name="term1" value="{$post['term1']}" /></div><div class="pull-left"><p class="form-control-static">〜</p></div>
<div class="pull-left"><input class="form-control datepicker date" type="text" id="term2" name="term2" value="{$post['term2']}" /></div>
<div class="clearfix"></div><span class="reset"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span>
</td>
</tr>
</table>
<button type="submit" class="btn btn-primary" value="アーカイブ化"><i class="fa fa-fw fa-check"></i>アーカイブ化</button>
</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
