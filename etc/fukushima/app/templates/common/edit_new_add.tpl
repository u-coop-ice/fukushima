<div id="form-group_new_add">
<div class="form-group">
<label class="col-sm-3 control-label">{$methods['new_add']['title']|default:"現住所"}{if $methods['new_add']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}<br />
<span class="em08">マンション・建物の名前も省略しないでご記入ください</span></label>

<div class="col-sm-9 radio">
<label for="newaddYES"><input type="radio" id="newaddYES" name="new_add" class="{if $methods['new_add']['use']==2}validate[required]{/if}" value="1" {if $regist['new_add']=="1"}checked="checked"{/if} /> {$newaddList[1]}</label>

<label for="newaddNON"><input type="radio" id="newaddNON" name="new_add" class="{if $methods['new_add']['use']==2}validate[required]{/if}" value="3" {if $regist['new_add']=="3"}checked="checked"{/if} /> {$newaddList[3]}</label>
</div>
<span id="new_add_must" class="must">*</span>
</div>
</div>

<div id="new_add">
<div class="form-group">
<div class="col-sm-9 col-sm-offset-3">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="tel" id="new_zipcodef" name="new_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $regist['new_zipcodef']}{$regist['new_zipcodef']|string_format:"%03d"}{/if}" />
{if $error['no_num_new_zipcodef']}<span class="must_view">*半角数字で入力してください</span>{/if}
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="new_zipcodes" name="new_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $regist['new_zipcodes']}{$regist['new_zipcodes']|string_format:"%04d"}{/if}" />
{if $error['new_zipcodef'] || $error['new_zipcodef']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_new_zipcodes']}<span class="must_view">*半角数字で入力してください</span>{/if}
</div>
<div class="clearfix"></div>
<div class="row">
<div class="col-xs-6 col-sm-4">
<select  name="new_pref" id="new_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$regist['new_pref']}
</select>
{if $error['new_pref']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
<input type="text" id="new_addressf" name="new_addressf" class="form-control input-lg validate[required,maxSize[25]]" maxlength="25" value="{$regist['new_addressf']}" placeholder="○○市○○町" />
{if $error['new_addressf']}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="new_addresss" name="new_addresss" class="form-control input-lg validate[maxSize[25]]" maxlength="25" value="{$regist['new_addresss']}" placeholder="番地など" />
<input type="text" id="new_addresst" name="new_addresst" class="form-control input-lg validate[maxSize[25]]" maxlength="25" value="{$regist['new_addresst']}" placeholder="アパート・建物名・部屋番号など" />
</div>

</div>
</div>


{literal}
<script type="text/javascript">
$(function($){
	setAttr();
	$("input[name='new_add']").click( function(){
		setAttr()
	});
});

function setAttr() {
		if ($("input[name='new_add']:checked").val() != 1) {
			$('#new_add *').prop("disabled",true);
			$('#new_add').hide();
			$('#tr_student_phone').hide();
			$('#tr_student_phone input').prop("disabled",true);
		} else {
			$("#new_add *").removeAttr("disabled");
			$('#new_add').slideDown();
			$('#tr_student_phone').show();
			$('#tr_student_phone input').prop("disabled",false);
		}
	}

</script>
{/literal}