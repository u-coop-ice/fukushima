<div id="tr_student_phone">
<div id="form-group_student_phone" class="form-group">
<label class="col-sm-3 control-label">{$methods['student_phone']['title']|default:"電話番号"}{if $methods['student_phone']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">

<input type="tel" id="student_phone1" name="student_phone1" class="form-control input-lg validate[{if $methods['student_phone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="3" value="{$post['student_phone1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="student_phone2" name="student_phone2" class="form-control input-lg validate[{if $methods['student_phone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['student_phone2']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="student_phone3" name="student_phone3" class="form-control input-lg validate[{if $methods['student_phone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['student_phone3']}" />
</div>
<div class="clearfix"></div>

<p class="help-block">（半角数字）</p>
{if $error['student_phone1'] || $error['student_phone2'] || $error['student_phone3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_student_phone1'] || $error['no_num_student_phone2'] || $error['no_num_student_phone3']}<span class="must_view">*半角数字で入力してください</span>{/if}
{if $error['no_phonenumber']}<span class="must_view">*どちらかは入力ください</span>{/if}
{if $error['no_number_student_phone']}<span class="must_view">*電話番号の形式が不正です</span>{/if}

</div>
</div>
</div>
