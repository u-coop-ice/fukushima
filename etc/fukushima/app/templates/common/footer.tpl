</div><!-- main-inner -->
</div><!-- main -->

<div id="sub" class=" {if $smarty.const.COMPONENT=='arbeit'}full{/if}">

<div class="sidecolumn navi">

<div id="menu-inner">
{if $smarty.const.COMPONENT=="user" && $login}
<dl>
<dt>ユーザーマイページ</dt>
<dd><a href="/app/user/?mode=show_regist"><i class="fa fa-fw fa-caret-right"></i>登録情報の確認・変更</a></dd>
<dd><a href="/app/user/?mode=list_app"><i class="fa fa-fw fa-caret-right"></i>お申込み内容の確認</a></dd>
<dd><a href="/app/user/?mode=list_mail"><i class="fa fa-fw fa-caret-right"></i>{$init_coopname}との連絡{if $app_add_ct} <span class="badge">{$app_add_ct}</span>{/if}</a></dd>
<dd><a href="/about/policy/"><i class="fa fa-fw fa-caret-right"></i>サイト利用規約</a></dd>


<dd><a href="{$self}?signout=1"><i class="fa fa-fw fa-caret-right"></i>サインアウト</a></dd>
</dl>


{else if $smarty.const.COMPONENT=="htkt"}
<div class="hidden-xs">
{if $self=="index.php"}
<dl>
<dt>一言カード投稿</dt>
<dt><a class="btn btn-primary" href="{$init_url}app/{$smarty.const.COMPONENT}/contribute.php">一言カードの投稿はこちら<i class="fa fa-fw fa-chevron-right"></i></a></dt>
</dl>



<div id="cat">
<dl>
<dt>宛先</dt>
{htkt_categories all=1}
<dd class="category_{$category['id']}"><a href="{$self}?cid={$category['id']}"><span class="label label-{$category['color']}"><i class="fa fa-caret-right"></i></span> {$category['denomination']}({$category['entry_count']})</a></dd>
{/htkt_categories}

<dd><a href="{$self}"><strong>すべてを表示</strong></a></dd>
</dl>
</div>

<dl>
<dt>月別アーカイブ</dt>
{htkt_archives}
<dd><a href="{$self}?year={$archive['year']}&month={$archive['month']}">{$archive['year']}年{$archive['month']}月({$archive['entry_count']})</a></dd>
{/htkt_archives}
</dl>


{else}

<div class="widget">
<dl>
<dt>個人情報について</dt>
<dd>当生協では個人情報に関して適用される法令、規範を遵守するとともに、以下の基本方針のもとに組合員及びその関係者に関する情報の適正な管理・利用と保護に努めております。［<a target="_blank" href="{$init_coopurl}home/privacypolicy/">詳細</a>］<br /><span class="em08">別ウィンドウで開きます。</span></dd>

<dt>セキュリティについて</dt>
<dd>このサイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</dd>
</dl>
</div>
{/if}
</div>

{else if $smarty.const.COMPONENT=="shopping"}

{if $init_category["error"]}

{else if $mode!="buy_confirm"}

<div class="widget">
<dl>
<dt><a href="{$self}?mode=view_cart"><i class="fa fa-shopping-cart"></i> カートを見る{if $item_in_cart}<span class="badge">{$item_in_cart}</span>{/if}</a></dt>
</dl>
</div>


<div class="widget">
<dl>
<dt><i class="fa fa-bookmark"></i> カテゴリ</dt>
{sp_subcategories part=$smarty.const.PART}
<dd><i class="fa fa-fw fa-caret-right"></i><span><a href="{$self}?subcategory_id={$subcategory['id']}">{$subcategory['denomination']}({$subcategory['entry_count']})</a>{if $subcategory['state']!=1} <span class="label label-default"><i class="fa fa-exclamation-triangle"></i>{$stateOpenList[$subcategory['state']]}</span>{/if}</span></dd>
{/sp_subcategories}
</dl>
</div>

<div class="widget">
<dl>
{if !$login}
<dt><a id="login" href="{$self}?mode=normal_login"><i class="fa fa-sign-in"></i> サインイン（新規ユーザー登録）</a></dt>
{*<dt><a href="{$self}?mode=step1"><i class="fa fa-edit"></i> 新規登録はこちら</a></dt>*}
{*<dt><a href="/app/regist/?reffer={$smarty.const.COMPONENT}&part={$smarty.const.PART}"><i class="fa fa-edit"></i> 新規登録はこちら</a></dt>*}
{else}

<dt><a href="/app/user/?mode=show_regist" target="_blank"><i class="fa fa-user"></i> 登録情報表示</a></dt>
<dt><a href="{$self}?mode=list_ship_address"><i class="fa fa-book"></i> アドレス帳</a></dt>
<dt><a href="/app/user/?mode=list_app" target="_blank"><i class="fa fa-list-ul"></i> 注文の履歴</a></dt>
{/if}
</dl>
</div>

<div class="widget">
<dl>
<dt><i class="fa fa-info-circle"></i> ご利用に関して</dt>
<dd><i class="fa fa-fw fa-caret-right"></i><span><a href="{$self}?mode=usage">ご利用案内・送料等</a></span></dd>
<dd><i class="fa fa-fw fa-caret-right"></i><span><a href="{$self}?mode=low">特定商取引法に基づく表示</a></span></dd>
</dl>
</div>


{else}

<div class="widget">
<dl>
<dt>個人情報の取り扱いについて</dt>
<dd>{$init_coopname}では、個人情報に関して適用される法令、規範を遵守するとともに、会員生協組合員及びその関係者に関する情報の適正な管理・利用と保護に努めております。［<span rel="tips" title="別ウィンドウで開く::個人情報の取り扱いについて"><a href="{$init_coopurl}home/privacypolicy/" target="_blank">詳細</a></span>］</dd>
</dl>
</div>

<div class="widget">
<dl>
<dt>セキュリティについて</dt>
<dd>このサイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</dd>
</dl>
</div>

{/if}


{else}
<div class="widget">
<dl>
<dt>個人情報について</dt>
<dd>当生協では個人情報に関して適用される法令、規範を遵守するとともに、以下の基本方針のもとに組合員及びその関係者に関する情報の適正な管理・利用と保護に努めております。［<a target="_blank" href="{$init_coopurl}home/privacypolicy/">詳細</a>］<br /><span class="em08">別ウィンドウで開きます。</span></dd>

<dt>セキュリティについて</dt>
<dd>このサイトは、プライバシー保護のため、SSL暗号化通信を採用しています。</dd>
</dl>
</div>
{/if}
</div><!-- menu -->

</div>{*sidecolumn*}

</div>{*#sub*}

<div class="clear"></div>

</div><!-- /container -->

</div><!-- /content -->

</div><!-- /pagebody -->

<!-- start of footer -->
<div id="global_footer">


<!-- start of footer -->
<div id="footer" class="container">
<div id="footer_inner">

<!-- ページTOPへジャンプ -->

<p id="page2top">
<a href="#wrapper" title="back to top"><i class="fa fa-fw fa-chevron-up"></i></a>
</p>

<div class="footer_other">

<ul class="footer_nav">
<li><a href="/home/privacypolicy/" target="_blank" class="leftside">プライバシー・ポリシー</a></li>
{*<li><a href="/about/policy/" target="_blank">サイト利用規約</a></li>*}
<li><a href="/store/#store_ask" target="_blank" title="お問い合わせ">お問い合わせ</a></li>
<li><a href="/home/sitemap/" title="サイトマップ">サイトマップ</a></li>
</ul>
<p id="copyright">&copy; 2021- {$init_coopnameE}</p>

</div>

</div><!-- end of footer_inner -->
</div><!-- end of footer -->

</div><!-- end of gb_footer -->

</div><!-- End Of wrapper -->

</body>
</html>