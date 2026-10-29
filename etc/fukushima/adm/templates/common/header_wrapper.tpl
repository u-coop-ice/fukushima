<!-- start of header -->
<div id="global_header">
<div id="header" class="container">
<div id="header_inner" class="container">

<h1><a href="{$init_url}adm/">{$init_coopname} {$init_coopnameE}</a></h1>


{if $login}<div id="username"><span style="font-size: 0.75rem;">管理アカウントのパスワード変更・2段階認証のリセットはこちら<br /></span><a href="{$init_url}adm/?mode=edit_myself" title="管理ユーザーのパスワード変更・2段階認証のリセット"><i class="fa fa-user"></i> {$auth_username}</a></div>{/if}


</div><!-- /header-inner -->
</div><!-- /header -->

<div id="overheader">
<div id="global_tab">

<div id="tab">
<ul class="flexnav" data-breakpoint="768">
<li id="global[home]" {if $smarty.const.COMPONENT=="index.php"}class="focus"{/if}><a href="{$init_url}adm/">HOME</a></li>
{if $login}
{if $authority['ask'][0]}
<li id="global[ask]" {if $smarty.const.COMPONENT=="ask"}class="focus"{/if}><a href="{$init_url}adm/ask/">お問い合せ</a></li>
{/if}
{if $authority['entry'][0]}
<li id="global[entry]" {if $smarty.const.COMPONENT=="entry"}class="focus"{/if}><a href="{$init_url}adm/entry/">汎用エントリ</a></li>
{/if}

{if $authority['reserve'][0]}
<li id="global[reserve]" {if $smarty.const.COMPONENT=="reserve"}class="focus"{/if}><a href="{$init_url}adm/reserve/">日付エントリ</a></li>
{/if}

{if $authority['member'][0]}
<li id="global[member]" {if $smarty.const.COMPONENT=="member"}class="focus"{/if}><a href="{$init_url}adm/member/">組合員</a></li>
{/if}


{if $authority['living'][0]}
<li id="global[living]" {if $smarty.const.COMPONENT=="living"}class="focus"{/if}><a href="{$init_url}adm/living/">不動産</a></li>
{/if}

{if $authority['shopping'][0]}
<li id="global[shopping]" {if $smarty.const.COMPONENT=="shopping"}class="focus"{/if}><a href="{$init_url}adm/shopping/">ショッピング</a></li>
{/if}

{if $authority['mm'][0]}
<li id="global[mm]" {if $smarty.const.COMPONENT=="mm"}class="focus"{/if}><a href="{$init_url}adm/mm/">メール配信</a></li>
{/if}
{if $authority['regist'][0]}
<li id="global[regist]" {if $smarty.const.COMPONENT=="regist"}class="focus"{/if}><a href="{$init_url}adm/regist/">ユーザー</a></li>
{/if}
{if $authority['master'][0]}
<li id="global[master]" {if $smarty.const.COMPONENT=="master"}class="focus"{/if}><a href="{$init_url}adm/master/">管理者限定</a></li>
{/if}
{/if}
</ul>
</div>
</div>
</div>

</div><!-- /headerwrapper -->