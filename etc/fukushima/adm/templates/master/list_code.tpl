{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('コードを削除してもよろしいですか');
}
//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="所属コード・大学合格種別（KLAS）の一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 編集権限 *}



{* 記事本体 開始 *}
<h4 class="page_title">【{$init_univname}】{$page_title}</h4>

<p class="pad_l">KLASにて設定を変更した場合は必ず変更してください。該当するフォームの選択項目、データ書き出しに反映します。</p>
<div class="hr"></div>
<h5>所属コード<br /><span class="em08">フォームで使用しない場合は非表示にしてください。</span></h5>

{code name="23"}
{if $code_header}
<table class="inputForm_free" cellspacing="0">
<tr>
<th class="mh">コード</th>
<th class="mh">名称</th>
<th class="mh">区分</th>
<th class="mh">並び順</th>
<th class="mh"></th>
</tr>
{/if}
<tr><td><a href="{$self}?mode=edit_code&id={$code['id']}&name={$code['name']}&univ_id={$code['univ_id']}">{$code['number']|string_format:"%04d"}</a></td>
<td>{$code['value']}
{if $code['flag']==1}
<span class="label label-success">表示</span>
{else}
<span class="label label-primary">非表示</span>
{/if}
</td>
<td>{$memberList[$code['member']]}</td>

<td>{$code['sort_order']}</td>

<td>
<form method="post" action="{$self}?mode=delete_code" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="univ_id" value="{$view_univ_id}" />
<input type="hidden" name="id" value="{$code['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除">削除</button>
</form>
</td></tr>
{if $code_footer}
</table>
<p><a class="btn btn-primary" href="{$self}?mode=edit_code&name={$code['name']}&univ_id={$code['univ_id']}"><i class="fa fa-fw fa-plus"></i>所属コードの追加</a>
</p>
{/if}
{/code}
{if $no_code}<p class="alert alert-info">登録コードがありません。</p>{/if}

<h5>大学合格種別<br /><span class="em08">フォームで使用しない場合は非表示にしてください。</span></h5>

{code name="24"}
{if $code_header}
<table class="inputForm_free" cellspacing="0">
<tr>
<th class="mh">コード</th>
<th class="mh">名称</th>
<th class="mh">並び順</th>
<th class="mh"></th>
</tr>

{/if}
<tr><td><a href="{$self}?mode=edit_code&id={$code['id']}&name={$code['name']}&univ_id={$code['univ_id']}">{$code['number']|string_format:"%02d"}</a></td>
<td>{$code['value']}
{if $code['flag']==1}
<span class="label label-success">表示</span>
{else}
<span class="label label-primary">非表示</span>
{/if}
</td>
<td>{$code['sort_order']}</td>
<td>
<form method="post" action="{$self}?mode=delete_code" class="delete_category" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$code['id']}" />
<button class="btn btn-primary btn-sm" type="submit" value="削除">削除</button>
</form>
</td></tr>

{if $code_footer}
</table>
<p><a class="btn btn-primary" href="{$self}?mode=edit_code&name={$code['name']}&univ_id={$code['univ_id']}"><i class="fa fa-fw fa-plus"></i>大学合格種別コードの追加</a>
</p>
{/if}
{/code}
{if $no_code}<p class="alert alert-info">登録コードがありません。</p>{/if}



{* 記事本体 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
