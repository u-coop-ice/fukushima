{if $smarty.const.COMPONENT=="reserve"}
<div class="sidecolumn navi">

{*<dl>
<dt><i class="fa fa-fw fa-square"></i>登録一覧</dt>
{if $authority['reserve']['show']}
{categories all=1 component="reserve"}
{get_app_count category_id=$category['id']}
<dd><a href="{$init_url}adm/reserve/?mode=show_calendar&category_id={$category['id']}"><i class="fa fa-fw fa-caret-right"></i>{$category['denomination']}({$app_count})</a></dd>
{/categories}
{/if*}


<dl>
<dt><i class="fa fa-fw fa-square"></i>カテゴリ設定</dt>
{categories all=1 component="reserve"}
<dd><i class="fa fa-fw fa-caret-right"></i><span class="em10 bold deepblue">{$category['denomination']}</span></dd>
<dl class="pad_l2">
<dd><a href="{$init_url}adm/reserve/?mode=edit_calendar&category_id={$category['id']}" ><i class="fa fa-calendar"></i> 開設日</a></dd>
<dd><a href="{$init_url}adm/reserve/?mode=edit_category&category_id={$category['id']}" ><i class="fa fa-edit"></i> 項目・時限等設定</a></dd>
</dl>
{/categories}

<p><dd><a href="{$init_url}adm/reserve/?mode=edit_category"><i class="fa fa-plus"></i> 新規追加</a></dd></p>


<dt>データベースの操作</dt>
<dd><a href="{$init_url}adm/reserve/?mode=edit_excel" ><i class="fa fa-file"></i>  データ書き出し</a></dd>

</dl>
<p>
<a class="btn btn-primary btn-sm" target="_blank" href="https://www.icloud.com/keynote/0O_r64-7XcfwIx0vG4hBhlJaA">
<i class="fa fa-cloud"></i> 日付け選択エントリマニュアル <i class="fa fa-external-link"></i></a>
</p>
</div>
{/if}
