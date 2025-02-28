<tr><th>銀行口座</th>
<td>

{if $app['code_branch']}
<span class="gray">銀行名：</span>{$app['bank_name']}<br />
<span class="gray">本支店名：</span>{$app['bank_branch']}<br />
<span class="gray">種目：</span>{$bankSortList[$app['bank_sort']]}<br />
{if $app['code_bank']}<span class="gray">銀行コード：</span>{$app['code_bank']}<br />{/if}
<span class="gray">支店コード：</span>{$app['code_branch']}<br />
<span class="gray">口座番号：</span>{$app['bank_account']}<br />
<span class="gray">口座名義名：</span>{$app['bank_holder']}（{$app['bank_holder_kana']}）
{else}
<span class="gray">銀行名：</span>{$app['bank_name']}<br />
<span class="gray">記号：</span>{$app['bank_branch']}<br />
<span class="gray">番号：</span>{$app['bank_account']}<br />
<span class="gray">口座名義名：</span>{$app['bank_holder']}（{$app['bank_holder_kana']}）
{/if}


</td>
</tr>
