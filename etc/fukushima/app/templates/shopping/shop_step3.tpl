{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.autotab/jquery.autotab.min.js"></script>

<script type="text/javascript" src="../js/step3.js"></script>

<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>

<script type="text/javascript">

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

{if $card_err}
{literal}

$(function(){
var position=$("#h3_payment").offset().top-60;
$("html,body").animate({
    scrollTop : position
	}, {
    queue : false
	});
});
{/literal}
{/if}
{literal}


/*
function set_btn_submit(){
	if($("#token-card").size()) {
		$("#token-card").hide();
	}
	$("#check_regist_card").removeClass('none').find('input').prop('disabled',false);
	$("#btn_submit").show();
}
*/


    function fixFormAttributeForMS(){

var ua = navigator.userAgent.toLowerCase();
var ver = navigator.appVersion.toLowerCase();

// IE(11以外)
var isMSIE = (ua.indexOf('msie') > -1) && (ua.indexOf('opera') == -1);
// IE6
var isIE6 = isMSIE && (ver.indexOf('msie 6.') > -1);
// IE7
var isIE7 = isMSIE && (ver.indexOf('msie 7.') > -1);
// IE8
var isIE8 = isMSIE && (ver.indexOf('msie 8.') > -1);
// IE9
var isIE9 = isMSIE && (ver.indexOf('msie 9.') > -1);
// IE10
var isIE10 = isMSIE && (ver.indexOf('msie 10.') > -1);
// IE11
var isIE11 = (ua.indexOf('trident/7') > -1);
// IE
var isIE = isMSIE || isIE11;
// Edge
var isEdge = (ua.indexOf('edge') > -1);

if (isIE || isEdge){
    	var input = $("#form-group_payment").find('input');
		var vt = $("#inputCardnumber").find('input');
        $('#theForm').append(input);
        if (vt){
        $('#theForm').append(vt);
        }
}
        return true;
    }

function getJpoName(j) {
{/literal}
	var jpo = {$paymentJpoList_json};
{literal}
	return jpo[j];
}



</script>

{/literal}
{/capture}

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

<div class="center em08">＊完了画面まで進みませんと注文が完了しません。ご注意ください。</div>
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
{$item["noshi"]}{if $item["noshi_other"]}（{$item["noshi_other"]}）{/if}{if $item['noshi_name']}：{$item['noshi_name']}{/if}
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
</td></tr>
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
<th>配送希望日</th>
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
<form id="" method="post" action="{$self}?mode=buy_confirm">
<button class="btn btn-primary" name="reinput2" type="submit" value="戻って修正"><i class="fa fa-fw fa-chevron-left"></i>戻って修正</button>
</form>


<h3 id="h3_payment">お支払い方法・その他</h3>


<form class="form-horizontal">
<div class="form-group" id="form-group_payment">
<label class="col-sm-3 control-label">お支払い方法<span class="label label-danger">必須</span></label>
<div class="col-sm-9">

{if in_array(4,$init_paymentList) || in_array(5,$init_paymentList)}
{include file='restrict_3d_card.tpl'}
{/if}


{if $init_paymentList|@count>1}
{foreach from=$init_paymentList item=p}
<div class="radio">
<label><input type="radio" form="theForm" name="payment" value="{$p}" {if $post['payment']==$p}checked="checked"{/if} placeholder="">{$paymentList[$p]}</label>
</div>
{/foreach}
{else}
{foreach from=$init_paymentList item=p}
<p class="form-control-static input-lg">{$paymentList[$p]}</p>
<input type="hidden" form="theForm" name="payment" value="{$p}" />
{/foreach}
{/if}
</div>
</div>
</form>

{if in_array(5,$init_paymentList)}
<div id="setCardInfo_veritrans">

{if $post['payment']==5}
{if $card_err}
<div class="alert alert-danger">
<h4>クレジットカードの決済に失敗しました</h4>
{$card_err}
カード情報を確認しもう一度入力し直して下さい。
</div>
{/if}
{/if}

<form class="form-horizontal">
<div class="form-group{if !$post['token_id']} none{/if}" id="inputCardnumber" data="{$post['token_id']}">
<label class="col-sm-3 control-label">カード情報</label>
<div class="col-sm-9">


<input type="hidden" form="theForm" id="token_id" name="token_id" value="{$post['token_id']}">
<input type="hidden" form="theForm" id="jpo" name="jpo" value="{$post['jpo']}">
<input type="hidden" form="theForm" id="req_card_number" name="req_card_number" value="{$post['req_card_number']}">

{if $post['token_id']}
<div class="contact gray">
<p id="label_req_card_number" class=""><span class='em14 green'><i class='fa fa-fw fa-check-circle'></i></span>{$post['req_card_number']}
{if $post['jpo']}<br />支払種別: {$paymentJpoList[$post['jpo']]}{/if}
</p>
</div>
<button class="btn btn-primary btn-sm" id="btn_reinput_cardnumber" type="button">カード情報を変更する</button>
{else}
<p id="label_req_card_number" class="form-control-static"></p>
{/if}


</div>
</div>
</form>


<div id="inputCard" {if $post['token_id']}class="none"{/if}>



{if $regist['cust_id_veritrans']}
<div id="inputCardInfo" class="form-horizontal">
{get_customer_info_veritrans cust_id=$regist['cust_id_veritrans']}

<div class="form-group">
<label class="col-sm-3 control-label">ご登録済みのクレジットカード</label>

<div class="col-sm-9">
<input type="hidden" form="theForm" id="regist_card_number" name="regist_card_number" value="{$post['regist_card_number']}">

{foreach from=$cardList item=card}
<div class="contact gray">
<p class="form-control-statics">
カード番号：{$card[1]}</p>
<div class="radio">
<label data="{$card[1]}"><input type="radio" form="theForm" name="veritrans-card_id" value="{$card[0]}" {if $post['card_id']==$card[0]}checked="checked"{/if}>このカードで支払う</label></div>
</div>
{foreachelse}
<p class="alert alert-info">カードの登録が見つかりません。</p>
{/foreach}
<button class="btn btn-primary btn-sm" id="btn_input_newcardnumber" type="button">新しいカードを使う</button>
</div>
</div>
</div>{* inputCardInfo*}
{/if}


<form class="form-horizontal" action="{$smarty.config.veritrans_token_api_url}" data="{$smarty.config.veritrans_token_api}" id="vtForm" method="post">

<div id="inputTokenInfo">

<div class="form-group">
<label class="col-sm-3 control-label">カード番号</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="cardnumber1" name="cardnumber1" maxlength="4" size="4" value="{$post['cardnumber1']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" />
</div>
<div class="pull-left"><p class="form-control-static">&nbsp;</p></div>
<div class="pull-left"><input type="tel" id="cardnumber2" name="cardnumber2" maxlength="4" size="4" value="{$post['cardnumber2']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" /></div>
<div class="pull-left"><p class="form-control-static">&nbsp;</p></div>
<div class="pull-left"><input type="tel" id="cardnumber3" name="cardnumber3" maxlength="4" size="4" value="{$post['cardnumber3']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" /></div>
<div class="pull-left"><p class="form-control-static">&nbsp;</p></div>
<div class="pull-left"><input type="tel" id="cardnumber4" name="cardnumber4" maxlength="4" size="4" value="{$post['cardnumber4']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" /></div>

<div class="clearfix" style="margin-bottom:0.5em;"></div>

<div class="pull-left">&nbsp;<img class="img" src="/c/images/card/card_visa.png" srcset="/c/images/card/card_visa.png 1x,/c/images/card/card_visa@2x.png 2x" />
<img class="img" src="/c/images/card/card_master.png" srcset="/c/images/card/card_master.png 1x,/c/images/card/card_master@2x.png 2x" />
<img class="img" src="/c/images/card/card_jcb.png" srcset="/c/images/card/card_jcb.png 1x,/c/images/card/card_jcb@2x.png 2x" />
<img class="img" src="/c/images/card/card_amex.png" srcset="/c/images/card/card_amex.png 1x,/c/images/card/card_amex@2x.png 2x" />

</div>
<div class="clear"></div>
{if $incorrect_number_err}<span class="red"><i class="fa fa-exclamation-triangle"></i>カード番号が不正です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">有効期限</label>
<div class="col-sm-9">
<div class="pull-left"><select id="exp_month" name="exp_month" class="form-control input-lg">
{html_options output=$expMonthList values=$expMonthList selected=$post['exp_month']}
</select></div>
<div class="pull-left"><p class="form-control-static">&nbsp;/&nbsp;</p></div>
<div class="pull-left">
<select id="exp_year" name="exp_year" class="form-control input-lg">
{html_options output=$expYearList values=$expYearList selected=$post['exp_year']}
</select></div>
<div class="clear"></div>
{if $exp_month_err=="1" || $exp_year_err=="1"}<span class="must_view">*必須項目です</span>{/if}

{if $invalid_expiry_err}<span class="red"><i class="fa fa-exclamation-triangle"></i>カードの有効期限が不正です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">セキュリティコード</label>
<div class="col-sm-9">
<p class=""><input type="tel" name="cvc" id="cvc" maxlength="4" value="{$post['cvc']}" class="form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" /></p>

{if $cvc_err=="1"}<span class="must_view">*必須項目です</span>{/if}

<div class="pull-right"><img src="/c/images/card/securitycode.png" srcset="/c/images/card/securitycode.png 1x,/c/images/card/securitycode@2x.png 2x"/></div>
<p class="help-block">
セキュリティコードとは、カードに表示されいている3〜4桁の数字のことです。<br />（カード会社によって表示位置は異なります。）</p>
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">カード名義人（英語）</label>
<div class="col-sm-9">
<input type="text" class="form-control input-lg validate[required]" id="holdername" name="holdername" value="{$post['holdername']}" placeholder="（TARO YAMADA）" />
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">支払種別</label>
<div class="col-sm-9">
<select name="jpo" form="theForm" id="select_jpo" class="form-control input-lg validate[required]" >
{html_options options=$paymentJpoList selected=$post['jpo']}
</select>
{if $jpo_err=="1"}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<div class="col-sm-9 col-sm-offset-3">
<button class="btn btn-info" id="btn_submit_token" type="submit">カード情報の内容を確認する</button>
</div>
</div>

<div class="clearfix"></div>

</div>

</form>


</div>

</div>
{/if}

<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=buy_confirm" onsubmit="return fixFormAttributeForMS()">


{if in_array(4,$init_paymentList)}
<div class="col-sm-9 col-sm-offset-3">
<div id="setCardInfo_payjp">
{if $wc_errmsg}<p class="red"><i class="fa fa-exclamation-triangle"></i>{$wc_errmsg}</p>{/if}

{if $card_err}
<div class="alert alert-danger">
<h4>クレジットカードの決済に失敗しました</h4>
{$card_err}
カード情報を確認しもう一度入力し直して下さい。
</div>
{/if}

{if $login}

{if $regist['cust_id'] || $post['payjp-token']}

<div id="inputTokenInfo">
{if $regist['cust_id'] && !$post['payjp-token']}
{get_customer_info_payjp cust_id=$regist['cust_id']}

{if !$cust_errmsg}
<h5>ご登録済みのクレジットカード</h5>
{foreach from=$cards item=card}
<div class="contact gray">
<p class="form-control-statics">カード種別(c)：{$card->brand}<br />
カード番号：xxxx-xxxx-xxxx-{$card->last4}&nbsp;&nbsp;{$card->exp_month|string_format:"%02d"}/{$card->exp_year}<br />
　　名義人：{$card->name}</p>
<div>
<div class="radio">
<label><input type="radio" name="payjp-card_id" value="{$card->id}" {if $post['card_id']==$card->id}checked="checked"{/if}>このカードで支払う</label></div>
</div>
</div>
{foreachelse}
<p class="alert alert-info">カードの登録が見つかりません。</p>
{/foreach}

{else}
<p class="alert alert-danger"><i class="icon-exclamation-sign"></i> {$cust_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
<input type="hidden" name="cust_id_error" value="1"/>
{/if}

{/if}


{if $post['payjp-token']}
{get_token_info_payjp token_id=$post['payjp-token']}
{if !$token_errmsg}
<div id="token-card" class="contact gray">
<p class="form-control-statics">カード種別(t)：{$token->brand}<br />
カード番号：xxxx-xxxx-xxxx-{$token->last4}&nbsp;&nbsp;{$token->exp_month|string_format:"%02d"}/{$token->exp_year}<br />
　　名義人：{$token->name}</p>
</div>

{else}
<p class="alert alert-danger"><i class="icon-exclamation-sign"></i> {$token_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
{/if}

{/if}
<div class="clearfix"></div>
</div>
{/if}

{else}
{if $post['payjp-token']}
{get_token_info_payjp token_id=$post['payjp-token']}
{if !$token_errmsg}
<div id="token-card" class="contact gray">
<h5 class="top">クレジットカード情報</h5>
<p class="form-control-statics">カード種別(t)：{$token->brand}<br />
カード番号：xxxx-xxxx-xxxx-{$token->last4}&nbsp;&nbsp;{$token->exp_month|string_format:"%02d"}/{$token->exp_year}<br />
　　名義人：{$token->name}</p>
{else}
<p class="alert alert-danger"><i class="icon-exclamation-sign"></i> {$token_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
{/if}
</div>



{/if}
{/if}

<p><script src="https://checkout.pay.jp/" class="payjp-button" data-partial="true" data-on-created="set_btn_submit" data-key="{if $init_category['test_mode']}{$smarty.config.payjp_public_api_test}{else}{$smarty.config.payjp_public_api}{/if}"></script></p>
</div>


</div>
{/if}{* pay.jp*}

{*if $login}
<div id="check_regist_card" class="none">
<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9">
<div class="checkbox">
<label><input type="checkbox" form="theForm" id="regist_card" name="regist_card" {if $post['regist_card']}checked="checked"{/if} value="1" disabled="disabled" />
今回使用したクレジットカードをユーザー情報に登録する。</label>
<p class="help-block">次回からこのクレジットカードの入力を省略できます。</p>
</div>
</div>
</div>
</div>
{/if*}


<div class="clearfix"></div>


{if $init_category['opt_bill']}
{if $post['ship_flag']<2}
<div id="setBillInfo">
<div class="form-group" id="form-group_bill">
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
