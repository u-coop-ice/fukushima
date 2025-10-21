{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="登録データの書き出し"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}</h4>


{* 絞り込み *}
<h5>データの絞り込み条件</h5>
<form method="post" action="{$self}?mode=export_excel" class="filter_entry">
<table class="inputForm">
<tr><th>カテゴリ</th>
<td>
{categories component=$smarty.const.COMPONENT part=$smarty.const.PART}
<input type="hidden" name="category_id" id="category_id" value="{$category['id']}"/>
{$category['denomination']}
{/categories}
</td>
</tr>

<tr>
<th>キャンセル</th>
<td>
<div class="radio">
<label><input type="radio" name="opt_cancelled" checked="checked" value="1"> 含めない</label>
/
<label><input type="radio" name="opt_cancelled" value="0"> 含める</label>
</div>
</td>
</tr>

<tr>
<th>ユーザー登録データ</th>
<td>
<div class="radio">
<label><input type="radio" name="opt_regist" checked="checked" value="0"> 汎用エントリで設定した項目のみ</label>
/
<label><input type="radio" name="opt_regist" value="1"> すべて</label>
</div>
</td>
</tr>

<tr>
<th>アーカイブ</th>
<td>
<div class="radio">
<label><input type="radio" name="opt_archived" checked="checked" value="1"> 含めない</label>
/
<label><input type="radio" name="opt_archived" value="0"> 含める</label>
</div>
</td>
</tr>

<tr>
<th>書き出し履歴</th>
<td>
<p class="form-control-static">すべて</p>
<input type="hidden" id="export_date" name="export_date" value="all" />
</td>
</tr>
</table>

<p><button class="btn btn-primary" type="submit" value="書き出し">書き出し</button></p>
</form>

{* 記事本体 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_entry}
<p>記事が見つかりませんでした。</p>
{/if}
{if $db_error}
<p>記事の読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
