{if $k==1}
<h4 class="page-header">変更する項目について：4月からの情報を入力してください</h4>
{else if $k==4}
<h4 class="page-header">入力者情報</h4>
{/if}

<div class="form-group" id="form-group_extra{$k}">

<label class="col-sm-3 control-label">
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
{if $extra_err[$k]}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>