<div id="form-group_memo" class="form-group">
<label class="control-label col-sm-3">{$methods['memo']['title']}{if $methods['memo']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<textarea id="memo" name="memo" rows="8" cols="40" class="form-control input-lg{if $methods['memo']['use']==2} validate[required]{/if}">{$regist['memo']}</textarea>
{if $error['memo']}<span id="memo_must" class="must">*必須項目です</span>{/if}
</div>
</div>