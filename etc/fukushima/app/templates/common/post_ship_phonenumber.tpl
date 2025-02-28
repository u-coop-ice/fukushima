<div id="form-group_ship_phonenumber" class="form-group">
<label class="col-sm-3 control-label">電話番号（携帯可）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_phonenumber1" name="ship_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$post["ship_phonenumber1"]}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left"><input type="tel" id="ship_phonenumber2" name="ship_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$post["ship_phonenumber2"]}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left"><input type="tel" id="ship_phonenumber3" name="ship_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$post["ship_phonenumber3"]}"  />
</div>
<div class="clearfix"></div>
<br />
{if $error['ship_phonenumber1'] || $error['ship_phonenumber2'] || $error['ship_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_phonenumber1'] || $error['no_num_ship_phonenumber2'] || $error['no_num_ship_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
</div>
</div>