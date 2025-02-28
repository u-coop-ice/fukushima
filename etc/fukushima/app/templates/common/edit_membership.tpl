<div id="form-group_membership" class="form-group">
<label class="col-sm-3 control-label">組合員番号{if $methods['membership']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="tel" id="membership1" maxlength="4" name="membership1" placeholder="半角4桁
" class="num form-control input-lg validate[{if $methods['membership']['use']==2}required,{/if}minSize[4],custom[onlyNumberSp]]" value="{$regist['membership1']}"/>
</div>

<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left"><input type="tel" id="membership2" name="membership2" maxlength="4" placeholder="半角4桁
" class="num form-control input-lg validate[{if $methods['membership']['use']==2}required,{/if}minSize[4],custom[onlyNumberSp]]" value="{$regist['membership2']}" /></div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left"><input type="tel" id="membership3" name="membership3" maxlength="4" placeholder="半角4桁
" class="num form-control input-lg validate[{if $methods['membership']['use']==2}required,{/if}minSize[4],custom[onlyNumberSp]]" value="{$regist['membership3']}" /></div>
<div class="clear"></div>
{if $error['membership']=="1"}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>