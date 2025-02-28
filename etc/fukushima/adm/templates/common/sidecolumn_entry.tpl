{if $smarty.const.COMPONENT=="entry"}

<div class="sidecolumn navi">
<dl>
{*<dt><i class="fa fa-fw fa-square"></i>登録一覧</dt>
{if $authority['entry']['show']}
{categories all=1 component="entry"}
{get_app_count category_id=$category['id']}
<dd><a href="{$init_url}adm/entry/?mode=list_app&category_id={$category['id']}"><i class="fa fa-fw fa-caret-right"></i>{$category['denomination']}({get_component_app_count category_id=$category['id']})</a></dd>
{/categories}
{/if*}

{if $authority['entry']['edit']}
<dt><i class="fa fa-fw fa-square"></i>カテゴリ</dt>
<dd {if $mode=="edit_category"}class="focus"{/if}><a href="{$init_url}adm/entry/?mode=edit_category" ><i class="fa fa-fw fa-edit"></i>カテゴリの新規作成</a></dd>
<dd {if $mode=="list_category"}class="focus"{/if}><a href="{$init_url}adm/entry/?mode=list_category" ><i class="fa fa-fw fa-list"></i>カテゴリの一覧</a></dd>
{/if}


{if $authority['entry']['master']}
<dt><i class="fa fa-fw fa-square"></i>データベース</dt>
<dd {if $mode=="edit_excel"}class="focus"{/if}><a href="{$init_url}adm/entry/?mode=edit_excel" ><i class="fa fa-fw fa-caret-right"></i>登録データ書き出し</a></dd>
<dd><a href="{$init_url}adm/entry/?mode=edit_archived" ><i class="fa fa-fw fa-caret-right"></i>登録データのアーカイブ化</a></dd>
{/if}


<div>
<a class="btn btn-primary btn-sm" rel="external" href="https://www.icloud.com/keynote/0unFPGUXU6UvINCzrui8Z6qKA">
<i class="fa fa-cloud"></i> 汎用エントリシステムマニュアル <i class="fa fa-external-link"></i></a>
</div>
</dl>
</div>
{/if}