
<div id="tab">
<ul class="flexnav" data-breakpoint="768">


{if $smarty.const.COMPONENT=="shopping"}
<li class="ui-user"><a href="{$self}?mode=view_cart"><i class="fa fa-shopping-cart"></i> カートを見る{if $item_in_cart}<span class="badge">{$item_in_cart}</span>{/if}</a></li>
<li class="ui-user header visible-xs-block">カテゴリ</li>
{sp_subcategories component=$smarty.const.PART}
<li class="ui-user"><a href="{$self}?subcategory_id={$subcategory['id']}"><i class="fa fa-fw fa-caret-right"></i>{$subcategory['denomination']}({$subcategory['entry_count']}){if $subcategory['state']!=1} <span class="label label-default"><i class="fa fa-exclamation-triangle"></i>{$stateOpenList[$subcategory['state']]}</span>{/if}</a></li>
{/sp_subcategories}
{/if}
<li class="header visible-xs-block"></li>
{if !$login}
<li class="ui-user"><a id="login" href="{$self}?mode=normal_login"><i class="fa fa-sign-in"></i> サインイン</a></li>
<li class="header visible-xs-block"></li>
{else}
<li class="ui-user"><a href="/app/user/?mode=show_regist" target="_blank"><i class="fa fa-user"></i> 登録情報表示</a></li>
<li class="ui-user"><a href="{$self}?mode=list_ship_address"><i class="fa fa-book"></i> アドレス帳</a></li>
<li class="ui-user"><a href="/app/user/?mode=list_app" target="_blank"><i class="fa fa-list-ul"></i> 注文の履歴</a></li>
<li class="ui-user"><a href="{$self}?signout=1{if $query}&amp;{$query}{/if}"><i class="fa fa-sign-out"></i> サインアウト</a></li>
<li class="header visible-xs-block"></li>
{/if}
<li class="ui-user"><a href="{$self}?mode=usage"><i class="fa fa-truck"></i> ご利用案内・送料等</a></li>
<li class="ui-user"><a href="{$self}?mode=low"><i class="fa fa-file-text"></i> 特定商取引法に基づく表示</a></li>

{*<li class="visible-xs-block"><a href="/home/sitemap/" title="サイトマップ"><i class="fa fa-sitemap"></i> サイトマップ</a></li>*}


{*<li class="visible-xs-block"><a href="/home/faq/" title="よくあるご質問"><i class="fa fa-question-circle"></i> よくある質問</a></li>*}

<li class="header visible-xs-block"></li>
<li class="visible-xs-block"><a href="/app/ask/"><i class="fa fa-envelope"></i> お問い合わせ</a></li>

<li class="header visible-xs-block"></li>

{include_file file="/include/tabmenu.txt"}


</ul>
</div>