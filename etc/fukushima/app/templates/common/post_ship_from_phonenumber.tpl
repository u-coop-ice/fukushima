<div id="form-group_ship_from_phonenumber" class="form-group">
<label class="col-sm-3 control-label">発送元電話番号<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber1" name="ship_from_phonenumber1" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="5" value="{$post["ship_from_phonenumber1"]}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber2" name="ship_from_phonenumber2" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$post["ship_from_phonenumber2"]}"  />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_phonenumber3" name="ship_from_phonenumber3" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{$post["ship_from_phonenumber3"]}"  />
</div>
<div class="clearfix"></div>
{if $error['ship_from_phonenumber1'] || $error['ship_from_phonenumber2'] || $error['ship_from_phonenumber3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_ship_from_phonenumber1'] || $error['no_num_ship_from_phonenumber2'] || $error['no_num_ship_from_phonenumber3']}<span class="must_view">*半角数字で入力ください</span>{/if}
{if $error['no_number_ship_from_phonenumber']}<span class="must_view">*電話番号のフォーマットが不正です</span>{/if}
</div>
</div>