{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

<script type="text/javascript">
//<[!CDATA[
$(document).on("pageshow", "#wrapper", function () {
	$("#theForm").submit(function(){
		return remove_accountCheck();
	});

function remove_accountCheck() {
	if (!confirm('退会処理を完了してよろしいですか？\nこの操作は取り消せません。')) {
		return false;
	}
}

});

//]]>
</script>

{/literal}
{/capture}




{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}登録内容の確認{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 登録内容表示 開始 *}

{if $changed_email}
<p class="alert alert-success">メールアドレス（ユーザーアカウント）を変更しました。</p>
{/if}


<h4 class="page_title">
{if $regist['namef']}{$regist['namef']} {$regist['nameg']}{else}{$regist['username']}{/if} さま</h4>

{if $saved}
<p class="alert alert-success">変更を保存しました。</p>
{/if}

<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">登録基本情報</th></tr>
<tr><th>ユーザー名</th>
<td><span class="prc">{$regist['username']}</span><div><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_password"><i class="fa fa-fw fa-key"></i>パスワード変更</a></div></td></tr>
<tr><th>最終更新日</th><td>{$regist['date']}</td></tr>
<tr><th>登録日</th><td>{$regist['regist_date']}</td></tr>
</table>


<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">大学・所属</th></tr>
{*include file='regist_year.tpl'*}
{include file='regist_univ.tpl'}
{*include file='regist_exam.tpl'*}
{include file='regist_dept.tpl'}
{*include file='regist_examnumber.tpl'*}

<tr><th class="mh" colspan="2">主に生協との連絡に使用するE-mailアドレス</th></tr>
<tr>
<th>E-mail</th>
<td>{$regist['email']}
{if $regist['send_error']}<p class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> 生協からのメールが届いていません。メールアドレスの変更または、メール受信設定の見直しを行って下さい。</p>{/if}

<div><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_email"><i class="fa fa-fw fa-edit"></i>メールアドレス変更</a></div></td>
</tr>


{include file='regist_partition1.tpl'}
{include file='regist_name.tpl'}
{include file='regist_membership.tpl'}
{include file='regist_sex.tpl'}
{include file='regist_age.tpl'}
{include file='regist_student_email.tpl'}
{include file='regist_student_email_mobile.tpl'}
{include file='regist_new_add.tpl'}
{include file='regist_student_phone.tpl'}
{include file='regist_mobilephone.tpl'}
{include file='regist_partition2.tpl'}
{include file='regist_address.tpl'}
{include file='regist_phonenumber.tpl'}

{if ($regist['parent_namef'])}
{include file='regist_partition2.tpl'}
{include file='regist_parent_name.tpl'}
{include file='regist_parent_sex.tpl'}
{include file='regist_parent_email.tpl'}
{include file='regist_parent_email_mobile.tpl'}
{include file='regist_parent_mobile.tpl'}
{include file='regist_parent_com.tpl'}
{include file='regist_parent_com_phone.tpl'}
{/if}

</td></tr>
<tr><th class="mh" colspan="2">メール配信</th></tr>
<tr><th>生協からのニュースレーター・お知らせ</th><td>{$dmList[$regist['dm']|default:0]}
	<span><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_subscribe_mail"><i class="fa fa-fw fa-envelope-o"></i> 配信設定の変更</a></span>
<p class="help-block"><i class="fa fa-info-circle"></i>{$init_coopname}が配信しているメールマガジン・生協からのお知らせの配信設定の変更が行えます。※各種お申込み・各種講座の登録などに関連したお知らせメールは含みません。</p>

</td></tr>


<tr><th class="mh" colspan="2">クレジットカード</th></tr>
<tr><th>登録済みクレジットカード</th>
<td>
{*if $regist['cust_id']}
{get_customer_info_payjp cust_id=$regist['cust_id']}
{if !$cust_errmsg}
{foreach from=$cards item=card}
<div class="contact gray">
　カード種別：{$card->brand}<br />
　カード番号：xxxx-xxxx-xxxx-{$card->last4}&nbsp;&nbsp;{$card->exp_month|string_format:"%02d"}/{$card->exp_year}<br />
　　　名義人：{$card->name}
</div>
{foreachelse}
<p class="alert alert-info">カードが見つかりません。</p>
{/foreach}

<div><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_creditcard"><i class="fa fa-fw fa-credit-card"></i>カードを編集</a></div>
{else}
<p class="red"><i class="fa fa-exclamation-triangle"></i> {$cust_errmsg} クレジットカード情報をもう一度登録しなおしてください。</p>
<div><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_creditcard"><i class="fa fa-fw fa-credit-card"></i>カードを登録</a></div>
{/if}
{else}
クレジットカードの登録はありません。
<span><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_creditcard"><i class="fa fa-fw fa-credit-card"></i>カードを登録</a></span>
{/if*}
{if $regist['cust_id_veritrans']}
{get_customer_info_veritrans cust_id=$regist['cust_id_veritrans']}
{foreach from=$cardList item=card}
<div class="contact gray">
<p class="form-control-statics">
カード番号：{$card[1]}</p>
</div>
{foreachelse}
<p class="alert alert-info">カードの登録が見つかりません。</p>
{/foreach}
<div><a class="btn btn-primary btn-sm" href="{$self}?mode=edit_creditcard"><i class="fa fa-fw fa-credit-card"></i>カードを編集</a></div>

{/if}
</td></tr>
</table>

<p><a class="btn btn-primary" href="{$self}?mode=edit_regist"><i class="fa fa-fw fa-edit"></i>登録内容を追加・編集する</a></p>
<p><a class="btn btn-primary" href="{$self}"><i class="fa fa-fw fa-reply"></i>ユーザーページに戻る</a></p>

<p class="right em09"><a class="" href="{$self}?mode=remove_account">アカウントを削除し退会する</a></p>
<br />
<div class="clear"></div>


{* 記事編集フォーム 終了 *}

{* ユーザーが見つからなかった場合の出力等 開始 *}
{if $no_regist}
<p class="note">登録データが見当たりません。</p>
{/if}
{if $db_error}
<p class="error">ユーザーの読み込みに失敗しました。</p>
{/if}
{* ユーザーが見つからなかった場合の出力等 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
