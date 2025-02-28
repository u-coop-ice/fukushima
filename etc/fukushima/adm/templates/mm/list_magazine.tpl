{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('メールマガジンを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}
{if $view_status=="sent"}
{assign var="page_title" value="送信済みメールの一覧"}
{/if}
{if $view_status=="draft"}
{assign var="page_title" value="下書きの一覧"}
{/if}
{if $view_status=="reserved"}
{assign var="page_title" value="送信予約メールの一覧"}
{/if}
{include file='header.tpl'}

<h4 class="page_title">{if $view_group_id}{groups id=$view_group_id}【{$group['denomination']}】{/groups}{/if}{$page_title}</h4>
{if $deleted}
<p class="alert alert-success">メールマガジンを削除しました。</p>
{/if}


<p><a class="btn btn-primary" href="{$self}?mode=edit_magazine">メールマガジンの新規作成</a></p>

{if $view_search_word}
<h5>「{$view_search_word}」の検索結果</h5>
{/if}

{magazines per_page=10}
{if $magazine_header}
<div id="ct">{$magazine_count}件中の{$first_magazine_no}〜{$last_magazine_no}件目
<div id="search">
<form method="post" class="form-inline" action="{$self}?mode=list_magazine{if $view_status}&status={$view_status}{/if}" class="filter_entry">
<p class="right"><input type="search" class="form-control" id="search_word" name="search_word" value="{$view_search_word}" placeholder="メルマガ検索" maxlength="64" />
<button class="btn btn-primary" type="submit" value="検索">検索</button></p>
</form>
</div>
</div>


<table class="inputForm_free" cellspacing="0">
<col width="370">
<col width="120">
<col width="130">
<col width="50">
<thead>
<tr class="mh">
<th>件名</th>
<th>宛先</th>
<th>{if $view_status=="sent"}送信{elseif $view_status=="draft"}作成{elseif $view_status=="reserved"}予約{/if}日時</th>
{if $view_status=="sent"}
<th>送信数</th>
{else}
<th>削除</th>
{/if}
</tr>
</thead>
{/if}
<tbody>
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode={if {$view_status}=="sent"}show{else}edit{/if}_magazine&magazine_id={$magazine['id']}">{$magazine['subject']}</a><br><span class="magizine_body" style="overflow:hidden;">{$magazine['body']|mb_truncate:56:'...'}</span></td>
<td>{if $magazine['group_id']}{$magazine['group_denomination']}{else}
{translate_condition condition=$magazine['condition']}
{if $translate_condition['component']}<div><span class="badge badge-secondary">お申込み</span> {$translate_condition['component']} {$translate_condition['category_denomination']}</div>{/if}
{if $translate_condition['forced']}<div><span class="badge badge-secondary">ユーザーの配信停止設定</span> {$translate_condition['forced']}</div>{/if}
{/if}</td>
<td>{if $view_status=="sent"}{$magazine['date']|date_format:"%Y-%m-%d %H:%M"}{else if $view_status=="draft"}{$magazine['date']|date_format:"%Y-%m-%d %H:%M"}{else if $view_status=="reserved"}{$magazine['reserve']|date_format:"%Y-%m-%d %H:%M"}{/if}</td>

{if $view_status=="sent"}
<td>{$magazine['sent_count']}</td>
{else}
<td class="delete_magazine_button">
{if $view_status!="sent"}
<form method="post" action="{$self}?mode=delete_magazine" class="delete_magazine" onsubmit="return deleteCheck();">
<input type="hidden" name="query" value="{$query}" />
<input type="hidden" name="id" value="{$magazine['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除">削除</button>
</form>
{/if}
</td>
{/if}
</tr>
</tbody>
{if $magazine_footer}
</table>
{/if}
{/magazines}

{* ページ選択 *}
{include file='page_select.tpl'}


{if $no_magazine}
<p class="alert alert-info">メルマガが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">メルマガの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
