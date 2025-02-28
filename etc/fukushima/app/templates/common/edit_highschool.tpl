<div id="form-group_highschool" class="form-group">
<label class="control-label col-sm-3">出身高校{if $methods['major']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="highschool" name="highschool" maxlength="16" class="form-control input-lg{if $methods['major']['use']==2}validate[required]{/if}" value="{$regist['highschool']}" />
{if $error['highschool']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>