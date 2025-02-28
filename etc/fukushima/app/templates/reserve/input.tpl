{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script type="text/javascript" src="/js/jquery/gpObserveText/jquery.gpobservetext-1.0.min.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){

tmp = new Array();
	var c = $("#comedate").val();
		$("#comedate_div").datepicker({
	altField: "#comedate",
	altFormat: "yy-mm-dd",
 	dateFormat: 'yy-mm-dd',
  changeMonth: true,
  changeYear: true,
		showMonthAfterYear: false,
{/literal}
		minDate:new Date({$startYear},{$startMonth}-1,{$startDay}),
		maxDate: new Date({$endYear},{$endMonth}-1,{$endDay}),
{literal}
		beforeShowDay: function(date) {
{/literal}
setDay = new Array({$setDay});
setOverDay = new Array({$setOverDay});
{literal}
var dd = date.getDate();
var mm = date.getMonth()+1;
var yy = date.getYear();
if (yy < 2000) { yy += 1900; }
if (mm < 10) { mm = "0" + mm; }
if (dd < 10) { dd = "0" + dd; }
var oneDay = yy + '-' + mm + '-' + dd;
setDays = setDay.join('/');

loop1:
for (i = 0; i < setDay.length; i++) {
	if (setDays.match(oneDay)) {
		if ($.inArray(oneDay,setOverDay)<0){
		return [true];
		} else {
		return [true,'overstock'];
		}
	} else {
		return [false];
	}


}
				}
		}).datepicker("setDate", c);

 });



$(function(){
	$('#comedate').gpObserveText()
	.on('textchange',function(){
	optScTime()
	});
optScTime();
});

function optScTime(){
	$('#cometime').hide();
	$('#cometime_note').html('');

	if (!$('#comedate').val()){
	$('#cometime_note').html('<p class="alert alert-danger">日付を選択してください</p>');
	$('button[type="submit"]').prop("disabled",true);
	return false;}



	var selected = $('#cometime').val();
	if (!selected){ selected='{/literal}{$post['cometime']}{literal}';}


	$('#cometime_spin').html('<p class="form-control-static input-lg"><i class="fa fa-spinner fa-pulse"></i></p>');


	$.ajax({
	type: "post",
	url: "./?mode=select_calendar_time",
	async: true,
	dataType: "json",
	data: {date:$('#comedate').val(),selected:selected{/literal}{if $view_category_id},category_id:{$view_category_id}{/if}{literal}}
	}).done(function(selectvalue){
	if (selectvalue.stock_error){
	$('#cometime').hide();
	$('#cometime_note').html('<p class="alert alert-danger">予定数に達しました</p>');
	$('#cometime_spin').html('');
	$('button[type="submit"]').prop("disabled",true);
		} else {
	$('#cometime').html(selectvalue.select);
	$('button[type="submit"]').prop("disabled",false);
	$('#cometime_spin').html('');
	$('#cometime').show();

		}
}).fail(function(e){
});

};

//]]>

</script>


<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>

<script>
$(function(){
$("#theForm").validationEngine({
	promptPosition:"inline",
	scrollOffset:200
});
});
</script>

<script type="text/javascript" src="/js/jquery/jquery.autoKana/jquery.autoKana.js"></script>
<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>
<script type="text/javascript">
$(function($){
	$('#zipcodef').zip2addr({
	zip2:'#zipcodes',
	pref:'#pref',
	addr:'#addressf'
	}),
	$('#new_zipcodef').zip2addr({
	zip2:'#new_zipcodes',
	pref:'#new_pref',
	addr:'#new_addressf'
	}),
	$('#ship_zipcodef').zip2addr({
	zip2:'#ship_zipcodes',
	pref:'#ship_pref',
	addr:'#ship_addressf'
	})

$.fn.autoKana('#namef', '#kanaf', {katakana:true});
$.fn.autoKana('#nameg', '#kanag', {katakana:true});

$.fn.autoKana('#parent_namef', '#parent_kanaf', {katakana:true});
$.fn.autoKana('#parent_nameg', '#parent_kanag', {katakana:true});


});


</script>

{/literal}
{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}{$category['denomination']}{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}

<form id="theForm" class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded" action="{$self}?mode=confirm">


<div class="panel panel-default">
<div class="panel-heading">
{$category['denomination']}
</div>
{if $category['description_web']}
<div class="panel-body">{$category['description_web']|nl2br}</div>
{/if}
</div>

{if $errmsg}<div class="alert alert-danger">{$errmsg}</div>{/if}



<div class="form-group">
<label class="col-sm-3 control-label">{$category['comedate_title']|default:"ご来店予定日"}<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div id="comedate_div"></div>

<input type="text" id="comedate" name="comedate" class="form-control input-lg datepicker validate[required]" maxlength="10" value="{$post['comedate']}" readonly="readonly" />
{if $error['comedate']}<span class="must_view">*必須項目です</span>{/if}

<div id="cometime_note"></div>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">{$category['cometime_title']|default:"予定時間"}<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div id="cometime"></div>

{*<select	name="cometime" id="cometime" class="form-control input-lg validate[required]">
{html_options options=$cometimeList selected=$post['cometime']}
</select>*}
{if $error['cometime']}<span class="must_view">*必須項目です</span>{/if}

<div id="cometime_spin"></div>
<input type="hidden" id="post_cometime" name="post_cometime" value="{$post['cometime']}" />
</div>
</div>


<h4>メールアドレス<span class="em08">（お申し込み控えのメールをお送りいたします）</span></h4>

<div class="form-group">
{if $login}
<label class="col-sm-3 control-label">E-mail</label>
<div class="col-sm-9"><p class="form-control-static">
{$regist['username']} <span><a class="btn btn-primary" href="{$init_url}app/user/?mode=show_regist">登録情報の編集</a></span>
</p>
</div>
{else}
<label class="col-sm-3 control-label">E-mail<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="email" name="email" class="form-control input-lg validate[required,custom[email]" value="{$post['email']}" />
{if $email_err=="1"}<span class="must_view">*入力必須項目です</span>{/if}
{if $no_email_err=="1"}<span class="must_view">*E-mailアドレスが不正です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">E-mail<span class="em08">（確認）</span><span class="label label-danger">必須</span></label>
<div class="col-sm-9"><input type="text" id="emailcfrm" name="emailcfrm" maxlength="64" class="form-control input-lg validate[required,custom[email],equals[email]]" value="{$post['emailcfrm']}" />
{if $emailcfrm_err=="1"}<span class="must_view">*入力必須項目です</span>{/if}
{if $no_emailcfrm_err=="1"}<span class="must_view">*E-mail（確認）アドレスが不正です</span>{/if}
{if $nonemail_err=="1"}<span class="must_view">*E-mailアドレスが一致していません。</span>{/if}
</div>
{/if}
</div>

<h4>基本情報</h4>


{$html}

<input type="hidden" id="code" name="code" value="{$post['code']}" />
<div class="box">
<div class="row">
<div class="col-sm-8 col-sm-push-2">
<button class="submit btn btn-primary btn-block" type="submit" name="confirm" value="1">入力内容を確認する<i class="fa fa-fw fa-chevron-right"></i></button>
</div></div>
</div>
</form>
{* メール編集フォーム 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}

