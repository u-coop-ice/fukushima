{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

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
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="在庫管理ログ"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{* 編集権限 *}

{logs sort=DESC log="stock_log" per_page=20}


{if $log_header}

{* 記事一覧本体 開始 *}
<h4 class="page_title">{$page_title} 一覧</h4>
{if $deleted}
<p class="deleted">ログ削除しました。</p>
{/if}


<p>{$log_count}件中の{$first_log_no}〜{$last_log_no}件目</p>

<table class="inputForm_free em09" cellspacing="0">
<tr class="table-header">
<th class="mh">日時</th>
<th class="mh">商品名</th>
<th class="mh">受注</th>
<th class="mh nowrap">在庫</th>
<th class="mh">管理ID</th>
</tr>
{/if}

<tr class="{if $is_odd}odd{/if}">
<td>{$log['date']}</td>
<td><a class="" target="_blank" href="{$self}?mode=edit_item&item_id={$log['item_id']}">【{$log['item_no']}】{$log['item_name']}</a></td>
<td>{if $log['app_id']}<a class="" target="_blank" href="{$self}?mode=show_order&app_id={$log['app_id']}">{$log['regist_code']}</a>{/if}</td>
<td class="right">{$log['num']|number_plus}</td>
<td>{$log['auth_username']}</td>
</tr>
{if $log_footer}
</table>
{/if}
{/logs}
{* 記事一覧本体 終了 *}

{* ページ選択 *}
{include file='page_select.tpl'}


{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_log}
<p class="note">ログが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">データベースの読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
