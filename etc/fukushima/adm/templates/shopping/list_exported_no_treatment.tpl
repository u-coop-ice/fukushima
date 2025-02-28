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
{assign var="page_title" value="書き出し済＋未対応 一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 宿泊予約一覧本体 開始 *}
<h4 class="page_title">{$page_title}</h4>

{*
<div id="search">
<form method="post" id="searchForm" action="{$self}?mode=list_paid_completed" class="filter_entry">
<p>

<select name="plan_id" id="plan_id">
<option value="">すべての日程</option>
{plans}
<option value="{$plan_id}"{if $plan_id == $view_plan_id} selected="selected"{/if}>{$plan_name}</option>
{/plans}
</select>


<select name="subplan_id" id="subplan_id" {if $view_subplan_id}data="{$view_subplan_id}"{/if}>
<option value="">すべてのプラン・パック</option>
</select>

{html_options options=$statusList name='status' selected=$view_status}

<label for="searchword">
<input type="search" id="searchword" name="searchword" value="{$view_searchword}" placeholder="氏名・カナ" maxlength="64" />
</label>
<input type="submit" value="検索" /></p>
</form>
</div>
*}

{if $updated}
<p class="note saved">取扱フラグを更新しました。</p>
{/if}


{orders no_treatment=1 per_page=50}
{if $order_header}
<p>{$order_count}件中の{$first_order_no}〜{$last_order_no}件目</p>


<form method="post" id="exportForm" action="{$self}?mode=update_app_status">

<table class="inputForm free">
<col width="5%"/>
<col width="25%"/>
<col width="20%"/>
<col width="20%"/>
<col width="20%"/>
<col width="10%"/>
<tr class="table-header">
<th colspan="2" class="mh"><label><input type="checkbox" id="all" /> 登録番号</label></th>
<th class="mh">カテゴリ</th>
<th class="mh">氏名</th>
<th class="mh">最終書き出し日</th>
<th class="mh">状況</th>
</tr>
{/if}
<tr class="{if $is_odd}odd{/if}">
<td><input type="checkbox" id="app_id[{$order['id']}]" name="app_id[]" value="{$order['id']}" /></td>
<td>
<label for="app_id[{$order['id']}]">
<a href="{$self}?mode=show_order&id={$order['id']}" target="_blank">{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
</a>{if $order['arranged']}<span class="tag min">管理</span>{/if}<br />{$order['regist_date']|date_format:"H:i:s"}
</label>
</td>
<td>{$order['category_denomination']}</td>

<td><span class="get_regist" data="{$order['regist_id']}">{$order['regist_namef']} {$order['regist_nameg']}</span></td>

<td>{$order['date_exported']}</td>
<td><span class="tag min {$statusColorList[$order['status']|default:0]}">{$statusOrderList[$order['status']|default:0]}</span></td>
</tr>
{if $order_footer}
</table>
<p><button class="btn btn-primary" type="submit" id="" name="export" value="「取扱フラグ」を「手配済」に更新する"><i class="fa fa-fw fa-check-square"></i>「取扱フラグ」を「手配済」に更新する</button></p>
</form>
{/if}
{/orders}

<p class="alert alert-info">この一覧で選択できない手配は、個々の手配ページから操作ください。</p>

{* 注文一覧本体 終了 *}

{* ページ選択 *}
{include file='page_select.tpl'}

{* 予約が見つからなかった場合の出力等 開始 *}
{if $no_export}
<p class="alert alert-info">該当する受注データが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">受注データの読み込みに失敗しました。</p>
{/if}
{* 予約が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
