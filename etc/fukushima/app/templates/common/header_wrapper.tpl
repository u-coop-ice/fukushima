<!-- start of header -->

<div id="global_header">
<div id="header" class="container">
<div id="header_inner" class="container">

<h1><a href="{$init_coopurl}"{if $confirmList[$mode]} onclick="return confirm('入力はキャンセルされます。よろしいですか？')"{/if}>{$init_coopname} {$init_coopnameE}</a></h1>

<div id="status_header">
<ul class="status">
<li class="navy"><a href="https://newlife.u-coop.or.jp/fukushima/" target="_blank">受験生・新入生はこちら</a></li>

{if $login}
<p class="welcome_username"><a href="/app/user/"><i class="fa fa-fw fa-user"></i>{$regist['username']}</a></p>
{/if}

{if !$login}
{*<li class="navy"><a id="login" href="{if $smarty.const.COMPONENT=='shopping'}{$self}?mode=normal_login{else}/app/user/{/if}"><i class="fa fa-sign-in"></i> サインイン（新規登録）</a></li>*}
{else}
<li class="navy"><a href="/app/user/" title="登録情報の確認・編集やお申込み内容の確認はこちらから"><i class="fa fa-fw fa-bars"></i>ユーザーページ</a></li>
{/if}

<li><a href="/store/#store_ask" title="お問い合わせ">お問い合わせ</a></li>
{if $login}
<li><a href="/app/user/?mode=list_mail" title="生協からのメッセージ">メッセージ{if $app_add_ct}<span class="cart_content">{$app_add_ct}</span>{/if}
</a></li>
{/if}
{*<li><a href="/home/sitemap/" title="サイトマップ"><i class="fa fa-fw fa-sitemap"></i>サイトマップ</a></li>*}

{if $item_in_cart}
<li><a href="{$self}?mode=view_cart"><i class="fa fa-shopping-cart"></i> カート<span class="cart_content">{$item_in_cart}</span></a></li>
{/if}


</ul>

</div><!-- #status_header -->



<div class="clear"></div>

</div><!-- /header-inner -->

<div class="menu-button">
<span class="icon"><i class="fa fa-bars"></i></span>
menu</div>
</div><!-- /header -->

<div id="overheader">
<div id="global_tab">
{include file="tabmenu.tpl"}
</div>
</div>
</div><!-- /global_header -->
