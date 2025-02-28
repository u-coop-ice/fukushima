<tr><th class="vtop">{$methods['stock_multi']['title']}</th>
<td>{if $methods['stock_multi']['tag']=='checkbox'}{if count($app['stock_multi'])}{$app['stock_multi']|implode:"/"}{/if}{else}{$app['stock_multi']|default:"未入力"}{/if}</td>
</tr>
