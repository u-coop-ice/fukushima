<div id="form-group_highschool" class="form-group">
<label class="col-sm-3 control-label">出身高校{if $note_highschool==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">

<input type="text" id="highschool" name="highschool" maxlength="16" class="form-control input-lg{if $note_highschool==2} validate[required]{/if}" value="{$post['highschool']}" />
{if $error['highschool']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>