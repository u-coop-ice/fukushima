{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('孫カテゴリーを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="孫カテゴリーの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-success">孫カテゴリーを削除しました。</p>
{/if}
<p><a class="btn btn-primary" href="{$self}?mode=edit_sub2category">孫カテゴリーの新規作成</a></p>
{sp_sub2categories}
{if $sub2category_header}
<table class="inputForm free">
<tr>
<th class="mh">名前</th>
<th class="mh">親カテゴリ名</th>
<th class="mh">並び順</th>
<th class="mh">商品数</th>
<th class="mh">受注終了</th>
<th class="mh">削除</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=edit_sub2category&sub2category_id={$sub2category['id']}">{$sub2category['denomination']}</a></td>
<td style="">{$sub2category['subcategory_denomination']}</td>
<td style="text-align : center;">{$sub2category['sort_order']}</td>
<td style="text-align : center;">{$sub2category['entry_count']}</td>
<td class="tooltips" title="{$sub2category['subcategory_open_date']}〜{$sub2category['end']}">
<span class="tag {$visibleColorList[$sub2category['state']]}">{$stateOpenList[$sub2category['state']]}</span></td>
<td class="delete_category_button">
{if $sub2category['entry_count']}
&nbsp;
{else}
<form method="post" action="{$self}?mode=delete_sub2category" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="sub2category_id" value="{$sub2category['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除"><i class="fa fa-fw fa-times"></i>削除</button>
</form>
{/if}
</td>
</tr>
{if $sub2category_footer}
</table>
{/if}
{/sp_sub2categories}
{if $no_sub2category}
<p>孫カテゴリーが見つかりませんでした。</p>
{/if}
{if $db_error}
<p>孫カテゴリーの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
