{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('アドレスグループを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="ユーザーグループの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-success">ユーザーグループを削除しました。</p>
{/if}
<p><a class="btn btn-primary" href="{$self}?mode=edit_group"><i class="fa fa-fw fa-plus"></i>ユーザーグループの新規作成</a></p>

{groups}
{if $group_header}
<table class="inputForm_free" cellspacing="0">
<col width="20%">
<col width="50%">
<col width="10%">
<col width="10%">
<col width="10%">
<tr class="mh">
<th>ユーザーグループ名</th>
<th>絞り込み条件</th>
<th>配信停止リンク</th>
<th>登録数</th>
<th>削除</th>
</tr>
{/if}

<tr{if $is_odd} class="odd"{/if}>
<td>{if $authority['mm']['edit']}<a href="{$self}?mode=edit_group&group_id={$group['id']}">{$group['denomination']}</a>{else}{$group['denomination']}{/if}</td>
<td>{if $group['condition']}{translate_condition condition=$group['condition']}
{if $translate_condition['component']}<div><span class="badge badge-secondary">お申込み</span> {$translate_condition['component']} {$translate_condition['category_denomination']}</div>{/if}
{if $translate_condition['forced']}<div><span class="badge badge-secondary">ユーザーの配信停止設定</span> {$translate_condition['forced']}</div>{/if}


{/if}</td>
<td>{$onoffList[$group['unsubscribe']]}</td>
<td class="text-center">{get_regist_count group_id=$group['id']}</td>
<td class="delete_group_button">
{if $authority['mm']['delete']}
<form method="post" action="{$self}?mode=delete_group" class="delete_group" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$group['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除"><i class="fa fa-fw fa-times"></i>削除</button>
</form>
{/if}
</td>
</tr>

{if $group_footer}
</table>

{if $view_archived}
<p class=""><a href="{$self}?mode=list_group">アーカイブは表示しない</a></p>
{else}
<p class=""><a href="{$self}?mode=list_group&archived=1">アーカイブを含めてすべて表示</a></p>
{/if}

{/if}

{/groups}



{if $no_group}
<p class="alert alert-info">ユーザーグループが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">グループの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
