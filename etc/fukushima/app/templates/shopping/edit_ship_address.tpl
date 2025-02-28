{* ヘッダー部分の組み込み *}
{if !$layout_class}
{assign var="layout_class" value="two-column"}
{/if}

{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../../js/jquery.validationEngine-ja.js"></script>


<script type="text/javascript" src="/js/jquery/jquery.autoKana/jquery.autoKana.js"></script>
<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>

<script type="text/javascript">
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
	})
});

$(function(){
	$.fn.autoKana('#ship_namef', '#ship_kanaf', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#ship_nameg', '#ship_kanag', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
});

//]]>
</script>
{/literal}
{/capture}
{* ページタイトル 開始 *}
{capture assign="page_title"}アドレス帳の{if $new_address}追加{else}編集{/if}{/capture}
{* ページタイトル 終了 *}

{include file='header.tpl'}

<h3>{$page_title}</h3>

<form id="theForm" class="form-horizontal" action="{$self}?mode=save_ship_address" method="post" enctype="x-www-form-urlencoded">

{addresses regist_id=$regist['id'] id=$view_ship_address_id}


<div class="form-group">
<label class="col-sm-3 control-label">氏名<span class="tag red micro">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-xs-6 col-sm-4">
<input type="text" id="ship_namef" name="ship_namef" maxlength="32" value="{$address["ship_namef"]}" class="form-control input-lg validate[required]" placeholder="（姓）" />
</div>
<div class="col-xs-6 col-sm-4">
<input type="text" id="ship_nameg" name="ship_nameg" maxlength="32" value="{$address["ship_nameg"]}" class="form-control input-lg validate[required]" placeholder="（名）" />
</div>
</div>
{if $ship_namef_err || $ship_nameg_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">フリガナ<span class="tag red micro">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-xs-6 col-sm-4">
<input type="text" id="ship_kanaf" name="ship_kanaf" maxlength="32" value="{$address["ship_kanaf"]}" class="form-control input-lg validate[required]" placeholder="（セイ）" />
</div>
<div class="col-xs-6 col-sm-4">
<input type="text" id="ship_kanag" name="ship_kanag" maxlength="32" value="{$address["ship_kanag"]}" class="form-control input-lg validate[required]" placeholder="（メイ）" />
</div>
</div>
{if $ship_kanaf_err || $ship_kanag_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">ご住所<span class="tag red micro">必須</span><br />
<span class="em08">アパート・マンション・建物の名前も省略しないでご記入ください</span></label>
<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left"><input type="tel" id="ship_zipcodef" name="ship_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $address["ship_zipcodef"]}{$address["ship_zipcodef"]|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_zipcodes" name="ship_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $address["ship_zipcodes"]}{$address["ship_zipcodes"]|string_format:"%04d"}{/if}" />
</div>
{if $ship_zipcodef_err || $ship_zipcodes_err}<span class="must_view">*必須項目です</span>{/if}

<div class="clear"></div>
<div class="row">
<div class="col-xs-6 col-sm-4">
<select name="ship_pref" id="ship_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$address["ship_pref"]}
</select>
</div>
</div>
{if $ship_pref_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_addressf" name="ship_addressf" class="form-control input-lg validate[required]" maxlength="30" value="{$address["ship_addressf"]}" placeholder="（○○市○○町）" />
{if $ship_addressf_err}<span class="must_view">*必須項目です</span>{/if}
<input type="text" class="form-control input-lg" id="ship_addresss" name="ship_addresss" maxlength="30" value="{$address["ship_addresss"]}" placeholder="（番地）" /><input type="text" class="form-control input-lg" id="ship_addresst" name="ship_addresst" maxlength="30" value="{$address["ship_addresst"]}" placeholder="（アパート・建物名など）" />
<p class="help-block">番地の入力漏れにご注意ください。</p>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">電話番号（携帯可）<span class="tag red micro">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_phonenumber1" name="ship_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$address["ship_phonenumber1"]}"  /></div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_phonenumber2" name="ship_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$address["ship_phonenumber2"]}"  /></div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_phonenumber3" name="ship_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$address["ship_phonenumber3"]}"  />
</div>
<div class="clear"></div>
{if $ship_phonenumber1_err || $ship_phonenumber2_err || $ship_phonenumber3_err}<span class="must_view">*必須項目です</span>{/if}
{if $no_num_ship_phonenumber1_err || $no_num_ship_phonenumber2_err || $no_num_ship_phonenumber3_err}<span class="must_view">*半角数字で入力ください</span>{/if}
</div>
</div>

<input type="hidden" name="address_id" value="{$address['id']}"/>

{/addresses}
<button class="btn btn-primary" type="submit" name="submit" value="アドレスを保存する">アドレスを保存する</button>
<span><a class="btn btn-primary" href="{$return_url}">キャンセル</a></span>
</form>
<div class="clear"></div>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
