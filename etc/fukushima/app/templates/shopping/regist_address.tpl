<tr><th>ご注文者住所</th><td>
{if ($regist['pref'] !="")}
〒{$regist['zipcodef']|string_format:"%03d"}-{$regist['zipcodes']|string_format:"%04d"}<br />
{$regist['pref']}&nbsp;{$regist['addressf']}
{if $regist['addresss']}
<br />{$regist['addresss']}
{/if}
{if $regist['addresst']}
<br />{$regist['addresst']}
{/if}
{else}未登録
{/if}

</td></tr>
