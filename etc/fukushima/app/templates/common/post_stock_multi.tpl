
<div id="form-group_stock_multi" class="form-group">
<label class="col-sm-3 control-label">{$methods['stock_multi']['title']}{if $methods['stock_multi']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}
</label>

<div class="col-sm-9">

{if $no_stock_multi_key}
<span class="label label-danger">選択された項目は予定数に達したため締め切りました。</span><br />{/if}
{if $methods['stock_multi']['tag']=='select'}
<select name="stock_multi" id="stock_multi" class="form-control input-lg{if $methods['stock_multi']['use'] == 2} validate[required]{/if}">
<option value=""></option>
{foreach from=$stock_multi item=item key=key}
<option value="{$key}" {if $item['diff']<=0}disabled="disabled"{/if} {if $post["stock_multi"]==$key}selected="selected"{/if}>{if $item['diff']<=0}【締切】{/if}{$key}</option>
{/foreach}

</select>

{else if $methods['stock_multi']['tag']=='radio'}
{foreach from=$stock_multi item=item key=key}
<div class="radio">
{if $item['diff']<=0}
<span class="form-control-static">【締切】{$key}</span>
{else}
<label><input type="radio" name="stock_multi" value="{$key}" {if $post["stock_multi"]==$key}checked="checked"{/if}>{$key}</label><br />
{/if}
</div>
{/foreach}
{/if}

{if $methods['stock_multi']['note']}<p class="help-block">{$methods['stock_multi']['note']}</p>{/if}
{if $stock_multi_err}<span class="must_view">*必須項目です</span>{/if}

</div>
</div>