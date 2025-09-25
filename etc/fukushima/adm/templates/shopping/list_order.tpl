{* ページタイトル 開始 *}

{assign var="page_title" value="注文の一覧"}

{capture assign="header_insert"}
{literal}

<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
$(".date").AnyTime_picker({format: "%Y-%m-%d"});
});
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

<link rel="stylesheet" type="text/css" href="/js/jquery/jquery.powertip-1.3.2/css/jquery.powertip.min.css" />
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.3.2/jquery.powertip.min.js"></script>
<script type="text/javascript">
//<[!CDATA[
$(function(){
$('.tooltips').powerTip({placement: 'n'});
});
//]]>
</script>


{/literal}
{/capture}


{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{* 注文一覧本体 開始 *}
<h4 class="top">{$page_title} <span class="tag micro">{$statusOrderList[$view_status]}
</span></h4>


{if $view_searchword}
<h5>『{$view_searchword}』で検索</h5>
{/if}

<div id="search">
<form action="{$self}?{$url_query}" method="post" class="form-inline">
<input type="text" name="regist_date" class="form-control date datetime" id="regist_date" value="{$view_regist_date}" placeholder="受注日"/>
<select class="form-control" name="status">
{html_options options=$statusOrderList selected=$view_status}
</select>
<input type="search" class="form-control" id="searchword" name="searchword" value="{$view_searchword}" placeholder="氏名(カナ)・受注番号で検索">
<button class="btn btn-primary" type="submit" name="" value="検索">検索</button>
</form>
</div>


{orders per_page=10}
{if $order_header}
<p>{$order_count|number_format}件中の{$first_order_no}〜{$last_order_no}件目</p>

<form method="post" id="exportForm" action="{$self}?mode=export_word">

<table class="inputForm free">
<col style="width:1%;"/>
<col style="width:4%;"/>
<col width="10%"/>
<col width="20%"/>
<col style="width:5%;"/>
<col width="10%"/>
<col width="10%"/>
<col width="10%"/>
<col width="10%"/>
<tr class="table-header">
<th class="mh" colspan="2"><label><input type="checkbox" id="all" /> 番号</label></th>
<th class="mh">カテゴリ</th>
<th class="mh">顧客名</th>
<th class="mh right">点数</th>
<th class="mh right">備考</th>
<th class="mh right">合計金額</th>
<th class="mh">支払</th>
<th class="mh">状況</th>
</tr>
{/if}
<tr{if $order['status']==9} class="cancelled"{/if}>

<td><input type="checkbox" id="app_id[{$order['id']}]" name="app_id[]" value="{$order['id']}" /></td>
<td>
<a href="{$self}?mode=show_order&app_id={$order['id']}">{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
</a><br /><label for="app_id[{$order['id']}]">{$order['regist_date']|date_format:"H:i:s"}</label>{if $order['admin_flag']}<span class="tag min gray">管理</span>{/if}</td>
<td>{$order['category_denomination']}</td>
<td>{$order['regist_namef']} {$order['regist_nameg']}{if $order['ship_from_name']}（{$order['ship_from_name']}）{/if}
<span class="tag min {$visibleColorList[$order['regist_status']]}">{$registList[$order['regist_status']]}</span>
{if $order['ship_namef']}<br /><i class="fa fa-arrow-right fa-fw"></i>{$order['ship_namef']} {$order['ship_nameg']}{/if}
</td>
<td class="right">{$order['num']|number_format}</td>
<td><span class="tooltips" title="{$order['memo']|nl2br}">{$order['memo']|mb_truncate:"30":"…"}</span></td>
<td class="right">{$order['total_price_all']|number_format}</td>
<td><p>{$paymentAdminList[$order['payment']]}
{if $order['test_mode']}<span class="label label-default">test</span></p>{/if}
</td>
<td><span class="tag min {$statusColorList[$order['status']|default:0]}">{$statusOrderList[$order['status']|default:0]}</span></td>
</tr>
{if $order_footer}
</table>

<button class="btn btn-primary" type="submit" id="" name="export" value=""><i class="fa fa-fw fa-file"></i>受注確認書を書き出す</button>
</form>

{/if}
{/orders}
{* 注文一覧本体 終了 *}

{* ページ選択 *}
{include file='../common/page_select.tpl'}

{* 注文が見つからなかった場合の出力等 開始 *}
{if $no_order}
<p class="alert alert-info">注文が見つかりませんでした。</p>
{/if}
{if $no_category}
<p class="alert alert-info">権限がありません。</p>
{/if}

{if $db_error}
<p class="alert alert-danger">注文の読み込みに失敗しました。</p>
{/if}
{* 注文が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
