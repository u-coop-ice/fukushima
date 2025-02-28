{orders}
【ご注文内容】
-----------------------------------------------------------------------------
受付No| {if $regist_code}{$regist_code}
{else}{$order['category_infocode']}:{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
{/if}
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
※ご注文者と異なる
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

{else if $regist['namef']}
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
のし　　　　　：{$suborder['methods']['noshi']}{if $suborder['methods']['noshi_other']}（{$suborder['methods']['noshi_other']}）{/if}

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

【お支払方法・その他】
お支払方法　　：{$paymentList[$order['payment']]}{if $order['jpo']}（{$paymentJpoList[$order['jpo']]}）
{/if}

{if $order['memo']}【備考欄】
{$order['memo']}
{/if}
{/orders}
