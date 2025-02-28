<tr><th>{$methods['new_add']['title']|default:"現住所"}</th><td>
{if $regist['new_add']}<p><span class="label label-info">{$newaddList[$regist['new_add']]}</span></p>{/if}
{if ($regist['new_zipcodef'])}
<p>〒{$regist['new_zipcodef']|string_format:"%03d"}-{$regist['new_zipcodes']|string_format:"%04d"}<br />
{$regist['new_pref']}&nbsp;{$regist['new_addressf']}
{if $regist['new_addresss']}
<br />{$regist['new_addresss']}
{/if}
{if $regist['new_addresst']}
<br />{$regist['new_addresst']}
{/if}
</p>
{/if}
</td></tr>

