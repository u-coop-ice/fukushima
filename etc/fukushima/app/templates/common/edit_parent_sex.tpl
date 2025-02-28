<div id="form-group_sex" class="form-group">
<label class="control-label col-sm-3">保護者性別／続柄{if $methods['parent_sex']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="radio">
<input type="radio" class="validate[required] radio" id="parentSexM" name="parent_sex" value="1" {if $regist['parent_sex']=="1"}checked="checked"{/if} /><label for="parentSexM"> {$sexList[1]}</label>
<span class="gray">&nbsp;&nbsp;／&nbsp;&nbsp;</span>
<input type="radio" class="validate[required] radio" id="parentSexF" name="parent_sex" value="2" {if $regist['parent_sex']=="2"}checked="checked"{/if} /><label for="parentSexF"> {$sexList[2]}</label>
&nbsp;{if $error['parent_sex']}<span class="must_view">*必須項目です</span>{/if}
</div>
<select id="parent_relation" name="parent_relation" class="form-control input-lg validate[required]">
{html_options values=$parentRelationList output=$parentRelationList selected=$regist['parent_relation']}
</select>
&nbsp;{if $error['parent_relation']}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>