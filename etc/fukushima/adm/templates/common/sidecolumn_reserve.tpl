{if $smarty.const.COMPONENT=="reserve"}
<div class="sidecolumn navi">

<dl>
<dt><i class="fa fa-fw fa-square"></i>カテゴリ設定</dt>

<dd><a href="{$init_url}adm/reserve/?mode=list_category"><i class="fa fa-list"></i> カテゴリ一覧</a></dd>
<dd><a href="{$init_url}adm/reserve/?mode=edit_category"><i class="fa fa-plus"></i> 新規追加</a></dd>


<dt>データベースの操作</dt>
<dd><a href="{$init_url}adm/reserve/?mode=edit_excel" ><i class="fa fa-file"></i>  データ書き出し</a></dd>

</dl>
<p>
<a class="btn btn-primary btn-sm" target="_blank" href="https://www.icloud.com/keynote/0O_r64-7XcfwIx0vG4hBhlJaA">
<i class="fa fa-cloud"></i> 日付け選択エントリマニュアル <i class="fa fa-external-link"></i></a>
</p>
</div>
{/if}
