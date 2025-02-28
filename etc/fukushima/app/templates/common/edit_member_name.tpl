<div id="form-group_member_name" class="form-group">
<label class="control-label col-sm-3">組合員氏名{if $methods['member_name']['use']==2}<span class="label label-danger">必須</span>{/if}</label>
<div class="col-sm-9">
<div class="row">
<div class="col-xs-6 col-sm-4">
<input type="text" id="member_namef" name="member_namef" class="{if $methods['member_name']['use']==2}validate[required]{/if} form-control input-lg" maxlength="32" value="{$regist['member_namef']}" placeholder="姓（漢字）" />
</div>
<div class="col-xs-6 col-sm-4">
<input type="text" id="member_nameg" name="member_nameg" class="{if $methods['member_name']['use']==2}validate[required]{/if} form-control input-lg" maxlength="32" value="{$regist['member_nameg']}" placeholder="名（漢字）" />
</div>
</div>
{if $error['member_namef'] || $error['member_nameg']}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>
