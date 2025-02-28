{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('カテゴリを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="カテゴリの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-info">カテゴリを削除しました。</p>
{/if}

{if $authority["shopping"]["master"]}
<p><a class="btn btn-primary" href="{$self}?mode=edit_category"><i class="fa fa-fw fa-edit"></i>カテゴリの新規作成</a></p>
{/if}


{sp_categories}
{if $category_header}
<table class="inputForm free">
<tr>
<th class="mh" style="width:30%;">名前</th>
<th class="mh" style="width:20%;">ディレクトリ</th>
<th class="mh" style="width:20%;">サブカテゴリ数</th>
<th class="mh" style="width:15%;">状態</th>
<th class="mh" style="width:15%;">削除</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=edit_category&category_id={$category['id']}">{$category['denomination']}</a></td>
<td>{$category['part']}</td>
<td style="text-align : center;">{$category['child_count']}</td>
<td style="text-align : center;"><span class="tag {$visibleColorList[$category["visible"]]}">{$visibleList[$category["visible"]]}</span></td>

<td class="delete_category_button">
{if $category['child_count']}
&nbsp;
{else}
{$category["entry_count"]}
<form method="post" action="{$self}?mode=delete_category" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="category_id" value="{$category['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除"><i class="fa fa-fw fa-times"></i>削除</button>
</form>
{/if}
</td>
</tr>
{if $category_footer}
</table>
{/if}
{/sp_categories}
{if $no_category}
<p class="alert alert-info">カテゴリが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">カテゴリの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
