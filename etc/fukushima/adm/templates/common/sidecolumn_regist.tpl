{if $smarty.const.COMPONENT=="regist"}
<div class="sidecolumn navi">
<dl>

{if $authority['regist']['show']}
<dt><i class="fa fa-fw fa-square"></i>ユーザー登録</dt>
<dd><a href="{$init_url}adm/regist/?mode=list_regist"><i class="fa fa-fw fa-caret-right"></i>登録ユーザー({get_regist_count})</a></dd>
<dd><a href="{$init_url}adm/regist/?mode=list_regist&dm=1"><i class="fa fa-fw fa-caret-right"></i>配信停止({get_regist_count dm=1})</a></dd>
<dd><a href="{$init_url}adm/regist/?mode=list_regist&status=9"><i class="fa fa-fw fa-caret-right"></i>退会({get_regist_count status=9})</a></dd>
{/if}



{if $authority['regist']['master']}
<dt><i class="fa fa-fw fa-square"></i>データベース</dt>
{*<dd {if $mode=="edit_excel"}class="focus"{/if}><a href="{$init_url}adm/export/?mode=edit_excel_entry" ><i class="fa fa-fw fa-caret-right"></i>汎用エントリ書き出し</a></dd>*}
<dd {if $mode=="edit_excel"}class="focus"{/if}><a href="{$init_url}adm/regist/?mode=edit_excel_regist" ><i class="fa fa-fw fa-caret-right"></i>ユーザーデータ書き出し</a></dd>
{/if}

</dl>
</div>
{/if}
