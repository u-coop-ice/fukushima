{* ページタイトル 開始 *}
{capture assign="page_title"}送信済みメールの表示{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{literal}
{/literal}

{* 送信済みメルマガ表示 *}
{magazines}
<h4 class="page_title">{$page_title}</h4>

<table class="inputForm send" cellspacing="0">
<col width="100" />
<col width="400" />
<tr>
<th>件名</th>
<td>{$magazine['subject']}</td>
</tr>
<tr>
<th>宛先</th>
<td>{if $magazine['group_id']}{$magazine['group_denomination']}{else}
{translate_condition condition=$magazine['condition']}
{if $translate_condition['component']}<div><span class="badge badge-secondary">お申込み</span> {$translate_condition['component']} {$translate_condition['category_denomination']}</div>{/if}
{if $translate_condition['forced']}<div><span class="badge badge-secondary">ユーザーの配信停止設定</span> {$translate_condition['forced']}</div>{/if}
{/if}</td>
</tr>
<tr>
<th>送信日時</th>
<td>{$magazine['date']}</td>
</tr>
<tr>
<th>本文</th>
<td class="magbody">{$magazine['body']|nl2br}{groups id=$magazine['group_id']}<br />{$group['signature']|nl2br}{/groups}</td>
</tr>
</table>
{/magazines}
{* メルマガ表示 終了 *}

{* 商品が見つからなかった場合の出力等 開始 *}
{if $no_magazine}
<p>メルマガが見つかりませんでした。</p>
{/if}
{if $db_error}
<p>メルマガの読み込みに失敗しました。</p>
{/if}
{* が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
