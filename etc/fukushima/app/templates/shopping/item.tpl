{* ヘッダー部分の組み込み *}


{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript">
$(function(){
$("#formCart").validationEngine({
	promptPosition: "inline"
});
});
</script>
{/literal}
{/capture}

{assign var="layout_class" value="two-column"}
{include file='header.tpl'}


{* 商品情報 開始 *}
{items}
{if $smarty.const.PART == $item['category_part']}

<div class="itembox">
<h5>【{$item['no']}】{$item['name']|default:'無題'}</h5>


<div class="item-content">

<div class="itemimg">
{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}
{image_display_gcs calc_width="300" file_image=$item['image'] image_dir=$image_dir}
<img class="img-responsive" src="{$image_src}" {if $image_srcset}srcset="{$image_srcset}"{/if} alt="{$item['name']}" title="{$item['name']}" />
</div><!-- itemimg -->

<div class="item-table">
<table>
{if $item['limit_date']}
<tr><th>承り期間：</th><td>{$item['limit_date']|date_format:"%m月%d日まで"}</td></tr>
{/if}
{if $item['send_date']}
<tr><th>お届け期間：</th><td>{$item['send_date']}</td></tr>
{/if}
{if !$item['nominate']}
<tr><th>配達日指定：</th><td>不可</td></tr>
{/if}
{if $item['temperature']}
<tr><th>配送方法：</th><td>{$temperatureList[$item['temperature']]}</td></tr>
{/if}
{if $item['bestbefore']}
<tr><th>賞味期限：</th><td>{$item['bestbefore']}</td></tr>
{/if}
{if $item['maker']}
<tr><th>生産国：</th><td>{$item['maker']}</td></tr>
{/if}

{if $item['package']}
<tr><th>包装：</th><td>{$packageList[$item['package']]}</td></tr>
{/if}
{if $item['wrap_use']}
<tr><th>包装：</th><td>可</td></tr>
{/if}
{if $item['noshi_use']}
<tr><th>のし：</th><td>可</td></tr>
{/if}

<tr><th>税込み価格：</th><td><span class="price">{$item['price']|number_format}円</span>{if $item['postage']} <span class="label label-info">{$postageList[$item['postage']]}</span>{/if}{if $item['price_base']}<br /><span class="em09">本体価格: {$item['price_base']|number_format}円（税: {$item['tax']|number_format}円）</span>{/if}</td></tr>
</table>

{if $item['closed']}<p class="alert alert-danger">{$item['limit_note']|default:"お申込みは終了しました。"}</p>

{else}
{check_item_stock item_id=$item['id']}
{if $stock_error}<p class="alert alert-danger">完売のため取扱を終了しました。</p>{/if}
{/if}


{if !$item['closed'] && !$stock_error}
<form method="post" id="formCart" class="form-horizontal" action="{$self}?mode=add_cart">

{get_item_info id=$item['id']}
{if $itm["cart"]|@count}
{foreach from=$itm["cart"] key=k item=v}
{if $v["use"]}
<div class="form-group">
<label class="col-sm-3 control-label">
{$v["title"]}{if $v["use"]==2}<span class="label label-danger">必須</span>{/if}</label>
<div class="col-sm-9">
<select name="cart{$k}" id="cart{$k}" class="form-control input-lg{if $v['use'] == 2} validate[required]{/if}">
{html_options values=$v['select'] output=$v['select'] selected=$item["cart{$k}"]}
</select>
{if $cart{$k}_err}<span class="must_view">*必須項目です</span>{/if}
<p class="help-block">{$v["note"]}</p>
</div>
</div>{/if}
{/foreach}
{/if}

<div class="form-group">
<label class="col-sm-3 control-label">個数</label>
<label class="col-sm-3 control-label">
<input type="tel" class="form-control input-lg validate[required,custom[number]]" maxlength="3" name="num" id="num" value="1" />
</label>
</div>


<p><button class="btn btn-success btn-block" type="submit" name="add_cart" id="add_cart" value="カートに入れる"><i class="fa fa-fw fa-shopping-cart"></i>カートに入れる</button></p>
<input type="hidden" name="item_id" value="{$item['id']}" />
</form>

{/if}
</div>

<div class="clear"></div>

{if $item['description']}
<div class="item-description">{$item['description']|nl2br}</div>
{/if}

{if $item['content']}<p class="contact gray em09">{$item['content']|nl2br}</p>{/if}


{if $item_has_category && !$is_category}
<p class="right">
<a class="btn btn-primary btn-sm" href="{$self}?subcategory_id={$item['subcategory_id']}">{$item['subcategory_denomination']}</a>
</p>
{/if}

<div class="clear"></div>
<p><a class="btn btn-primary" href="javascript:history.back();"><i class="fa fa-fw fa-chevron-left"></i>前に戻る</a></p>

</div><!-- item-content -->


<div class="clear"></div>
</div><!-- itembox -->
{else}
<p class="alert alert-danger">URLが不正です。</p>
{/if}
{/items}


{* 商品情報 終了 *}

{* 商品がない場合など 開始 *}
{if $no_item}
<p>商品がありません</p>
{/if}
{if $db_error}
<p>データベースからデータを読み込むのに失敗しました。</p>
{/if}
{* 商品がない場合など 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
