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
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="ユーザー登録一覧"}


{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事一覧本体 開始 *}
<h4 class="page_title">{$page_title}
{if $view_dm==1}
<span class="label label-default">配信停止</span>
{else if $view_status==9}
<span class="label label-default">退会</span>
{else}
{/if}
</h4>
{if $deleted}
<p class="success">登録データを削除しました。</p>
{/if}


{if $view_searchword}
<h5>『{$view_searchword}』で検索</h5>
{/if}

<div id="search" class="pull-right">
<form action="{$self}?{$url_query}" class="form-inline" method="put">
<input type="hidden" name="mode" value="list_regist">
<div class="form-group">
<input type="search" id="searchword" name="searchword" class="form-control" value="{$view_searchword}" style="width: 300px;" placeholder="メールアドレス・名前で検索">
</div>
{if $view_dm==1}
<input type="hidden" name="dm" value=1 />
{else if $view_status==9}
<input type="hidden" name="status" value=9 />
{else}
{/if}
<button class="btn btn-primary" type="search" name="" value="検索">現在のステータスで検索</button>
</form>
</div>



{regists onregist=1 per_page=10}
{if $regist_header}
<p>{$regist_count}件中の{$first_regist_no}〜{$last_regist_no}件目</p>

<br class="clearfix" />

<table class="inputForm_free em09" cellspacing="0">
<tr class="table-header">
<th class="mh">ID</th>
<th class="mh">username</th>
<th class="mh">名前</th>
<th class="mh">学部・学科</th>
<th class="mh">入学年度</th>
<th class="mh">登録日</th>
{*if $authority['regist']['delete']}<th class="mh">削除</th>{/if*}
</tr>
{/if}
<tr>
<td><a href="{$self}?mode=show_regist&rid={$regist['id']}">{$regist['id']|string_format:"%04d"}</a></td>
<td>{$regist['username']}{if $regist['status']==-9}<span class="tag min gray">非登録</span>{else if $regist['status']==9}<span class="tag black min">退会</span>{/if}{if $regist['send_error']}<span class="tag black min">送信エラー</span>{/if}{if $regist['inherit']}<span class="label label-primary">newlife継承</span>{/if}{if $regist['dm']}<span class="label label-default">配信停止</span>{/if}
</td>
<td>{if $regist['namef']}{$regist['namef']} {$regist['nameg']}{else}未登録{/if}</td>
<td>{if $regist["dept"]}{code name=23 id=$regist["dept"]}{$code['value']}{/code}{else}未登録{/if}</td>
<td>{$regist['year']}</td>
<td>登録:{$regist['regist_date']}<br />
更新:{$regist['date']}</td>

{*if $authority['entry']['delete']}
<td class="delete_entry_button">
<form method="post" action="{$self}?mode=delete_regist" class="delete_regist" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$regist['id']}" />
<input type="hidden" name="query" value="{$query}" />
<input type="submit" value="削除" />
</form>
</td>
{/if*}
</tr>
{if $regist_footer}
</table>
{/if}
{/regists}
{* 記事一覧本体 終了 *}

{* ページ選択 *}
{include file='page_select.tpl'}


{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_regist}
<p class="alert alert-info">登録データが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">登録データの読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
