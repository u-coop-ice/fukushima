<tr><th class="vtop">{$methods['stock_multi']['title']}</th>
<td>{if $methods['stock_multi']['tag']=='checkbox'}{$post['stock_multi']|implode:"/"}{else}{$post['stock_multi']|default:"未入力"}{/if}</td>
</tr>
