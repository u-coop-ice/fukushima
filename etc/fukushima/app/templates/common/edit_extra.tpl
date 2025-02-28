
<div class="form-group" id="form-group_extra{$k}">
<label class="control-label col-sm-3">
{$methods['extra'][$k]['title']}{if $methods['extra'][$k]['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}
</label>
<div class="col-sm-9">

{if $methods['extra'][$k]['tag']=='select'}
<div>
<select name="extra[{$k}]" id="extra[{$k}]" class="form-control input-lg{if $methods['extra'][$k]['use'] == 2} validate[required]{/if}">
<option value=""></option>
{html_options values=$extraList output=$extraList selected=$post['extra'][$k]}
</select>
</div>
{else if $methods['extra'][$k]['tag']=='checkbox'}
<div class="checkbox">
{if $methods['extra'][$k]['use'] == 2}
{html_checkboxes name="extra[{$k}]" id="extra[{$k}]" class="validate[required]" values=$extraList output=$extraList selected=$post['extra'][$k] assign=tags}
{else}
{html_checkboxes name="extra[{$k}]" id="extra[{$k}]" values=$extraList output=$extraList selected=$post['extra'][$k] assign=tags}
{/if}
{section name=buttons loop=$tags}
<div class="ui-corner-all">{$tags[buttons]}</div>
{/section}
</div>

{else if $methods['extra'][$k]['tag']=='radio'}
<div class="radio">
{if $methods['extra'][$k]['use'] == 2}
{html_radios name="extra[{$k}]" id="extra[{$k}]" class="validate[required]" values=$extraList output=$extraList selected=$post['extra'][$k] assign=tags}
{else}
{html_radios name="extra[{$k}]" id="extra[{$k}]" values=$extraList output=$extraList selected=$post['extra'][$k] assign=tags}
{/if}
{section name=buttons loop=$tags}
<div class="ui-corner-all">{$tags[buttons]}</div>
{/section}
</div>

{else if ($methods['extra'][$k]['tag']=='text')}
<input type="text" name="extra[{$k}]" id="extra[{$k}]" class="form-control input-lg{if $methods['extra'][$k]['use'] == 2} validate[required]{/if}" value="{$post['extra'][$k]}" placeholder="" />

{else if ($methods['extra'][$k]['tag']=='textarea')}
<textarea name="extra[{$k}]" id="extra[{$k}]" placeholder="" class="form-control input-lg{if $methods['extra'][$k]['use'] == 2} validate[required]{/if}">
{$post['extra'][$k]}</textarea>

{/if}
{if $methods['extra'][$k]['note']}<p class="help-block">{$methods['extra'][$k]['note']}</p>{/if}
{if $error['extra'][$k]}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>