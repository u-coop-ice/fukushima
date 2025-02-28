{if $smarty.const.COMPONENT=="transition"}

<div class="sidecolumn navi">
<dl>

<dt><i class="fa fa-fw fa-square"></i>登録一覧</dt>
{if $authority['transition']['show']}
<dd><a href="{$init_url}adm/transition/?mode=list_app"><i class="fa fa-fw fa-caret-right"></i>{$init_pagetitle}({get_component_app_count})</a></dd>
{/if}

{if $authority['transition']['edit']}
<dt><i class="fa fa-fw fa-square"></i>基本設定</dt>
<dd><a href="{$init_url}adm/transition/?mode=edit_init" ><i class="fa fa-fw fa-cogs"></i>設定編集</a></dd>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 初期設定</a></dd>
{/if}


{if $authority['transition']['edit']}
<dt><i class="fa fa-fw fa-square"></i>データベース</dt>
<dd><a href="{$init_url}adm/transition/?mode=edit_excel" ><i class="fa fa-fw fa-caret-right"></i>登録データ書き出し</a></dd>
{/if}
</dl>
</div>
{/if}