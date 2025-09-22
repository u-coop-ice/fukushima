{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('商品を削除してもよろしいですか');
}
//]]>
</script>

<link rel="stylesheet" type="text/css" href="/js/jquery/jquery.powertip-1.3.2/css/jquery.powertip.min.css" />
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.3.2/jquery.powertip.min.js"></script>
<script type="text/javascript">
//<[!CDATA[
$(function(){
$('.tooltips').powerTip({
	placement: 'n',
	smartPlacement: true
});
});
//]]>
</script>

{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="商品の一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品一覧本体 開始 *}
<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="deleted alert alert-success">商品を削除しました。</p>
{/if}
<p><a class="btn btn-primary" href="{$self}?mode=edit_item"><i class="fa fa-fw fa-edit"></i>商品の新規作成</a></p>
{*item_page_navi_setup show_all=1 per_page=20*}

{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}
{items show_all=1 per_page=20}
{if $item_header}
<p>{$item_count}件中の{$first_item_no}〜{$last_item_no}件目</p>
<table class="inputForm free">
<col style="width:5%;"/>
<col style="width:5%;"/>
<col style="width:30%;"/>
<col style="width:25%;"/>
<col style="width:15%;"/>
<col style="width:10%;"/>
<col style="width:10%;"/>
<tr>
<th class="mh">番号</th>
<th class="mh"></th>
<th class="mh">名前</th>
<th class="mh">カテゴリ</th>
<th class="mh">公開</th>
<th class="mh">在庫</th>
<th class="mh">削除</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=edit_item&item_id={$item['id']}">{$item['no']}</a></td>
<td>
{if $item["image"]}
{image_display_gcs calc_width=64 file_image=$item['image'] image_dir=$image_dir}
<img class="itemImg" src="{$image_src}" {$image_attr} alt="{$item_name}" title="{$item_name}" /><br />
{/if}
</td>
<td>{$item['name']}
<div>{$item['price']|number_format}円</div></td>
<td>{$item['category_denomination']}{if $item['subcategory_denomination']} <i class="fa fa-angle-right"></i> {$item['subcategory_denomination']}{/if}{if $item['sub2category_denomination']} <i class="fa fa-angle-right"></i> {$item['sub2category_denomination']}{/if}</td>
<td><span class="tag {$visibleColorList[$item['visible']]}">{$visibleList[$item['visible']]}</span>
{if $item['limit_date']}<br />〜{$item['limit_date']}{/if}
</td>
<td>{if $item['onstock']==1}{$item['stock']}<span class="tag green min">ON</span>{else if $item['onstock']==2}<span class="tag primary min tooltips" title="{if is_array($item['composition_item_ids'])}{foreach from=$item['composition_item_ids'] item="composition_item_ids"}<div>ã{$composition_item_ids['no']}ã{$composition_item_ids['name']} x {$composition_item_ids['num']}</div>{/foreach}{/if}">SET</span>{else}-{/if}</td>
<td class="delete_item_button">
<form method="post" action="{$self}?mode=delete_item" class="delete_item" onsubmit="return deleteCheck();">
<input type="hidden" name="item_id" value="{$item['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value=""><i class="fa fa-fw fa-times"></i>削除</button>
</form>
</td>
</tr>
{if $item_footer}
</table>
{/if}
{/items}
{* 商品一覧本体 終了 *}

{* ページ選択 *}
{include file='../common/page_select.tpl'}

{* 商品が見つからなかった場合の出力等 開始 *}
{if $no_item}
<p class="alert alert-info">商品が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">商品の読み込みに失敗しました。</p>
{/if}
{* 商品が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
