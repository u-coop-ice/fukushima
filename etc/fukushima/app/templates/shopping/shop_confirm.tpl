{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="two-column"}

{capture assign="header_insert"}
{literal}

<script type="text/javascript">
//<![CDATA[
$(function () {
	$('#theForm').submit(function(){
	if(window.confirm('お申込み内容を送信してよろしいですか? \nこの操作は取り消せません。')){
		$(this).find(':submit').button('loading');
	} else {
		return false;
	}
	});
});
//]]>
</script>

{/literal}
{/capture}



{include file='header.tpl'}

<!-- STEPS -->
<table class="steps">
<tr>
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="cleared"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
<td class="cleared"><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td class="cleared"><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td class="now"><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td><span class="number">6</span><span class="hidden-xs description">ご注文完了</span></td>
</tr>
</table>

<div class="center em08">＊完了画面まで進みませんと注文が完了しません。ご注意ください。</div>
<!-- /STEPS -->


{* 商品一覧 開始 *}
{include file='cart_table.tpl'}


{* 顧客情報 開始 *}
<h3 class="header">ご注文者様の情報</h3>
{if $login}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{*if $getAuthdata_member_name}
{include file="regist_member_name.tpl"}
{else}
{include file="conf_member_name.tpl"}
{/if*}
{include file="regist_name.tpl"}
{include file="regist_email.tpl"}

{if $getAuthdata_new_add}
{include file="regist_new_add.tpl"}
{include file="regist_student_phone.tpl"}
{include file="regist_mobilephone.tpl"}
{else if $getAuthdata_address}
{include file="regist_address.tpl"}
{include file="regist_phonenumber.tpl"}
{else}
{include file="conf_address.tpl"}
{include file="conf_phonenumber.tpl"}
{/if}


{if $methods['age']['use']}
<tr>
<th>生年月日</th>
<td>{if $regist['birthday']}{$regist['birthday']}{else}{$post["birthday"]}{/if}</td>
</tr>
{/if}
</table>

{else}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />

{*include file="conf_member_name.tpl"*}
<tr>
<th>お名前</th>
<td>{$post["namef"]} {$post["nameg"]}</td>
</tr>
{if $post["membership1"]}
<tr>
<th>組合員番号</th>
<td>{$post["membership1"]}-{$post["membership2"]}-{$post["membership3"]}</td>
</tr>
{/if}
<tr>
<th>E-mail</th>
<td>{$post["email"]}</td>
</tr>
<tr>
<th>住所</th>
<td>〒{$post["zipcodef"]|string_format:"%03d"}-{$post["zipcodes"]|string_format:"%04d"}<br />{$post["pref"]} {$post["addressf"]} {$post["addresss"]}{$post["addresst"]}</td>
</tr>
<tr>
<th>電話番号</th>
<td>{$post["phonenumber"]}</td>
</tr>
{if $methods['age']['use']}
<tr>
<th>生年月日</th>
<td>{$post["birthday"]}</td>
</tr>
{/if}
</table>
{/if}


{if $post['ship_from']}

<h3 class="header">発送元情報</h3>

<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>発送元名称</th>
<td>{$post["ship_from_name"]}（{$post["ship_from_kana"]}）</td>
</tr>
<tr>
<th>発送元住所</th>
<td>〒{$post["ship_from_zipcodef"]|string_format:"%03d"}-{$post["ship_from_zipcodes"]|string_format:"%04d"}<br />{$post["ship_from_pref"]} {$post["ship_from_addressf"]}{if $post["ship_from_addresss"]} {$post["ship_from_addresss"]}{/if}{if $post["ship_from_addresst"]}<br />{$post["ship_from_addresst"]}{/if}
</td>
</tr>
<tr>
<th>発送元電話番号</th>
<td>{$post["ship_from_phonenumber"]}</td>
</tr>
</table>


{/if} 



<h3 class="header">お届け先情報</h3>
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
{if !$post["ship_flag"]}
<tr><th>お届け先について</th>
<td class="prc">ご注文者様住所にお届け</td></tr>
{else if $post["ship_flag"]==1}


{if $post['ship_address']}
{addresses regist_id=$regist['id'] id=$post['ship_address']}

<tr><th>氏名</th>
<td>{$address["ship_namef"]} {$address["ship_nameg"]}（{$address["ship_kanaf"]} {$address["ship_kanag"]}）様</td></tr>

<tr><th>ご住所</th>
<td>〒{$address["ship_zipcodef"]|string_format:"%03d"}-{$address["ship_zipcodes"]|string_format:"%04d"}<br />
{$address["ship_pref"]} {$address["ship_addressf"]}{if $address["ship_addresss"]} {$address["ship_addresss"]}{/if}
{if $address["ship_addresst"]}<br />{$address["ship_addresst"]}{/if}
</td></tr>


<tr><th>電話番号（携帯可）</th>
<td>{$address["ship_phonenumber"]}</td></tr>

{if $methods['age']['use']}
<tr>
<th>年齢</th>
<td>{if $address["ship_age"]}{$ageCheckList[$address["ship_age"]]}{else}{$ageCheckList[$post['ship_age']]}{/if}</td>
</tr>
{/if}



{/addresses}
{else}


<tr><th>氏名</th>
<td>{$post["ship_namef"]} {$post["ship_nameg"]}（{$post["ship_kanaf"]} {$post["ship_kanag"]}）様</td></tr>

<tr><th>ご住所</th>
<td>〒{$post["ship_zipcodef"]|string_format:"%03d"}-{$post["ship_zipcodes"]|string_format:"%04d"}<br />
{$post["ship_pref"]} {$post["ship_addressf"]} {$post["ship_addresss"]}
{if $post["ship_addresst"]}{$post["ship_addresst"]}{/if}
</td></tr>
<tr><th>電話番号（携帯可）</th>
<td>{$post["ship_phonenumber"]}</td></tr>
{if $methods['age']['use']}
<tr>
<th>年齢</th>
<td>{$ageCheckList[$post['ship_age']]}</td>
</tr>
{/if}

{/if}
{else if $post["ship_flag"]==2}
<tr><th>受け取り店舗</th>
<td>{$post["store"]}</td></tr>
{/if}
</table>

<form id="" method="post" action="{$self}?mode=buy_confirm">
<button class="btn btn-primary" name="reinput1" type="submit" value="戻って修正"><i class="fa fa-fw fa-chevron-left"></i>戻って修正</button>
</form>



{if $post['ship_flag']<2}
<h3>{if !$init_category['flag_send']}配送について{else}配送オプション{/if}</h3>
{items cart=1}
{get_item_info id=$item["id"]}
{if !$init_category['flag_send']}
<h5>【{$itm['no']}】{$itm['name']} × {$item['num']}</h5>
{else if $itm['wrap_use'] || $itm['noshi_use'] || $itm['extra']|@count}
<h5>【{$itm['no']}】{$itm['name']} × {$item['num']}</h5>
{/if}
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />

{if !$init_category['flag_send']}
<tr>
<th>配送希望日</th>
<td>
{if $itm["nominate"]}{$item["ship_date"]|default:"指定なし"}{else}指定不可{/if}{if $itm["send_date"]}（{$itm["send_date"]}）{/if}
</td>
</tr>
<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$item["ship_time"]]}
</td>
</tr>
{/if}

{if {$itm["wrap_use"]}}
<tr><th>包装</th>
<td>
{$item["wrap"]}
</td>
</tr>
{/if}
{if $itm["noshi_use"]}
<tr><th>のし</th>
<td>
{$item["noshi"]}{if $item["noshi_other"]}（{$item["noshi_other"]}）{/if}{if $item['noshi_name']}：{$item['noshi_name']}{/if}
</td>
</tr>
{/if}

{if $itm["extra"]|@count}
{foreach from=$itm["extra"] key=k item=v}
{if $v["use"]}
<tr><th class="vtop">
{$v["title"]}</th>
<td>
{$item["extra{$k}"]}
</td>
{/if}
{/foreach}
{/if}
</table>
{/items}

{if $init_category['flag_send']}
{get_category_info}
<h3>配送について</h3>

<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>配達希望日</th>
<td>
{if $init_category['nominate']}{$post["ship_date"]|default:"指定なし"}{else}指定不可{/if}{if $init_category['send_date']}（{$init_category['send_date']}）{/if}
</td>
</tr>
<tr><th>時間指定</th>
<td>
{$shiptimeKeyList[$post["ship_time"]]}
</td>
</tr>
</table>
{/if}


<form id="" method="post" action="{$self}?mode=buy_confirm">
<button class="btn btn-primary" name="reinput2" type="submit" value="戻って修正"><i class="fa fa-fw fa-chevron-left"></i>戻って修正</button>
</form>
{/if}

<h3>お支払い方法・その他</h3>
<table class="inputForm">
<col style="width:20%" />
<col style="width:80%" />
<tr>
<th>お支払い方法</th>
<td>{$paymentList[$post["payment"]]}
</td><tr>

{if $post['payment']==4 || $post['payment']==5}
<tr><td colspan="2">
<div class="contact gray">
<h5 class="top">クレジットカード情報</h5>
{if $post['payment']==4}
{if $login}
{if $post['card_id'] && !$post["token_id"]}
{get_card_info_payjp card_id=$post["card_id"] cust_id=$regist["cust_id"]}
{if !$card_errmsg}
<p>カード種別：{$card->brand}<br />
カード番号：xxxx-xxxx-xxxx-{$card->last4}<br />
　有効期限：{$card->exp_month|string_format:"%02d"}/{$card->exp_year}<br />
　　名義人：{$card->name}</p>
{else}
<p class="red"><i class="icon-exclamation-sign"></i> {$card_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
{/if}
{/if}
{/if}

{if $post['payjp-token']}
{get_token_info_payjp token_id=$post['payjp-token']}
{if !$token_errmsg}
<p>カード種別：{$token->brand}<br />
カード番号：xxxx-xxxx-xxxx-{$token->last4}<br />
　有効期限：{$token->exp_month|string_format:"%02d"}/{$token->exp_year}<br />
　　名義人：{$token->name}</p>
{else}
<p class="red"><i class="fa fa-exclamation-sign"></i> {$token_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
{/if}
{/if}
{if $post["regist_card"]}
<p class="alert alert-info">今回使用したクレジットカードをユーザー情報に登録する。</p>
{/if}

{if $wc_errmsg}<span class="red"><i class="fa fa-exclamation-triangle"></i>{$wc_errmsg}</span>{/if}

{else if $post_payment=5}
{if $post['req_card_number']}
<p>カード番号：{$post['req_card_number']}
{if $post['jpo']}<br />　支払種別：{$paymentJpoList[$post['jpo']]}{/if}
{if $post["regist_card"]}
<p class="alert alert-info">今回使用したクレジットカードをユーザー情報に登録する。</p>
{/if}
</p>
{else}
<p>カード番号：{$post['regist_card_number']}
{if $post['jpo']}<br />　支払種別：{$paymentJpoList[$post['jpo']]}{/if}
</p>
{/if}
{/if}

</div>

</td></tr>
{/if}

{if $paymentTypeList[$post['payment']]==0}
{if $post['bill']}
<tr><th>請求書・払込用紙について</th>
<td>{$billList[$post['bill']]}
{if $post['bill_addressf']}
<p>〒{$post['bill_zipcodef']}-{$post['bill_zipcodes']} {$post['bill_pref']} {$post['bill_addressf']}{$post['bill_addresss']}{$post['bill_addresst']}<br />{$post['bill_name']}</p>
{/if}

</td>
</tr>
{/if}
{/if}

<th>備考欄</th>
<td>
{$post["memo"]|nl2br}
</td>
</tr>
</table>

<form id="" method="post" action="{$self}?mode=buy_confirm">
<button class="btn btn-primary" name="reinput3" type="submit" value="戻って修正"><i class="fa fa-fw fa-chevron-left"></i>戻って修正</button>
</form>

{if ($post['payment']==4 && !$wc_errmsg) || $post['payment']!=4}
<form id="theForm" method="post" action="{$self}?mode=buy_end">

<div class="box center">
<p><strong class="red">以上の内容でよろしければ、下のボタンをクリックしてください</strong></p>
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<button class="btn btn-success btn-block" name="regist" type="submit" value="入力内容を送信し、注文を確定する" data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i>ご注文情報を送信しています" autocomplete="off"><i class="fa fa-check fa-fw"></i>入力内容を送信し、注文を確定する</button>
</div></div>
<p><strong class="em09 blue">お客様の通信環境その他の要因により、画面切り替わりまでしばらく時間がかかることがあります。</strong></p>
</div>
</form>
{/if}
{* 顧客情報 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
