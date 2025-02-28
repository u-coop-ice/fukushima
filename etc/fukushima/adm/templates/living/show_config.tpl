{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[

//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="{$init_pagetitle}の初期設定"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>

{if $saved}
<p class="note">設定を保存しました。</p>
{/if}

<table class="inputForm_free" cellspacing="0">
<col style="width:30%;" />
<col style="width:70%;" />
<tr><th class="mh" colspan="2">{$init_pagetitle}初期設定</th></tr>
<tr><th>大学生協名</th><td>{$init_coopname} {$init_coopnameE}<br />{$init_url}
</td></tr>
<tr><th>大学生協コード</th><td>{$smarty.session.config['membershipfirst4']}
</td></tr>
<tr><th>大学生協システムID</th><td>{$smarty.session.config['univ_id']}</td></tr>
<tr><th>大学名</th><td>{$init_univname}<br />{$init_univurl}</td></tr>
<tr><th>基本メールアドレス</th><td>{$smarty.session.config['email']}</td></tr>
<tr><th>Return-Path:</th><td>{$init_errormail}</td></tr>
{*<tr>
<th>カード決済の設定</th>
<td>API送信先URL：{#webpay_url#}
<br />秘密鍵：{#webpay_api#}</td>
</tr>*}
<tr><th>{$init_pagetitle}管理メールアドレス</th><td>{$smarty.session.config['component'][$smarty.const.COMPONENT]['store_ordermail']|default:"（基本メールアドレス）"}</td></tr>

<tr><th>店舗名等</th><td>{$smarty.session.config['component'][$smarty.const.COMPONENT]['store_name']}</td></tr>
<tr><th>店舗営業時間</th><td>{$smarty.session.config['component'][$smarty.const.COMPONENT]['store_time']|nl2br}</td></tr>
<tr><th>連絡先住所</th><td>{$smarty.session.config['component'][$smarty.const.COMPONENT]['store_address']|nl2br}</td></tr>
<tr><th>連絡先（TEL）</th><td>{$smarty.session.config['component'][$smarty.const.COMPONENT]['store_phonenumber']}</td></tr>
<tr><th>連絡先（FAX）</th><td>{$smarty.session.config['component'][$smarty.const.COMPONENT]['store_faxnumber']}</td></tr>

</table>
<p><a class="btn btn-primary" href="{$self}?mode=edit_config">基本設定を変更する<i class="fa fa-fw fa-chevron-right"></i></a></p>
{include file='footer.tpl'}
