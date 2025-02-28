<tr><th class="vtop">{$methods['extra'][$extras[$f]['k']]['title']}</th>
<td>{if $methods['extra'][$extras[$f]['k']]['tag']=='checkbox'}{if count($app['extra'][$extras[$f]['k']])}{$app['extra'][$extras[$f]['k']]|implode:"/"}{/if}{else}{$app['extra'][$extras[$f]['k']]|default:"未入力"}{/if}</td>
</tr>
