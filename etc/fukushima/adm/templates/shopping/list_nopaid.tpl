{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('受注登録を削除してもよろしいですか？この操作は取り消せません。');
}
//]]>
</script>



<script type="text/javascript">
//<[!CDATA[
$(function(){
	$("#all").on("click",function(){
		var all = $(this).prop('checked');
			$("[name^='app_id']").prop('checked',all);
	});
});

//]]>
</script>

<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="../js/get_regist.js"></script>
<!--<script type="text/javascript" src="./js/select_plan.js"></script>-->
<!--<script type="text/javascript" src="./js/get_reserve.js"></script>-->


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
{* ページタイトル 開始 *}
{assign var="page_title" value="未入金受注 一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 宿泊予約一覧本体 開始 *}
<h3 class="page_title">{$page_title} <span class="label label-success">手配済</span> <span class="label label-info">WEB決済を除く</span></h3>


<div id="search">
<form method="PUT" id="searchForm" action="{$self}?mode=list_nopaid" class="filter_entry form-inline">

<select name="category_id" id="category_id" class="form-control">
<option value="">（カテゴリ）</option>
{sp_categories all=1}
<option value="{$category['id']}"{if $category['id'] == $view_category_id} selected="selected"{/if}>{$category['denomination']}</option>
{/sp_categories}
</select>


<label for="searchword">
<input type="search" id="searchword" name="searchword" class="form-control" value="{$view_searchword}" placeholder="氏名・カナ" maxlength="64" />
</label>
<input type="hidden" name="mode" value="list_nopaid" />
<button type="submit" class="btn btn-primary" value="検索">検索</button>
</form>
</div>


{if $sent}
<p class="alert alert-info">「ご入金のお願い」メールを送信しました。</p>
{/if}


{*order_page_navi_setup nopaid=1 nopayment=4*}
{orders nopaid=1 nocard=1 status=1 per_page=50}
{if $order_header}
<p>{$order_count}件中の{$first_order_no}〜{$last_order_no}件目</p>


<form method="post" id="exportForm" action="{$self}?mode=sendmail_nopaid">

<table class="inputForm free">
<col width="5%"/>
<col width="20%"/>
<col width="15%"/>
<col width="20%"/>
<col width="10%"/>
<col width="10%"/>
<col width="10%"/>
<col width="10%"/>
<tr class="table-header">
<th colspan="2" class="mh"><label><input type="checkbox" id="all" /> 登録番号</label></th>
<th class="mh">カテゴリ</th>
<th class="mh">氏名</th>
<th class="mh">支払状況</th>
<th class="mh">支払</th>
<th class="mh">回数</th>
<th class="mh">状況</th>
</tr>
{/if}
<tr class="{if $is_odd}odd{/if}">
<td>{if $order['category_nopaid_message']}<input type="checkbox" id="app_id[{$order['id']}]" name="app_id[]" value="{$order['id']}" />{/if}</td>
<td>
<label for="app_id[{$order['id']}]">
<a href="{$self}?mode=show_order&app_id={$order['id']}" target="_blank">{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
</a>{if $order['arranged']}<span class="tag min">管理</span>{/if}<br />{$order['regist_date']|date_format:"H:i:s"}
</label>
</td>
<td>{$order['category_denomination']}</td>

<td><span class="get_regist" data="{$order['regist_id']}">{$order['regist_namef']} {$order['regist_nameg']}</span><span class="tag min {$visibleColorList[$order['regist_status']]}">{$registList[$order['regist_status']]}</span></td>

<td class="nowrap"><span  class="tooltips" title="支払確認済：{$order['payment_confirmed']|number_format}／請求金額：{$order['total_price_all']|number_format}
{logs process='payment_confirmed' app_id=$order['id'] no_pager=1}{if $log['process']}<br />{$log['date']} {$log['value']|number_format}更新{/if}{/logs}"><span class="tag micro navy">確認済</span>{$order['payment_confirmed']|number_format}<br /><span class="tag micro navy">請求額</span>{$order['total_price_all']|number_format}</span></td>
<td>{$paymentAdminList[$order['payment']]}</td>

<td>{$order['sendmail_nopaid']}</td>

<td><span class="tag min {$statusColorList[$order['status']|default:0]}">{$statusOrderList[$order['status']|default:0]}</span></td>
</tr>
{if $order_footer}
</table>
<p><button class="btn btn-primary" type="submit" id="" name="export" value="「ご入金のお願い」メールを送信する"><i class="fa fa-fw fa-envelope"></i>「ご入金のお願い」メールを送信する</button></p>
</form>
{/if}
{/orders}

<p class="alert alert-info">カテゴリ設定で入金督促メールの設定が無い場合は、この機能は使えません。<br />この一覧で選択できない手配は、個々の手配ページから操作ください。</p>

{* 注文一覧本体 終了 *}

{* ページ選択 *}
{include file='page_select.tpl'}

{* 予約が見つからなかった場合の出力等 開始 *}
{if $no_order}
<p class="alert alert-info">注文が見つかりませんでした。</p>
{/if}
{if $no_category}
<p class="alert alert-info">権限がありません。</p>
{/if}
{if $db_error}
<p class="error">データの読み込みに失敗しました。</p>
{/if}
{* 予約が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
