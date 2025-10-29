<div id="form-group_dept" class="form-group">
<label class="col-sm-3 control-label">学類・研究科{if $methods['dept']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<select name="dept" id="dept" class="form-control input-lg{if $methods['dept']['use']==2} validate[required]{/if}" >
<option value=""></option>
{code name=23}
<option value="{$code['id']}" {if $regist['dept']==$code['id']}selected="selected"{/if}>{$code['value']}</option>
{/code}
</select>
</div>
<div class="clearfix"></div>
{if $error['dept']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>