{* ヘッダー部分の組み込み *}
{if !$layout_class}
{assign var="layout_class" value="two-column"}
{/if}

{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
return confirm('住所を削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}

{* ページタイトル 開始 *}
{capture assign="page_title"}保存されている住所一覧（アドレス帳）{/capture}
{* ページタイトル 終了 *}

{include file='header.tpl'}

<h3>{$page_title}</h3>

{if $saved}
<p class="alert alert-success">アドレスを保存しました。</p>
{/if}
{if $deleted}
<p class="alert alert-info">アドレスを削除しました。</p>
{/if}

{addresses regist_id=$regist['id']}
<div class="contact {if $post['ship_address']==$address['id']}checked{/if}">


<h5 class="top">{$address['ship_namef']} {$address['ship_nameg']}</h5>

〒{$address['ship_zipcodef']|string_format:"%03d"}-{$address['ship_zipcodes']|string_format:"%04d"}<br />
{$address['ship_pref']} {$address['ship_addressf']}{if $address['ship_addresss']} {$address['ship_addresss']}{/if}{if $address['ship_addresst']} {$address['ship_addresst']}{/if}
<br />{$address['ship_phonenumber']}
<div class="clear"></div>

<div class="pull-right">
<form method="post" action="{$self}?mode=delete_ship_address" class="delete_address" onsubmit="return deleteCheck();">
<input type="hidden" name="address_id" value="{$address['id']}" />
<div><button class="btn btn-primary btn-sm" type="submit" value="削除"><i class="fa fa-fw fa-times"></i>削除</button></div>
</form>
</div>
<span><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_ship_address&address_id={$address['id']}"><i class="fa fa-fw fa-edit"></i>編集</a></span>
<div class="clearfix"></div>


</div>
{/addresses}
<p class=""><a class="btn btn-primary" href="{$self}?mode=edit_ship_address"><i class="fa fa-fw fa-plus"></i>アドレスを追加する</a></p>

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_address}
<p class="alert alert-info">アドレスが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">データベースの読み込みに失敗しました。</p>
{/if}


<p><a class="btn btn-primary" href="{$self}"><i class="fa fa-fw fa-reply"></i>商品一覧にもどる</a></p>
<div class="clear"></div>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
