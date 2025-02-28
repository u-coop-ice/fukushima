<div id="form-group_phonenumber" class="form-group">
<label class="col-sm-3 control-label">{$methods['phonenumber']['title']|default:"実家（帰省先）電話番号"}{if $methods['phonenumber']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="phonenumber1" name="phonenumber1" class="form-control input-lg validate[{if $methods['phonenumber']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="5" value="{$post['phonenumber1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="phonenumber2" name="phonenumber2" class="form-control input-lg validate[{if $methods['phonenumber']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['phonenumber2']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="phonenumber3" name="phonenumber3" class="form-control input-lg validate[{if $methods['phonenumber']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['phonenumber3']}" />
</div>
<div class="clearfix"></div>

<p class="help-block">（半角数字）</p>
{if $error['phonenumber1'] || $error['phonenumber2'] || $error['phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_phonenumber1'] || $error['no_num_phonenumber2'] || $error['no_num_phonenumber3']}<span class="must_view">*半角数字で入力してください</span>{/if}
{if $error['no_number_phonenumber']}<span class="must_view">*電話番号の形式が不正です</span>{/if}

</div>
</div>