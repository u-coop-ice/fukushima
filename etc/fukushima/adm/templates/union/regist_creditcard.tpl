<tr><th class="vtop">クレジットカード情報</th>
<td class="vtop">


{if $post['token_id']}

{get_token_info token_id=$post['token_id']}
{if !$token_errmsg}
<p>カード種別：{$token_type}<br />
カード番号：xxxx-xxxx-xxxx-{$token_last4} {$token_exp_month|string_format:"%02d"}/{$token_exp_year}<br />
　　名義人：{$token_name}</p>
{else}
<p class="red"><i class="icon-exclamation-sign"></i> {$token_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
{/if}
{/if}

</td>
</tr>
