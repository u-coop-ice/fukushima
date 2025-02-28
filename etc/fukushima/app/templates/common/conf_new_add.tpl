<tr><th>{$methods['new_add']['title']}</th>
<td>
<span class="label label-info">{$newaddList[$post['new_add']]}</span>
{if ($post['new_zipcodef'] !="" || $post['new_zipcodes'] !="" || $post['new_pref'] !="" || $post['new_addressf'] !="")}
<div>
〒{$post['new_zipcodef']|string_format:"%03d"}−{$post['new_zipcodes']|string_format:"%04d"}<br />
{$post['new_pref']} {$post['new_addressf']}
{if $post['new_addresss']}
<br />{$post['new_addresss']}
{/if}
{if $post['new_addresst']}
{$post['new_addresst']}
{/if}
</div>
{/if}
</td>
</tr>

