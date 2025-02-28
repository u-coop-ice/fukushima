<div id="form-group_parent_com_phone" class="form-group">
<label class="col-sm-3 control-label">勤務先電話番号{if $note_parent_com_phone==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="text" id="parent_com_phone1" name="parent_com_phone1" class="validate[{if $note_parent_com_phone==2}required,{/if}custom[onlyNumberSp]]" maxlength="5" value="{$post['parent_com_phone1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="parent_com_phone2" name="parent_com_phone2" class="validate[{if $note_parent_com_phone==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['parent_com_phone2']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="parent_com_phone3" name="parent_com_phone3" class="validate[{if $note_parent_com_phone==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['parent_com_phone3']}" />
</div>
<span class="help-block">（半角数字）</span>
{if $error['parent_com_phone1'] || $error['parent_com_phone2'] || $error['parent_com_phone3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_parent_com_phone1'] || $error['no_num_parent_com_phone2'] || $error['no_num_parent_com_phone3']}<span class="must_view">*半角数字で入力してください</span>{/if}
{if $error['no_number_parent_com_phone']}<span class="must_view">*電話番号の形式が不正です</span>{/if}

</div>
</div>