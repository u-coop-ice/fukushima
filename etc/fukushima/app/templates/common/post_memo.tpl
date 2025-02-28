<div id="form-group_memo" class="form-group">
<label class="col-sm-3 control-label">{$methods['memo']['title']}{if $methods['memo']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
	<textarea id="memo" name="memo" rows="8" cols="40" class="form-control input-lg{if $methods['memo']['use']==2} validate[required]{/if}">{$post['memo']}</textarea>
{if $error['memo']=="1"}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>