{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-3.1.0.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-3.1.0.js"></script>
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
	});
	$('#new_zipcodef').zip2addr({
	zip2:'#new_zipcodes',
	pref:'#new_pref',
	addr:'#new_addressf'
	});
	$('#ship_zipcodef').zip2addr({
	zip2:'#ship_zipcodes',
	pref:'#ship_pref',
	addr:'#ship_addressf'
	});

$.fn.autoKana('#namef', '#kanaf', {katakana:true});
$.fn.autoKana('#nameg', '#kanag', {katakana:true});

});
</script>

{/literal}
{if $category['component']=="reserve"}
{literal}

<link rel="stylesheet" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.4.custom/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script type="text/javascript" src="/js/jquery/gpObserveText/jquery.gpobservetext-1.0.min.js"></script>



<script type="text/javascript">
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


	$('#cometime_spin').html('<p class="form-control-plaintext"><div class="spinner-border text-default" id="spinner" role="status"><span class="sr-only">Loading...</span></p>');


	$.ajax({
	type: "post",
	url: "/adm/ajax/?mode=select_calendar_time",
	async: true,
	dataType: "json",
	data: {date:$('#comedate').val(),selected:selected,category_id:$("#form-group_comedate").data('category_id'),component:"reserve"}
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
		console.log(e);
	});
}

</script>


<style>
#comedate_div .ui-datepicker-title select {
	display: inline;
	padding: .275rem 2.25rem .275rem .75rem;
	border: var(--bs-border-width) solid var(--bs-border-color);
	border-radius: var(--bs-border-radius);
	background-color: #FFF;
}

#comedate_div .ui-datepicker .ui-datepicker-prev, #comedate_div .ui-datepicker .ui-datepicker-next {
  top: 5px;
  width: 2.0em;
  height: 2.0em;
}

</style>
{/literal}
{/if}

{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}{$category['denomination']}{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='preview_header.tpl'}

{* 商品編集フォーム 開始 *}
<div>

{if $category['js']}
<script type="text/javascript">
{$category['js']}
</script>
{/if}

<div class="panel panel-default">
<div class="panel-heading">
{$category['denomination']}
</div>
{if $category['description_web']}
<div class="panel-body">
{$category['description_web']|nl2br}
</div>
{/if}
</div>



<form id="theForm" class="form-horizontal">

{if $category['component']=="reserve"}
{if $setDay}
<div id="form-group_comedate" class="form-group row" data-category_id="{$category['id']}">
<label class="col-sm-3 col-form-label">{$category['comedate_title']|default:"ご来店予定日"}<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div id="comedate_div"></div>

<input type="text" id="comedate" name="comedate" class="form-control input-lg datepicker validate[required]" maxlength="10" value="{$post['comedate']}" readonly="readonly" />
{if $error['comedate']}<span class="must_view">*必須項目です</span>{/if}

<div id="cometime_note" class="mt-2"></div>

</div>
</div>

<div class="form-group row">
<label class="col-sm-3 col-form-label">{$category['cometime_title']|default:"予定時間"}<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div id="cometime"></div>
{if $error['cometime']}<span class="must_view">*必須項目です</span>{/if}

<div id="cometime_spin"></div>
<input type="hidden" id="post_cometime" name="post_cometime" value="{$post['cometime']}" />
</div>
</div>
{else}
<div class="alert alert-danger">
選択出来る日程がありません。
</div>
{/if}
{/if}

<h4 class="page-header">メールアドレス<span class="em08">（お申し込み控えのメールをお送りいたします）</span></h4>

<div class="form-group row">
<label class="col-form-label col-sm-3">E-mail</label>
<div class="col-sm-9">
<p class="form-control-plaintext">
sample@sample.sample <span>{if $category['authorization']}<button class="btn btn-primary" type="button"><span>登録情報の編集<i class="fa fa-fw fa-chevron-right"></i></span></button>{/if}</span>
</p>
</div>
</div>

{if $html}
<h4 class="page-header">入力項目</h4>
{$html}
{/if}
<input type="hidden" id="code" name="code" value="{$post['code']}" />
<div class="box">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<button class="submit btn btn-primary btn-block w-100" type="button" name="confirm" value="1"><span>これはプレビューです<i class="fa fa-fw fa-chevron-right"></i></span></button>
</div></div>
</div>

</form>

{* メール編集フォーム 終了 *}

</div>

{* フッター部分の組み込み *}
{include file='preview_footer.tpl'}

