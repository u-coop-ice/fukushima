
<div id="form-group_mobilephone" class="form-group">
<label class="col-sm-3 control-label">{$methods['mobilephone']['title']|default:"携帯電話番号"}{if $methods['mobilephone']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="text" id="mobilephone1" name="mobilephone1" class="form-control input-lg validate[{if $methods['mobilephone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="3" value="{$post['mobilephone1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="mobilephone2" name="mobilephone2" class="form-control input-lg validate[{if $methods['mobilephone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['mobilephone2']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="mobilephone3" name="mobilephone3" class="form-control input-lg validate[{if $methods['mobilephone']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['mobilephone3']}" />
</div>
<div class="clear"></div>
<p class="help-block">（半角数字）</p>
{if $error['mobilephone1'] || $error['mobilephone2'] || $error['mobilephone3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_mobilephone1'] || $error['no_num_mobilephone2'] || $error['no_num_mobilephone3']}<span class="must_view">*半角数字で入力してください</span>{/if}
{if $error['no_number_mobilephone']}<span class="must_view">*電話番号の形式が不正です</span>{/if}

</div>
</div>