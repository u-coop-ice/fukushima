{if $smarty.const.COMPONENT=="member"}
<div class="sidecolumn navi">
{if $smarty.const.PART==""}
<dl>
<dt><i class="fa fa-square"></i> サービス</dt>
{categories all=1 component="member"}
{if $category['part']}
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/{$category['part']}/?category_id={$category['id']}"><i class="fa fa-wrench"></i> {$category['denomination']}</dd>
{/if}
{/categories}
</dl>
<div class="hr"></div>

<dl>
<dt><i class="fa fa-square"></i> 基本設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
</dl>

{else if $smarty.const.PART}

<dl>
<dt><i class="fa fa-square"></i> 登録</dt>
{categories all=1 component=$smarty.const.COMPONENT part=$smarty.const.PART}
{get_app_count category_id=$category['id']}
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/{$smarty.const.PART}/?mode=list_app&category_id={$category['id']}"><i class="fa fa-fw fa-caret-right"></i>{$category['denomination']}({$app_count})</a></dd>
{/categories}
</dl>
<dl>
<dt><i class="fa fa-fw fa-square"></i>データベース</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/{$smarty.const.PART}/?mode=edit_excel&category_id={$category['id']}" ><i class="fa fa-fw fa-file-excel-o"></i>登録データ書き出し</a></dd>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/{$smarty.const.PART}/?mode=edit_archived&category_id={$category['id']}" ><i class="fa fa-fw fa-caret-right"></i>登録データのアーカイブ化</a></dd>
</dl>
<dl>
<dt><i class="fa fa-square"></i> 設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/{$smarty.const.PART}/?mode=edit_category&category_id={$category['id']}" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
</dl>
{/if}


</div>
{/if}
