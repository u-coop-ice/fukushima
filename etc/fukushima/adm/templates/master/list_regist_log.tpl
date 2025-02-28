{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>


<script type="text/javascript">

//<[!CDATA[
$(function(){

$('.get_entry').on('click',function(){
	var username = $(this).attr('data');

$.fancybox.showLoading();

	$.ajax({
		async:false,
		cache:false,
		type: "post",
		data: {username:username},
		url:"../entry/?mode=get_entry",
		success: function(d){
$.fancybox.hideLoading();
$.fancybox(d,{
	 width : 650,
	 height: $(document).height()*0.8,
	 autoSize: false
});
		}
	});
});


});


//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="ユーザーログ"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{* 編集権限 *}

{logs log=regist_log sort=DESC per_page=20 all=1}

{if $log_header}

{* 記事一覧本体 開始 *}
<h4 class="page_title">{$page_title} 一覧</h4>


<div id="search" class="right">
<form method="get" action="{$self}" class="form-inline filter_entry">

<input type="hidden" name="mode" value="list_regist_log" />
<p>

{html_options output=$logKindList class="form-control" values=$logKindList name="kind" selected=$view_kind}

<label for="searchword">
<input class="form-control" type="search" id="searchword" name="searchword" value="{$view_search_word}" maxlength="64" placeholder="（Email）" />
</label>
<input class="btn btn-primary" type="submit" value="検索" /></p>

</form>
</div>

{if $view_search_word}
<h5>{$view_search_word}の検索結果</h5>
{/if}
<div class="clear"></div>



{if $deleted}
<p class="deleted">登録を削除しました。</p>
{/if}


<p>{$log_count}件中の{$first_log_no}〜{$last_log_no}件目</p>

<table class="inputForm_free em09" cellspacing="0">
<tr class="table-header">
<th class="mh">日時</th>
<th class="mh">USERNAME</th>
<th class="mh">UserAgent</th>
<th class="mh">種別</th>
<th class="mh">種別ID</th>
<th class="mh">結果</th>
</tr>
{/if}

<tr class="{if $is_odd}odd{/if}">
<td>{$log['date']}</td>
<td><span class="get_entry" data="{$log['username']}">{$log['username']}</span></td>
<td>{$log['ua']}</td>
<td>{$log['kind']}</td>
<td>{if $log['app_id']}{$log['app_id']}{else if $log['app_add_id']}{$log['app_add_id']}{else} {/if}</td>
<td>{$log['result']}</td>
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
<p class="note">登録が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">データベースの読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
