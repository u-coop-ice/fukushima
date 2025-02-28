{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('登録データを削除してもよろしいですか');
}
//]]>
</script>

<link rel="stylesheet" type="text/css" href="/js/jquery/jquery.powertip-1.2.0/css/jquery.powertip.min.css" />
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.2.0/jquery.powertip.min.js"></script>
<script type="text/javascript">
//<[!CDATA[
$(function(){
$('.tooltips').powerTip({placement: 'n'});
});
//]]>
</script>


{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="{$category['denomination']} 登録一覧"}

{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事一覧本体 開始 *}
<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-success">登録データを削除しました。</p>
{/if}


{* 編集権限 *}


<div>
<div id="search">
<form class="form-inline" method="put" action="{$self}">

<input type="hidden" name="mode" value="list_app" />

<p>
<input class="form-control" type="search" id="search_word" name="search_word" value="{$view_search_word}" placeholder="email・氏名（カナOK）" maxlength="64" />

{if $view_category_id}
<input type="hidden" name="cid" value="{$view_category_id}" />
{/if}
{if $stock_multiList}
{html_options name="stock_multi" values=$stock_multiList output=$stock_multiList selected=$view_stock_multi}
{/if}
<input class="btn btn-primary" type="submit" value="検索" /></p>
</form>
</div>
</div>

{*app_page_navi_setup per_page=10*}
{apps per_page=10}
{if $app_header}
{*get_app_count component=$smarty.const.COMPONENT part=$smarty.const.PART*}
<p>{$app_count}件中の{$first_app_no}〜{$last_app_no}件目</p>

<table class="inputForm_free" cellspacing="0">
<col style="width: 9em;"/>
<tr class="table-header">
<th class="mh">ID</th>
<th class="mh">名前</th>
{if $smarty.const.COMPONENT=="transition"}
<th class="mh">status</th>
{else if $smarty.const.COMPONENT=="reserve"}
<th class="mh" style="width:7em;">{$category['comedate_title']}</th>
<th class="mh">{$category['cometime_title']}</th>
{/if}
<th class="mh" style="width:5em;">メモ</th>

{if $authority[$smarty.const.COMPONENT]['delete']}<th class="mh" style="width: 4.5em;">削除</th>{/if}
</tr>
{/if}
<tr {if $app['cancelled'] || $app['status']==9}class="cancelled"{/if}>
<td><a href="{$self}?mode=show_app&app_id={$app['id']}{if $view_archived && $app['archived']}&archived=1{/if}">{$app['regist_date']|date_format:"%Y%m%d"}-{$app['app_count']|string_format:"%04d"}</a>{if $app['cancelled'] || $app['status']==9}<span class="tag min black">キャンセル済</span>{/if}{if $app['archived']}<span class="tag min black">archived</span>{/if}</td>
<td>{$app['namef']} {$app['nameg']}{if $app['regist_status']==-9}<span class="tag gray min">非登録</span>{else if $app['regist_status']==9}<span class="tag black min">退会</span>{/if}</td>
<td>{$app['comedate']}</td>
<td>{$app['cometime']}</td>
<td><span class="tooltips" title="{$app['treat']|nl2br}">{$app['treat']|mb_truncate:10:'･･･'}</span></td>
{if $authority[$smarty.const.COMPONENT]['delete']}
<td class="delete_entry_button">
{if $app['regist_status']!=1}
<form method="post" action="{$self}?mode=delete_app" class="delete_entry" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$app['id']}" />
<input type="hidden" name="query" value="{$query}" />
<button type="submit" class="btn btn-primary btn-sm" value="削除" ><i class="fa fa-fw fa-times"></i>削除</button>
</form>
{/if}
</td>
{/if}
</tr>
{if $app_footer}
</table>
{/if}
{/apps}
{* 記事一覧本体 終了 *}

{if $return_query}
<p><a class="btn btn-primary" href="{$self}{$return_query}"><i class="fa fa-fw fa-reply"></i>前に戻る</a></p>
{/if}

<p>
{*if $view_archived}
<a href="{$self}?mode=list_app{if $view_category_id}&cid={$view_category_id}{/if}">非アーカイブのみを表示</a>
{else}
<a href="{$self}?mode=list_app{if $view_category_id}&cid={$view_category_id}{/if}&archived=1">アーカイブ化した登録を含めて表示</a>
{/if*}
</p>

{* ページ選択 *}
{include file='page_select.tpl'}


{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_app}
<p class="alert alert-info">登録データが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">登録データの読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
