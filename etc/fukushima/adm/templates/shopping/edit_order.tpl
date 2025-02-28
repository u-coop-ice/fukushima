{* ページタイトル 開始 *}
{assign var="page_title" value="注文の詳細"}
{* ページタイトル 終了 *}


{capture assign="header_insert"}
{literal}

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.autoKana/jquery.autoKana.js"></script>
<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>


<script type="text/javascript">
//<![CDATA[

$(function($){
	$("#theForm").validationEngine({
		promptPosition: "inline"
	});
});


$(function($){
	$('#ship_zipcodef').zip2addr({
	zip2:'#ship_zipcodes',
	pref:'#ship_pref',
	addr:'#ship_addressf'
	});
	$('#ship_from_zipcodef').zip2addr({
	zip2:'#ship_from_zipcodes',
	pref:'#ship_from_pref',
	addr:'#ship_from_addressf'
	});
	$('#zipcodef').zip2addr({
	zip2:'#zipcodes',
	pref:'#pref',
	addr:'#addressf'
	});
});

$(function(){
	$.fn.autoKana('#ship_namef', '#ship_kanaf', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#ship_nameg', '#ship_kanag', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#ship_from_name', '#ship_from_kana', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
});


//]]>
</script>

{/literal}
{/capture}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 注文詳細本体 開始 *}
<h4 class="page_title">{$page_title}</h4>

{if $captured}
<p class="note">
{if $captured==2}カード売上げの課金に失敗しました。{else if $captured==1}カード売上げを課金しました。{/if}
</p>
{/if}

{orders}
<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th class="mh" colspan="2">お申込み情報</th>
</tr>
<tr><th>注文ID</th><td>{$order['id']} <span class="tag {$statusColorList[$order['status']|default:0]}">{$statusOrderList[$order['status']|default:0]}</span></td></tr>
<tr><th>注文番号</th><td>{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}</td></tr>
<tr><th>日付</th><td>{$order['regist_date']}</td></tr>
</table>

<div class="contact {if $order['status']==9}dark{/if}">


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
<td>{$suborder['name']}</td>
<td class="num right">{$suborder['price']|number_format}円</td>
<td class="num right">{$suborder['num']}</td>
<td class="num right">{$suborder['total_price']|number_format}円</td>
</tr>
{if $suborder_footer}
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
{/if}
{/suborders}

{if $order['ship_flag']<2}
{if !$order['category_flag_send']}
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
<tr><td colspan="2">{$suborder['name']}</td></tr>
<tr><th>配達希望日</th>
<td>{if $suborder['nominate']}{$suborder['ship_date']|default:"指定なし"}{else}指定不可{/if}{if $suborder['send_date']}（{$suborder['send_date']}）{/if}</td>
</tr>
<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$suborder['ship_time']]}
</td>
</tr>
{if {$suborder['noshi_use']}}
<tr><th>のし</th>
<td>
{$suborder['noshi']}{if $suborder['noshi_other']}（{$suborder['noshi_other']}）{/if}
</td>
</tr>
{/if}
{if $suborder['extra1_use']}
<tr><th class="vtop">{$suborder['extra1_title']}</th>
<td>{$suborder['extra1']}</td>
</tr>
{/if}
{if $suborder['extra2_use']}
<tr><th class="vtop">{$suborder['extra2_title']}</th>
<td>{$suborder['extra2']}</td>
</tr>
{/if}
{if $suborder['extra3_use']}
<tr><th class="vtop">{$suborder['extra3_title']}</th>
<td>{$suborder['extra3']}</td>
</tr>
{/if}

{if $suborder_footer}
</table>
{/if}
{/suborders}

{else}
<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th colspan="2" class="mh">配送オプション等</th>
</tr>
<tr><th>配達希望日</th>
<td>{$order['ship_date']}</td></tr>
<tr><th>配達希望時間</th>
<td>{$order['ship_time']}</td></tr>
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
<td>{$paymentList[$order['payment']]}</td></tr>

<tr><th>備考欄</th><td>{$order['memo']|nl2br}</td></tr>
</table>
</div>

<p><a class="btn btn-primary" href="{$self}?mode=show_order&app_id={$order['id']}"><i class="fa fa-chevron-left fa-fw"></i>注文情報に戻る</a></p>


<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=save_order_ship">

<h4>発送元情報</h4>
{if $order['ship_from']}

<div class="form-group">
<label class="col-sm-3 control-label">発送元名称<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="ship_from_name" name="ship_from_name" maxlength="64" value="{$order["ship_from_name"]}" class="form-control input-lg validate[required]" placeholder="（発送元名）" />
{if $error['ship_from_name']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">発送元フリガナ<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="ship_from_kana" name="ship_from_kana" maxlength="64" value="{$order["ship_from_kana"]}" class="form-control input-lg validate[required]" placeholder="（ハッソウモトメイ）" />
{if $ship_from_kana_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">発送元ご住所<span class="label label-danger">必須</span><br />
<span class="em08">アパート・マンション・建物の名前も<br />省略しないでご記入ください</span></label>
<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="text" id="ship_from_zipcodef" name="ship_from_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $order["ship_from_zipcodef"]}{$order["ship_from_zipcodef"]|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="ship_from_zipcodes" name="ship_from_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $order["ship_from_zipcodes"]}{$order["ship_from_zipcodes"]|string_format:"%04d"}{/if}" />
{if $ship_from_zipcodef_err || $ship_from_zipcodes_err}<span class="must_view">*必須項目です</span>{/if}
</div>
<select name="ship_from_pref" id="ship_from_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$order["ship_from_pref"]}
</select>
{if $ship_from_pref_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_from_addressf" name="ship_from_addressf" class="form-control input-lg validate[required]" maxlength="30" value="{$order["ship_from_addressf"]}" placeholder="（○○市○○町）" />
{if $ship_from_addressf_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" class="form-control input-lg" id="ship_from_addresss" name="ship_from_addresss" maxlength="30" value="{$order["ship_from_addresss"]}" placeholder="（番地）" />
<input type="text" class="form-control input-lg" id="ship_from_addresst" name="ship_from_addresst" maxlength="30" value="{$order["ship_from_addresst"]}" placeholder="（アパート・建物名など）" />
<span class="help-block">番地の入力漏れにご注意ください。</span>

</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">発送元電話番号<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber1" name="ship_from_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$order['ship_from_phonenumber1']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber2" name="ship_from_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$order['ship_from_phonenumber2']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber3" name="ship_from_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$order['ship_from_phonenumber3']}"  />
</div>
<div class="clearfix"></div>
{if $error['ship_from_phonenumber1'] || $error['ship_from_phonenumber2'] || $error['ship_from_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_from_phonenumber1'] || $error['no_num_ship_from_phonenumber2'] || $error['no_num_ship_from_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
{if $error['no_number_ship_from_phonenumber']}<span class="must_view">*電話番号のフォーマットが不正です</span>{/if}
</div>

</div>

{else}
{regists rid=$order['regist_id']}


<div class="form-group">
<label class="col-sm-3 control-label">発送元名称<span class="tag red micro">必須</span></label>
<input type="text" id="ship_from_name" name="ship_from_name" maxlength="64" value="{if $order['ship_from_name']}{$order['ship_from_name']}{else}{$regist['namef']} {$regist['nameg']}{/if}" class="form-control input-lg validate[required]" placeholder="（発送元名）" />
{if $ship_from_name_err}<span class="must_view">*必須項目です</span>{/if}
</div>

<div class="form-group">
<label class="col-sm-3 control-label">発送元フリガナ<span class="tag red micro">必須</span></label>
<input type="text" id="ship_from_kana" name="ship_from_kana" maxlength="64" value="{if $order['ship_from_kana']}{$order['ship_from_kana']}{else}{$regist['kanaf']} {$regist['kanag']}{/if}" class="form-control input-lg validate[required]" placeholder="（ハッソウモトメイ）" />
{if $ship_from_kana_err}<span class="must_view">*必須項目です</span>{/if}
</div>

{if !$regist_new_add}
<div class="form-group">
<label class="col-sm-3 control-label">発送元ご住所<span class="tag red micro">必須</span><br />
<span class="em08">アパート・マンション・建物の名前も省略しないでご記入ください</span></label>
<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="text" id="ship_from_zipcodef" name="ship_from_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $order['ship_from_zipcodef']}{$order['ship_from_zipcodef']|string_format:'%03d'}{else if $regist['zipcodef']}{$regist['zipcodef']|string_format:'%03d'}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="ship_from_zipcodes" name="ship_from_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $order['ship_from_zipcodes']}{$order['ship_from_zipcodes']|string_format:'%04d'}{else if $regist['zipcodes']}{$regist['zipcodes']|string_format:'%04d'}{/if}" />
{if $ship_from_zipcodef_err || $ship_from_zipcodes_err}<span class="must_view">*必須項目です</span>{/if}
</div>
<div class="clearfix"></div>
<select name="ship_from_pref" id="ship_from_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$order['ship_from_pref']|default:$regist["pref"]}
</select>
{if $ship_from_pref_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_from_addressf" name="ship_from_addressf" class="form-control input-lg validate[required]" maxlength="30" value="{if $order['ship_from_addressf']}{$order['ship_from_addressf']}{else}{$regist['addressf']}{/if}" placeholder="（○○市○○町）" />
{if $ship_from_addressf_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_from_addresss" name="ship_from_addresss" class="form-control input-lg" maxlength="30" value="{if $order['ship_from_addresss']}{$order['ship_from_addresss']}{else}{$regist['addresss']}{/if}" placeholder="（番地）" />
<input type="text" id="ship_from_addresst" name="ship_from_addresst" class="form-control input-lg" maxlength="30" value="{if $order['ship_from_addresst']}{$order['ship_from_addresst']}{else}{$regist['addresst']}{/if}" placeholder="（アパート・建物名など）" />
<span class="help-block">番地の入力漏れにご注意ください。</span></p>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">発送元電話番号<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber1" name="ship_from_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$regist['phonenumber1']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber2" name="ship_from_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$regist['phonenumber2']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber3" name="ship_from_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$regist['phonenumber3']}"  />
</div>
<div class="clearfix"></div>
{if $error['ship_from_phonenumber1'] || $error['ship_from_phonenumber2'] || $error['ship_from_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_from_phonenumber1'] || $error['no_num_ship_from_phonenumber2'] || $error['no_num_ship_from_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
{if $error['no_number_ship_from_phonenumber']}<span class="must_view">*電話番号のフォーマットが不正です</span>{/if}
</div>

</div>

{else}
{include file="regist_new_add.tpl"}


<tr><th>発送元ご住所<span class="tag red micro">必須</span><br />
<span class="em08">アパート・マンション・建物の名前も<br />省略しないでご記入ください</span></th>
<td>〒<input type="text" id="ship_from_zipcodef" name="ship_from_zipcodef" class="validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $regist["new_zipcodef"]}{$regist["new_zipcodef"]|string_format:"%03d"}{/if}" />
−
<input type="text" id="ship_from_zipcodes" name="ship_from_zipcodes" class="validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $regist["new_zipcodes"]}{$regist["new_zipcodes"]|string_format:"%04d"}{/if}" />
{if $ship_from_zipcodef_err || $ship_from_zipcodes_err}<span class="must_view">*必須項目です</span>{/if}
<br />
<select name="ship_from_pref" id="ship_from_pref" class="validate[required]">
{html_options output=$prefList values=$prefList selected=$regist["new_pref"]}
</select>
{if $ship_from_pref_err}<span class="must_view">*必須項目です</span>{/if}
<p><input type="text" id="ship_from_addressf" name="ship_from_addressf" class="validate[required]" maxlength="30" value="{$regist["new_addressf"]}" placeholder="（○○市○○町）" />
{if $ship_from_addressf_err}<span class="must_view">*必須項目です</span>{/if}
</p>
<p><input type="text" id="ship_from_addresss" name="ship_from_addresss" maxlength="30" value="{$regist["new_addresss"]}" placeholder="（番地）" /><br />
<input type="text" id="ship_from_addresst" name="ship_from_addresst" maxlength="30" value="{$regist["new_addresst"]}" placeholder="（アパート・建物名など）" />
<br /><span class="em09">番地の入力漏れにご注意ください。</span></p>
</td></tr>




{if $regist['mobilephone']}

<div class="form-group">
<label class="col-sm-3 control-label">発送元電話番号<span class="tag red micro">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber1" name="ship_from_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$regist['mobilenumber1']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber2" name="ship_from_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$regist['mobilenumber2']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber3" name="ship_from_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$regist['mobilenumber3']}"  />
</div>
<div class="clearfix"></div>
{if $error['ship_from_phonenumber1'] || $error['ship_from_phonenumber2'] || $error['ship_from_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_from_phonenumber1'] || $error['no_num_ship_from_phonenumber2'] || $error['no_num_ship_from_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
{if $error['no_number_ship_from_phonenumber']}<span class="must_view">*電話番号のフォーマットが不正です</span>{/if}
</div>
</div>
</div>

{else}

<div class="form-group">
<label class="col-sm-3 control-label">発送元電話番号<span class="tag red micro">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber1" name="ship_from_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$regist['student_phone1']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber2" name="ship_from_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$regist['student_phone2']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber3" name="ship_from_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$regist['student_phone3']}"  />
</div>
<div class="clearfix"></div>
{if $error['ship_from_phonenumber1'] || $error['ship_from_phonenumber2'] || $error['ship_from_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_from_phonenumber1'] || $error['no_num_ship_from_phonenumber2'] || $error['no_num_ship_from_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
{if $error['no_number_ship_from_phonenumber']}<span class="must_view">*電話番号のフォーマットが不正です</span>{/if}
</div>
</div>
</div>
{/if}
{/if}
{/regists}
{/if}
<h4>配送先情報</h4>


{if $order['ship_flag']<2}


<div class="form-group">
<label class="col-sm-3 control-label">氏名<span class="label label-danger">必須</span></label>
<div class="row">
<div class="col-sm-4 col-xs-6">
<input type="text" id="ship_namef" name="ship_namef" maxlength="32" value="{$order["ship_namef"]}" class="form-control input-lg validate[required]" placeholder="（姓）" />
</div>
<div class="col-sm-4 col-xs-6">
<input type="text" id="ship_nameg" name="ship_nameg" maxlength="32" value="{$order["ship_nameg"]}" class="form-control input-lg validate[required]" placeholder="（名）" />
</div>
</div>
{if $ship_namef_err || $ship_nameg_err}<span class="must_view">*必須項目です</span>{/if}
</div>

<div class="form-group">
<label class="col-sm-3 control-label">フリガナ<span class="label label-danger">必須</span></label>
<div class="row">
<div class="col-sm-4 col-xs-6">

<input type="text" id="ship_kanaf" name="ship_kanaf" maxlength="32" value="{$order["ship_kanaf"]}" class="form-control input-lg validate[required]" placeholder="（セイ）" />
</div>
<div class="col-sm-4 col-xs-6">
<input type="text" id="ship_kanag" name="ship_kanag" maxlength="32" value="{$order["ship_kanag"]}" class="form-control input-lg validate[required]" placeholder="（メイ）" />
{if $ship_kanaf_err || $ship_kanag_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">ご住所<span class="label label-danger">必須</span><br />
<span class="em08">アパート・マンション・建物の名前も省略しないでご記入ください</span></label>
<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="text" id="ship_zipcodef" name="ship_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $order["ship_zipcodef"]}{$order["ship_zipcodef"]|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="ship_zipcodes" name="ship_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $order["ship_zipcodes"]}{$order["ship_zipcodes"]|string_format:"%04d"}{/if}" />
{if $ship_zipcodef_err || $ship_zipcodes_err}<span class="must_view">*必須項目です</span>{/if}
</div>
<div class="clearfix"></div>
<select name="ship_pref" id="ship_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$order["ship_pref"]}
</select>
{if $ship_pref_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_addressf" name="ship_addressf" class="form-control input-lg validate[required]" maxlength="30" value="{$order["ship_addressf"]}" placeholder="（○○市○○町）" />
{if $ship_addressf_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" class="form-control input-lg" id="ship_addresss" name="ship_addresss" maxlength="30" value="{$order["ship_addresss"]}" placeholder="（番地）" />
<input type="text" class="form-control input-lg" id="ship_addresst" name="ship_addresst" maxlength="30" value="{$order["ship_addresst"]}" placeholder="（アパート・建物名など）" />
<span class="help-block">番地の入力漏れにご注意ください。</span>

</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">電話番号（携帯可）<span class="tag red micro">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_phonenumber1" name="ship_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$order['ship_phonenumber1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_phonenumber2" name="ship_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$order['ship_phonenumber2']}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_phonenumber3" name="ship_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$order['ship_phonenumber3']}"  />
</div>
<div class="clearfix"></div>
{if $error['ship_phonenumber1'] || $error['ship_phonenumber2'] || $error['ship_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_phonenumber1'] || $error['no_num_ship_phonenumber2'] || $error['no_num_ship_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
{if $error['no_number_ship_phonenumber']}<span class="must_view">*電話番号のフォーマットが不正です</span>{/if}
</div>

</div>

{else if $order['ship_flag']==2}

<div class="form-group">
<label class="col-sm-3 control-label">受け取り店舗</label>
<div class="col-sm-9">
	<p class="form-control-static">{$order['store']}</p>
</div>
</div>{/if}

<div class="contact">

<input type="hidden" name="app_id" value="{$order['id']}" />

<p class="center"><button class="btn btn-primary" type="submit" ><i class="fa fa-fw fa-check"></i>発送元・発送先情報を更新する</button></p>
</div>
</form>




{regists rid=$order['regist_id']}
{if $regist['status']==-9}
{if $regist_header}
<form id="registForm" class="form-horizontal" method="post" action="{$self}?mode=save_order_regist">
<h5>注文者情報</h5>
{/if}

{include file="../../../app/templates/common/edit_name.tpl"}
{include file="../../../app/templates/common/edit_address.tpl"}
{include file="../../../app/templates/common/edit_phonenumber.tpl"}

{if $regist_footer}
</table>
<div class="contact">
<input type="hidden" name="regist_id" value="{$order['regist_id']}" />
<input type="hidden" name="app_id" value="{$order['id']}" />

<p class="center"><button type="submit" class="btn btn-primary" ><i class="fa fa-fw fa-check"></i>注文者情報を更新する</button></p>
</div>
</form>
{/if}

{else}
{if $regist_header}
<table class="inputForm">
<tr><th class="mh" colspan="2">注文者情報</th></tr>
{/if}
{include file="regist_status.tpl"}

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


<tr><th>メールアドレス</th><td>{$regist['email']}</td></tr>
{if $regist_footer}
</table>
{/if}
{/if}
{/regists}

<p><a class="btn btn-primary" href="{$self}?mode=show_order&app_id={$order['id']}"><i class="fa fa-chevron-left fa-fw"></i>注文情報に戻る</a></p>



{/orders}
{* 注文詳細本体 終了 *}

{* 注文が見つからなかった場合の出力等 開始 *}
{if $no_order}
<p>注文が見つかりませんでした。</p>
{/if}
{if $db_error}
<p>注文の読み込みに失敗しました。</p>
{/if}
{* 注文が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
