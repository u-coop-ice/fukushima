

【ご注文内容】

受付No| {$regist_code}
------+----------------------------------------------------------------------
 番号 |                              商品名
      |                              単価          個数          小計
------+----------------------------------------------------------------------
{items cart=1}{get_item_info id=$item['id']}
 {$ctr|string_format:"%4d"} | 【{$itm['no']}】{$itm['name']}
{if $itm["cart"]|@count}
{foreach from=$itm["cart"] key=k item=v}
{if $v["use"]}
      | {$v["title"]}: {$item["cart{$k}"]}
{/if}
{/foreach}
{/if}
      |                        {$itm['price']|number_format|string_format:"%16s"}  {$item['num'
      ]|number_format|string_format:"%8s"}  {$item['total_price']|number_format|string_format:"%16s"}
{if $item_footer}
{if $post['reduction']}
------+----------------------------------------------------------------------
値引き|                                                {$post['reduction']|gmp_neg|number_format|string_format:"%20s"}
{/if}
{if $post['postage']}
------+----------------------------------------------------------------------
 送料 |                                                {$post['postage']|number_format|string_format:"%20s"}
{/if}
------+----------------------------------------------------------------------
 合計 |                                                {$post['total_price_all']|number_format|string_format:"%20s"}
{/if}
{/items}


{if $post['ship_from']}
※ご注文者様とは異なる発送元を指定

【発送元情報】

発送元名称　　：{$post["ship_from_name"]}（{$post["ship_from_kana"]}）
ご住所　　　　：〒{$post["ship_from_zipcodef"]|string_format:"%03d"}-{$post["ship_from_zipcodes"]|string_format:"%04d"}
　　　　　　　：{$post["ship_from_pref"]} {$post["ship_from_addressf"]}{if $post["ship_from_addresss"]} {$post["ship_from_addresss"]}
{/if}{if $post["ship_from_addresst"]}
　　　　　　　　{$post["ship_from_addresst"]}
{/if}
電話番号　　　：{$post["ship_from_phonenumber"]}
{/if} 

【お届け先について】
{if !$post['ship_flag']}
ご注文者様住所にお届け
{else if $post['ship_flag']==1}
氏名　　　　　：{$post['ship_namef']} {$post['ship_nameg']}（{$post['ship_kanaf']} {$post['ship_kanag']}）様
ご住所　　　　：〒{$post['ship_zipcodef']|string_format:"%03d"}-{$post['ship_zipcodes']|string_format:"%04d"}
　　　　　　　：{$post['ship_pref']} {$post['ship_addressf']} {$post['ship_addresss']} {$post['ship_addresst']}
電話番号　　　：{$post['ship_phonenumber']}
{if $flag_drink && $post['ship_age']}
年齢　　　　　：{$ageCheckList[$post['ship_age']]}
{/if}
{else if $post['ship_flag']==2}
受け取り店舗　：{$post['store']}
{/if}

{if $post['ship_flag']<2}

{if !$init_category['flag_send']}配送について{else}配送オプション{/if}

{items cart=1}{get_item_info id=$item['id']}
{if !$init_category['flag_send']}
【{$itm['no']}】{$itm['name']} × {$item['num']}
{else if $itm['wrap_use'] || $itm['noshi_use'] || $itm['extra']|@count}
【{$itm['no']}】{$itm['name']} × {$item['num']}
{/if}
-----------------------------------------------------------------------------
{if !$init_category['flag_send']}
配達希望日　　：{if $itm['nominate']}{$item['ship_date']|default:"指定なし"}{else}指定不可{/if}{if $itm['send_date']}（{$itm['send_date']}）{/if}

配達希望時間　：{$shiptimeKeyList[$item['ship_time']]}
{/if}

{if {$itm["wrap_use"]}}
包装　　　　　：{$item["wrap"]}
{/if}
{if {$itm['noshi_use']}}
のし　　　　　：{$item['noshi']}{if $item['noshi_other']}（{$item['noshi_other']}）{/if}{if $item['noshi_name']}：{$item['noshi_name']}{/if}

{/if}
{if $itm["extra"]|@count}
{foreach from=$itm["extra"] key=k item=v}
{if $v["use"]}
{$v["title"]}：{$item["extra{$k}"]}

{/if}
{/foreach}{/if}

{/items}
{if $init_category['flag_send']}{get_category_info}
【配送について】

配達希望日　　：{if $init_category['nominate']}{$post['ship_date']|default:"指定なし"}
{else}指定不可
{/if}{if $init_category['send_date']}（{$init_category['send_date']}）
{/if}
配達希望時間　：{$shiptimeKeyList[$post['ship_time']]}
{/if}
{/if}

----------------------------------------------------------------------------

【お支払方法・その他】
お支払方法　　：{$paymentList[$post['payment']]}{if $post['jpo']}（{$paymentJpoList[$post['jpo']]}）
{/if}
{if $paymentTypeList[$post['payment']]==0}
{if $post['bill']}
請求書払込用紙：{$billList[$post['bill']]}
{if $post['bill_addressf']}
　　　　　　　　〒{$post['bill_zipcodef']}-{$post['bill_zipcodes']} {$post['bill_pref']} {$post['bill_addressf']}{$post['bill_addresss']}{$post['bill_addresst']}
　　　　　　　　{$post['bill_name']}
{/if}
{/if}
{/if}

----------------------------------------------------------------------------

【備考欄】
{$post['memo']}

----------------------------------------------------------------------------
