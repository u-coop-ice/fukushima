{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{capture assign="header_insert"}
{literal}


<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript">
$(function(){
$("#theForm").validationEngine({
	promptPosition: "inline"
});
});




$(function($){
	$('[name="payment"]').on('click', function(){
	setCardInfo();
	});

	$('[name="payjp-card_id"]').on('click',function(){
//		set_btn_submit();
		$("#btn_submit").show();
	});

	setCardInfo();
});


function setCardInfo() {
	var payment = $('[name="payment"]:checked').val();
	if (!payment){
	var payment = $('[name="payment"]:hidden').val();
	}
	if(payment==4){;
		$("#setCardInfo").show();
		if ($("[name='payjp-token']").val()){
		$("#btn_submit").show();
		} else if($("#token-card").size()) {
		$("#btn_submit").show();
		}
	} else if (payment) {
		$("#setCardInfo").hide();
		$("#btn_submit").show();
	} else {
		$("#setCardInfo").hide();
		$("#btn_submit").hide();
	}
}
{/literal}

{if $init_category['opt_bill']}

{literal}
$(function($){
	$('#bill_zipcodef').zip2addr({
	zip2:'#bill_zipcodes',
	pref:'#bill_pref',
	addr:'#bill_addressf'
	});

});

$(function(){
	$("#bill").on('change',function(){
		billAddress();
	});
	billAddress();

	function billAddress() {
	if ($("#bill").val()!=3){
	$('#form-group_bill_address,#form-group_bill_name').hide().find('input,select').prop("disabled",true);
	} else {
	$('#form-group_bill_address,#form-group_bill_name').show().find('input,select').prop("disabled",false);
	}
}

});
{/literal}
{/if}
{literal}
function set_btn_submit(){
	if($("#token-card").size()) {
		$("#token-card").hide();
	}
	$("#check_regist_card").removeClass('none').find('input').prop('disabled',false);
	$("#btn_submit").show();
}





$(function(){
	var check = $('div.check-group');
	$('input', check).css({'opacity': '0'});

$("check input:checked").addClass("checked");
$("input:checked", check).parent().addClass('checked');

	$('label', check).click(function() {
	if ($(this).hasClass('checked')){
		$(this).removeClass('checked');
		} else {
		$(this).addClass('checked');
		}
	});

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

</script>

{/literal}
{/capture}

{assign var="page_title" value="新規注文登録（step 4）"}


{include file='header.tpl'}

<!-- STEPS -->
<table class="steps">
<tr>
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="cleared"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
<td class="cleared"><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td class="now"><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td><span class="number">6</span><span class="hidden-xs description">ご注文完了</span></td>
</tr>
</table>

<div class="center em08">＊完了画面まで進みませんとが注文が完了しません。ご注意ください。</div>
<!-- /STEPS -->


{* 商品一覧 開始 *}
{include file='cart_table.tpl'}


{if $post["ship_flag"]<2}
<h3>{if !$init_category['flag_send']}配送について{else}配送オプション{/if}</h3>

{items cart=1}
{get_item_info id=$item['id']}
{if !$init_category['flag_send']}
<h5>【{$itm['no']}】{$itm['name']} × {$item['num']}</h5>
{else if $itm['wrap_use'] || $itm['noshi_use'] || $itm['extra']|@count}
<h5>【{$itm['no']}】{$itm['name']} × {$item['num']}</h5>
{/if}

<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{if !$init_category['flag_send']}
<tr>
<th>配送希望日</th>
<td>
{if $itm["nominate"]}{$item["ship_date"]|default:"指定なし"}{else}指定不可{/if}{if $itm["send_date"]}（{$itm["send_date"]}）{/if}
</td>
</tr>
<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$item["ship_time"]]}
</td>
</tr>
{/if}
{if {$itm["wrap_use"]}}
<tr><th>包装</th>
<td>
{$item["wrap"]}
</td>
</tr>
{/if}

{if {$itm["noshi_use"]}}
<tr><th>のし</th>
<td>
{$item["noshi"]}{if $item["noshi_other"]}（{$item["noshi_other"]}）{/if}
</td>
</tr>
{/if}


{if $itm["extra"]|@count}
{foreach from=$itm["extra"] key=k item=v}
{if $v["use"]}
<tr><th class="vtop">
{$v["title"]}</th>
<td>
{$item["extra{$k}"]}
</td>
</tr>
{/if}
{/foreach}
{/if}
</table>
{/items}

{if $init_category['flag_send']}
{get_category_info}
<h3>配送について</h3>

<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>配達希望日</th>
<td>
{if $init_category['nominate']}{$post["ship_date"]|default:"指定なし"}{else}指定不可{/if}{if $init_category['send_date']}（{$init_category['send_date']}）{/if}
</td>
</tr>
<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$post["ship_time"]]}
</td>
</tr>
</table>
{/if}

{/if}
<form id="" method="post" action="{$self}?mode=confirm">
<button class="btn btn-primary" name="reinput2" type="submit" value="戻って修正"><i class="fa fa-fw fa-chevron-left"></i>戻って修正</button>
</form>


<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=confirm">
<h3>お支払い方法・その他</h3>


<div class="form-group">
<label class="col-sm-3 control-label">お支払い方法<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
{foreach from=$paymentList item=p key=k}
{if $p<4 || $p>6}
<div class="radio">
<label><input type="radio" name="payment" value="{$k}" {if $post['payment']==$k}checked="checked"{/if}>{$p}</label>
</div>
{/if}
{/foreach}
</div>
</div>

{if $init_category['opt_bill']}
{if $post['ship_flag']<2}
<div class="form-group">
<label class="col-sm-3 control-label">請求書・払込用紙について<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select name="bill" id="bill" class="form-control input-lg validate[required]">
{html_options options=$billList selected=$post['bill']}
</select>

</div>
</div>


<div id="form-group_bill_address" class="none form-group">

<label class="col-sm-3 control-label">指定郵送先 住所<span class="label label-danger">必須</span><br />
<span class="em08">マンション・建物の名前も省略しないでご記入ください</span></label>
<div class="col-sm-9">

<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="tel" id="bill_zipcodef" name="bill_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $post['bill_zipcodef']}{$post['bill_zipcodef']|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="bill_zipcodes" name="bill_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $post['bill_zipcodes']}{$post['bill_zipcodes']|string_format:"%04d"}{/if}" />
{if $bill_zipcodef_err || $bill_zipcodes_err}<span class="must_view">*必須項目です</span>{/if}
{if $no_num_bill_zipcodef_err || $no_num_bill_zipcodes_err}<span class="must_view">*半角数字で入力してください</span>{/if}
</div>
<select name="bill_pref" id="bill_pref" class="form-control input-lg validate[required]">
{html_options values=$prefList output=$prefList selected=$post['bill_pref']}
</select>
{if $pref_err}<span class="must_view">*必須項目です</span>{/if}
<div class="clearfix"></div>

<input type="text" id="bill_addressf" name="bill_addressf" class="form-control input-lg validate[required,maxSize[25]]" maxlength="25" value="{$post['bill_addressf']}" placeholder="○○市○○町" />
{if $bill_addressf_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="bill_addresss" name="bill_addresss" class="form-control input-lg validate[maxSize[25]]" maxlength="25" value="{$post['bill_addresss']}" placeholder="番地など"/>
<input type="text" id="bill_addresst" name="bill_addresst" class="form-control input-lg validate[maxSize[25]]" maxlength="25" value="{$post['bill_addresst']}" placeholder="アパート・建物名・建物名など"/>
</div>
</div>

<div id="form-group_bill_name" class="none form-group">
<label class="col-sm-3 control-label">指定郵送先 宛先<span class="label label-danger">必須</span></label>
<div class="col-sm-9">

<input type="text" id="bill_name" name="bill_name" class="validate[required] form-control input-lg" maxlength="25" value="{$post['bill_name']}" placeholder="郵送先宛名"/>

</div>
</div>
{/if}
{/if}


<div class="form-group">
<label class="col-sm-3 control-label">備考欄</label>
<div class="col-sm-9">
<textarea rows="30" class="form-control input-lg" name="memo" id="memo" >{$post["memo"]}</textarea>
</div>
</div>

<div id="btn_submit" class="contact none">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<button class="btn btn-primary btn-block" name="confirm" type="submit" value="step5.注文および入力内容の確認">注文および入力内容の確認<i class="fa fa-fw fa-chevron-right"></i></button>
</div>
</div>
</div>

</form>
{* 顧客情報 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
