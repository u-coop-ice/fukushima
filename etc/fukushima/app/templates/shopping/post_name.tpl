<div class="form-group">
<label class="col-sm-3 control-label">ご注文者氏名<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
{if ($login && !$post['namef'] && !$post['nameg']) || $mode=='edit_regist' || !$login}

<div class="row">
<div class="col-sm-4 col-xs-6"><input type="text" id="namef" name="namef" class="form-control input-lg validate[required]" maxlength="32" value="{$post['namef']}" placeholder="（姓）" />
</div>
<div class="col-sm-4 col-xs-6"><input type="text" id="nameg" name="nameg" class="form-control input-lg validate[required]" maxlength="32" value="{$post['nameg']}" placeholder="（名）" />
</div>
</div>
{if $namef_err || $nameg_err}<span class="must_view">*必須項目です</span>{/if}
{else}
<p class="form-control-static">{$post['namef']} {$post['nameg']}</p>
<input type="hidden" name="namef" value="{$post['namef']}" /> <input type="hidden"  name="nameg" value="{$post['nameg']}" />{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">ご注文者フリガナ<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-4 col-xs-6"><input type="text" id="kanaf" name="kanaf" class="form-control input-lg validate[required,custom[onlyLetterKana]]" maxlength="32" value="{$post['kanaf']}" placeholder="（セイ）" /></div>
<div class="col-sm-4 col-xs-6"><input type="text" id="kanag" name="kanag" class="form-control input-lg validate[required,custom[onlyLetterKana]]" maxlength="32" value="{$post['kanag']}" placeholder="（メイ）" /></div>
</div>
&nbsp;{if $kanaf_err || $kanag_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>