{if $smarty.const.COMPONENT=="htkt"}
<div class="sidecolumn navi">
<dl>

<dt><i class="fa fa-fw fa-square"></i>投稿一覧</dt>
{if $authority['htkt']['show']}
{htkt_categories all=1}
<dd><span class="label label-{$category['color']}"><i class="fa fa-caret-right"></i></span> <a href="{$init_url}adm/htkt/?mode=list_entry&category_id={$category['id']}">{$category['denomination']}({$category['entry_count']})</a></dd>
{/htkt_categories}
<dd><a href="{$init_url}adm/htkt/?mode=list_entry"><i class="fa fa-fw fa-caret-right"></i>すべて</a></dd>
{/if}
{if $authority['htkt']['edit']}
<dd><a href="{$init_url}adm/htkt/?mode=edit_entry&new=1" ><i class="fa fa-fw fa-edit"></i>投稿の新規作成</a></dd>
{/if}

{if $authority['htkt']['edit']}
<dt><i class="fa fa-fw fa-square"></i>カテゴリ</dt>
<dd><a href="{$init_url}adm/htkt/?mode=edit_category" ><i class="fa fa-fw fa-edit"></i>カテゴリの新規作成</a></dd>
<dd><a href="{$init_url}adm/htkt/?mode=list_category" ><i class="fa fa-fw fa-list"></i>カテゴリの一覧</a></dd>
{/if}

{if $authority['htkt']['master']}
<div class="hr"></div>

<dt>基本設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
{/if}

</dl>
</div>
{/if}
