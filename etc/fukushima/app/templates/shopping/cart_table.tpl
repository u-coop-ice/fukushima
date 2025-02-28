{* 商品一覧 開始 *}
{items cart=1}
{if $item_header}
<h3 class="header">ご注文内容</h3>

{if $now_mode =='view_cart'}
{if $cart_msg}
<p class="alert alert-info">{$cart_msg}</p>
{/if}

{if count($stock_errors)}
<p class="alert alert-danger">
{foreach from=$stock_errors item=stock_error}
申し訳ございません。{$stock_error['name']}の在庫が『{$stock_error['short']}』不足しています。商品の選択または個数を見直してください。
{/foreach}
</p>
{/if}

{/if}

<table class="inputForm free">
<tr>
<th class="mh nowrap">番号</th>
<th colspan="2" class="mh">商品</th>
</tr>
{/if}

{if $now_mode =='buy_confirm'}
<tr>
<td>{$ctr}</td>
<td class="no-right-border vtop">
{get_item_info id=$item['id']}
<div class="itemimg">
{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}
{image_display_gcs calc_width="80" file_image=$itm['image'] image_dir=$image_dir}
<img class="itemImg" src="{$image_src}" {if $image_srcset}srcset="{$image_srcset}"{/if} {$image_attr} alt="{$itm['name']}" title="{$itm['name']}" />

{if $itm["cart"]|@count}
{foreach from=$itm["cart"] key=k item=v}
{if $v["use"]}
<div>{$v["title"]}: {$item["cart{$k}"]}</div>
{/if}
{/foreach}
{/if}


<p>{$item['total_price']|number_format}円</p>
</td>
<td class="no-left-border vtop">【{$itm['no']}】{$itm['name']}
<p class="right">数量：{$item['num']}</p>
</td>
</tr>

{else}

<tr>
<td>{$ctr}</td>
<td class="no-right-border vtop">
{get_item_info id=$item['id']}
{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}
{image_display_gcs calc_width="80" file_image=$itm['image'] image_dir=$image_dir}
<a href="{$self}?id={$itm['id']}">

<img class="itemImg" src="{$image_src}" {if $image_srcset}srcset="{$image_srcset}"{/if} {$image_attr} alt="{$itm['name']}" title="{$itm['name']}" />

</a>

{if $itm["cart"]|@count}
{foreach from=$itm["cart"] key=k item=v}
{if $v["use"]}
<div>{$v["title"]}: {$item["cart{$k}"]}</div>
{/if}
{/foreach}
{/if}

<p>{$itm['price']|number_format}円</p>
</td>
<td class="vtop">
<a href="{$self}?id={$itm['id']}">【{$itm['no']}】{$itm['name']}</a>
{if $stock_errors[$index]}<p><span class="tag red">在庫が足りません。カートから商品を削除{if $item['num']>1}または個数を変更{/if}ください。</span></p>{/if}

<form method="post" action="{$self}?mode=change_num&amp;now_mode={$now_mode}" class="form-inline">
<input type="tel" name="num" value="{$item['num']}" size="5" maxlength="3" class="number form-control validate[required,custom[number]]" />
<input type="hidden" name="index" value="{$index}" />
<button type="submit" name="change" class="btn btn-primary btn-sm" value="1"><i class="fa fa-fw fa-refresh"></i>個数を変更</button>
</form>
<form method="post" action="{$self}?mode=delete_cart_item&amp;now_mode={$now_mode}">
<input type="hidden" name="index" value="{$index}" />
<button type="submit" name="delete" class="btn btn-primary btn-sm" value="1"><i class="fa fa-fw fa-times"></i>この商品を削除</button>
</form>
</td>
</tr>
{/if}


{if $itm['flag_drink']}{assign var="flag_drink" value="1"}{/if}

{if $item_footer}

{if $reduction}
<tr>
<th colspan="2">値引き</th>
<td class="right">-{$reduction|number_format}円</td>
</tr>
{/if}


{if $postage}
<tr>
<th colspan="2">送料</th>
<td class="right">{$postage|number_format}円</td>
</tr>
{/if}

<tr>
<th colspan="2">合計</th>
<td class="right prc">{$total_price_all|number_format}円</td>
</tr>
</table>
{/if}
{/items}


{if $no_item}
<p class="alert alert-info">カートには商品が入っていません</p>
<p><a class="btn btn-primary" href="{$self}">お買い物を続ける<i class="fa fa-fw fa-chevron-right"></i></a></p>

{else if $now_mode == 'view_cart'}
<div style="float: right;">
<p><a class="btn btn-primary" href="{$self}">お買い物を続ける<i class="fa fa-fw fa-chevron-right"></i></a></p>
<p><a class="btn btn-primary" href="{$self}?mode=clear_cart"><i class="fa fa-fw fa-times"></i>カートの商品をすべて削除する</a></p>
</div>
<div class="clear"></div>

<div class="contact">ご注文前に、<a  class="btn btn-primary btn-sm" href="{$self}?mode=usage" target="_blank">ご利用案内（お届け予定・配送料金）<i class="fa fa-external-link"></i></a> をご確認ください。

{*if !$login}<br /><span class="marker yellow thin">ご注文にはサインイン（ユーザー登録）が必須になりました。ユーザー登録がお済みでない方も「レジに進む」よりユーザー登録へお進みください。</span>{/if*}
</div>



<div class="box">

<div class="row">
<div class="col-sm-8 col-sm-offset-2">

<form method="post" action="{$self}?mode=buy_confirm&amp;no_user=0">
<p><button {if !$login}id="login"{/if} class="btn btn-success btn-block" type="submit" name="step1" value="1">レジに進む{if !$login}
（サインイン）{/if}<i class="fa fa-fw fa-chevron-right"></i></button></p>
</form>

{if !$login}
<p><a class="btn btn-primary btn-sm" href="{$self}?mode=buy_confirm&no_user=1">ユーザー登録せずにレジに進む</a></p>
{/if}

</div>

</div>
</div>


<p class="alert alert-danger"><strong class="em12"><i class="fa fa-warning"></i> タブや別ウィンドウを開いて複数のご注文を同時並行で行わないで下さい。</strong>ご注文はお送り先1件ごとに入力し、ご注文を確定させてから次のご注文を行ってください。カートの中身およびお送り先が混合される恐れがございます。</p>

{*include file="note.tpl"*}


{/if}


