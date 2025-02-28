{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/js/jquery/jquery-ui-1.11.4/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript">
//<![CDATA[


$(function($){


{/literal}

n = {$is_item_exist};

{if $init_category['flag_send']}
{get_category_info}

var delivery_start = '{$init_category["js_term_start"]}';
var delivery_end = '{$init_category["js_term_end"]}';
var setDay = {$init_category['setDay']|default:'false'};

{literal}
		$("#ship_date").datepicker({
  dateFormat: 'yy-mm-dd',
  changeMonth: true,
  changeYear: true,
		showMonthAfterYear: false,
  dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
  monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
		minDate: new Date(delivery_start),
		maxDate: new Date(delivery_end),
		beforeShowDay: function(date) {
var ddd = date.getDate();
var mmm = date.getMonth()+1;
var yyy = date.getYear();
//alert(yy);
if (yyy < 2000) { yyy += 1900; }
if (mmm < 10) { mmm = "0" + String(mmm); }
if (ddd < 10) { ddd = "0" + String(ddd); }
var oneDay = String(yyy) + '-' + String(mmm) + '-' + String(ddd);
setDays = setDay;

								if (setDays.match(oneDay)) {
            return [true];
        }
        else {
           return [false];
       }
			}
		});
{/literal}


{else}

{literal}


var intervals = new Array();
delivery_ends = new Array();
delivery_starts = new Array();
var setDay = new Array();
{/literal}


{items cart=1}
{get_item_info id=$item['id']}

{if $itm['intervals']}
intervals.push({$itm['intervals']});
{else if $itm['subcategory_intervals']}
intervals.push({$itm['subcategory_intervals']});
{else}
intervals.push(0);
{/if}

{if $itm['subcategory_term_end']}
var delivery_end = "{$itm['js_term_end']}";
{else}
delivery_end = false;
{/if}
delivery_ends.push(delivery_end);

{if $itm['subcategory_term_start']}
var delivery_start = "{$itm['js_term_start']}";
{else}
var delivery_start = false;
{/if}
delivery_starts.push(delivery_start);

setDay.push({$itm['setDay']});

{/items}
{literal}

	for (i=1; i<=n;i++){

if(setDay[i-1]){

var setday=setDay[(i-1)];

		$("#ship_date"+i).datepicker({
  dateFormat: 'yy-mm-dd',
  changeMonth: true,
  changeYear: true,
		showMonthAfterYear: false,
  dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
  monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
		minDate: new Date(delivery_starts[i-1]),
		maxDate: new Date(delivery_ends[i-1]),
		beforeShowDay: function(date) {
var ddd = date.getDate();
var mmm = date.getMonth()+1;
var yyy = date.getYear();
//alert(yy);
if (yyy < 2000) { yyy += 1900; }
if (mmm < 10) { mmm = "0" + String(mmm); }
if (ddd < 10) { ddd = "0" + String(ddd); }
var oneDay = String(yyy) + '-' + String(mmm) + '-' + String(ddd);
setDays = setday.split(',');

loop1:
for (i = 0; i < setDays.length; i++) {
		if (setday.match(oneDay)) {
            return [true];
        }
        else {
	           return [false];
	       }
}
			}
		});
} else if (setDay[(i-1)]==false){
	$('#ship_date'+i).prop('disabled',true);
} else {

		$('#ship_date'+i).datepicker({
  dateFormat: 'yy-mm-dd',
  changeMonth: true,
  changeYear: true,
		showMonthAfterYear: false,
  dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
  monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
		minDate: '+'+(eval(intervals[i-1])+1)+'d'
		});


}
	} //for

{/literal}
{/if}
{literal}
});


$(function($){
	setNoshi();
	for (i=1; i<=n;i++){
	$('#noshi'+i).click( function(){setNoshi()});
	}
});

function setNoshi() {
	for (i=1; i<=n;i++){
		if ($('#noshi'+i).val() == "その他") {
		$('#noshi_other'+i).prop("disabled",false).addClass("validate[required,maxSize[6]]");
		} else {
		$('#noshi_other'+i).prop("disabled",true).removeClass("validate[required]");
		}
		}
	}

//]]>
</script>

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
</script>

{/literal}
{/capture}

{assign var="page_title" value="新規注文登録（step3）"}


{include file='header.tpl'}

<!-- STEPS -->
<table class="steps">
<tr>
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="cleared"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
<td class="now"><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td><span class="number">6</span><span class="hidden-xs description">ご注文完了</span></td>
</tr>
</table>

<div class="center em08">＊完了画面まで進みませんとが注文が完了しません。ご注意ください。</div>
<!-- /STEPS -->


{include file='cart_table.tpl'}


{* 顧客情報 開始 *}
<h3 class="header">ご注文者様の情報</h3>
{if $post['regist_id']}
{regists rid=$post['regist_id']}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{include file="regist_name.tpl"}
{include file="regist_email.tpl"}
{if $regist['new_addressf']}
{include file="regist_new_add.tpl"}
{include file="regist_student_phone.tpl"}
{include file="regist_mobilephone.tpl"}
{else}
{include file="regist_address.tpl"}
{include file="regist_phonenumber.tpl"}
{/if}
{if $flag_drink}
<tr>
<th>生年月日</th>

<td>{if $regist['birthday']}{$regist['birthday']}{else}{$post["birthday"]}{/if}</td>

</tr>
{/if}
</table>
{/regists}


{else}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>お名前</th>
<td>{$post["namef"]} {$post["nameg"]}（{$post["kanaf"]} {$post["kanag"]}）</td>
</tr>
{if $post["membership1"]}
<tr>
<th>組合員番号</th>
<td>{$post["membership1"]}-{$post["membership2"]}-{$post["membership3"]}</td>
</tr>
{/if}
<tr>
<th>E-mail</th>
<td>{$post["email"]}</td>
</tr>
<tr>
<th>住所</th>
<td>〒{$post["zipcodef"]|string_format:"%03d"}-{$post["zipcodes"]|string_format:"%04d"}<br />{$post["pref"]} {$post["addressf"]}{if $post["addresss"]} {$post["addresss"]}{/if}{if $post["addresst"]}<br />{$post["addresst"]}{/if}
</td>
</tr>
<tr>
<th>電話番号</th>
<td>{$post["phonenumber"]}</td>
</tr>
{if $flag_drink}
<tr>
<th>生年月日</th>
<td>{$post["birthday"]}</td>
</tr>
{/if}
</table>
{/if}

{if $post['ship_from']}

<h3 class="header">発送元情報</h3>

<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>発送元名称</th>
<td>{$post["ship_from_name"]}（{$post["ship_from_kana"]}）</td>
</tr>
<tr>
<th>発送元住所</th>
<td>〒{$post["ship_from_zipcodef"]|string_format:"%03d"}-{$post["ship_from_zipcodes"]|string_format:"%04d"}<br />{$post["ship_from_pref"]} {$post["ship_from_addressf"]}{if $post["ship_from_addresss"]} {$post["ship_from_addresss"]}{/if}{if $post["ship_from_addresst"]}<br />{$post["ship_from_addresst"]}{/if}
</td>
</tr>
<tr>
<th>発送元電話番号</th>
<td>{$post["ship_from_phonenumber"]}</td>
</tr>
</table>


{/if} 



<form id="" method="post" action="{$self}?mode=confirm">
<button class="btn btn-primary" name="reinput1" type="submit" value="1"><i class="fa fa-fw fa-chevron-left"></i>戻って修正</button>
</form>



<h3 class="header">お届け先情報</h3>

<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=confirm">
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{if !$post['ship_flag']}
<tr><th>お届け先について</th>
<td class="prc">ご注文者様住所にお届け</td></tr>
{else if $post['ship_flag']==1}
{if $post['ship_address']}
{addresses id=$post['ship_address']}

<tr><th>氏名</th>
<td>{$address["ship_namef"]} {$address["ship_nameg"]}（{$address["ship_kanaf"]} {$address["ship_kanag"]}）様</td></tr>

<tr><th>ご住所</th>
<td>〒{$address["ship_zipcodef"]|string_format:"%03d"}-{$address["ship_zipcodes"]|string_format:"%04d"}<br />
{$address["ship_pref"]} {$address["ship_addressf"]}{if $address["ship_addresss"]} {$address["ship_addresss"]}{/if}
{if $address["ship_addresst"]}<br />{$address["ship_addresst"]}{/if}
</td></tr>


<tr><th>電話番号（携帯可）</th>
<td>{$address["ship_phonenumber"]}</td></tr>

{if $flag_drink}
<tr>
<th>年齢{if !$address["ship_age"]}<span class="tag red micro">必須</span>{/if}</th>
<td>{if $address["ship_age"]}{$ageCheckList[$address["ship_age"]]}{else}
{html_radios name="ship_age" options=$ageCheckList class="validate[required]" checked=$post['ship_age']}{/if}

{if $no_adult_ship_age_err}<p class="tag red min">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</p>{/if}
<p>※酒類をお買上の場合は必ず選択下さい。<br />
未成年の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</p>
{if $ship_age_err}<span class="must_view">*必須項目です</span>{/if}

</td>
</tr>
{/if}



{/addresses}
{else}
<tr><th>氏名</th>
<td>{$post["ship_namef"]} {$post["ship_nameg"]}（{$post["ship_kanaf"]} {$post["ship_kanag"]}）様</td></tr>

<tr><th>ご住所</th>
<td>〒{$post["ship_zipcodef"]|string_format:"%03d"}-{$post["ship_zipcodes"]|string_format:"%04d"}<br />
{$post["ship_pref"]} {$post["ship_addressf"]}{if $post["ship_addresss"]} {$post["ship_addresss"]}{/if}
{if $post["ship_addresst"]}<br />{$post["ship_addresst"]}{/if}
</td></tr>


<tr><th>電話番号（携帯可）</th>
<td>{$post["ship_phonenumber"]}</td></tr>

{if $flag_drink}
<tr>
<th>年齢<span class="tag red micro">必須</span></th>
<td>
{html_radios name="ship_age" options=$ageCheckList class="validate[required]" checked=$post['ship_age']}
{if $no_adult_ship_age_err}<p class="tag red min">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</p>{/if}
<p>※酒類をお買上の場合は必ず選択下さい。<br />
未成年の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</p>
{if $ship_age_err}<span class="must_view">*必須項目です</span>{/if}

</td>
</tr>
{/if}
{/if}

{else if $post["ship_flag"]==2}
<tr><th>受け取り店舗</th>
<td>{$post["store"]}</td></tr>
{/if}


</table>


{if $post['ship_flag']<2}
<h3>{if !$init_category['flag_send']}配送について{else}配送オプション{/if}</h3>

{items cart=1}
{get_item_info id=$item['id']}
{if !$init_category['flag_send']}
<h5>【{$itm['no']}】{$itm['name']} × {$item['num']}</h5>
{else if $itm['wrap_use'] || $itm['noshi_use'] || $itm['extra']|@count}
<h5>【{$itm['no']}】{$itm['name']} × {$item['num']}</h5>
{/if}

{if !$init_category['flag_send']}

<div class="form-group">
<label class="col-sm-3 control-label">配達希望日</label>
<div class="col-sm-9">
{if $itm["nominate"]}
<input type="text" class="ship_date form-control input-lg" id="ship_date{$ctr}" name="ship_date{$ctr}" value="{$item["ship_date"]}" />
{if $itm["send_date"]}<br />（お届け期間：{$itm["send_date"]}）{/if}
{else}
<input type="hidden" id="ship_date{$ctr}" name="ship_date{$ctr}" value="日付指定不可" />
<p class="form-control-static">日付指定不可{if $itm["send_date"]}（お届け期間：{$itm["send_date"]}）{/if}</p>
{/if}
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">時間指定<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select name="ship_time{$ctr}" id="ship_time{$ctr}" class="form-control input-lg validate[required]">
{html_options options=$shiptimeKeyList selected=$item["ship_time"]}
</select>
</div>
</div>
{/if}


{if $itm['wrap_use'] > 0}
<div class="form-group">
<label class="col-sm-3 control-label">包装<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select name="wrap{$ctr}" id="wrap{$ctr}" class="form-control input-lg validate[required]">
{html_options output=$noshiList values=$noshiList selected=$item['wrap']}
</select>
</div>
</div>
{/if}


{if $itm["noshi_use"] > 0}
<div class="form-group">
<label class="col-sm-3 control-label">のし<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
{if $itm["noshi_use"]==1}
<select name="noshi{$ctr}" id="noshi{$ctr}" class="form-control input-lg validate[required]">
{html_options output=$noshiList values=$noshiList selected=$item["noshi"]}
</select>
{else if $itm["noshi_use"]==2}
<select name="noshi{$ctr}" id="noshi{$ctr}" class="form-control input-lg validate[required]">
{html_options output=$noshi2List values=$noshi2List selected=$item["noshi"]}
</select>
<input class="form-control input-lg" type="text" id="noshi_other{$ctr}" name="noshi_other{$ctr}" value="{$item["noshi_other"]}" />（6文字以内 例：内祝・快気祝・寸志・粗品）
{/if}
</div>
</div>
{/if}

{if $itm["extra"]|@count}
{foreach from=$itm["extra"] key=k item=v}
{if $v["use"]}
<div class="form-group">
<label class="col-sm-3 control-label">
{$v["title"]}{if $v["use"]==2}<span class="label label-danger">必須</span>{/if}
</label>
<div class="col-sm-9">
<select name="extra{$k}{$ctr}" id="extra{$k}{$ctr}" class="form-control input-lg{if $v['use'] == 2} validate[required]{/if}">
{html_options values=$v['select'] output=$v['select'] selected=$item["extra{$k}"]}
</select>
{if $extra{$k}_err}<span class="must_view">*必須項目です</span>{/if}
<p class="help-block">{$v["note"]}</p>
</div>
</div>{/if}
{/foreach}
{/if}

{/items}


{if $init_category['flag_send']}
<h3>配送について</h3>

<div class="form-group">
<label class="col-sm-3 control-label">配送希望日</label>
<div class="col-sm-9">
{if $init_category['nominate']}
<input type="text" class="ship_date form-control input-lg" id="ship_date" name="ship_date" value="{$post['ship_date']}" />
{if $init_category['send_date']}<p class="form-control-statics">（お届け期間：{$init_category['send_date']}）</p>{/if}
{else}
<input type="hidden" id="ship_date" name="ship_date" value="日付指定不可" />
<p class="form-control-static">日付指定不可{if $init_category['send_date']}（お届け期間：{$init_category['send_date']}）{/if}</p>
{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">時間指定<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
	<select name="ship_time" id="ship_time" class="form-control input-lg validate[required]">
{html_options options=$shiptimeKeyList selected=$post["ship_time"]}
</select>
</div>
</div>
{/if}

{/if}
<div class="box center">
<button class="btn btn-primary" name="step3" type="submit" value="1">step4. お支払い方法の入力へ進む<i class="fa fa-fw fa-chevron-right"></i></button>
</div>

</form>



{* 顧客情報 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
