{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('選択されたグループのメルマガデータをすべて削除してもよろしいですか？この操作後は元にもどせません。');
}
//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="送信および作成したメールの一括削除"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}</h4>
<p class="ind"><strong class="red">この操作は元にもどせません。</strong></p>

{* 絞り込み *}
<h4>データの絞り込み条件</h4>
<form method="post" action="{$self}?mode=delete_all_magazine" class="filter_entry" onsubmit="return deleteCheck();">
<table class="inputForm">
<tr><th >アドレスグループ</th>
<td><select class="form-control" name="group_id" id="group_id">
<option value="" {if $view_group_id == ""}selected{/if}></option>
{groups}
<option value="{$group['id']}" {if $group['id'] == $view_group_id}selected{/if}>{$group['name']}</option>
{/groups}
</select>
</td>
</tr>
</table>

<button class="btn btn-primary" type="submit" value="削除する">削除する</button>
</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
