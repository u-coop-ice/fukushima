<div id="form-group_parent_sex" class="form-group">
<label class="col-sm-3 control-label">保護者性別／続柄{if $note_parent_sex==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">

<div class="radio">
<label for="parentSexM"><input type="radio" class="validate[required] radio" id="parentSexM" name="parent_sex" value="1" {if $post['parent_sex']=="1"}checked="checked"{/if} /> {$sexList[1]}</label>
<span class="gray">&nbsp;&nbsp;／&nbsp;&nbsp;</span>
<label for="parentSexF"> <input type="radio" class="validate[required] radio" id="parentSexF" name="parent_sex" value="2" {if $post['parent_sex']=="2"}checked="checked"{/if} />{$sexList[2]}</label>
</div>&nbsp;{if $error['parent_sex']}<span class="must_view">*必須項目です</span>{/if}
&nbsp;&nbsp;&nbsp;&nbsp;
<select id="parent_relation" name="parent_relation" class="validate[required]">
{html_options values=$parentRelationList output=$parentRelationList selected=$post['parent_relation']}
</select>
&nbsp;{if $error['parent_relation']}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>