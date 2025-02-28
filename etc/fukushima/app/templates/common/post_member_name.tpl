
<div id="form-group_member_name" class="form-group">
<label class="col-sm-3 control-label">組合員氏名{if $methods['member_name']['use']==2}<span class="label label-danger">必須</span>{/if}</label>
<div class="col-sm-9">

<div class="row">
<div class="col-sm-4 col-xs-6"><input type="text" id="member_namef" name="member_namef" class="form-control input-lg{if $methods['member_name']['use']==2} validate[required]{/if}" maxlength="32" value="{$post['member_namef']}" placeholder="（姓）" />
</div>
<div class="col-sm-4 col-xs-6"><input type="text" id="member_nameg" name="member_nameg" class="form-control input-lg{if $methods['member_name']['use']==2} validate[required]{/if}" maxlength="32" value="{$post['member_nameg']}" placeholder="（名）" />
</div>
</div>
{if $error['member_namef'] || $error['member_nameg']}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>