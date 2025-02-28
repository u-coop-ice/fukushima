<div id="form-group_ship_address" class="form-group">
<label class="col-sm-3 control-label">{$methods['ship_address']['title']|default:"住所"}{if $methods['ship_address']['use']==2}<span class="label label-danger">必須</span>{/if}<br />
<span class="em08">アパート・マンション・建物の名前も省略しないでご記入ください</span></label>
<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="tel" id="ship_zipcodef" name="ship_zipcodef" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="3" value="{if $post["ship_zipcodef"]}{$post["ship_zipcodef"]|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="ship_zipcodes" name="ship_zipcodes" class="form-control input-lg validate[required,custom[onlyNumberSp]]" maxlength="4" value="{if $post["ship_zipcodes"]}{$post["ship_zipcodes"]|string_format:"%04d"}{/if}" />
{if $error['ship_zipcodef'] || $error['ship_zipcodes']}<span class="must_view">*必須項目です</span>{/if}
</div>
<div class="clearfix"></div>
<select name="ship_pref" id="ship_pref" class="form-control input-lg validate[required]">
{html_options output=$prefList values=$prefList selected=$post["ship_pref"]}
</select>
{if $error['ship_pref']}<span class="must_view">*必須項目です</span>{/if}
<input type="text" id="ship_addressf" name="ship_addressf" class="form-control input-lg validate[required]" maxlength="30" value="{$post["ship_addressf"]}" placeholder="（○○市○○町）" />
{if $error['ship_addressf']}<span class="must_view">*必須項目です</span>{/if}
<input type="text" class="form-control input-lg" id="ship_addresss" name="ship_addresss" maxlength="30" value="{$post["ship_addresss"]}" placeholder="（番地）" />
<input type="text" class="form-control input-lg" id="ship_addresst" name="ship_addresst" maxlength="30" value="{$post["ship_addresst"]}" placeholder="（アパート・建物名など）" />
<span class="help-block">番地の入力漏れにご注意ください。</span>

</div>
</div>
