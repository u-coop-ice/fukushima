{if $smarty.const.COMPONENT=="master"}
{if $authority['master'][0]}
<div class="sidecolumn navi">
<dl>

<dt><i class="fa fa-fw fa-square"></i>システム管理</dt>
<dd><a href="{$init_url}adm/master/?mode=list_user"><i class="fa fa-fw fa-caret-right"></i>システムユーザー管理</a></dd>
<dd><a href="{$init_url}adm/master/?mode=edit_site_setting"><i class="fa fa-fw fa-caret-right"></i>初期設定の確認</a></dd>

<dd><a href="{$init_url}adm/master/?mode=list_code"><i class="fa fa-fw fa-caret-right"></i>所属コード管理</a></dd>

{if $authority['master']['delete']}
<dd><i class="fa fa-fw fa-caret-right"></i>登録データの一括削除<span class="tag micro gray">準備中</span></dd>
{/if}
{/if}

<dt><i class="fa fa-fw fa-square"></i>ログ閲覧</dt>


{if $authority['master'][0]}
<dd><a href="{$init_url}adm/master/?mode=list_regist_log"><i class="fa fa-fw fa-caret-right"></i>ユーザーログ</a></dd>
{/if}
{if $authority['master'][0]==9}
<dd><a href="{$init_url}adm/master/?mode=list_admin_log"><i class="fa fa-fw fa-caret-right"></i>システムログ</a></dd>
{/if}

</dl>
</div>
{/if}
