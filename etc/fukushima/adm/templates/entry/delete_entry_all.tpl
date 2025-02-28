{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('選択されたカテゴリの登録データをすべて削除してもよろしいですか？この操作後は元にもどせません。');
}
//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="登録データの一括削除"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}</h4>
<p class="ind"><strong class="red">この操作は元にもどせません。</strong></p>

{* 絞り込み *}
<h5>データの絞り込み条件</h5>
<form method="post" action="{$self}?mode=delete_all" class="filter_entry" onsubmit="return deleteCheck();">
<table class="inputForm">
<tr><th >カテゴリ（講座名）</th>
<td><select name="category_id" id="category_id">
<option value="" {if $view_cat_id == ""}selected{/if}></option>
{categories}
<option value="{$category['id']}" {if $category['id'] == $view_category_id}selected{/if}>{$category['denomination']}</option>
{/categories}
<option value="99999999" {if $view_cat_id == "99999999"}selected{/if}>すべてのカテゴリ</option>
</select>
</td>
<tr>
<th>削除条件</th>
<td>
<label for="export_date">書き出し済み、未書き出しに関わらずすべて</label>
</td>
</tr>
</table>

<input type="submit" value="削除する" />
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
