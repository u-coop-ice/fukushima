<div id="form-group_address" class="form-group">
<label class="col-sm-3 control-label">{$methods['address']['title']|default:"実家（帰省先）住所"}{if $methods['address']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}<br />
<span class="em08">マンション・建物の名前も省略しないでご記入ください</span></label>

<div id="add">

<div class="col-sm-9">
<div class="pull-left"><p class="form-control-static">〒</p></div>
<div class="pull-left">
<input type="tel" id="zipcodef" name="zipcodef" class="form-control input-lg validate[{if $methods['address']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="3" value="{if $regist['zipcodef']}{$regist['zipcodef']|string_format:"%03d"}{/if}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="tel" id="zipcodes" name="zipcodes" class="form-control input-lg validate[{if $methods['address']['use']==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{if $regist['zipcodes']}{$regist['zipcodes']|string_format:"%04d"}{/if}" />
</div>
{if $error['zipcodef'] || $error['zipcodes']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_zipcodef'] || $error['no_num_zipcodes']}<span class="must_view">*半角数字で入力してください</span>{/if}
<div class="clearfix" style="margin-bottom: 0.5em;"></div>

<div class="row">
<div class="col-xs-6 col-sm-4">

<select name="pref" id="pref" class="form-control input-lg{if $methods['address']['use']==2} validate[required]{/if}">
{html_options values=$prefList output=$prefList selected=$regist['pref']}
</select>
{if $error['pref']}<span class="must_view">*必須項目です</span>{/if}
<div class="clearfix" style="margin-bottom: 0.5em;"></div>
</div>
</div>

<input type="text" id="addressf" name="addressf" class="form-control input-lg validate[{if $methods['address']['use']==2}required,{/if}maxSize[25]]" maxlength="25" value="{$regist['addressf']}" placeholder="○○市○○町" />
{if $error['addressf']}<span class="must_view">*必須項目です</span>{/if}
<div class="clearfix" style="margin-bottom: 0.5em;"></div>
<input type="text" id="addresss" name="addresss" class="form-control input-lg validate[maxSize[25]]" maxlength="25" value="{$regist['addresss']}"  placeholder="番地など"/>
<div class="clearfix" style="margin-bottom: 0.5em;"></div>
<input type="text" id="addresst" name="addresst" class="form-control input-lg validate[maxSize[25]]" maxlength="25" value="{$regist['addresst']}"  placeholder="アパート・建物名・部屋番号など"/>
</div>
</div>
</div>