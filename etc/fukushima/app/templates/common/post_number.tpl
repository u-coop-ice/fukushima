<div id="form-group_number" class="form-group">
<label class="col-sm-3 control-label">学籍番号{if $methods['number']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">

<input type="text" id="number" name="number" maxlength="15" placeholder="（半角英数）
" class="form-control input-lg validate[{if $methods['number']['use']==2}required,{/if}maxSize[15],custom[onlyLetterNumber]]" value="{$post['number']}" />
{if $error['number']=="1"}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>