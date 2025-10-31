{if $k==1}
<tr><th class="mh" colspan="2">変更される項目について</th>
{else if $k==4}
<tr><th class="mh" colspan="2">入力者情報</th></tr>
{/if}
{if $methods['extra'][$k]['use']}
<tr><th class="vtop">{$methods['extra'][$k]['title']|nl2br}</th>
<td>{if $methods['extra'][$k]['tag']=='checkbox'}{if $post['extra'][$k]}{$post['extra'][$k]|implode:"/"}{else}未入力{/if}{else}{$post['extra'][$k]|default:"未入力"}{/if}</td>
</tr>
{/if}