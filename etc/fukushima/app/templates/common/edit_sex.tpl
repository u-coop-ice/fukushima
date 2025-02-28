<div id="form-group_sex" class="form-group">
<label class="col-sm-3 control-label">{$methods['sex']['title']|default:"性別"}{if $methods['sex']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="radio col-sm-9">
<label for="man"><input type="radio" id="man" name="sex" value="1" {if $regist['sex']=="1"}checked="checked"{/if} {if $methods['sex']['use']==2}class="validate[required]"{/if} /> {$sexList[1]}</label>
<span class="gray">&nbsp;/&nbsp;</span>
<label for="woman"><input type="radio" id="woman" name="sex" value="2" {if $regist['sex']=="2"}checked="checked"{/if} {if $methods['sex']['use']==2}class="validate[required]"{/if} /> {$sexList[2]}</label>
{if $error['sex']=="1"}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>