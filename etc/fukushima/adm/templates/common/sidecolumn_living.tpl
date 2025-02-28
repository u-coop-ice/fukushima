{if $smarty.const.COMPONENT=="living"}
<div class="sidecolumn navi">
{if $smarty.const.PART==""}
<dl>
<dt><i class="fa fa-square"></i> サービス</dt>
<dd><i class="fa fa-caret-right"></i> 今のところ設定なし</dd>

<dt><i class="fa fa-square"></i> お問い合わせ</dt>
{get_add_count add="living"}

<dd><i class="fa fa-caret-right"></i> <a href="{$init_url}adm/ask/?mode=list_mail&amp;add=living" >お問い合わせ(不動産)({$add_counts['all']})</a></dd>
</dl>
<div class="hr"></div>

<dl>
<dt><i class="fa fa-square"></i> 基本設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
</dl>
{/if}

</div>
{/if}
