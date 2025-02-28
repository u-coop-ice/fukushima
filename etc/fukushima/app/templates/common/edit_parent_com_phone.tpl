<div id="form-group_parent_com_phone" class="form-group">
<label class="control-label col-sm-3">勤務先電話番号{if $methods['parent_com_phone']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="text" id="parent_com_phone1" name="parent_com_phone1" class="form-control input-lg validate[{if $methods['parent_com_phone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="5" value="{$regist['parent_com_phone1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="parent_com_phone2" name="parent_com_phone2" class="form-control input-lg validate[{if $methods['parent_com_phone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$regist['parent_com_phone2']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="parent_com_phone3" name="parent_com_phone3" class="form-control input-lg validate[{if $methods['parent_com_phone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$regist['parent_com_phone3']}" />
<span class="help-block">（半角数字）</span>
</div>

{if $error['parent_com_phone1'] || $error['parent_com_phone2'] || $error['parent_com_phone3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_parent_com_phone1'] || $error['no_num_parent_com_phone2'] || $error['no_num_parent_com_phone3']}<span class="must_view">*半角数字で入力してください</span>{/if}

</div>
</div>