<div id="form-group_parent_com" class="form-group">
<label class="control-label col-sm-3">勤務先名称{if $methods['parent_com']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="parent_com" name="parent_com" class="form-control input-lg{if $methods['parent_com']['use']==2} validate[required]{/if}" maxlength="128" value="{$regist['parent_com']}" />
{if $error['parent_com']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>