{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{* ページタイトル 開始 *}
{assign var="page_title" value="新規受注登録（カート）"}
{if $now_mode == 'confirm'}
{assign var="page_title" value="新規受注登録（step2）"}
{/if}
{* ページタイトル 終了 *}

{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>

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
	});
	$('#zipcodef').zip2addr({
	zip2:'#zipcodes',
	pref:'#pref',
	addr:'#addressf'
	});
	$('#ship_from_zipcodef').zip2addr({
	zip2:'#ship_from_zipcodes',
	pref:'#ship_from_pref',
	addr:'#ship_from_addressf'
	});
});

$(function(){
	$.fn.autoKana('#namef', '#kanaf', {
		katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#nameg', '#kanag', {
	katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
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

$(function($){
	setAttr();
	$("[name='ship_flag']").click( function(){setAttr()});

});



function setAttr() {
	var tmp1 = $("#ship");
	var tmp3 = $("#ship_self");
	var tmp2 = $("#shop");
	if($("#ship_flag1").prop('checked')){
			$("#globalfooter").position('relative');
			tmp1.slideDown();
			tmp2.hide();
			tmp1.find("input,select").addClass("validate[required]").removeAttr("disabled");
			tmp2.find("select").removeClass("validate[required]").attr("disabled","disabled");
			tmp3.hide();
					tmp3.find("input").prop("disabled",true);

		} else if($("#ship_flag2").prop('checked')) {
			tmp1.hide();
			tmp2.slideDown();
			tmp1.find("input,select").removeClass("validate[required]").prop("disabled",true);
			tmp2.find("select").addClass("validate[required]").prop("disabled",false);
			tmp3.hide().find("input").prop("disabled",true);
		} else if($("#ship_flag0").prop('checked')) {
			tmp2.hide();
			tmp3.show();
			tmp3.find("input").prop("disabled",false);
			tmp1.hide();
			tmp1.find("input,select").removeClass("validate[required]").attr("disabled",true);
			tmp2.find("select").addClass("validate[required]").prop("disabled",true);
		} else {
			tmp1.hide();
			tmp2.hide();
					tmp1.find("input,select").attr("disabled","disabled");
					tmp2.find("select").attr("disabled","disabled");
			tmp3.hide();
					tmp3.find("input").prop("disabled",true);
		}
		$("#addresss,#ship_addresss,#addresst,#ship_addresst").removeClass("validate[required]");
}


$(function(){
	var a =$("input[name='ship_from']");
	setFrom(a);
	a.click( function(){setFrom(a)});
});


function setFrom(e) {
	if(e.prop('checked')){
		$("#ship_from").show();
		$("#ship_from *").prop('disabled',false);
	} else {
		$("#ship_from").find('input,select').prop('disabled',true);
		$("#ship_from").hide();
	}
}

</script>


{/literal}
{/capture}



{include file='header.tpl'}

<!-- STEPS -->
<table class="steps">
<tr>
{if $now_mode == 'confirm'}
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="now"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
{else}
<td class="first now"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class=""><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
{/if}
<td><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td><span class="number">6</span><span class="hidden-xs description">ご注文完了</span></td>
</tr>
</table>

<div class="center em08">＊完了画面まで進みませんとが注文が完了しません。ご注意ください。</div>
<!-- /STEPS -->

{include file='cart_table.tpl'}

{if $now_mode == 'confirm'}

<p class="note">※一配送ごとのご注文になります。配送先が複数の場合は、配送先ごとに注文を完了してください。</p>

{* 顧客情報 開始 *}
<h3 class="header">ご注文者様の情報</h3>
<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=confirm">

{if $regist['id']}

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

<tr><th>生年月日{if $methods['age']['use']==2}<span class="tag micro red">必須</span>{/if}</th>
<td>
{if !$regist['birthday']}
<script type="text/javascript" src="/js/islib2.js"></script>
<script type="text/javascript">

$(function($){
	$('#age').attr('readonly', true);
	$('#age').addClass('DIS');
	$('#birth_year').change( function(){ calcAge() });
	$('#birth_month').change( function(){ calcAge() });
	$('#birth_day').change( function(){ calcAge() });
	calcAge();
})

function calcAge() {
	var y = $('#birth_year').val();
	var m = $('#birth_month').val();
	var d = $('#birth_day').val();
		if(IsDate(y,m,d)){
		var tmp = new Date();
		var cmp = new Date();
		cmp.setMonth(m-1);
		cmp.setDate(d);
		var age = tmp.getYear() - (y-1900);
		if(tmp.getTime() < cmp.getTime()) { age -= 1; }
		if(age > 1900){ age= age-1900;}
		$("#age").val(age);
		}
	}
</script>

<select id="birth_year" name="birth_year" {if $methods['age']['use']==2}class="validate[required]"{/if}>
{html_options options=$birthYearList selected=$post['birth_year']}
</select>
年&nbsp;
<select id="birth_month" name="birth_month" {if $methods['age']['use']==2}class="validate[required]"{/if}>
{html_options options=$monthList selected=$post['birth_month']}
</select>
月&nbsp;
<select id="birth_day" name="birth_day" {if $methods['age']['use']==2}class="validate[required]"{/if}>
{html_options options=$dayList selected=$post['birth_day']}
</select>
日&nbsp;
{if $birth_year_err || $birth_month_err || $birth_day_err}<span class="must_view">*必須項目です</span>{/if}

（現在の年齢
<input type="text" id="age" name="age" readonly="readonly" maxlength="3" />
歳）

{else}
{$regist['birthday']}
{/if}
{if $age_err}<span class="must_view">*必須項目です</span>{/if}{if $no_num_age_err}<span class="must_view">*半角数字で入力してください</span>{/if}{if $no_adult_age_err}<span class="must_view">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>{/if}


<br />
※酒類をお買上の場合は必ずご記入下さい。<br />未成年の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</label>
</td></tr>
{/if}
</table>


{else}

{include file="post_name.tpl"}
{include file="post_email.tpl"}
{include file="post_address.tpl"}
{include file="post_phonenumber.tpl"}



{if $flag_drink}
<tr><th>生年月日{if $methods['age']['use']==2}<span class="tag micro red">必須</span>{/if}</th>
<td>
<script type="text/javascript" src="/js/islib2.js"></script>
<script type="text/javascript">

$(function($){
	$('#age').attr('readonly', true);
	$('#age').addClass('DIS');
	$('#birth_year').change( function(){ calcAge() });
	$('#birth_month').change( function(){ calcAge() });
	$('#birth_day').change( function(){ calcAge() });
	calcAge();
})

function calcAge() {
	var y = $('#birth_year').val();
	var m = $('#birth_month').val();
	var d = $('#birth_day').val();
		if(IsDate(y,m,d)){
		var tmp = new Date();
		var cmp = new Date();
		cmp.setMonth(m-1);
		cmp.setDate(d);
		var age = tmp.getYear() - (y-1900);
		if(tmp.getTime() < cmp.getTime()) { age -= 1; }
		if(age > 1900){ age= age-1900;}
		$("#age").val(age);
		}
	}
</script>

<select id="birth_year" name="birth_year" {if $methods['age']['use']==2}class="validate[required]"{/if}>
{html_options options=$birthYearList selected=$post['birth_year']}
</select>
年&nbsp;
<select id="birth_month" name="birth_month" {if $methods['age']['use']==2}class="validate[required]"{/if}>
{html_options options=$monthList selected=$post['birth_month']}
</select>
月&nbsp;
<select id="birth_day" name="birth_day" {if $methods['age']['use']==2}class="validate[required]"{/if}>
{html_options options=$dayList selected=$post['birth_day']}
</select>
日&nbsp;
{if $birth_year_err || $birth_month_err || $birth_day_err}<span class="must_view">*必須項目です</span>{/if}

（現在の年齢
<input type="text" id="age" name="age" readonly="readonly" maxlength="3" />
歳）


{if $no_adult_age_err}<span class="must_view">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>{/if}
<br />
※酒類をお買上の場合は必ずご記入下さい。<br />未成年の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</label>
</td></tr>
{/if}
</table>

{/if}


<div class="center contact gray">
<label><input type="checkbox" name="ship_from" value="1" {if $post["ship_from"]}checked="checked"{/if} />
&nbsp;<span class="prc">発送元をご注文者様とは別にする</span></label>
</div>


<div id="ship_from" class="none">

{include file="post_ship_from_name.tpl"}
{include file="post_ship_from_address.tpl"}
{include file="post_ship_from_phonenumber.tpl"}



</div>





<div class="center contact gray">
<div class="form-group">
{foreach from=$init_shipList key="k" item="ship"}
<label class="radio-inline"><input type="radio" id="ship_flag{$ship}" name="ship_flag" value="{$ship}" {if $post["ship_flag"]==$ship}checked="checked"{/if} />
<span class="prc">{$shipList[$ship]}</span></label>
{/foreach}

</div>
</div>

<div id="ship_self" class="box center"><button class="btn btn-primary" name="step2" type="submit" value="step3. 配送先の確認と配送オプションの入力へ進む">step3. 配送先の確認と配送オプションの入力へ進む</button></div>


<div id="shop" class="">
<h3 class="header">お届け先情報</h3>
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>受け取り店舗<span class="tag red micro">必須</span></th>
<td><select name="store" id="store">
{html_options output=$storeList values=$storeList selected=$post["store"]}
</select></td>
</tr>
</table>
</div>

<div id="ship" class="">
<h3 class="header">お届け先情報</h3>


{include file="post_ship_name.tpl"}
{include file="post_ship_address.tpl"}
{include file="post_ship_phonenumber.tpl"}


<div id="ship_self" class="box center"><button class="btn btn-primary" name="step2" type="submit" value="step3. 配送先の確認と配送オプションの入力へ進む">step3. 配送先の確認と配送オプションの入力へ進む</button></div>

</div>
</div><!-- ship -->

</form>

<div class="clear"></div>

{* 顧客情報 終了 *}
{/if}

{* 商品がない場合 開始 *}
{if $no_item}
{if $cleared}
<p class="alert alert-success">カートの商品をすべて削除しました。</p>
{else}
<p class="alert alert-danger">カートには商品が入っていません。</p>
{/if}
<p><a class="btn btn-primary" href="{$self}">お買い物を続ける<i class="fa fa-fw fa-chevron-right"></i></a></p>
{/if}
{* 商品がない場合 終了 *}

{* フッター部分の組み込み *}
{include file="footer.tpl"}
