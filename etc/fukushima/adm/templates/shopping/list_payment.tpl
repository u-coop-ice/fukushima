{* ページタイトル 開始 *}
{assign var="page_title" value="入金管理"}
{* ページタイトル 終了 *}

{capture assign="header_insert"}
{literal}


<link rel="stylesheet" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.datepicker.min.js"></script>


<link rel="stylesheet" type="text/css" href="/js/jquery/jquery.powertip-1.2.0/css/jquery.powertip.min.css" />
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.2.0/jquery.powertip.min.js"></script>

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
//<[!CDATA[
$(function(){
$('.tooltips').powerTip({
	placement: 'ne'
});
});
//]]>
</script>

<script type="text/javascript" src="/js/jquery/gpObserveText/jquery.gpobservetext-1.0.min.js"></script>

<script type="text/javascript">
//<[!CDATA[

$(function(){
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 2,
		maxDate: new Date(),
		autoclose: true
	});

});

$(function(){
	$(document).on('click','.auto_input',function(){
	var d = $(this).attr('data');
	var diff = parseInt($(this).attr('title'))*(-1);
	$('[name="payment_confirmed['+d+']"]').val(diff);
	if (diff>0){
	$("#date_paid"+d).show();
	var d = $('[name="date_paid['+d+']"]');
	d.removeAttr("disabled");
	d.datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 2,
		maxDate: new Date(),
		autoclose: true
	});
	d.datepicker('show');
	}
	});

});

$(function($){
	$('[id^="update"]').validationEngine('attach',{
	'promptPosition': "inline",
	'scrollOffset':200,
	'onValidationComplete': function(form, status){

if (status == true){
		var t = form;
		var did = t.attr('data');
		var json = form.serializeArray();
		$.ajax({
		url:"./?mode=save_payment",
		type: "post",
		data: json,
		dataType: "json",
		cache	: false,
		async	: false
	}).done(function(res){
		if (res.err){
			alert(res.errmsg);
			return false;
		}

		var ttl = '支払確認済：'+res.payment_confirmed;
//alert(ttl);
	if (res.status==9){
		var dd = -(res.price_cancelled-res.payment_confirmed);
		ttl +='取消後請求金額：'+res.price_cancelled;
	} else {
		var dd = -(res.total_price_all-res.payment_confirmed);
		ttl +='請求金額：'+res.total_price_all;
	}
		ttl +='<br />';
		ttl += res.logs;
		var spn = '<span class="tooltips" title="'+ttl+'">';
		if (dd==0) {
		spn += '<span class="tag navy min">支払済</span>';
		$('#update'+did+' *').prop('disabled',true);
		$('#update'+did).text('-');
		if (res.date_paid){
			$('#update'+did).append('<br />口座入金日: '+res.date_paid);
		}
		} else if (dd<0) {
		spn += '<span class="red">'+dd+'</span>';
		} else {
		spn ='+'+dd;
		}

		spn +='</span>';

		if (dd>0){
			spn += '<span class="min tag auto_input" data="'+did+'" title="'+dd+'">自動入力</span>';
		}


		t.children('[name="payment_confirmed['+did+']"]').val('');
		$('#diff'+did).html(spn);
		$('#diff'+did+' .tooltips').powerTip({placement: 'ne'});

		}).fail(function(r){
			console.log(r)
		});
}

	}
	});
});

//]]>
</script>
{/literal}
{/capture}



{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{* 注文一覧本体 開始 *}
<h4 class="top">{$page_title} <span class="tag micro">{$paidList[$view_paid]}{if $view_payment}・{$paymentAdminList[$view_payment]}{/if}
</span>／<span class="micro tag">未対応・手配済</span>のみ</h4>


{if $view_searchword}
<h5>『{$view_searchword}』で検索</h5>
{/if}

<div id="search">
<form action="{$self}?{$url_query}" method="post" class="form-inline">
{if $view_paid}<input type="text" class="form-control datepicker" name="search_date_paid" value="{$view_date_paid}" placeholder="口座入金日">{/if}

<input class="form-control" type="text" id="searchword" name="searchword" value="{$view_searchword}" placeholder="氏名(カナ)・受注番号で検索">
<button class="btn btn-primary" type="submit" value="検索">検索</button>
</form>
</div>

{*order_page_navi_setup per_page=10*}
{orders per_page=10}
{if $order_header}
<p>{$order_count}件中の{$first_order_no}〜{$last_order_no}件目</p>
<table class="inputForm free">
<col style="width:5%;"/>
<col width="10%"/>
<col width="20%"/>
<col style="width:10%;"/>
<col width="20%"/>
<col width="10%"/>
<tr class="table-header">
<th class="mh">番号</th>
<th class="mh">カテゴリ</th>
<th class="mh">氏名</th>
<th class="mh right" colspan="2">支払状況</th>
<th class="mh">支払</th>
</tr>
{/if}
<tr{if $order['status']==9} class="cancelled"{/if}>
<td><a href="{$self}?mode=show_order&app_id={$order['id']}">{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
</a><br />{$order['regist_date']|date_format:"H:i:s"}
<span class="tag min {$statusColorList[$order['status']|default:0]}">{$statusOrderList[$order['status']|default:0]}</span>
{if $order['sendmail_paid_completed']}<span class="tag green min"><i class="fa fa-envelope"></i> 入金</span>{/if}
</td>
<td>{$order['category_denomination']}</td>
<td>{$order['regist_namef']} {$order['regist_nameg']}
<span class="tag min {$visibleColorList[$order['regist_status']]}">{$registList[$order['regist_status']]}</span></td>

{if $order['payment']==4}
<td colspan="2">
{get_charged_info_payjp charged_id=$order['charged_id'] api_key=$order['api_key']}
{if $charged_errmsg}<span class="red"><i class="fa fa-exclamation-sign"></i>{$charged_errmsg}</span>{else}
<span class="tag min {$chargedColorList[{$charged_status}]}">{$chargedList[{$charged_status}]}</span>{*if $charged_amount_refunded}払戻金額：{$charged_amount_refunded}{/if*}{/if}
</td>
{else if $order['payment']==5}
<td colspan="2">
{get_charged_info_veritrans charged_id=$order['charged_id'] api_key=$order['api_key'] api_secret_key=$order['api_secret_key'] test_mode=$order['test_mode']}
{if $card_err}<p class="error alert alert-danger">{$card_err}</p>{/if}
{if $order_test_mode}<div class="tag gray min">テスト</div><br />{/if}
<div class="tag min {$detailOrderColorList[$last_transaction]}">{$detailOrderTypeList[$last_transaction]}</div>

</td>
{else}
<td id="diff{$order['id']}"><span class="tooltips" title="支払確認済：{$order['payment_confirmed']|number_format}／{if $order['status']==9}{$order['price_cancelled']|number_format}{else}請求金額：{$order['total_price_all']|number_format}{/if}
{logs log='payment_log' process='payment_confirmed' sort='DESC' app_id=$order['id'] no_pager=1}<br />{$log['date']} {$log['value']|number_plus}更新

{/logs}


">{if $order['paid_difference']==0 && $order['payment_confirmed']>0}<span class="tag min navy">支払済</span>{else}{$order['paid_difference']}{/if}</span>{if $order['paid_difference']} <span class="auto_input" data="{$order['id']}" title="{$order['paid_difference']}"><a class="btn btn-primary btn-xs">自動入力</a></span>{/if}</td>


<td>
{if $order['paid_difference']==0}
-{if $order['date_paid']}<br />口座入金日: {$order['date_paid']}{/if}
{else}
<form id="update{$order['id']}" class="update_order" data="{$order['id']}" method="post">
<input type="hidden" name="app_id" value="{$order['id']}" />
<input type="text" name="payment_confirmed[{$order['id']}]" class="form-control payment_confirmed validate[required]" />
<div id="date_paid{$order['id']}" class="none">
<input type="text" class="form-control validate[required] datepicker" disabled="disabled" name="date_paid[{$order['id']}]" placeholder="口座入金日" /></div>
<input type="hidden" name="payment" value="{$order['payment']}" />
<button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button>
</form>
{/if}
</td>
{/if}

<td>{$paymentAdminList[$order['payment']]}
</td>
</tr>
{if $order_footer}
</table>
{/if}
{/orders}
{* 注文一覧本体 終了 *}

{* ページ選択 *}
{include file='../common/page_select.tpl'}

{* 注文が見つからなかった場合の出力等 開始 *}
{if $no_order}
<p class="alert alert-info">注文が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">注文の読み込みに失敗しました。</p>
{/if}
{* 注文が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
