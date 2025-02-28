{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{* ページタイトル 開始 *}
{capture assign="page_title"}注文手続き{/capture}
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
		promptPosition: "inline",
			scrollOffset:200
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
	$("#btn_ship_new_address").click( function(){
		setNewAddress()
	});

});

function setNewAddress() {
	var a = $("#new_ship_address");
	if (a.hasClass("none")){
		a.removeClass("none");
		a.find("input,select").prop("disabled",false);
	} else {
		a.addClass("none");
		a.find("input,select").prop("disabled",true);
	}
}

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
{if $now_mode =='buy_confirm'}
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="now"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
{else}
<td class="first now"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
{/if}
<td><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td><span class="number">6</span><span class="hidden-xs description">ご注文完了</span></td>
</tr>
</table>

<div class="center em08">＊完了画面まで進みませんと注文が完了しません。ご注意ください。</div>
<!-- /STEPS -->

{include file='cart_table.tpl'}

{if $now_mode == 'buy_confirm'}

<p><a class="btn btn-primary btn-sm" href="{$self}?mode=view_cart"><i class="fa fa-fw fa-chevron-left"></i>カートに戻る</a></p>

<p class="alert alert-info">一配送ごとのご注文になります。配送先が複数の場合は、配送先ごとに注文を完了してください。</p>

{* 顧客情報 開始 *}

<h3 class="header">ご注文者様の情報</h3>
<form id="theForm" class="form-horizontal" method="post" action="{$self}?mode=buy_confirm">

{if $login}
{*if $getAuthdata_member_name}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{include file="regist_member_name.tpl"}
</table>
{else}
{include file="post_member_name.tpl"}
{/if*}


<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{include file="regist_name.tpl"}
{include file="regist_email.tpl"}
</table>

{if $getAuthdata_new_add}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{include file="regist_new_add.tpl"}
{include file="regist_student_phone.tpl"}
{include file="regist_mobilephone.tpl"}
</table>
{else if $getAuthdata_address}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{include file="regist_address.tpl"}
{include file="regist_phonenumber.tpl"}
</table>
{else}

{include file="post_address.tpl"}
{include file="post_phonenumber.tpl"}

{/if}



{if $methods['age']['use']}
{if !$getAuthdata_birthday}

{if $post['birth_year']}
{include file="post_age.tpl"}
{else}
{include file="edit_age.tpl"}
{/if}
{else}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{include file="regist_age.tpl"}
</table>
{/if}
{if $age_err}<span class="must_view">*必須項目です</span>{/if}{if $no_num_age_err}<span class="must_view">*半角数字で入力してください</span>{/if}{if $no_adult_age_err}<span class="must_view">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>{/if}
<span class="help-block">※酒類をお買上の場合は必ずご記入下さい。<br />20歳未満の方の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>
{/if}
<p class="right"><a class="btn btn-primary" href="/app/user/?mode=edit_regist&amp;cmp={$smarty.const.COMPONENT}&amp;part={$smarty.const.PART}&amp;md=buy_confirm"><i class="fa fa-fw fa-edit"></i>登録情報の編集</a></p>
<div class="clear"></div>


{else}

{include file="post_email.tpl"}
{*include file="post_member_name.tpl"*}
{include file="post_name.tpl"}



{*
<tr>
<th>組合員番号<span class="label label-danger">必須</span></th>
<td>
<input type="text" name="membership1" id="membership1" maxlength="4" value="{$post["membership1"]}" />
{if $membership1_err}<span class="must_view">*</span>{/if}
{if $no_num_membership1_err}<span class="must_view">*</span> <strong class="em09 red">半角数字で入力ください。</strong>{/if}
-
<input type="text" name="membership2" id="membership2" maxlength="4" value="{$post["membership2"]}" />
{if $membership2_err}<span class="must_view">*</span>{/if}
{if $no_num_membership2_err}<span class="must_view">*</span> <strong class="em09 red">半角数字で入力ください。</strong>{/if}
-
<input type="text" name="membership3" id="membership3" maxlength="4" value="{$post["membership3"]}" />
{if $membership3_err}<span class="must_view">*</span>{/if}
{if $no_num_membership3_err}<span class="must_view">*</span> <strong class="em09 red">半角数字で入力ください。</strong>{/if}<span class="em09">（半角数字で入力ください）</span>
{if $membership4_err}<span class="must_view">*</span> <strong class="em09 red">組合員番号が不正です。</strong>{/if}
</td>
</tr>
*}

{include file="post_address.tpl"}
{include file="post_phonenumber.tpl"}


{if $methods['age']['use']}
{include file="post_age.tpl"}

{if $no_adult_age_err}<span class="must_view">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>{/if}

<span class="help-block">※酒類をお買上の場合は必ずご記入下さい。<br />未成年の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>
{/if}
</table>

{/if}

<div class="center contact gray">
<label><input type="checkbox" name="ship_from" value="1" {if $post["ship_from"]}checked="checked"{/if} />
&nbsp;<span class="prc">発送元（送り主）をご注文者様とは別にする</span></label>
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

<div id="ship_self" class="box center">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<button class="btn btn-primary btn-block" name="step2" type="submit" value="配送先の確認と配送オプションの入力へ進む">配送先の確認と配送オプション入力へ進む<i class="fa fa-fw fa-chevron-right"></i></button>
</div>
</div>
</div>


<div id="shop">
<h3 class="header">お届け先情報</h3>
<div class="form-group">
<label class="col-sm-3 control-label">受け取り店舗<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select name="store" id="store" class="form-control input-lg">
{html_options output=$storeList values=$storeList selected=$post["store"]}
</select>
</div>
</div>

<div class="box center">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<button class="btn btn-primary btn-block" name="step2" type="submit" value="配送先の確認と配送オプションの入力へ進む">配送先の確認と配送オプション入力へ進む<i class="fa fa-fw fa-chevron-right"></i></button>
</div>
</div>
</div>

</div>

<div id="ship" class="">
<h3 class="header">お届け先情報</h3>

{if $login}
{addresses regist_id=$regist['id']}
<div class="contact {if $post['ship_address']==$address['id']}checked{/if}">

<h5 class="top">{$address['ship_namef']} {$address['ship_nameg']}</h5>
<p>〒{$address['ship_zipcodef']|string_format:"%03d"}-{$address['ship_zipcodes']|string_format:"%04d"}<br />
{$address['ship_pref']}{$address['ship_addressf']}{$address['ship_addresss']}{$address['ship_addresst']}</p>
<p><button class="btn btn-primary" type="submit" name="ship_address[{$address['id']}]" value="この住所を使う"><i class="fa fa-fw fa-check"></i>この住所を使う</button>
<span><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_ship_address&amp;cmp={$smarty.const.COMPONENT}&amp;part={$smarty.const.PART}&amp;md=buy_confirm&amp;address_id={$address['id']}"><i class="fa fa-fw fa-edit"></i>編集</a></span>
</p>
</div>
{/addresses}

<p id="btn_ship_new_address"><a class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>新しい住所を追加</a></p>
<div id="new_ship_address" {if !$post["ship_namef"] || $post["ship_address"]}class="none"{/if}>
{else}
<div>
{/if}
{include file="post_ship_name.tpl"}
{include file="post_ship_address.tpl"}
{include file="post_ship_phonenumber.tpl"}

{*if $methods['age']['use']}
<div class="form-group">
<label class="col-sm-3 control-label">年齢<span class="label label-danger">必須</span></label>

<div class="col-sm-9">
<div class="radio">
{html_radios name="ship_age" options=$ageCheckList class="validate[required]" checked=$post["ship_age"]}
</div>
{if $no_adult_ship_age_err}<span class="must_view">*20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</span>{/if}
<p>※酒類をお買上の場合は必ず選択下さい。<br />
未成年の飲酒は法律で禁止されています。20歳以上の年齢であることが確認できない場合には、酒類のお申込はお受けできません。</p>
{if $error['ship_age']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
{/if*}

<div class="box center">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<button class="btn btn-primary btn-block" name="step2" type="submit" value="配送先の確認と配送オプションの入力へ進む">配送先の確認と配送オプション入力へ進む<i class="fa fa-fw fa-chevron-right"></i></button>
</div>
</div>

</div>

</div>
</div><!-- ship -->

</form>

<div class="clear"></div>

{* 顧客情報 終了 *}
{/if}

{* 商品がない場合 開始 *}
{if $no_item}
{if $cleared}
<p class="note">カートの商品をすべて削除しました。</p>
{else}
<p class="note">カートには商品が入っていません。</p>
{/if}
<div class="btn"><a href="{$self}">お買い物を続ける</a></div>
{/if}
{* 商品がない場合 終了 *}

{* フッター部分の組み込み *}
{include file="footer.tpl"}
