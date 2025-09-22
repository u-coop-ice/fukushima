{if $smarty.const.COMPONENT=="shopping"}


<div class="sidecolumn navi">

<dl>
<dt><i class="fa fa-square"></i> 注文の表示</dt>

{get_order_count}
{foreach from=$order_counts item=cts key=category_id}
<dl>
<dt>{$categoryList[$category_id]['denomination']}</dt>
{foreach from=$cts item=ct key=stat}
<dd style="padding-left:0.5em;"><a href="{$self}?mode=list_order&category_id={$category_id}&status={$stat}"><i class="fa fa-caret-right"></i> {$statusOrderList[$stat]}({$ct})</a></dd>
{/foreach}
</dl>
{/foreach}

<dd><a href="{$self}?mode=list_exported_no_treatment"><i class="fa fa-check-square"></i> 取扱フラグ一斉更新</a></dd>

<dd><a href="./order.php"><i class="fa fa-shopping-cart"></i> 新規注文作成</a><span class="tag min red">new</span></dd>

<dd><a href="{$self}?mode=list_stock_log"><i class="fa fa-caret-right"></i> 在庫ログ一覧</a></dd>

</dl>

<dl>
<dt><i class="fa fa-square"></i> 入金管理<span class="min tag">未対応・手配済・取消</span></dt>
{get_order_count paid=1}
{foreach from=$order_counts item=cts key=category_id}
<dl>
<dt>{$categoryList[$category_id]['denomination']}</dt>
{foreach from=$cts item=ct key=paid}
<dd style="padding-left:0.5em;"><a href="{$self}?mode=list_payment&category_id={$category_id}&paid={$paid}"><i class="fa fa-caret-right"></i> {$paidList[$paid]}</a>
<dl class="pad_l">
{foreach from=$ct item=p key=py}
<dd>
<a href="{$self}?mode=list_payment&category_id={$category_id}&paid={$paid}&payment={$py}"><i class="fa fa-caret-right"></i> {$paymentAdminList[$py]}({$p})</a></dd>
{/foreach}
</dl></dd>
{/foreach}
</dl>
{/foreach}

<dd><a href="{$self}?mode=list_paid_completed"><i class="fa fa-envelope"></i> 入金確認済メール配信</a></dd>
<dd><a href="{$self}?mode=list_nopaid"><i class="fa fa-envelope-o"></i> 支払い督促メール配信</a></dd>

</dl>

</div>

<div class="sidecolumn navi">

<dl>
<dt><i class="fa fa-square"></i> システムメール</dt>
<dd><a href="{$init_url}adm/ask/?mode=list_mail" target="_blank"><i class="fa fa-envelope"></i> すべてのメール履歴</a></dd>
</dl>

</div>

<div class="sidecolumn navi">
<dl>
<dt><i class="fa fa-square"></i> データベース操作</dt>
{*<dd><a href="{$self}?mode=edit_excel"><i class="fa fa-file-excel-o"></i> 注文の情報の書き出し</a></dd>*}
<dd><a href="{$self}?mode=edit_excel_paid"><i class="fa fa-file-excel-o"></i> 支払フラグでのデータの書き出し</a></dd>
<dd><a href="{$self}?mode=edit_excel_dev"><i class="fa fa-file-excel-o"></i> 注文データの書き出し<span class="min tag yellow">ヤマト</span></a></dd>
<dd><a href="{$self}?mode=edit_excel_jp"><i class="fa fa-file-excel-o"></i> 注文データの書き出し<span class="min tag red">ゆうパック</span></a></dd>
</dl>
</div>

<div class="sidecolumn navi">

<dl>
<dt><i class="fa fa-square"></i> 商品の操作</dt>
<dd><a href="{$self}?mode=edit_item"><i class="fa fa-plus-square"></i> 商品の登録</a></dd>
<dd><a href="{$self}?mode=list_item"><i class="fa fa-list"></i> 商品の一覧</a></dd>
<dl class="pad_l">
{sp_categories all=1}
<dt><i class="fa fa-folder-open"></i> <a href="{$self}?mode=list_item&cid={$category['id']}">{$category['denomination']}</a></dt>
{sp_subcategories category=$category['id'] all=1}
{if subcategory_header}
<dd>
{/if}
<a href="{$self}?mode=list_item&scid={$subcategory['id']}"><i class="fa fa-angle-right"></i> {$subcategory['denomination']}({$subcategory['entry_count']})</a>
{sp_sub2categories subcategory_id=$subcategory['id'] all=1}
<dl class="pad_l">
<dd><a href="{$self}?mode=list_item&s2cid={$sub2category['id']}"><i class="fa fa-caret-right"></i> {$sub2category['denomination']}({$sub2category['entry_count']})</a></dd>
</dl>
{/sp_sub2categories}
{if subcategory_footer}
</dd>
{/if}
{/sp_subcategories}
{/sp_categories}
</dl>
</dl>

<dl>
<dt><i class="fa fa-square"></i> カテゴリの操作</dt>
{if $authority["shopping"]["master"]}
<dd><a href="{$self}?mode=edit_category"><i class="fa fa-plus-square"></i> カテゴリの新規作成</a></dd>
{/if}
<dd><a href="{$self}?mode=list_category"><i class="fa fa-list"></i> カテゴリの一覧</a></dd>
<dt><i class="fa fa-square"></i> サブカテゴリの操作</dt>
<dd><a href="{$self}?mode=edit_subcategory"><i class="fa fa-plus-square"></i> サブカテゴリの新規作成</a></dd>
<dd><a href="{$self}?mode=list_subcategory"><i class="fa fa-list"></i> サブカテゴリの一覧</a></dd>
<dt><i class="fa fa-square"></i> 孫カテゴリの操作</dt>
<dd><a href="{$self}?mode=edit_sub2category"><i class="fa fa-plus-square"></i> 孫カテゴリの新規作成</a></dd>
<dd><a href="{$self}?mode=list_sub2category"><i class="fa fa-list"></i> 孫カテゴリの一覧</a></dd>
</dl>
</div>


<div class="sidecolumn navi">

<dl>
<dt>基本設定</dt>
<dd><a href="{$init_url}adm/{$smarty.const.COMPONENT}/?mode=show_config" ><i class="fa fa-cogs"></i> 基本設定</a></dd>
</dl>

</div>

{/if}
