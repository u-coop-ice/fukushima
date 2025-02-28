{* ページタイトル 開始 *}
{assign var="page_title" value="注文の詳細"}
{* ページタイトル 終了 *}


{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<![CDATA[

$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").next().addClass("checked");
$("input:checked").parent().addClass("checked");

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');
		});
		$(this).addClass('checked');
	});
});


function captureCheck(){
return window.confirm('カード決済操作を完了してよろしいですか? \nこの操作は取り消せません。');
}

function adjustCheck(){
return window.confirm('この処理を完了してよろしいですか? \nこの操作は取り消せません。');
}

$(function(){
	$('#cancelForm').validationEngine('attach',{
	'promptPosition': "inline",
	'scrollOffset': 200,
	});

	$('#captureForm').validationEngine('attach',{
	'promptPosition': "inline",
	'scrollOffset': 200,
	});
});

$(function(){
	$("#btn_autoinput").on('click',function(){
		var auto = parseInt($(this).attr('data'));
		if (auto){
		$(this).prev().val(auto*(-1));
	}
		return;
	});
});

//]]>
</script>


<link rel="stylesheet" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.datepicker.min.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />


<link rel="stylesheet" type="text/css" href="/js/jquery/jquery.powertip-1.2.0/css/jquery.powertip.min.css" />
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.2.0/jquery.powertip.min.js"></script>

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>


<script type="text/javascript">
//<![CDATA[

$(function(){

	$(".mailForm").on('submit',function(){

	var json =$(this).serializeArray();
	$.ajax({
	url:"../ask/index.php?mode=edit_mail",
	type: "post",
	data: json,
	cache	: false,
	success: function(){
	$.fancybox({
	width: $('body').innerWidth()*0.8,
	height: $('body').innerHeight()*0.9,
	href:"../ask/index.php?mode=edit_mail",
	type: "iframe",
	helpers: {
          overlay: {
            locked: false
          }
        }
	});
		}
	});
	return false;
	});
});

$(function(){
$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
  changeMonth: false,
  changeYear: false,
		numberOfMonths :2,
		showCurrentAtPos: 1,
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
		numberOfMonths :2,
		showCurrentAtPos: 1,
		changeMonth: true,
		changeYear: true,
		autoclose: true
	});
	d.datepicker('show');
	}
	});

});


$(function(){
	$('.abled').one('click',function(){
		$(this).prev().find('input').removeAttr('disabled');
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
		cache	: false,
		async	: false,
		success: function(r){
		var res = $.parseJSON(r)
		if (res.errmsg){return false;}
		location.reload();
		}
		});
} //if
  }
 });
});


$(function(){
$('[name="status"]').on('click',function(){
			switchCancel();
		});
			switchCancel();
});

function switchCancel() {

	var st = $('[name="status"]:checked').val();
	if (st==9){
	$('#status_cancelled').show();
		var ecd = Boolean($('#edit_cancelled').size());
		$('#status_cancelled').find('input,textarea').prop('disabled',ecd);
	} else {
	$('#status_cancelled').hide();
	$('#status_cancelled *').find('input,textarea').prop('disabled',true);
	}
}

$(function(){
	$('#edit_cancelled').one('click',function(){
		$(this).next('div').show().find('input,textarea').prop('disabled',false);
	});
});


//]]>
</script>



{/literal}
{/capture}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 注文詳細本体 開始 *}
<h3 class="top">{$page_title}</h3>

{if $captured}
<p class="alert alert-info">
{if $captured==2}カードの処理に失敗しました。{else if $captured==1}カード処理に成功しました。{/if}
</p>
{/if}
{if $errmsg}
<p class="alert alert-danger">{$errmsg}</p>
{/if}

{orders}
<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th class="mh" colspan="2">お申込み情報</th>
</tr>
<tr><th>注文ID</th><td>{$order['id']} <span class="tag {$statusColorList[$order['status']|default:0]}">{$statusOrderList[$order['status']|default:0]}</span>

{if $order["admin_flag"]}<span class="tag gray">管理者登録</span>{/if}
</td></tr>
<tr><th>注文番号</th><td>{$order['category_infocode']}:{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}</td></tr>
<tr><th>日付</th><td>{$order['regist_date']}</td></tr>
</table>

<div class="contact {if $order['status']==9}dark{/if}">

<table class="inputForm">

<tr class="table-header"><th class="mh" colspan="2">配送元情報</th></tr>
{if $order['ship_from']}
<tr><th>名前</th><td>{$order['ship_from_name']}（{$order['ship_from_kana']}）様 {if $order['ship_from']}<span class="tag navy">注文者と異なる</span><br />{/if}</td></tr>
<tr><th>配送元住所</th><td>〒{$order['ship_from_zipcodef']|string_format:"%03d"}-{$order['ship_from_zipcodes']|string_format:"%04d"}<br />
{$order['ship_from_pref']} {$order['ship_from_addressf']}{if $order['ship_from_addresss']}<br />
{$order['ship_from_addresss']}{/if}{if $order['ship_from_addresst']}<br />{$order['ship_from_addresst']}{/if}</td></tr>
<tr><th>電話番号</th><td>{$order['ship_from_phonenumber']}</td></tr>
{else}
{regists rid=$order['regist_id']}
{include file="regist_name.tpl"}
{if !$regist['new_add'] || $regist['new_add']==3}
{include file="regist_address.tpl"}
{include file="regist_phonenumber.tpl"}
{else}
{include file="regist_new_add.tpl"}
{if $regist['mobilephone']}
{include file="regist_mobilephone.tpl"}
{else}
{include file="regist_student_phone.tpl"}
{/if}
{/if}
{/regists}
{/if}
<tr class="table-header"><th class="mh" colspan="2">配送先情報</th></tr>


{if $order['ship_flag']<2}
<tr><th>名前</th><td>{$order['ship_namef']} {$order['ship_nameg']}（{$order['ship_kanaf']} {$order['ship_kanag']}）様 {if !$order['ship_flag']}<span class="label label-info">登録住所に配送</span><br />{/if}</td></tr>
<tr><th>配送先住所</th><td>〒{$order['ship_zipcodef']|string_format:"%03d"}-{$order['ship_zipcodes']|string_format:"%04d"}<br />
{$order['ship_pref']} {$order['ship_addressf']}{if $order['ship_addresss']}<br />
{$order['ship_addresss']}{/if}{if $order['ship_addresst']}<br />{$order['ship_addresst']}{/if}</td></tr>
<tr><th>電話番号</th><td>{$order['ship_phonenumber']}</td></tr>
{if $order['ship_age']}
<tr><th>年齢</th><td>{$ageCheckList[$order['ship_age']]}</td></tr>
{/if}
{else if $order['ship_flag']==2}
<tr><th>受け取り店舗</th><td>{$order['store']}</td></tr>
{/if}
</table>
{if $order["admin_flag"]}
<div class="pull-right">
<p class="center"><a class="btn btn-primary" href="{$self}?mode=edit_order&app_id={$order['id']}"><i class="fa fa-fw fa-edit"></i>発送元・発送先を編集する</a></p>
</div>{/if}
<div class="clearfix"></div>
{assign var='view_order_id' value=$order['id']}
{suborders}
{if $suborder_header}
<table class="inputForm free">
<tr class="table-header">
<th class="mh">商品名</th>
<th class="mh">単価</th>
<th class="mh">個数</th>
<th class="mh">小計</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td>{$suborder['name']}
{if $suborder['methods']['cart']|@count}
{foreach from=$suborder['methods']['cart'] key=k item=v}
{if $v['use']}
<div>{$v['title']}: {$v['value']}</div>
{/if}
{/foreach}
{/if}
</td>
<td class="num right">{$suborder['price']|number_format}円</td>
<td class="num right">{$suborder['num']}</td>
<td class="num right">{$suborder['total_price']|number_format}円</td>
</tr>
{/suborders}

{if $order['reduction']}
<tr>
<th colspan="3">値引き</th>
<td class="num right">-{$order['reduction']|number_format}円</td>
</tr>
{/if}

{if $order['postage']}
<tr>
<th colspan="3">送料</th>
<td class="num right">{$order['postage']|number_format}円</td>
</tr>
{/if}
<tr>
<th class="header" colspan="3">合計</th>
<td class="num prc right">{$order['total_price_all']|number_format}円</td>
</tr>
</table>

{if $order['ship_flag']<2}
{assign var='view_order_id' value=$order['id']}
{suborders}
{if $suborder_header}
<table class="inputForm">
<col width="150">
<col width="400">

<tr class="table-header">
<th colspan="2" class="mh">配送オプション等</th>
</tr>
{/if}

{if !$order['methods']['flag_send']}
<tr><td colspan="2">{$suborder['name']}</td></tr>
{else if ($suborder['methods']['wrap_use'] || $suborder['methods']['noshi_use'] || $suborder['methods']['extra']|@count)}
<tr><td colspan="2">{$suborder['name']}</td></tr>
{/if}
{if !$order['methods']['flag_send']}
<tr><th>配達希望日</th>
<td>{if $suborder['methods']['nominate']}{$suborder['ship_date']|default:"指定なし"}{else}指定不可{/if}{if $suborder['methods']['send_date']}（{$suborder['methods']['send_date']}）{/if}</td>
</tr>

<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$suborder['ship_time']]}
</td>
</tr>
{/if}
{if $suborder['methods']['wrap_use']}
<tr><th>包装</th>
<td>{$suborder['methods']['wrap']}</td>
</tr>
{/if}

{if $suborder['methods']['noshi_use']}
<tr><th>のし</th>
<td>
{$suborder['methods']['noshi']}{if $suborder['methods']['noshi_other']}（{$suborder['methods']['noshi_other']}）{/if}{if $suborder['methods']['noshi_name']}：{$suborder['methods']['noshi_name']}{/if}
</td>
</tr>
{/if}
{if $suborder['methods']['extra']|@count}
{foreach from=$suborder['methods']['extra'] key=k item=v}
{if $v['use']}
<tr><th class="vtop">{$v['title']}</th>
<td>{$v['value']}</td>
</tr>
{/if}
{/foreach}
{/if}
{if $suborder_footer}
</table>
{/if}
{/suborders}

{if $order['methods']['flag_send']}
<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th colspan="2" class="mh">配送について</th>
</tr>
<tr><th>配達希望日</th>
<td>{if $order['methods']['nominate']}{$order['ship_date']|default:"指定なし"}{else}指定不可{/if}</td></tr>
<tr><th>配達希望時間</th>
<td>{$shiptimeKeyList[$order['ship_time']]}</td></tr>
</table>
{/if}

{/if}

<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th class="mh" colspan="2">お支払い方法・備考等</th>
</tr>

<tr><th>お支払い方法</th>
<td>{$paymentList[$order['payment']]}
{if $order['test_mode']}<span class="tag gray min">テストモード</span>{/if}


{if $order['bill']}
</td></tr>
<tr><th>請求書・払込用紙について</th>
<td>{$billList[$order['bill']]}
{if $order['bill_addressf']}
<p>〒{$order['bill_zipcodef']}-{$order['bill_zipcodes']} {$order['bill_pref']} {$order['bill_addressf']}{$order['bill_addresss']}{$order['bill_addresst']}<br />{$order['bill_name']}</p>
{/if}
</td></tr>
{/if}
<tr><th>備考欄</th><td>{$order['memo']|nl2br}</td></tr>
</table>
</div>

<table class="inputForm">


{regists rid=$order['regist_id']}
<tr><th class="mh" colspan="2">注文者情報</th></tr>

{if $order["admin_flag"] && $regist["status"]==-9}
<tr><th>ユーザー登録</th><td><span class="tag gray">管理者登録</span></td></tr>
{else}
{include file="regist_status.tpl"}
{/if}
{*include file="regist_member_name.tpl"*}
{include file="regist_name.tpl"}
{*<tr><th>注文者名</th><td>{$regist['namef']} {$regist['nameg']}（{$regist['kanaf']} {$regist['kanag']}）様 {if $regist['status']==1}<span class="tag">登録済</span>{/if}</td></tr>*}
{include file="regist_membership.tpl"}
{include file="regist_dept.tpl"}
{include file="regist_new_add.tpl"}
{include file="regist_student_phone.tpl"}
{include file="regist_mobilephone.tpl"}
{include file="regist_address.tpl"}
{include file="regist_phonenumber.tpl"}
{include file="regist_age.tpl"}

<tr><th>メールアドレス</th><td>{$regist['email']}
{*if $regist["status"]==1*}

<form class="mailForm" method="post" enctype="multipart/form-data" action="{$self}?mode=edit_mail">
<input type="hidden" name="app_id" value="{$order['id']}" />
<input type="hidden" name="regist_id" value="{$regist['id']}" />
<div class="checkbox">
<label><input type="checkbox" name="arrange" value="1" />ご注文内容をメールに記載する</label>
</div>

<button class="btn btn-primary" type="submit" name="freemail" value="お申込者へメール作成・送信" title="{$order_cust_email}へシステムからメールを送信します。送信履歴にも反映します。"><i class="fa fa-fw fa-edit"></i>お申込者へメール作成・送信</button>



</form>
{if $regist["status"]==-9}
非登録ユーザーのためシステムメールが不達になる可能性があります。
{/if}
{*/if*}
</td></tr>

{if $regist_footer}
</table>
{/if}


{if $order["admin_flag"] && $regist["status"]==-9}
<div class="pull-right">
<p><a class="btn btn-primary" href="{$self}?mode=edit_order&app_id={$order['id']}#registForm"><i class="fa fa-fw fa-edit"></i>注文者情報を編集する</a></p>
</div>
{/if}
{/regists}
<div class="clearfix"></div>

<p><a class="btn btn-primary" href="{$self}{if $url_query}?{$url_query}{else}?mode=list_order{/if}"><i class="fa fa-chevron-left fa-fw"></i>注文一覧に戻る</a></p>

<table class="inputForm">
<col width="150">
<col width="400">
<tr><th colspan="2" class="mh">生協管理欄</th></tr>

{*
<tr><th>支払状況</th>

{if $order['payment']==4}
<td>
{if $charged_errmsg}<span class="red"><i class="fa fa-exclamation-sign"></i>{$charged_errmsg}</span>{else}
<span class="tag min {$chargedColorList[{$charged_status}]}">{$chargedList[{$charged_status}]}</span>{/if}
<p>{logs process="payment_confirmed" log="payment_log" app_id=$order['id']}{if $log['process']}{$log['date']} {$log['value']|number_plus}更新
{if $log['memo']}
&nbsp;{if $paymentTypeList[$log['payment']]}決済処理日{else}口座入金日{/if}: {$log['memo']}{/if}<br />{/if}{/logs}</p>
</td>
{else if $order['payment']==5}
<td>

</td>
*}

{if $paymentTypeList[$order['payment']]}
<tr><th>カード決済サイトの履歴</th>
<td>
{if !$order['charged_id']}
<p class="error alert alert-danger">カード決済履歴がありません。</p>
{if $order['status']==1 || $order['status'] >=9}
{if $order['paid_difference']>0}
<p class="error alert alert-danger">支払い履歴が不正です。</p>
{else if ($order['paid_difference']<0)}
<form id="returnForm" method="post" enctype="multipart/form-data" action="{$self}?mode=sendmail_payment_creditcard" onsubmit="return sendmailCheck();">

<input type="hidden" name="app_id[]" value="{$order['id']}" />

<button class="btn btn-primary" type="submit" name="public" value="WEBカード決済依頼メールを配信"><i class="fa fa-fw fa-paper-plane"></i>WEBカード決済依頼メールを配信</button>
</form>
{/if}
{/if}


{logs app_id=$order['id'] process="sendmail_payment_creditcard"}
{if $log_header}
<div>[送信履歴]</div>
{/if}
{$log['date']}<br />
{/logs}

{else}
{if $order['payment']==4}

{if $order['test_mode']}<span class="tag gray">テストモード</span>{/if}
{get_charged_info_payjp api_key=$order['api_key'] charged_id=$order['charged_id'] test_mode=$order['test_mode']}
{if $charged_errmsg}<span class="red"><i class="fa fa-exclamation-sign"></i>{$charged_errmsg}</span>{else}
<span class="tag min {$chargedColorList[{$charged_status}]}">{$chargedList[{$charged_status}]}</span>{if $charged_amount_refunded}払戻金額：{$charged_amount_refunded|number_format}円{/if}{/if}
<br />
<div class="contact gray">
　カード種別：{$charged_type}<br />
　カード番号：xxxx-xxxx-xxxx-{$charged_last4}&nbsp;&nbsp;{$charged_exp_month|string_format:"%02d"}/{$charged_exp_year}<br />
　　　名義人：{$charged_name}<br />
決済失効期限：{$charged_expire_time}<br />
　　与信金額：{$charged_amount|number_format}円
{if $charged_amount_refunded}<br />　　払戻金額：{$charged_amount_refunded|number_format}円{/if}
</div>


{if $order['status']==1 || $order['status']==2 || $order['status'] >=9}

{if $charged_status==-9}
<p class="alert alert-info">失効済</p>

{else if $charged_status==9}
<p class="alert alert-info">全額払戻済</p>

{else if $order['paid_difference']!=0}

{if $charged_status==0}

{if $order['total_price_all'] > $charged_amount}
<p class="error">与信金額より請求金額が大きくなっています。</p>
<p>この手配に紐付けて新しく手配を作成し、WEBカード決済依頼メールを送信してください。その後、この手配を取消、WEB決済も返金して無効化してください。</p>

<p class="btn"><a target="_blank" href="./order.php?user_id={$entry_id}&parent_id={$order['id']}&new=1">
<i class="fa fa-fw fa-check"></i>この手配に紐づけて新規受注を作成</a></p>

{else}
<form id="captureForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_capture" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />

{if $order['paid_difference']*(-1) == $charged_amount}
{else}
<p class="error">与信金額と請求金額が異なります。カード決済金額を確認後処理して下さい。</p>
<input type="text" name="amount[]" value="{$charged[0]['amount']}" class="charge form-control validate[required,max[{$charged_amount}]]" /> <button id="btn_autoinput" data="{$order['paid_difference']}" class="btn btn-primary btn-sm" type="button">自動入力</button>（{$charged_amount|number_format}円以下でカード決済が可能です。）
{/if}

<button class="btn btn-success" type="submit" name="capture" value="カードへの課金を確定し課金完了メールを送信する"><i class="fa fa-fw fa-check"></i>実売上化を行いカード情報確認完了メールを送信する</button>
</form>
{/if}
{else}

<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
{if $order['paid_difference'] < 0 && $order['paid_difference'] > $charged_amount_real*(-1)}
<p class="error alert alert-danger">支払済金額と返金／未収金額の組み合わせが不正のためカード処理ができません。</p>

{else}

<input type="text" name="amount[]" value="" class="charge form-control validate[required,custom[number,max[-1],min[-{$charged_amount_real}]]]" /> <button id="btn_autoinput" data="{$order['paid_difference']}" class="btn btn-primary btn-sm" type="button">自動入力</button>（{$charged_amount_real|number_format}円以下で処理可、返金はマイナスで入力）
<button class="btn btn-success" type="submit" name="capture" value="カード課金のキャンセル（返金）をする"><i class="fa fa-fw fa-check"></i>カード課金のキャンセル（返金）を行う(pay.jp)</button>
</form>
{/if}
{/if}

{else}

{if $order['status']==9 && $order['price_cancelled']==0 && $charged_status==0}
<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<button class="btn btn-success" type="submit" name="capture" value="与信を失効させる"><i class="fa fa-fw fa-check"></i>与信を失効させる</button>
</form>
{/if}


{/if}


{else}
<p class="alert alert-info"><span class="tag min green">手配済</span><span class="tag min black">取消</span>でクレジットカード処理が操作できます。</p>
{/if}{* reserve_status  *}

{else if $order['payment']==5}
{if $order['test_mode']}<p><span class="label label-default">テストモード</span></p>{/if}
{get_charged_info_veritrans api_key=$order['api_key'] api_secret_key=$order['api_secret_key'] charged_id=$order['charged_id'] test_mode=$order['test_mode']}
{if $card_err}<p class="error alert alert-danger">{$card_err}</p>{/if}
{foreach from=$charged  key=k item=v name=vt}
{if $v['cardTransactionType']!=''}
<div class="contact gray">
　　決済状態：{$v['cardTransactionType']}:{$detailOrderTypeList[$v['cardTransactionType']]} {if $v['mstatus']=='success'}<span class="label label-success">{else}<span class="label label-default">{/if}{$v['mstatus']}</span><br />

{if $v['reqJpoInformation']}　　支払種別：{$paymentJpoList[$v['reqJpoInformation']]}<br />{/if}

{if $v['reqCardNumber']}　カード番号：{$v['reqCardNumber']}&nbsp;&nbsp;{$v['cardExpire']}<br />{/if}
　　処理日時：{$v['txnDatetime']}<br />
{if $v['cardTransactionType']==a}与信失効期限：{$v['expire_time']}<br />{/if}
　　{if $v['cardTransactionType']==a}与信{else}決済{/if}金額：{$v['amount']|number_format}円
</div>
{/if}

{if $smarty.foreach.vt.last}
{if $v['cardTransactionType'] == "drpad" || $v['cardTransactionType'] == "drpae"}
{assign var="transaction_type" value=$v['cardTransactionType']}
{assign var="transaction_adjust" value=$v['amount']*(-1)}
{assign var="transaction_date" value=$v['txnDatetime']}
{/if}
{/if}
{/foreach}

{if $order['status']==1 || $order['status']==2 || $order['status'] >=9}

{if $has_expired}
<p class="alert alert-info">失効済</p>


{else if $order['paid_difference']!=0}


{if $has_captured}

{if $order['paid_difference'] < 0 && $order['paid_difference'] < $order['payment_confirmed']*(-1)}

<p class="error alert alert-danger">支払済金額と返金／未収金額の組み合わせが不正のためカード処理ができません。</p>
{else}

{if $transaction_type}
<form id="adjustForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_adjust" onsubmit="return adjustCheck();">
<input type="hidden" name="app_id" value="{$order['id']}" />
<input type="hidden" name="payment_confirmed" value="{$transaction_adjust}" />（{$transaction_adjust|number_format}円）
<input type="hidden" name="payment" value="{$order['payment']}" />
<input type="hidden" name="memo" value="{$transaction_date}" />

<button class="btn btn-success" type="submit" name="adjust" value="veritrans:mapのダイレクト返品をnewlifeのDBに反映させる"><i class="fa fa-fw fa-check"></i>veritrans:mapのダイレクト返品をnewlifeのDBに反映させる</button>
</form>
{else}
<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<input type="text" name="amount[]" value="" class="form-control charge validate[required,max[-1],min[-{$order['payment_confirmed']}]" /> <button id="btn_autoinput" data="{$order['paid_difference']}" class="btn btn-primary btn-sm" type="button">自動入力</button>（{$order['payment_confirmed']|number_format}円以下で処理可、返金はマイナスで入力）
<button class="btn btn-success" type="submit" name="capture" value="カード課金のキャンセル（返金）をする"><i class="fa fa-fw fa-check"></i>カード課金のキャンセル（返金）を行う</button>
</form>
{/if}
{/if}
{else}

{if $order['total_price_all'] > $charged[0]['amount']}
<p class="error">与信金額より請求金額が大きくなっています。</p>
<p>この手配に紐付けて新しく手配を作成し、WEBカード決済依頼メールを送信してください。その後、この手配を取消、WEB決済も返金して無効化してください。</p>
{else}


<form id="captureForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_capture" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />

{if (($order['status']==1 || $order['status']==2 || $order['status'] ==10) && ($charged[0]['amount'] == $order['total_price_all'])) || ($order['status']==9 && ($charged[0]['amount'] == $order['price_cancelled']))}
<input type="hidden" name="amount[]" value="{$charged[0]['amount']}" />
{else}
<p class="error">与信金額と請求金額が異なります。カード決済金額を確認後処理して下さい。</p>
<input type="text" name="amount[]" value="" class="charge form-control validate[required,min[1],max[{$charged[0]['amount']}]]" /> <button id="btn_autoinput" data="{$order['paid_difference']}" class="btn btn-primary btn-sm" type="button">自動入力</button>（{$charged[0]['amount']|number_format}円以下でカード決済が可能です。）
{/if}

<button class="btn btn-success" type="submit" name="capture" value="カードへの課金を確定し課金完了メールを送信する"><i class="fa fa-fw fa-check"></i>実売上化を行いカード情報確認完了メールを送信する</button>
</form>
{/if}
{/if}{* has_captured *}



{else if ($order['status']==9 && $order['price_cancelled']==0 && $charged[0]['amount']>0)}
{if !$has_captured}
<p class="error">与信を失効させる。</p>
<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<button class="btn btn-success" type="submit" name="capture" value="カード与信の取消を行う"><i class="fa fa-fw fa-check"></i>カード与信の取消を行う</button>
</form>
{/if}
{/if}

{else}
<p class="alert alert-info"><span class="tag min green">手配済</span><span class="tag min black">取消</span>でクレジットカード処理が操作できます。</p>
{/if}

{else if $order['payment']==6}


{if $order['test_mode']}<p><span class="tag gray">テストモード</span></p>{/if}
{get_charged_info_veritrans api_key=$order['api_key'] api_secret_key=$order['api_secret_key'] charged_id=$order['charged_id'] test_mode=$order['test_mode']}
{if $card_err}<p class="error alert alert-danger">{$card_err}</p>{/if}

<div class="panel panel-default">
<div class="panel-body">
受付番号：{$order['info']['receipt_number']}<br />
コンビニ種別：{$order['info']['cvs_type']}<br />
決済金額：{$order['info']['amount']|number_format}円<br />
支払期限：{$order['info']['payLimit']}<br />
入金受付日：{if $order['info']['paidDatetime']}{$order['info']['paidDatetime']}{else if $order['info']['expired']=="expired"}
<span class="label label-default">期限切れ</span>{/if}
</div>
</div>

{foreach from=$charged  key=k item=v name=vt}

<div class="contact gray">
　　決済状態：{$v['cvsTxnType']}: {$detailOrderTypeList[$v['cvsTxnType']]} {if $v['mstatus']=='success'}<span class="label label-success">{else}<span class="label label-default">{/if}{$v['mstatus']}</span><br />
　　処理日時：{$v['txnDatetime']}<br />
</div>
{/foreach}

{*if $order['status']==1 || $order['status']==2 || $order['status'] >=9*}


{if $has_expired}
<p class="alert alert-info">失効済</p>


{else if $has_captured}

{if $order['paid_difference']!=0}

{if $order['payment_confirmed']==0}

<p class="error alert alert-danger">支払済金額がnewlifeの支払履歴に反映していません。</p>

<form id="adjustForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_adjust" onsubmit="return adjustCheck();">
<input type="hidden" name="app_id" value="{$order['id']}" />
<input type="hidden" name="payment_confirmed" value="{$order['info']['amount']}" />（{$order['info']['amount']|number_format}円）
<input type="hidden" name="payment" value="{$order['payment']}" />
<input type="hidden" name="memo" value="{$order['info']['paidDatetime']}" />

<button class="btn btn-success" type="submit" name="adjust" value="veritrans:mapの入金額をnewlifeのDBに反映させる"><i class="fa fa-fw fa-check"></i>veritrans:mapの入金額をnewlifeのDBに反映させる</button>
</form>
{/if}

{/if}{* paid_difference *}


{else}
<p class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> お客さまからのお支払いは行われていません。</p>
{if $order['payment_confirmed']==0 && $order['paid_difference']!=$order['info']['amount']*(-1)}

{if ($order['status'] != 9 && $order['total_price_all'] > 0) || ($order['status'] == 9 && $order['price_cancelled'] > 0)}
<p class="error">コンビニ未払で請求金額とコンビニ払いの決済金額が異なります。</p>

<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<button class="btn btn-success" type="submit" name="capture" value="コンビニ請求を取り消しコンビニ払いの受付番号を再発行します。"><i class="fa fa-fw fa-check"></i>コンビニ請求を取り消し、コンビニ払いの受付番号を再発行します。</button>
</form>

{else}
<p class="error">コンビニ未払で請求金額がゼロ</p>
<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<button class="btn btn-success" type="submit" name="capture" value="コンビニ請求を取り消す"><i class="fa fa-fw fa-check"></i>コンビニ請求を取り消す</button>
</form>
{/if}


{/if}
{/if}

{*
<form id="cancelForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_cancel" onsubmit="return captureCheck();">
<input type="hidden" name="charged_id[]" value="{$order['charged_id']}" />
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<button class="btn btn-success" type="submit" name="capture" value="コンビニ請求を取り消す"><i class="fa fa-fw fa-check"></i>コンビニ請求を取り消す</button>
</form>
*}

{/if} {*payment 別*}
{/if}
</td></tr>
{/if} {* payment=4,5,6 *}




{*else}

<td id="diff{$order['id']}"><span class="tooltips" title="">{if $order['paid_difference']==0 && $order['payment_confirmed']>0}<span class="label label-primary">支払済</span>{/if}</span>

支払確認済：{$order['payment_confirmed']|number_format}／{if $order['status']==9}取消後請求額: {$order['price_cancelled']|number_format}{else}請求金額: {$order['total_price_all']|number_format}{/if}
{logs log=payment_log process='payment_confirmed' sort='DESC' app_id=$order['id']}<div>{$log['date']} {$log['value']|number_plus}更新
{if $log['memo']}
&nbsp;口座入金日: {$log['memo']}{/if}</div>
{/logs}

{if $order['paid_difference']} <span class="auto_input" data="{$order['id']}" title="{$order['paid_difference']}"><a class="btn btn-info btn-sm">自動入力</a></span>{/if}

{if $order['paid_difference']!=0}
<form id="update{$order['id']}" class="form-inline" data="{$order['id']}" method="post" action="?mode=save_payment">
<input type="hidden" name="app_id" value="{$order['id']}" />
<input type="hidden" name="md" value="show_order" />
<div class="pull-left"><input type="text" name="payment_confirmed[{$order['id']}]" class="form-control payment_confirmed validate[required]" /></div>


<div id="date_paid{$order['id']}" class="pull-left none">
<input type="text" disabled="disabled" class="form-control validate[required] datepicker" name="date_paid[{$order['id']}]" placeholder="口座入金日" /></div>
<button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button>
</form>
{/if}
</td>
{/if*}

<tr>
<th>支払状況</th>
<td>

{if $order['paid_difference']==0 && (($order['status']==9 && $order['price_cancelled']==0) || ($order['status']<9 && $order['total_price_all']==0))}-{else}{$order['paid_difference']|number_payment}（支払済額：{$order['payment_confirmed']|number_format}&nbsp;請求額：{if $order['status']==9}{$order['price_cancelled']|number_format}{else}{$order['total_price_all']|number_format}{/if}）

{if $order['status']==9}<p>{$order['note_cancelled']|nl2br}</p>{/if}


<p>{logs process="payment_confirmed" log="payment_log" per_page=1000 app_id=$order['id']}{if $log_process}{$log_date} {$log_value|number_plus}更新
{if $log_memo}
&nbsp;{if $paymentTypeList[$log_payment]}決済処理日{else}口座入金日{/if}: {$log_memo}{/if}<br />{/if}{/logs}</p>
{/if}

</td>
</tr>


{if $order['status']>-1}
<form id="theForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_order">

<tr><th>処理状況</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="status" options=$statusOrderList selected=$order['status']|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button>
<div class="clear" style="margin-bottom: 0.8em;"></div>
</td></tr>

<tbody id="status_cancelled" class="none">
<tr>
<th>取消時設定</th>
<td>
{if $order['status']==9}
<div>取消確定日：{$order['date_cancelled']|default:"未設定"}<br />
取消後の確定請求額：{$order['price_cancelled']|number_format}</div>
{if $order['note_cancelled']}<p class="contact gray">{$order['note_cancelled']|nl2br}</p>{/if}
<span id="edit_cancelled"><a class="btn btn-sm btn-primary">編集</a></span>
{/if}
<div {if $order['status']==9}class="none"{/if}>
取消確定日：<input type="text" id="date_cancelled" name="date_cancelled" class="form-control datepicker" placeholder="取消確定日" value="{$order['date_cancelled']}" /><br />
<input type="text" class="form-control" id="price_cancelled" name="price_cancelled" placeholder="取消後の確定請求額" value="{$order['price_cancelled']}" />
<span class="help-block">生協取扱手数料やキャンセル料発生の場合入力ください（半角数字）。</span>
<p class="">注釈</p>

<textarea id="note_cancelled" class="form-control" placeholder="キャンセル料の説明・注意書など" name="note_cancelled" >{$order['note_cancelled']}</textarea>
<p><button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button></p>
</div>
</td>
</tr>
</tbody>



{if $paymentTypeList[$order['payment']]==0}
<tr><th>入金確認メール</th>
<td>
{if $order["sendmail_paid_completed"]==1}<span class="label label-primary">送信済</span>
{else if $order["sendmail_paid_completed"]==-9}<span class="label label-default">skip</span>
{else}
<div class="checkbox"><label><input type="checkbox" name="sendmail_paid_completed" value="-9" disabled="disabled" />入金確認メール送信をskip</label> <span class="abled"><a class="btn btn-sm btn-primary">ロック解除</a></span>
<button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button></div>

{/if}</td></tr>
<tr><th>入金督促メール</th>
<td>
{if $order["sendmail_nopaid"]>0}{$order["sendmail_nopaid"]}回{/if}

{if $order["sendmail_nopaid"]==-9}<span class="gray tag min">skip</span>
{else}
<div class="checkbox"><label><input type="checkbox" name="sendmail_nopaid" value="-9" disabled="disabled" />入金督促メール送信をskip</label> <span class="abled"><a class="btn btn-primary btn-sm">ロック解除</a></span>
<button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button></div>
{/if}
</td></tr>
{/if}
<tr><th>メモ、特記事項</th>
<td>
<textarea class="form-control" name="treat" id="treat" cols="10" rows="5">{$order['treat']}</textarea>

<button class="btn btn-primary btn-sm" type="submit" value="更新">更新</button>

</td>
</tr>

<input type="hidden" name="id" value="{$order['id']}" />
</form>
{else}
{/if}
</table>

<div class="row">
<div class="col-sm-4"><form id="theForm" method="post" enctype="multipart/form-data" action="{$self}?mode=export_word">
<input type="hidden" name="app_id[]" value="{$order['id']}" />
{*<input type="hidden" name="format" value="1" />*}
<button class="btn btn-primary" type="submit" value="確認書の書き出し"><i class="fa fa-fw fa-file"></i>受注確認書の書き出し</button>
</form>
</div>

{*<div class="col-sm-4"><form id="theForm" method="post" enctype="multipart/form-data" action="{$self}?mode=export_word">
<input type="hidden" name="app_id[]" value="{$order['id']}" />
<input type="hidden" name="format" value="2" />
<button class="btn btn-primary" type="submit" value="納品書の書き出し"><i class="fa fa-fw fa-file"></i>納品書の書き出し</button>
</form>
</div>*}
</div>
{/orders}
{* 注文詳細本体 終了 *}

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
