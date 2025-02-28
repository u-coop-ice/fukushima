<div id="form-group_parent_com" class="form-group">
<label class="col-sm-3 control-label">勤務先名称{if $note_parent_com==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="parent_com" name="parent_com" class="form-control input-lg {if $note_parent_com==2} validate[required]{/if}" maxlength="128" value="{$post['parent_com']}" />
{if $error['parent_com']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>