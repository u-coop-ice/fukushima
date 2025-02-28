<!-- start of header -->
<div id="global_header">
<div id="header" class="container">
<div id="header_inner" class="container">

<h1><a href="{$init_url}adm/">{$init_coopname} {$init_coopnameE}</a></h1>

</div><!-- /header-inner -->
</div><!-- /header -->

<div id="overheader">
<div id="global_tab">

<div id="tab">
<ul class="flexnav" data-breakpoint="768">
<li id="global[home]" {if $smarty.const.COMPONENT=="index.php"}class="focus"{/if}><a href="{$init_url}adm/">HOME</a></li>
{if $login}
{if $authority['ask']['show']}
<li id="global[ask]" {if $smarty.const.COMPONENT=="ask"}class="focus"{/if}><a href="{$init_url}adm/ask/">お問い合せ</a></li>
{/if}
{if $authority['entry']['show']}
<li id="global[entry]" {if $smarty.const.COMPONENT=="entry"}class="focus"{/if}><a href="{$init_url}adm/entry/">汎用エントリ</a></li>
{/if}

{if $authority['reserve']['show']}
<li id="global[reserve]" {if $smarty.const.COMPONENT=="reserve"}class="focus"{/if}><a href="{$init_url}adm/reserve/">日付エントリ</a></li>
{/if}

{if $authority['mealcard']['show']}
<li id="global[mealcard]" {if $smarty.const.COMPONENT=="mealcard"}class="focus"{/if}><a href="{$init_url}adm/mealcard/">ミールカード</a></li>
{/if}

{if $authority['living']['show']}
<li id="global[living]" {if $smarty.const.COMPONENT=="living"}class="focus"{/if}><a href="{$init_url}adm/living/">不動産</a></li>
{/if}

{if $authority['shopping']['show']}
<li id="global[shopping]" {if $smarty.const.COMPONENT=="shopping"}class="focus"{/if}><a href="{$init_url}adm/shopping/">ショッピング</a></li>
{/if}

{if $authority['htkt']['show']}
<li id="global[htkt]" {if $smarty.const.COMPONENT=="htkt"}class="focus"{/if}><a href="{$init_url}adm/htkt/">一言カード</a></li>
{/if}
{if $authority['arbeit']['show']}
<li id="global[arbeit]" {if $smarty.const.COMPONENT=="arbeit"}class="focus"{/if}><a href="{$init_url}adm/arbeit/">アルバイト</a></li>
{/if}

{if $authority['mm']['show']}
<li id="global[mm]" {if $smarty.const.COMPONENT=="mm"}class="focus"{/if}><a href="{$init_url}adm/mm/">メール配信</a></li>
{/if}
{if $authority['regist']['show']}
<li id="global[regist]" {if $smarty.const.COMPONENT=="regist"}class="focus"{/if}><a href="{$init_url}adm/regist/">ユーザー</a></li>
{/if}
{if $authority['master']['show']}
<li id="global[master]" {if $smarty.const.COMPONENT=="master"}class="focus"{/if}><a href="{$init_url}adm/master/">管理者限定</a></li>
{/if}
{/if}
</ul>
</div>
</div>
</div>

</div><!-- /headerwrapper -->