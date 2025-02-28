<table id="set_onetime" class="inputForm" cellspacing="0">
<col style="width:30%;" />
<tr><th class="mh" colspan="2">配信絞り込み設定（「かつ」のみです。）</th></tr>

<tr>
<th>入学年度</th>
<td>
<select id="year" name="year" class="form-control">
{html_options options=$registYearList selected=$condition['year']}
</select>
年度
</td>
</tr>

<tr><th class="mh" colspan="2">お申込み有無で絞り込み</th></tr>
<tr>
<th>COMPONENT</th>
<td>
<div class="radio-group clearfix radio">
{html_radios id="component" name="component" options=$componentList selected=$condition['component'] assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<span class="reset"><a class="btn btn-sm btn-primary"><i class="fa fa-times"></i>リセット</a></span>
<div class="clear"></div>
</td>
</tr>

{if $componentList['entry']}
<tbody id="component_entry">
<tr>
<th>汎用エントリ</th>
<td>

<p><span class="tag">申込済</span></p>

<select id="category_id" name="category_id" class="form-control">
<option value=""></option>
{categories component="entry" no_archived=1}
<option value="{$category['id']}" {if $category['id']==$condition['category_id']}selected="selected"{/if}>{$category['denomination']}</option>
{/categories}
</select>
</td>
</tr>
</tbody>
{/if}

{if $componentList['reserve']}
<tbody id="component_reserve">
<tr>
<th>日付選択エントリ</th>
<td>
<p><span class="tag">申込済</span></p>
<select id="reserve_category_id" name="category_id" class="form-control">
<option value=""></option>
{categories no_archived=1 component="reserve"}
<option value="{$category['id']}" {if $category['id']==$condition['category_id']}selected="selected"{/if}>{$category['denomination']}</option>
{/categories}
</select>

<div style="margin-top:1rem;">
選択日付：
<select class="form-control" name="comedate" id="comedate" data="{$condition['comedate']}"></select>
</div>

<div style="margin-top:1rem;">
選択項目（時間等）：
<div id="cometime" class="checkbox" data='{if $condition["cometime"]}{json_encode($condition["cometime"])}{/if}'></div>
</div>

</td>
</tr>
</tbody>
{/if}

{if $componentList['shopping']}
<tbody id="component_shopping">
<tr>
<th>ショッピング</th>
<td>
<p><span class="tag">申込済</span></p>



<select id="category_id" name="category_id" class="form-control">
<option value=""></option>
{sp_categories}
<option value="{$category['id']}" {if $category['id']==$condition['category_id']}selected="selected"{/if}>{$category['denomination']}</option>
{/sp_categories}
</select>
</td>
</tr>
</tbody>
{/if}


<tr><th class="mh" colspan="2">配信停止系</th></tr>

<tbody id="onoff_unsubscribe">
<tr id="onoff_subscribe">
<th>配信停止リンク</th>
<td>
<div class="radio">
{html_radios id="unsubscribe" name="unsubscribe" options=$onoffList selected=$unsubscribe|default:1 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
{*<span class="reset"><a class="btn btn-sm btn-primary"><i class="fa fa-times"></i>リセット</a></span>*}
<span class="help-block">
メール末尾に配信停止用リンクを挿入します。<br />
COMPONENTでの絞り込みのないグループで設定できます。一旦配信停止にしたユーザーは、COMPONENTでの絞り込みのないメールグループから外れます。</span>
<div class="clear"></div>
</td>
</tr>
</tbody>

<tbody id="onoff_forced">
<tr>
<th>ユーザーの配信停止を無視する</th>
<td>
<div class="radio">
{html_radios id="forced" name="forced" options=$onoffList selected=$condition['forced']|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
{*<span class="reset"><a class="btn btn-sm btn-primary"><i class="fa fa-times"></i>リセット</a></span>*}
<span class="help-block">
「ON」の場合はユーザーの設定に関わらず配信されます。緊急／重要なお知らせを配信する場合などにご利用ください。</span>
</td></tr>
</tbody>
</table>

{literal}
<script>
$(function() {
$("#formID").validationEngine({
	promptPosition: "inline",
})
});
</script>

<script type="text/javascript">

//<![CDATA[
$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").parent().addClass("checked");

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');
		});
		$(this).addClass('checked');
	});
});

$(function(){

	var f = $("[name='forced']");

	f.on("click",function(){
	c = $(cp+':checked').val();
	setCmp(c);
	});

	var cp = '[name="component"]';
	cmp = $(cp+':checked').val();
	setCmp(cmp);

	$(cp).on("click",function(){
	cmp = $(cp+':checked').val();
	setCmp(cmp);
	});


	var rsv = $('#reserve_category_id');
	var rsvd = $('#comedate');
	rsv.on("change",function(){
		optReserveComedate();
	});
	rsvd.on("change",function(){
		optReserveCometime();
	});

	$(document).on("click",".cometime_all",function() {
	optCometime();
	});


	$('.reset').click(function() {
			var pd = $(this).prev('div');
			pd.find('input').prop('checked',false).parent('label').removeClass('checked');
	setCmp();
		});

});

function optReserveComedate(){
	if ($('[name="component"]:checked').val()!="reserve"){
		return;
	}

	$.ajax({
	type: "post",
	url: "/adm/ajax/?mode=select_app_comedate",
	dataType: "text",
	data: {category_id:$("#reserve_category_id").val(),selected_comedate:$('#comedate').attr('data')}
	}).done(function(selectvalue){
	$('#comedate').html(selectvalue);
	optReserveCometime();
	}).fail(function(e){
	});


}

function optReserveCometime(){

	if ($('[name="component"]:checked').val()!="reserve"){
	$('#cometime').html('');
	return;
	}

	if ($('[name="comedate"]').val()==""){
	$('#cometime').html('');
		return;
	}

	$.ajax({
	type: "post",
	url: "/adm/ajax/?mode=select_app_cometime",
	dataType: "text",
	data: {category_id:$("#reserve_category_id").val(),comedate:$('[name="comedate"]').val(),selected_cometime:$('#cometime').attr('data')}
	}).done(function(selectvalue){
	$('#cometime').html(selectvalue);

	optCometime();
	}).fail(function(e){
		console.log(e);
	});
}

function optCometime(){
	if ($('.cometime_all').prop('checked')){
		$('[name="cometime[]"]').prop('disabled',true);
	} else {
		$('[name="cometime[]"]').prop('disabled',false);
	}
}



function setCmp(e) {

$("[id^='component_']").find('select,input').prop("disabled",true);
$("[id^='component_']").find('tr').addClass('cancelled');

var forced = $("#onoff_forced").find('tr').find('input');
var unsubscribe = $("#onoff_unsubscribe").find('tr').find('input');


if (e){
	var d =$('#component_'+e);
	d.find('select,input').prop('disabled',false);
	d.find('tr').removeClass('cancelled');


	unsubscribe.eq(0).prop('disabled',false).prop('checked',true);
	unsubscribe.eq(1).prop('disabled',true).parent('label').addClass('gray');

	forced.eq(0).prop('disabled',false).parent('label').removeClass('gray');
//	forced.eq(1).prop('checked',true);

	optReserveComedate();

} else {

	unsubscribe.prop('disabled',false).parent('label').removeClass('gray');
}


	if (forced.eq(1).prop('checked')){
	unsubscribe.eq(0).prop('disabled',false).prop('checked',true);
	unsubscribe.eq(1).prop('disabled',true).parent('label').addClass('gray');
	} else {
	unsubscribe.prop('disabled',false).parent('label').removeClass('gray');
	}


}

//]]>
</script>
{/literal}
