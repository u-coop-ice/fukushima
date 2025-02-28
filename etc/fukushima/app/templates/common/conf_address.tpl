<tr><th>{$methods['address']['title']|default:"実家（帰省先）住所"}</th>
<td>{if ($post['zipcodef'] !="" || $post['zipcodes'] !="" || $post['pref'] !="" || $post['addressf'] !="")}
〒{$post['zipcodef']|string_format:"%03d"}−{$post['zipcodes']|string_format:"%04d"}<br />
{$post['pref']} {$post['addressf']}
{if $post['addresss']}
<br />{$post['addresss']}
{/if}
{if $post['addresst']}
{$post['addresst']}
{/if}
{else}
未入力
{/if}
</td></tr>
