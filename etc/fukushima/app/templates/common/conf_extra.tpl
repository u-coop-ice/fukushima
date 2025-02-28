{if $methods['extra'][$k]['use']}
<tr><th class="vtop">{$methods['extra'][$k]['title']}</th>
<td>{if $methods['extra'][$k]['tag']=='checkbox'}{if $post['extra'][$k]}{$post['extra'][$k]|implode:"/"}{else}未入力{/if}{else}{$post['extra'][$k]|default:"未入力"}{/if}</td>
</tr>
{/if}