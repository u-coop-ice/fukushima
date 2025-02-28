<div id="form-group_major" class="form-group">
<label class="control-label col-sm-3">学科・専攻等{if $methods['major']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="major" name="major" class="form-control input-lg{if $methods['major']['use']==2} validate[required]{/if}" value="{$regist['major']}" />
{if $error['major']=="1"}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>