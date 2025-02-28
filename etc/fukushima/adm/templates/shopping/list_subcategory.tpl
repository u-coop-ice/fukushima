{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('サブカテゴリを削除してもよろしいですか');
}
//]]>
</script>

<link rel="stylesheet" type="text/css" href="/js/jquery/jquery.powertip-1.2.0/css/jquery.powertip.min.css" />
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.2.0/jquery.powertip.min.js"></script>
<script type="text/javascript">
//<[!CDATA[
$(function(){
$('.tooltips').powerTip({
	placement: 'ne'
});
});
//]]>
</script>


{/literal}
{/capture}

{assign var="page_title" value="サブカテゴリの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-info deleted">サブカテゴリを削除しました。</p>
{/if}
<p><a class="btn btn-primary" href="{$self}?mode=edit_subcategory"><i class="fa fa-fw fa-edit"></i>サブカテゴリの新規作成</a></p>
{sp_subcategories}
{if $subcategory_header}
<table class="inputForm free">
<tr>
<th class="mh" style="width:20%;">名前</th>
<th class="mh" style="width:20%;">親カテゴリ名</th>
<th class="mh" style="width:10%;">並び順</th>
<th class="mh" style="width:10%;">商品数</th>
<th class="mh" style="width:20%;">受注状態</th>
<th class="mh" style="width:10%;">削除</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=edit_subcategory&subcategory_id={$subcategory['id']}">{$subcategory['denomination']}</a></td>
<td style="">{$subcategory['category_denomination']}</td>
<td style="text-align : center;">{$subcategory['sort_order']}</td>
<td style="text-align : center;">{$subcategory['entry_count']}</td>
<td class="tooltips" title="{$subcategory['open_date']}<br />{$subcategory['limit_date']}
"><span class="tag {$visibleColorList[$subcategory['state']]}">{$stateOpenList[$subcategory['state']]}</span>
{if !$subcategory['category_flag_send']}{if {$subcategory['term_start']} || {$subcategory['term_end']}}<div class="em10">配送期間:{$subcategory['term_start']}〜{$subcategory['term_end']}</div>{/if}{/if}

</td>
<td class="delete_category_button">
{if $subcategory['entry_count']}
&nbsp;
{else}
<form method="post" action="{$self}?mode=delete_subcategory" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="subcategory_id" value="{$subcategory['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除"><i class="fa fa-fw fa-times"></i>削除</button>
</form>
{/if}
</td>
</tr>
{if $subcategory_footer}
</table>
{/if}
{/sp_subcategories}
{if $no_subcategory}
<p class="note">サブカテゴリが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">サブカテゴリの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
