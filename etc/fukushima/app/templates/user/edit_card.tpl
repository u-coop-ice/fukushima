{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}


<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){
	$("#theForm").validationEngine({
		promptPosition: 'inline'
	});
});

function submitCheck() {
return confirm('登録されているカード情報を削除してよろしいですか？\nこの操作は取り消せません。');
}

function set_btn_submit(){
	$("#btn_submit").show();
}

//]]>
</script>


<script type="text/javascript">
//<![CDATA[
$(function () {
	$('#theForm').submit(function(){
		$(this).find(':submit').button('loading');
	});
});

$(function () {
	$('#btn_input_veritrans').one('click',function(){
		$(this).hide();
		$('#setCardInfo_veritrans').show();
	});
});


$(function(){
$("#vtForm").validationEngine('attach', {
    'promptPosition' : "inline",
    'scrollOffset': 200,
    'onValidationComplete': function(form, status){
if (status == true){
    submitToken(form);
    return false;
}
    return false;
  }
});
});


        function submitToken(e) {
            var data = {};
            data.token_api_key = e.attr("data");
            var url = e.attr("action");
                data.card_number = $('#cardnumber1').val()+$('#cardnumber2').val()+$('#cardnumber3').val()+$('#cardnumber4').val();
                data.card_expire = $('#exp_month').val()+'/'+($('#exp_year').val()-2000);
                data.security_code = $('#cvc').val();
                data.lang = "ja";
            var jpo = $('#select_jpo').val();

            var xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
            xhr.addEventListener('loadend', function () {
                if (xhr.status === 0) {
                    alert("トークンサーバーとの接続に失敗しました");
                    return;
                }
                var response = JSON.parse(xhr.response);
                if (xhr.status == 200) {
                    $('#inputTokenInfo').slideUp().find("input,select").prop('disabled',true);
                    $('#token_id').val(response.token);
                    $('#jpo').val(jpo);
                    var label_req_card_number = "<span class='em14 green'><i class='fa fa-fw fa-check-circle'></i></span>";
                    label_req_card_number +=response.req_card_number;
                    if (jpo){label_req_card_number += "<br />支払種別: "+getJpoName(jpo);}
                    $('#label_req_card_number').html(label_req_card_number).addClass('');
                    $('#req_card_number').val(response.req_card_number);
                    $('#btn_submit_token').hide().prop('disabled',true);
                    $('#inputCardnumber').show();
                    $(window).scrollTop($('#inputCardnumber').offset().top-50);
                }
                else {
                    $('#token_id').val(response.token);
                    alert(response.message);
                    $(window).scrollTop($('#cardnumber1').offset().top-50);
                }

            });
            xhr.send(JSON.stringify(data));
        }

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


//]]>
</script>
{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}カード情報の編集{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}
{include file='header.tpl'}

{if $saved}
<p class="saved alert alert-success">カードを登録しました。</p>
{/if}

{if $deleted}
<p class="deleted alert alert-success">カードを削除しました。</p>
{/if}

{if $errmsg}
<p class="alert alert-danger">{$errmsg}</p>
{/if}

{*if $regist['cust_id']}
{get_customer_info_payjp cust_id=$regist['cust_id']}

{if !$cust_errmsg}
<h4>ご登録のクレジットカード</h4>
{foreach from=$cards item=card}
<div class="contact gray">
<div class="pull-right"><form class="theDelete" method="post" action="{$self}?mode=delete_creditcard" onsubmit="return submitCheck();">
<button class="btn btn-primary btn-sm" type="submit" name="submit" value="カードを削除する"><i class="fa fa-fw fa-times"></i>削除</button>
<input type="hidden" name="card_id" value="{$card->id}">
</form>
</div>
　カード種別：{$card->brand}<br />
　カード番号：xxxx-xxxx-xxxx-{$card->last4}&nbsp;&nbsp;{$card->exp_month|string_format:"%02d"}/{$card->exp_year}<br />
　　　名義人：{$card->name}<br />
<div class="clearfix"></div>
</div>
{foreachelse}
<p class="alert alert-info">カードの登録が見つかりません。</p>
{/foreach}
{else}
<p class="red" id="carderrmsg"><i class="fa fa-exclamation-triangle"></i> {$cust_errmsg}</p>
{/if}

<div id="inputCardInfo">
<form id="theForm" method="post" action="{$self}?mode=save_creditcard">
<p>
<script src="https://checkout.pay.jp/" class="payjp-button" data-on-created="set_btn_submit" data-partial="true" data-key="{$smarty.config.payjp_public_api_test}"></script>
</p>
<div class="contact none" id="btn_submit"><p><button class="btn btn-success btn-block" type="submit" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>カードを登録しています" autocomplete="off"><i class="fa fa-fw fa-credit-card"></i>カードを登録する</button></p></div>
</form>
</div>
{/if}

<br />
*}
{if $regist['cust_id_veritrans']}
{get_customer_info_veritrans cust_id=$regist['cust_id_veritrans']}
{foreach from=$cardList item=card}
<div class="contact gray">
<div class="pull-right"><form class="theDelete" method="post" action="{$self}?mode=delete_creditcard_veritrans" onsubmit="return submitCheck();">
<button class="btn btn-primary btn-sm" type="submit" name="submit" value="カードを削除する"><i class="fa fa-fw fa-times"></i>削除</button>
<input type="hidden" name="card_id" value="{$card[0]}">
</form>
</div>

<p class="form-control-statics">
カード番号：{$card[1]}</p>
</div>
{foreachelse}
<p class="alert alert-info">カードの登録が見つかりません。</p>
{/foreach}
<p><button type="button" class="btn btn-primary" id="btn_input_veritrans"><i class="fa fa-fw fa-plus"></i>カードを登録する</button></p>

{if $card_err}
<div class="alert alert-danger">
<h4>クレジットカードの決済に失敗しました</h4>
{$card_err}
カード情報を確認しもう一度入力し直して下さい。
</div>
{/if}


<div id="setCardInfo_veritrans" class="none">

<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=save_creditcard_veritrans">
<div class="form-group none" id="inputCardnumber">
<label class="col-sm-3 control-label">カード情報</label>
<div class="col-sm-9">


<input type="text" id="token_id" name="token_id" value="{$post['token_id']}">
<input type="text" id="req_card_number" name="req_card_number" value="{$post['req_card_number']}">

<p id="label_req_card_number" class="form-control-static"></p>

<p><button class="btn btn-success" type="submit"><i class="fa fa-fw fa-credit-card"></i>カードを登録する</button></p>

</div>
</div>
</form>


<form class="form-horizontal" action="{$smarty.config.veritrans_token_api_url}" data="{$smarty.config.veritrans_token_api}" id="vtForm" method="post">

<div id="inputTokenInfo">

<div class="form-group">
<label class="col-sm-3 control-label">カード番号</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="cardnumber1" name="cardnumber1" maxlength="4" size="4" value="{$post['cardnumber1']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" />
</div>
<div class="pull-left"><p class="form-control-static">&nbsp;</p></div>
<div class="pull-left"><input type="tel" id="cardnumber2" name="cardnumber2" maxlength="4" size="4" value="{$post['cardnumber2']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" /></div>
<div class="pull-left"><p class="form-control-static">&nbsp;</p></div>
<div class="pull-left"><input type="tel" id="cardnumber3" name="cardnumber3" maxlength="4" size="4" value="{$post['cardnumber3']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" /></div>
<div class="pull-left"><p class="form-control-static">&nbsp;</p></div>
<div class="pull-left"><input type="tel" id="cardnumber4" name="cardnumber4" maxlength="4" size="4" value="{$post['cardnumber4']}" class="cardnumber form-control input-lg validate[required,custom[onlyNumberSp]]" placeholder="････" autocomplete="off" /></div>


<div class="pull-left">&nbsp;<img class="img" src="/c/images/card/card_visa.png" srcset="/c/images/card/card_visa.png 1x,/c/images/card/card_visa@2x.png 2x" />
<img class="img" src="/c/images/card/card_master.png" srcset="/c/images/card/card_master.png 1x,/c/images/card/card_master@2x.png 2x" />
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
<div class="col-sm-9 col-sm-offset-3">
<button class="btn btn-info" id="btn_submit_token" type="submit">カード情報の内容を確認する</button>
</div>
</div>

<div class="clearfix"></div>

</div>

</form>

</div>

{/if}



<p><a class="btn btn-primary" href="/app/user?mode=show_regist"><i class="fa fa-fw fa-chevron-left"></i>登録情報の確認に戻る</a></p>
{* 記事編集フォーム 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
