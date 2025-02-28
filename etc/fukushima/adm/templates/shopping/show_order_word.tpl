{orders}【ご注文内容】

受付No| {$order['category_infocode']}:{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
------+----------------------------------------------------------------------
 番号 | 商品名
      |                              単価          個数          小計
------+----------------------------------------------------------------------
{suborders}
 {$ctr_suborder|string_format:"%4d"} | 【{$suborder['no']}】{$suborder['name']}
{if $suborder['methods']['cart']|@count}
{foreach from=$suborder['methods']['cart'] key=k item=v}
{if $v['use']}
      | {$v['title']}: {$v['value']}
{/if}
{/foreach}
{/if}
      |                        {$suborder['price']|number_format|string_format:"%16s"}  {$suborder['num']|number_format|string_format:"%8s"}  {$suborder['total_price']|number_format|string_format:"%16s"}
{/suborders}
{if $order['reduction']}
------+----------------------------------------------------------------------
値引き|                                                {$order['reduction']|gmp_neg|number_format|string_format:"%20s"}
{/if}
{if $order['postage']}
------+----------------------------------------------------------------------
 送料 |                                                {$order['postage']|number_format|string_format:"%20s"}
{/if}
------+----------------------------------------------------------------------
 合計 |                                                {$order['total_price_all']|number_format|string_format:"%20s"}




【配送元】
{if $order['ship_from']}
※注文者と異なる
お名前　　　　：{$order['ship_from_name']}（{$order['ship_from_kana']}）様
配送元住所　　：〒{$order['ship_from_zipcodef']|string_format:"%03d"}-{$order['ship_from_zipcodes']|string_format:"%04d"}
　　　　　　　　{$order['ship_from_pref']} {$order['ship_from_addressf']}
{if $order['ship_from_addresss']}

　　　　　　　　{$order['ship_from_addresss']}
{/if}
{if $order['ship_from_addresst']}

　　　　　　　　{$order['ship_from_addresst']}
{/if}
電話番号　　　：{$order['ship_from_phonenumber']}

{else}
{regists rid=$order['regist_id']}
お名前　　　　：{$regist['namef']} {$regist['nameg']}（{$regist['kanaf']} {$regist['kanag']}）
{if !$regist['new_add'] || $regist['new_add']==3}
配送元住所　　：〒{$regist['zipcodef']|string_format:"%03d"}-{$regist['zipcodes']|string_format:"%04d"}

　　　　　　　　{$regist['pref']} {$regist['addressf']}
{if $regist['addresss']}

　　　　　　　　{$regist['addresss']}
{/if}
{if $regist['addresst']}

　　　　　　　　{$regist['addresst']}
{/if}
実家電話番号　：{$regist['phonenumber']}

{else}
住所　　　　　：〒{$regist['new_zipcodef']|string_format:"%03d"}-{$regist['new_zipcodes']|string_format:"%04d"}
　　　　　　　　{$regist['new_pref']} {$regist['new_addressf']}
{if $regist['new_addresss']}

　　　　　　　　{$regist['new_addresss']}
{/if}
{if $regist['new_addresst']}

　　　　　　　　{$regist['new_addresst']}
{/if}
{if $regist['mobilephone']}
携帯電話　　　：{$regist['mobilephone']}
{else}
　現住所TEL　 ：{$regist['student_phone']}
{/if}
{/if}
{/regists}
{/if}

【配送先等】
{if !$order['ship_flag']}
※ご注文者様住所にお届け
{/if}
{if $order['ship_flag']<2}
氏名　　　　　：{$order['ship_namef']} {$order['ship_nameg']}（{$order['ship_kanaf']} {$order['ship_kanag']}）様
ご住所　　　　：〒{$order['ship_zipcodef']|string_format:"%03d"}-{$order['ship_zipcodes']|string_format:"%04d"}
　　　　　　　　{$order['ship_pref']} {$order['ship_addressf']}
　　　　　　　　{$order['ship_addresss']}
{if $order['ship_addresst']}
　　　　　　　　{$order['ship_addresst']}
{/if}
電話番号　　　：{$order['ship_phonenumber']}

{else if $order['ship_flag']==2}
受け取り店舗　：{$order['store']}
{/if}

{if $order['ship_flag']<2}
{suborders}
{if $suborder_header}
【配送・オプション等】
{/if}
{if !$order['methods']['flag_send']}
【{$suborder['no']}】{$suborder['name']} × {$suborder['num']}
{else if ($suborder['methods']['wrap_use'] || $suborder['methods']['noshi_use'] || $suborder['methods']['extra']|@count)}
【{$suborder['no']}】{$suborder['name']} × {$suborder['num']}
{/if}
-----------------------------------------------------------------------------
{if !$order['methods']['flag_send']}
配達希望日　　：{if $suborder['methods']['nominate']}{$suborder['ship_date']|default:"指定なし"}
{else}指定不可
{/if}{if $suborder['methods']['send_date']}（{$suborder['methods']['send_date']}）
{/if}
配達希望時間　：{$shiptimeKeyList[$suborder['ship_time']]}
{/if}
{if $suborder['methods']['wrap_use']}
包装　　　　　：{$suborder['methods']['wrap']}

{/if}
{if $suborder['methods']['noshi_use']}
のし　　　　　：{$suborder['methods']['noshi']}{if $suborder['methods']['noshi_other']}（{$suborder['methods']['noshi_other']}）{/if}{if $suborder['methods']['noshi_name']}：{$suborder['methods']['noshi_name']}{/if}

{/if}
{if $suborder['methods']['extra']|@count}
{foreach from=$suborder['methods']['extra'] key=k item=v}
{if $v['use']}
{$v['title']}：{$v['value']}

{/if}
{/foreach}
{/if}
{/suborders}


{if $order['methods']['flag_send']}
【配送について】
配達希望日　　：{if $order['methods']['nominate']}{$order['ship_date']|default:"指定なし"}
{else}指定不可
{/if}
配達希望時間　：{$shiptimeKeyList[$order['ship_time']]}

{/if}
{/if}

{if $order_footer}
【お支払方法・その他】
{if $order['bill']}
請求書・払込用紙について：{$billList[$order['bill']]}
{if $order['bill_addressf']}
　　　　　　　　　　　　　〒{$order['bill_zipcodef']}-{$order['bill_zipcodes']} {$order['bill_pref']} {$order['bill_addressf']}{$order['bill_addresss']}{$order['bill_addresst']}
　　　　　　　　　　　　　{$order['bill_name']}
{/if}{/if}

お支払方法　　：{$paymentList[$order['payment']]}

{if $order['memo']}【備考欄】
{$order['memo']}
----------------------------------------------------------------------------
{/if}
{/if}


{regists rid=$order['regist_id']}
【注文者情報】
ユーザー登録：{$registList[$regist['status']]}
　　　お名前：{$regist['namef']} {$regist['nameg']}（{$regist['kanaf']} {$regist['kanag']}）
　組合員番号：{$regist['membership']|default:"未入力"}
　学部・学科：{if $regist['dept']}{code name=23 id=$regist['dept']}{$code['value']}{/code}
{else}未登録
{/if}

　　　現住所：{if ($regist['new_add'] !="" || $regist['new_zipcodef'] !="" || $regist['new_zipcodes'] !="" || $regist['new_pref'] !="" || $regist['new_addressf'] !="")}
{if $regist['new_add']}{$newaddList[$regist['new_add']]}
{else}
〒{$regist['new_zipcodef']|string_format:"%03d"}-{$regist['new_zipcodes']|string_format:"%04d"}

{$regist['new_pref']} {$regist['new_addressf']}
{if $regist['new_addresss']}

{$regist['new_addresss']}
{/if}
{if $regist['new_addresst']}

{$regist['new_addresst']}
{/if}
{/if}
{else}
未登録

{/if}

{if ($regist['student_phone'])}
　現住所TEL：{$regist['student_phone']}
{/if}
{if $regist['mobilephone']}
　　携帯電話：{$regist['mobilephone']}
{/if}

　　実家住所：{if ($regist['pref'] !="")}
〒{$regist['zipcodef']|string_format:"%03d"}-{$regist['zipcodes']|string_format:"%04d"}

　　　　　　　{$regist['pref']} {$regist['addressf']}
{if $regist['addresss']}

　　　　　　　{$regist['addresss']}
{/if}
{if $regist['addresst']}

　　　　　　　{$regist['addresst']}
{/if}
{else}未登録

{/if}

実家電話番号：{if ($regist['phonenumber'])}{$regist['phonenumber']}

{else}未登録

{/if}
{if $regist['birthday']}
　　生年月日：{$regist['birthday']}

{/if}

　　　メール：{$regist['email']}
{/regists}

{*
<table class="inputForm">
<col width="150">
<col width="400">
<tr><th colspan="2" class="mh">生協管理欄</th></tr>

<tr><th>支払状況</th>

{if $order['payment']==4}
<td>
{get_charged_info charged_id=$order['charged_id']}
{if $charged_errmsg}<span class="red"><i class="fa fa-exclamation-sign"></i>{$charged_errmsg}</span>{else}
<span class="tag min {$chargedColorList[{$charged_status}]}">{$chargedList[{$charged_status}]}</span>{/if}
</td>
{else}
<td id="diff{$order['id']}"><span class="tooltips" title="">{if $order['paid_difference']==0 && $order['payment_confirmed']>0}<span class="tag min navy">支払済</span>{/if}</span>

支払確認済：{$order['payment_confirmed']|number_format}／請求金額：{$order['total_price_all']|number_format}
{logs tbl='admin_log' process='payment_confirmed' sort='DESC' app_id=$order['id']}<br />{$log['date']} {$log['value']|number_format}更新

{/logs}




{if $order['paid_difference']} <span class="min tag auto_input" data="{$order['id']}" title="{$order['paid_difference']}">自動入力</span>{/if}

<br />

{if $order['paid_difference']==0}
{else}
<form id="update{$order['id']}" data="{$order['id']}" method="post" action="?mode=save_payment">
<input type="hidden" name="app_id" value="{$order['id']}" />
<input type="hidden" name="md" value="show_order" />
<input type="text" name="payment_confirmed[{$order['id']}]" class="payment_confirmed" />




<input class="min" type="submit" value="更新" />
</form>
{/if}
</td>
{/if}
</tr>


<form id="theForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_order">

<tr><th>対応状況</th>
<td>
<div class="radio-group clearfix">
{html_radios name="status" options=$statusList selected=$order['status']|default:"0" output=$statusList assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<input class="min" type="submit" value="更新" />
<div class="clear" style="margin-bottom: 0.8em;"></div>
</td></tr>
<tr><th>入金確認メール</th>
<td>{if $order["sendmail_paid_completed"]}<span class="navy tag min">送信済</span>{/if}</td></tr>
<tr><th>メモ、特記事項</th>
<td>
<textarea name="treat" id="treat" cols="10" rows="5">{$order['treat']}</textarea>

<input class="min" type="submit" value="更新" />

</td>
</tr>

<input type="hidden" name="id" value="{$order['id']}" />
</form>
</table>
*}

{/orders}
