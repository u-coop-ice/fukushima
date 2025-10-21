<div id="form-group_name" class="form-group">
<label class="col-sm-3 control-label">{$methods['parent_name']['title']|default:"保護者氏名"}{if $methods['parent_name']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">

<div class="row">
<div class="col-sm-4 col-xs-6">
<input type="text" id="parent_namef" name="parent_namef" class="form-control input-lg{if $methods['parent_name']['use']==2} validate[required]{/if}" maxlength="32" value="{$post['parent_namef']}" placeholder="（姓）" />
</div>
<div class="col-sm-4 col-xs-6">
<input type="text" id="parent_nameg" name="parent_nameg" class="form-control input-lg{if $methods['parent_name']['use']==2} validate[required]{/if}" maxlength="32" value="{$post['parent_nameg']}" placeholder="（名）" />
</div>
</div>&nbsp;{if $error['parent_namef'] || $error['parent_nameg']}<span class="must_view">*必須項目です</span>{/if}
</div>
<label class="col-sm-3 control-label">{$methods['parent_name']['title']|default:"保護者氏名"}{if $methods['parent_name']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-4 col-xs-6">
<input type="text" id="parent_kanaf" name="parent_kanaf" class="form-control input-lg{if $methods['parent_name']['use']==2} validate[required,custom[onlyLetterKana]]{else} validate[custom[onlyLetterKana]]{/if}" maxlength="32" value="{$post['parent_kanaf']}" placeholder="（セイ）" />
</div>
<div class="col-sm-4 col-xs-6">
<input type="text" id="parent_kanag" name="parent_kanag" class="form-control input-lg{if $methods['parent_name']['use']==2} validate[required,custom[onlyLetterKana]]{else} validate[custom[onlyLetterKana]]{/if}" maxlength="32" value="{$post['parent_kanag']}" placeholder="（メイ）" />
</div>&nbsp;{if $error['parent_kanaf'] || $error['parent_kanag']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
</div>