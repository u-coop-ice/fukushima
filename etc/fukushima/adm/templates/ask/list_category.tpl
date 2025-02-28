{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('宛先を削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="宛先の一覧"}

{include file='header.tpl'}

<h3 class="page_title">{$page_title}</h3>
{if $deleted}
<p class="alert alert-success deleted">宛先を削除しました。</p>
{/if}

{if $authority["htkt"]["master"]}
<p><a class="btn btn-primary" href="{$self}?mode=edit_category"><i class="fa fa-fw fa-plus"></i>宛先の新規作成</a></p>
{/if}


{ask_categories}
{if $category_header}

<p class="right">お問い合わせ管理アドレス：{if $component[$smarty.const.COMPONENT]['store_ordermail']}{$component[$smarty.const.COMPONENT]['store_ordermail']}{else}{$init_ordermail}{/if}</p>
<table class="inputForm free">
<tr>
<th class="mh" style="width:20%;">名前</th>
<th class="mh" style="width:35%;">メール設定</th>
<th class="mh" style="width:10%;">問合数</th>
<th class="mh" style="width:15%;">公開</th>
<th class="mh" style="width:10%;">並び順</th>
<th class="mh" style="width:10%;">削除</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=edit_category&category_id={$category['id']}">{$category['denomination']}</a></td>
<td>（お問い合わせ管理アドレス）{if $category['ordermail']}<br /><i class="fa fa-plus"></i> {$category['ordermail']|mb_truncate:40:"…"}{/if}</td>
<td>{$category["entry_count"]}</td>

<td><span class="tag {$visibleColorList[$category['visible']|default:0]}">{$visibleList[$category['visible']|default:0]}</span></td>
<td>{$category["sort_order"]}</td>

<td class="delete_category_button">
{if $authority["htkt"]["master"]}
{if $category["entry_count"]}
&nbsp;
{else}
<form method="post" action="{$self}?mode=delete_category" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="category_id" value="{$category['id']}" />
<button class="btn btn-primary btn-xs" type="submit" value="削除"><i class="fa fa-fw fa-times"></i>削除</button>
</form>
{/if}
{/if}
</td>
</tr>
{if $category_footer}
</table>
{/if}
{/ask_categories}
{if $no_category}
<p class="alert alert-info">宛先が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">宛先の読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
