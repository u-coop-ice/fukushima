{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[

$(function(){
	$('[id^="add_cart"]').submit(function(){
		var t = $(this);
		var did = t.attr('data');
		var json = $(this).serializeArray();
		$.ajax({
		url:"./order.php?mode=add_cart",
		type: "post",
		data: json,
		cache	: false,
		async	: false
		}).done(function(r){
//		var res = $.parseJSON(r)
//		if (res.errmsg){return false;}
//		alert("add cart!!");
		t.html('<p><span class="label label-success">選択済</span></p>');

		});
		return false;
	});

});


//]]>
</script>

{/literal}
{/capture}


{assign var="page_title" value="新規受注登録（商品一覧）"}



{include file='header.tpl'}


{* 商品一覧 開始 *}

{items per_page=100}
{if $item_header}
<p>{$item_count}件中の{$first_item_no}〜{$last_item_no}件目</p>
<ul class="list-group">
{/if}
<li class="list-group-item">
<div class="itembox">
<div class="itemimgbox">
{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}
{image_display_gcs calc_width="300" file_image=$item['image'] image_dir=$image_dir}

<div class="pull-left item-image">
<img class="img-responsive" src="{$image_src}" alt="{$item_name}" title="{$item_name}" />
</div>
</div><!-- itemimgbox -->

<div class="pull-left item-text">

{if $item['closed'] || !$item["visible"]}<p><span class="label label-danger">販売サイト 選択不可/非表示</span></p>{/if}

<h5>【{$item['no']}】{$item['name']}</h5>


{check_item_stock item_id=$item['id']}
{if $stock_error}<p class="alert alert-danger">在庫なし</p>{/if}


{if count($cart_item_id) && $item['id']|in_array:$cart_item_id}

<p><span class="label label-success">選択済</span></p>
{else}

<form id="add_cart{$item['id']}" class="form-horizontal" action="">

{get_item_info id=$item['id']}
{if $itm["cart"]|@count}
{foreach from=$itm["cart"] key=k item=v}
{if $v["use"]}
<div class="form-group">
<label class="control-label col-sm-3">
{$v["title"]}{if $v["use"]==2}<span class="label label-danger">必須</span>{/if}
</label>
<div class="col-sm-9">
<select name="cart{$k}" id="cart{$k}" class="form-control{if $v['use'] == 2} validate[required]{/if}">
{html_options values=$v['select'] output=$v['select'] selected=$item["cart{$k}"]}
</select>
{if $cart{$k}_err}<span class="must_view">*必須項目です</span>{/if}
{if $v["note"]}<p class="help-block">{$v["note"]}</p>{/if}
</div>
</div>{/if}
{/foreach}
{/if}


<div class="form-group">
<label class="control-label col-sm-3">個数</label>
<div class="col-sm-9">
<input type="tel" id="num" name="num" class="form-control num" size="5" value="{$item['num']|default:1}" />
</div>
</div>
<p><button class="btn btn-primary btn-sm" type="submit" name="add" value="1" >カート追加</button></p>

<input type="hidden" name="item_id" value="{$item['id']}" />

</form>
{/if}

<p><span>価格：</span><span class="price">{$item['price']|number_format}円（{$postageList[$item['postage']]}）</span></p>
<div class="clear"></div>
</div><!-- itemtxtbox -->
<div class="clear"></div>
</div><!-- itembox -->
</li>
{if $item_footer}
</ul><!-- items -->
{/if}
{/items}
{* 商品一覧 終了 *}

<div id="fixed_cart">
<a href="{$self}?mode=view_cart"><p class="icon"><i class="fa fa-shopping-cart"></i></p>go to cart</a>
</div>


{* ページ選択 *}
{include file='page_select.tpl'}

{* 商品がない場合など 開始 *}
{if $no_item}
<p class="note">商品がありません</p>
{/if}
{if $db_error}
<p class="error">データベースの読みに失敗しました。</p>
{/if}
{* 商品がない場合など 終了 *}

{* フッター部分の組み込み *}


{include file='footer.tpl'}
