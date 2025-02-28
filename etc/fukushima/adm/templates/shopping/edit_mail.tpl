{* ヘッダー部分の組み込み *}
{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript">
$(function(){
$("#formID").validationEngine();
});
</script>

<script type="text/javascript">
$(function(){

	$("[name=test]").on('click',function(){

if($("#mail_subject").val()=='' || $("#mail_body").val()==''){
	$("#formID").submit();
	return false;
}

if($("#mail_body").val().match(/ここに本文を書いてください。/)){
		alert('メール本文が未編集です!!');
	return false;
}


	var json =$("#formID").serializeArray();
	json.push({name: "test", value: 1});
	sendMail(json);
		alert('テスト送信を行いました。');
		return false;
	});

	$("[name=send]").on('click',function(){

if($("#mail_subject").val()=='' || $("#mail_body").val()==''){
	$("#formID").submit();
	return false;
}

if($("#mail_body").val().match(/ここに本文を書いてください。/)){
		alert('メール本文が未編集です!!');
	return false;
}


	var json =$("#formID").serializeArray();
	json.push({name: "send", value: 1});
	var conf = confirm('申込者さまにメールを送信します。この操作は取り消せません。');
	if (conf){
	sendMail(json);
	alert('申込者さまに送信が完了しました。');
	parent.$.fancybox.close();
	return false;
	} else {
	return false;
	}
	});
});

function sendMail(e){
	$.ajax({
	url:"./admin.php?mode=save_mail",
	type:"post",
	data:e,
	cache	: false,
	async: false,
	beforeSend: function(){
	$.fancybox.showActivity();
	},
	success: function(){
	$.fancybox.hideActivity();
		},
	error: function(){
	$.fancybox.hideActivity();
		alert('送信エラー');
		}
	});
}
</script>

<style type="text/css">
#mail_body {
	height: 40em;
	font-family: Osaka-Mono;
}
</style>

{/literal}
{/capture}

{include file='preview_header.tpl'}

{* 商品情報 開始 *}

<h4>登録ユーザー宛メールの作成・編集</h4>

<form id="formID" method="post" enctype="multipart/form-data" action="">
{orders}
{if $order_header}
<table class="inputForm" cellspacing="0">
<col style="width:30%;" />
<col style="width:70%;" />
{/if}
<tr>
<th>件名</th>
<td>
{if $view_root_id || $view_add_id}
<input type="text" id="mail_subject" name="mail_subject" value="{if $post_mail_subject}{$post_mail_subject}{else}Re{if $ct}({math equation="x + 1" x=$ct}){/if}: {adds}{$add_subject|regex_replace:"/[^Re(?\d+)?\: ]/":""}{/adds}{/if}" />
{else}
<input type="text" id="mail_subject" name="mail_subject" value="{if $post_mail_subject}{$post_mail_subject}{/if}" class="validate[required]" />
+【{$coopname}】
{/if}
</td>
</tr>
<tr>
<th><label for="email">宛先</label></th>
<td>{$order_cust_email}（{$order_cust_namef} {$order_cust_nameg}）
<input type="hidden" name="email" value="{$order_cust_email}" />
</td>
<tr>
<tr>
<th><label for="bcc">Bcc</label></th>
<td><input type="text" id="bcc" name="bcc" value="{$post_bcc}" class="validate[custom[email]]" /></td>
<tr>
<th>本文<br /><span class="em09">【送信専用】以下定型文が入ります。</span></th>
<td><textarea id="mail_body" name="mail_body" class="validate[required]">
{if $post['mail_body']}{$post['mail_body']}{else}
{$order['regist_namef']} {$order['regist_nameg']}様

ご利用ありがとうございます。{$init_coopname}でございます。
下記の通りご案内差し上げます。

【ご注文内容】

受付No| {$infocode}:{$order['regist_date']|date_format:"Ymd"}-{$order['app_count']|string_format:"%04d"}
------+----------------------------------------------------------------------
 番号 | 商品名
      |                              単価          個数          小計
------+----------------------------------------------------------------------
{suborders}
 {$ctr_suborder|string_format:"%4d"} | 【{$suborder['no']}】{$suborder['name']}
      |                        {$suborder['price']|number_format|string_format:"%16s"}  {$suborder['num']|number_format|string_format:"%8s"}  {$suborder['total_price']|number_format|string_format:"%16s"}
{/suborders}
{if $postage}
------+----------------------------------------------------------------------
 送料 |                                                {$postage|number_format|string_format:"%20s"}
{/if}
------+----------------------------------------------------------------------
 合計 |                                                {$total_price|number_format|string_format:"%20s"}

{*※上記の金額には送料を含んでおりません、送料を含んだ合計金額をこちらからご連絡いたします。*}

{if !$order['ship_flag']}
ご注文者さま住所にお届け
{else if $order['ship_flag']==1}
氏名　　　　　：{$order['ship_namef']} {$order['ship_nameg']}（{$order['ship_kanaf']} {$order['ship_kanag']}）様
ご住所　　　　：〒{$order['ship_zipcodef']|string_format:"%03d"}-{$order['ship_zipcodes']|string_format:"%04d"}
　　　　　　　：{$order['ship_pref']} {$order['ship_addressf']} {$order['ship_addresss']}{if $order['ship_addresst']} {$order['ship_addresst']}
{/if}
電話番号　　　：{$order['ship_phonenumber']}

{else if $order['ship_flag']==2}
受け取り店舗　：{$order['store']}
{/if}

{if $order['ship_flag']<2}

【配送について】

{suborders}
【{$suborder['no']}】{$suborder['name']} × {$suborder['num']}
-----------------------------------------------------------------------------
配達希望日　　：{if $suborder['nominate']}{$suborder['shipdate']|default:"指定なし"}
{else}指定不可
{/if}{if $suborder['send_date']}（{$suborder['send_date']}）
{/if}
配達希望時間　：{$suborder['ship_time']}
{if {$suborder['noshi']}}
のし　　　　　：{$suborder['noshi']}{if $suborder['noshi_other']}（{$suborder['noshi_other']}）{/if}

{/if}
{if $suborder['extra1_title']}

【オプション その他】

{$suborder['extra1_title']|string_format:"%14s"}：{$suborder['extra1']}
{/if}
{if $suborder['extra2_title']}
{$suborder['extra2_title']|mb_truncate:14}：{$suborder['extra2']}
{/if}
{if $suborder['extra3_title']}
{$suborder['extra3_title']|mb_truncate:14}：{$suborder['extra3']}
{/if}
{/suborders}
{/if}

{if $order_footer}
【お支払方法・その他】
お支払方法　　：{$paymentList[$order['payment']]}

{if $order['return_message']}
{$order['return_message']}
{/if}

【備考欄】
{$order['memo']}


{/if}
</textarea>
<p>【送信専用】当メールは送信専用ですので、当メールには返信できません。<br />
<br />
このメールに関する返信・お問い合わせは以下URL<br />
https://www.u-coop.or.jp/tohoku-bf/info/?to=yamagata
<br />
より行ってください。<br />
<br />
----------------------------------------------------------------------------<br />
{$coopname} </p>
{/if}
{/orders}
</td>
</tr>

</table>

<p class="center">
<input type="submit" name="test" value="テスト送信" />&nbsp;&nbsp;
<input type="submit" name="send" value="申込者へ送信（この操作は取り消せません）" /><br />
テストメールは{$ordermail}に送信されます。
</p>

{if $view_order_id}
<input type="hidden" name="order_id" value="{$view_order_id}" />
{/if}
{if $view_root_id}
<input type="hidden" name="root_id" value="{$view_root_id}" />
{/if}
{if $view_add_id}
<input type="hidden" name="add_id" value="{$view_add_id}" />
{/if}
<input type="hidden" name="customer_id" value="{$view_customer_id}" />
</form>


{if $db_error}
<p>データベースからデータを読み込むのに失敗しました。</p>
{/if}

{* フッター部分の組み込み *}
{include file='preview_footer.tpl'}
