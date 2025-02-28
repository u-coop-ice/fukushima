{if $smarty.const.COMPONENT=="mealcard"}
<div class="sidecolumn navi">
<dl>
<dt><i class="fa fa-fw fa-square"></i>登録一覧</dt>
{if $authority['mealcard']['show']}
<dd><a href="{$init_url}adm/mealcard/?mode=list_app"><i class="fa fa-fw fa-caret-right"></i>{$init_pagetitle}({get_component_app_count})</a></dd>
{/if}

{if $authority['mealcard']['edit']}
<dt><i class="fa fa-fw fa-square"></i>基本設定</dt>
<dd><a href="{$init_url}adm/mealcard/?mode=edit_category" ><i class="fa fa-fw fa-cogs"></i>設定編集</a></dd>
{/if}


{if $authority['mealcard']['edit']}
<dt><i class="fa fa-fw fa-square"></i>データベース</dt>
<dd><a href="{$init_url}adm/mealcard/?mode=edit_excel" ><i class="fa fa-fw fa-caret-right"></i>登録データ書き出し</a></dd>
<dd><a href="{$init_url}adm/mealcard/?mode=edit_archived" ><i class="fa fa-fw fa-caret-right"></i>登録データのアーカイブ化</a></dd>
{/if}

</dl>
</div>
{/if}
