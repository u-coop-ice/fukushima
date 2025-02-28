
<div id="form-group_schoolyear" class="form-group">
<label class="col-sm-3 control-label">学年{if $methods['schoolyear']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>

<div class="col-sm-9">
<div class="pull-left">

<select  name="schoolyear" id="schoolyear" class="form-control input-lg {if $methods['schoolyear']['use']==2} validate[required]{/if}">
{html_options values=$schoolyear output=$schoolyear selected=$post['schoolyear']}
</select>
</div>
<div class="clearfix"></div>

{if $error['schoolyear']=="1"}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>