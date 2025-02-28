{* ショッピング系*}
{*orders*}


<table class="inputForm">
<tr class="table-header">
<th class="mh" colspan="2">お申込み情報</th>
</tr>
<tr><th>申込番号</th><td>{$app['regist_date']|date_format:"Ymd"}-{$app['app_count']|string_format:"%04d"}</td></tr>
<tr><th>申込日時</th><td>{$app['regist_date']}</td></tr>


</table>

{assign var='view_order_id' value=$app['id']}
{suborders}
{if $suborder_header}
<table class="inputForm free">
<tr class="table-header">
<th class="mh">商品名</th>
<th class="mh">単価</th>
<th class="mh">個数</th>
<th class="mh">小計</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td>{$suborder['name']}
{if $suborder['methods']['cart']|@count}
{foreach from=$suborder['methods']['cart'] key=k item=v}
{if $v['use']}
<div>{$v['title']}: {$v['value']}</div>
{/if}
{/foreach}
{/if}
</td>
<td class="num">{$suborder['price']|number_format}円</td>
<td class="num">{$suborder['num']}</td>
<td class="num right">{$suborder['total_price']|number_format}円</td>
</tr>
{if $suborder_footer}

{if $app['reduction']}
<tr>
<th colspan="3">値引き</th>
<td class="num right">-{$app['reduction']|number_format}円</td>
</tr>
{/if}


{if $suborder['postage']}
<tr>
<th colspan="3">送料</th>
<td class="num right">{$suborder['postage']|number_format}円</td>
</tr>
{/if}
<tr>
<th class="header" colspan="3">合計</th>
<td class="nu prc right">{$app['total_price_all']|number_format}円</td>
</tr>
</table>
{/if}
{/suborders}

{if $app['ship_flag']<2}
{assign var='view_order_id' value=$app['id']}
{suborders}
{if $suborder_header}
<table class="inputForm">
<col width="150">
<col width="400">

<tr class="table-header">
<th colspan="2" class="mh">配送オプション等</th>
</tr>
{/if}

{if !$app['methods']['flag_send']}
<tr><td colspan="2">{$suborder['name']}</td></tr>
{else if ($suborder['methods']['wrap_use'] || $suborder['methods']['noshi_use'] || $suborder['methods']['extra']|@count)}
<tr><td colspan="2">{$suborder['name']}</td></tr>
{/if}
{if !$app['methods']['flag_send']}
<tr><th>配達希望日</th>
<td>{if $suborder['methods']['nominate']}{$suborder['ship_date']|default:"指定なし"}{else}指定不可{/if}{if $suborder['methods']['send_date']}（{$suborder['methods']['send_date']}）{/if}</td>
</tr>

<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$suborder['ship_time']]}
</td>
</tr>
{/if}
{if $suborder['methods']['wrap_use']}
<tr><th>包装</th>
<td>{$suborder['methods']['wrap']}</td>
</tr>
{/if}

{if $suborder['methods']['noshi_use']}
<tr><th>のし</th>
<td>
{$suborder['methods']['noshi']}{if $suborder['methods']['noshi_other']}（{$suborder['methods']['noshi_other']}）{/if}{if $suborder['methods']['noshi_name']}：{$suborder['methods']['noshi_name']}{/if}
</td>
</tr>
{/if}
{if $suborder['methods']['extra']|@count}
{foreach from=$suborder['methods']['extra'] key=k item=v}
{if $v['use']}
<tr><th class="vtop">{$v['title']}</th>
<td>{$v['value']}</td>
</tr>
{/if}
{/foreach}
{/if}
{if $suborder_footer}
</table>
{/if}
{/suborders}

{if $app['methods']['flag_send']}
<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th colspan="2" class="mh">配送について</th>
</tr>
<tr><th>配達希望日</th>
<td>{if $app['methods']['nominate']}{$app['ship_date']|default:"指定なし"}{else}指定不可{/if}</td></tr>
<tr><th>配達希望時間</th>
<td>{$shiptimeKeyList[$app['ship_time']]}</td></tr>
</table>
{/if}

{/if}


<table class="inputForm">
<tr class="table-header"><th class="mh" colspan="2">配送元情報</th></tr>
{if $app['ship_from']}
<tr><th>名前</th><td>{$app['ship_from_name']}（{$app['ship_from_kana']}）様{if $app['ship_from']} <span class="label label-primary">ユーザー登録情報と異なる</span>{/if}</td></tr>
<tr><th>配送元住所</th><td>〒{$app['ship_from_zipcodef']|string_format:"%03d"}-{$app['ship_from_zipcodes']|string_format:"%04d"}<br />
{$app['ship_from_pref']} {$app['ship_from_addressf']}{if $app['ship_from_addresss']}<br />
{$app['ship_from_addresss']}{/if}{if $app['ship_from_addresst']}<br />{$app['ship_from_addresst']}{/if}</td></tr>
<tr><th>電話番号</th><td>{$app['ship_from_phonenumber']}</td></tr>
{else}
{include file="regist_name.tpl"}
{if !$regist['new_add'] || $regist['new_add']==3}
{include file="regist_address.tpl"}
{include file="regist_phonenumber.tpl"}
{else}
{include file="regist_new_add.tpl"}
{if $regist['mobilephone']}
{include file="regist_mobilephone.tpl"}
{else}
{include file="regist_student_phone.tpl"}
{/if}
{/if}
{/if}

<tr class="table-header"><th class="mh" colspan="2">配送先情報</th></tr>

{if $app['ship_flag']<2}
<tr><th>名前</th><td>{$app['ship_namef']} {$app['ship_nameg']}（{$app['ship_kanaf']} {$app['ship_kanag']}）様{if !$app['ship_flag']} <span class="label label-primary">登録住所に配送</span>{/if}</td></tr>
<tr><th>郵便番号</th><td>{$app['ship_zipcodef']|string_format:"%03d"}-{$app['ship_zipcodes']|string_format:"%04d"}</td></tr>
<tr><th>住所</th><td>{$app['ship_pref']} {$app['ship_addressf']}{if $app['ship_addresss']}{$app['ship_addresss']}{/if}{if $app['ship_addresst']}<br />{$app['ship_addresst']}{/if}</td></tr>
<tr><th>電話番号</th><td>{$app['ship_phonenumber']}</td></tr>
{if $app['ship_age']}
<tr><th>年齢</th><td>{$ageCheckList[$app['ship_age']]}</td></tr>
{/if}
{else if $app['ship_flag']==2}
<tr><th>受け取り店舗</th><td>{$app['store']}</td></tr>
{/if}
</table>

<table class="inputForm">
<col width="150">
<col width="400">
<tr class="table-header">
<th class="mh" colspan="2">お支払い方法・備考等</th>
</tr>

<tr><th>お支払い方法</th>
<td>{$paymentList[$app['payment']]}</td></tr>

<tr><th>備考欄</th><td>{$app['memo']|nl2br}</td></tr>
</table>
{*/orders*}
