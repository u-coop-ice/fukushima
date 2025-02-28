{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}
{include file='header.tpl'}

{* 1ページあたり商品を10件ずつ表示 *}
{*item_page_navi_setup per_page=20 component=$smarty.const.PART*}

{* 商品一覧 開始 *}
{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}


<script type="text/javascript">
$(function(){
	$("#search_category").find("[name='subcategory_id']").on('change',function(){
		var subcategory_id = $(this).val();
		location.href = "./?subcategory_id=" + subcategory_id;
	});
});

</script>

<form id="search_category">
<p><select class="form-control input-lg" name="subcategory_id">
<option value="">（カテゴリで絞り込み）</option>
{sp_subcategories part=$smarty.const.PART}
<option value="{$subcategory['id']}" {if $view_subcategory_id==$subcategory['id']}selected="selected"{/if}>{if $subcategory['state']!=1}【{$stateOpenList[$subcategory['state']]}】{/if}{$subcategory['denomination']}({$subcategory['entry_count']})</option>
{/sp_subcategories}
</select></p>
</form>

{items part=$smarty.const.PART per_page=20}
{if $item_header}
<p>{$item_count}件中の{$first_item_no}〜{$last_item_no}件目</p>
<div class="list-group">
{/if}

<a class="list-group-item" href="{$self}?item_uuid={$item['uuid']}" title="{$item['name']}">
<div class="pull-left item-image">
{image_display_gcs file_image=$item['image'] image_dir=$image_dir calc_width="160"}
<img class="img-responsive" src="{$image_src}" alt="{$item_name}" title="{$item_name}"
 />
</div>


<div class="pull-left item-text">

<h5>【{$item['no']}】{$item['name']}</h5>

<p class="item-description">{$item['description']|mb_truncate:120:"..."|nl2br}</p>

<p><span>税込価格: </span><span class="price">{$item['price']|number_format}円</span>{if $item['postage']} <span class="label label-info">{$postageList[$item['postage']]}</span>{/if}
{if $item['price_base']}<br /><span class="em09">本体価格: {$item['price_base']|number_format}円（税: {$item['tax']|number_format}円）</span>{/if}
</p>
{if $item['closed']}<p class="alert alert-danger">{$item['limit_note']|default:"お申込みは終了しました。"}</p>

{else}
{check_item_stock item_id=$item['id']}
{if $stock_error}<p class="alert alert-danger">完売のため取扱を終了しました。</p>{/if}
{/if}

{if $item_has_category}
<p class="item-category"><span class="label label-default">{$item['subcategory_name']}</span></p>{/if}
</div><!-- itemtxtbox -->
<div class="clear"></div>
</a>

{if $item_footer}
</div><!-- items -->
{/if}
{/items}
{* 商品一覧 終了 *}

{* ページ選択 *}
{include file='page_select.tpl'}

<div class="visible-xs-block">
<div class="list-group">
<a class="list-group-item" href="{$self}?mode=usage">ご利用案内・送料等</a>
<a class="list-group-item" href="{$self}?mode=low">特定商取引法に基づく表示</a>
</div>
</div>


{* 商品がない場合など 開始 *}
{if $no_item}
<p class="alert alert-info">商品がありません</p>
{/if}
{if $db_error}
<p class="alert alert-danger">データベースの読みに失敗しました。</p>
{/if}
{* 商品がない場合など 終了 *}

{* フッター部分の組み込み *}

{if !$login}
{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-455544-5");
pageTracker._initData();
pageTracker._trackPageview();
</script>
{/literal}
{/if}

{include file='footer.tpl'}
