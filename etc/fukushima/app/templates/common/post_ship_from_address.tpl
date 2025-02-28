<div id="form-group_ship_from_address" class="form-group">
<label class="col-sm-3 control-label">発送元ご住所<span class="label label-danger">必須</span><br />
<span class="em08">アパート・マンション・建物の名前も省略しないでご記入ください</span></label>

<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_zipcodef" name="ship_from_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $post["ship_from_zipcodef"]}{$post["ship_from_zipcodef"]|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_from_zipcodes" name="ship_from_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $post["ship_from_zipcodes"]}{$post["ship_from_zipcodes"]|string_format:"%04d"}{/if}" />
{if $error['ship_from_zipcodef'] || $error['ship_from_zipcodes']}<span class="must_view">*必須項目です</span>{/if}
</div>
<select name="ship_from_pref" id="ship_from_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$post["ship_from_pref"]}
</select>
{if $error['ship_from_pref']}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_from_addressf" name="ship_from_addressf" class="form-control input-lg validate[required]" maxlength="30" value="{$post["ship_from_addressf"]}" placeholder="（○○市○○町）" />
{if $error['ship_from_addressf']}<span class="must_view">*必須項目です</span>{/if}
<input type="text" class="form-control input-lg" id="ship_from_addresss" name="ship_from_addresss" maxlength="30" value="{$post["ship_from_addresss"]}" placeholder="（番地）" />
<input type="text" class="form-control input-lg" id="ship_from_addresst" name="ship_from_addresst" maxlength="30" value="{$post["ship_from_addresst"]}" placeholder="（アパート・建物名など）" />
<span class="help-block">番地の入力漏れにご注意ください。</span>
</div>
</div>
