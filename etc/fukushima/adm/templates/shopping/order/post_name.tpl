<div id="form-group_name" class="form-group">
<label class="col-sm-3 control-label">{$methods['name']['title']|default:"氏名"}（漢字）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-4 col-xs-6"><input type="text" id="namef" name="namef" class="form-control input-lg validate[required]" maxlength="32" value="{$post['namef']}" placeholder="姓（漢字）" />
</div>
<div class="col-sm-4 col-xs-6"><input type="text" id="nameg" name="nameg" class="form-control input-lg validate[required]" maxlength="32" value="{$post['nameg']}" placeholder="名（漢字）" />
</div>
</div>
{if $namef_err || $nameg_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">{$methods['name']['title']|default:"氏名"}（カナ）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-4 col-xs-6"><input type="text" id="kanaf" name="kanaf" class="form-control input-lg validate[required,custom[onlyLetterKana]]" maxlength="32" value="{$post['kanaf']}" placeholder="姓（カナ）" /></div>
<div class="col-sm-4 col-xs-6"><input type="text" id="kanag" name="kanag" class="form-control input-lg validate[required,custom[onlyLetterKana]]" maxlength="32" value="{$post['kanag']}" placeholder="名（カナ）" /></div>
</div>&nbsp;{if $kanaf_err || $kanag_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>