<tr><th>{$methods['ship_address']['title']|default:"住所"}</th>
<td>{if ($post['ship_zipcodef'] !="" || $post['ship_zipcodes'] !="" || $post['ship_pref'] !="" || $post['ship_addressf'] !="")}
〒{$post['ship_zipcodef']|string_format:"%03d"}−{$post['ship_zipcodes']|string_format:"%04d"}<br />
{$post['ship_pref']} {$post['ship_addressf']}
{if $post['ship_addresss']}
<br />{$post['ship_addresss']}
{/if}
{if $post['ship_addresst']}
{$post['ship_addresst']}
{/if}
{else}
未入力
{/if}
</td></tr>
