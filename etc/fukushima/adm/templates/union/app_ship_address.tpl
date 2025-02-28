<tr><th>{$methods['ship_address']['title']|default:'住所'}</th><td>
{if ($app['ship_pref'] !="")}
〒{$app['ship_zipcodef']|string_format:"%03d"}-{$app['ship_zipcodes']|string_format:"%04d"}<br />
{$app['ship_pref']}&nbsp;{$app['ship_addressf']}
{if $app['ship_addresss']}
<br />{$app['ship_addresss']}
{/if}
{if $app['ship_addresst']}
<br />{$app['ship_addresst']}
{/if}
{else}未登録
{/if}

</td></tr>
