<h4 class="page-header">組合員（学生本人）情報：3月までの情報を入力してください</h4>

<div id="form-group_name" class="form-group">
<label class="col-sm-3 control-label">{$methods['name']['title']|default:"氏名"}（漢字）<span class="label label-danger">必須</span></label>

<div class="col-sm-9">
{if (!$regist['namef'] && !$regist['nameg']) ||  $smarty.get.mode=='edit_regist' || $smarty.get.mode=='save_regist'}
<div class="row">
<div class="col-xs-6 col-sm-4">
<input type="text" id="namef" name="namef" class="validate[required] form-control input-lg" maxlength="32" value="{$regist['namef']}" placeholder="姓（漢字）" />
</div>
<div class="col-xs-6 col-sm-4">
<input type="text" id="nameg" name="nameg" class="validate[required] form-control input-lg" maxlength="32" value="{$regist['nameg']}" placeholder="名（漢字）" />
</div>
</div>
{if $error['namef'] || $error['nameg']}<span class="must_view">*必須項目です</span>{/if}

{else}
<p class="form-control-static">{$regist['namef']} {$regist['nameg']} 様</p>
<input type="hidden" name="namef" value="{$regist['namef']}" />
<input type="hidden"  name="nameg" value="{$regist['nameg']}" />
{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">{$methods['name']['title']|default:"氏名"}（カナ）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-xs-6 col-sm-4">
<input type="text" id="kanaf" name="kanaf" class="validate[required,custom[onlyLetterKana]] form-control input-lg" maxlength="32" value="{$regist['kanaf']}" placeholder="姓（カナ）" />
</div>
<div class="col-xs-6 col-sm-4">
<input type="text" id="kanag" name="kanag" class="validate[required,custom[onlyLetterKana]] form-control input-lg" maxlength="32" value="{$regist['kanag']}" placeholder="名（カナ）" />
</div>
{if $error['kanaf'] || $error['kanag']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
</div>