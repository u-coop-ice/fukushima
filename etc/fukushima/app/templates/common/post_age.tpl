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

<div id="form-group_age" class="form-group">
<label class="col-sm-3 control-label">{$methods['age']['title']|default:"生年月日"}{if $methods['age']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<select id="birth_year" name="birth_year" class="form-control input-lg{if $methods['age']['use']==2} validate[required]{/if}">
{html_options options=$birthYearList selected=$post['birth_year']}
</select>
</div>
<div class="pull-left">
<select id="birth_month" name="birth_month" class="form-control input-lg{if $methods['age']['use']==2} validate[required]{/if}">
{html_options options=$monthList selected=$post['birth_month']}
</select>
</div>
<div class="pull-left">
<select id="birth_day" name="birth_day" class="form-control input-lg{if $methods['age']['use']==2} validate[required]{/if}">
{html_options options=$dayList selected=$post['birth_day']}
</select>
</div>
{if $error['birth_year'] || $error['birth_month'] || $error['birth_day']}<span class="must_view">*必須項目です</span>{/if}
<div class="clear"></div>
<p class="form-control-static">（現在の年齢<input type="text" id="age" name="age" readonly="readonly" maxlength="3" />歳）</p>
</div>
</div>