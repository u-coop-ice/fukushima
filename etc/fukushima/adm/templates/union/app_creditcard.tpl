<tr><th class="vtop">クレジットカード情報</th>
<td class="vtop">
カード種別：{$app['cardbrand']}<br />
{if $smarty.session.admin_mode}
カード番号：{$app['cardnumber1']}-{$app['cardnumber2']}-{$app['cardnumber3']}-{$app['cardnumber4']}
{else}
カード番号：xxxx-xxxx-xxxx-{$app['cardnumber4']}
{/if}
{$app['exp_month']|string_format:"%02d"}/{$app['exp_year']}<br />
　　名義人：{$app['holdername']}</p>

</td>
</tr>
