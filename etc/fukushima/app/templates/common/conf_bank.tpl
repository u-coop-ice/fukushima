{if $methods['bank']['use']}
<tr><th>{$methods['bank']['title']|default:"銀行口座"}</th>
<td>
<span class="gray">銀行名：</span>{$post['bank_name']}<br />
{if $post['bank']==1}
<span class="gray">記号：</span>{$post['bank_branch']}<br />
<span class="gray">番号：</span>{$post['bank_account']|string_format:"%08d"}<br />
{else}
<span class="gray">本支店名：</span>{$post['bank_branch']}<br />
<span class="gray">支店コード：</span>{$post['code_branch']}<br />
<span class="gray">口座種別：</span>{$bankSortList[$post['bank_sort']]}<br />
<span class="gray">口座番号：</span>{$post['bank_account']}<br />
{/if}
<span class="gray">口座名義名：</span>{$post['bank_holder_kana']}
</td>
</tr>
{/if}