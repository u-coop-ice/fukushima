<tr><th>ご注文者住所</th><td>
〒{$regist['new_zipcodef']|string_format:"%03d"}-{$regist['new_zipcodes']|string_format:"%04d"}<br />
{$regist['new_pref']}&nbsp;{$regist['new_addressf']}
{if $regist['new_addresss']}
<br />{$regist['new_addresss']}
{/if}
{if $regist['new_addresst']}
<br />{$regist['new_addresst']}
{/if}
</td></tr>

