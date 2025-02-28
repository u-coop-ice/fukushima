<div id="form-group_agree" class="form-group">
<label class="control-label col-sm-3">
{$methods['agree']['title']}
{if $methods['agree']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}
</label>
<div class="col-sm-9">

<div class="box agree"><p>{$methods['agree']['note_href']|nl2br}</p></div>

<div class="checkbox">
<label><input type="checkbox" name="agree" value="{$methods['agree']['select']}" {if $post['agree']==$methods['agree']['select']}checked="checked"{/if}  {if $methods['agree']['use']==2}class="validate[required]"{/if} />{$methods['agree']['select']}</label>
</div>
{if $error['agree']=="1"}<span class="must_view">*</span>{/if}
</div>

</div>