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
<p class="deleted alert alert-info">カテゴリを削除しました。</p>
{/if}
<div class="pull-right">
<div id="search">
<form class="form-inline" method="put" action="{$self}">

<input type="hidden" name="mode" value="list_category" />

<p>
<input class="form-control" type="search" id="search_word" name="search_word" value="{$view_search_word}" placeholder="カテゴリ名" maxlength="64" />

{if $view_archived}
<input type="hidden" name="archived" value="{$view_archived}" />
{/if}
<button class="btn btn-primary" type="submit">検索</button></p>
</form>
</div>
</div>

<div><a class="btn btn-primary" href="{$self}?mode=edit_category"><i class="fa fa-pencil-square-o"></i>カテゴリの新規作成</a></div>
<div class="clearfix"></div>

<p class="right">初期設定メール送信先：{$init_ordermail}</p>

{categories all=1 component="reserve" per_page=10}
{if $category_header}
<p>{$category_count}件中の{$first_category_no}〜{$last_category_no}件目</p>
<table class="inputForm_free" cellspacing="0">
<tr>
<th class="mh">名称</th>
<th class="mh" style="text-align: left;">登録メール送信先</th>
<th class="mh" style="width:7em">運用状態</th>
<th class="mh" style="width:5em">登録数</th>
<th class="mh" style="width:5em">並び順</th>
<th class="mh"></th>
{if $authority['reserve']['delete']}
<th class="mh">削除</th>
{/if}
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=edit_category&category_id={$category['id']}">{$category['denomination']}</a><br />
<code class="btn-copy-clipboard" title="クリップボードに保存する"><i class="fa fa-fw fa-clipboard"></i>{$init_url}app/reserve/?cd={$category['code']}</code>

<div><a href="{$init_url}adm/reserve/?mode=edit_calendar&category_id={$category['id']}" ><i class="fa fa-calendar"></i> 開設日</a></div>

</td>
<td style="text-align:left;word-break: break-all;">{if $category['ordermail']}{$category['ordermail']}{else}{$init_ordermail}{/if}</td>
<td class="nowrap">
<span title="{$category['date_start']}〜{$category['date_limit']}" class="tag 
{if $category['status']<0}black">終了{else if $category['status']==0}red">準備中
{else}{if $category['onstock']}{if $app_count_state<1}black">在庫切停止{else}green">稼働中{/if}
{else}green">稼働中{/if}{/if}</span>
</td>
<td>
<a href="{$self}?mode=show_calendar&category_id={$category['id']}">{$category['entry_count']}</a>
</td>
<td>{$category['sort_order']}</td>
<td><a class="btn btn-primary btn-sm" title="設定をコピーしてカテゴリを作成します。ただし開設日は新しく設定ください。" href="{$self}?mode=edit_category&category_id={$category['id']}&copy=1"><i class="fa fa-copy"></i></a></td>

{if $authority['reserve']['delete']}
<td class="delete_category_button">
{if $app_count}
&nbsp;
{else}
<form method="post" action="{$self}?mode=delete_category" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$category['id']}" />
<input type="hidden" name="query" value="{$query}" />
<input class="btn btn-primary btn-sm" type="submit" value="削除" />
</form>
{/if}
</td>
{/if}
</tr>
{if $category_footer}
</table>
{/if}
{/categories}

{if $view_archived}
<p class=""><a href="{$self}?mode=list_category">アーカイブは表示しない</a></p>
{else}
<p class=""><a href="{$self}?mode=list_category&archived=1">アーカイブを含めてすべて表示</a></p>
{/if}

{* ページ選択 *}
{include file='page_select.tpl'}


{if $no_category}
<p class="alert alert-info">カテゴリーが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">カテゴリーの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
