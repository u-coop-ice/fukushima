{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[

//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="{$init_pagetitle}の初期設定編集"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>

{if $saved}
<p class="alert alert-success">設定を保存しました。</p>
{/if}

<form method="post" action="{$self}?mode=save_config">
<table class="inputForm_free" cellspacing="0">
<col style="width:30%;" />
<col style="width:70%;" />
<tr><th class="mh" colspan="2">{$init_pagetitle}の初期設定</th></tr>
<tr><th>大学生協名</th><td>{$init_coopname} {$init_coopnameE}<br />{$init_url}
</td></tr>
<tr><th>大学生協コード</th><td>{$smarty.session.config['membershipfirst4']}
</td></tr>
<tr><th>大学生協システムID</th><td>{$smarty.session.config['univ_id']}</td></tr>
<tr><th>大学名</th><td>{$init_univname}<br />{$init_univurl}</td></tr>
<tr><th>基本メールアドレス</th><td>{$smarty.session.config['email']}</td></tr>
<tr><th>Return-Path:</th><td>{$init_errormail}</td></tr>

<tr><th>{$init_pagetitle}管理メールアドレス</th><td><input class="form-control" type="text" name="store_ordermail" id="store_ordermail" value="{$component[$smarty.const.COMPONENT]['store_ordermail']}
" placeholder="（{$init_pagetitle}管理用メールアドレス）"></td></tr>

<tr><th>店舗名等</th><td><input class="form-control" type="text" id="store_name" name="store_name" value="{$component[$smarty.const.COMPONENT]['store_name']}
" placeholder="（本部 ○○○係）"></td></tr>
<tr><th>店舗営業時間</th><td><textarea class="form-control" name="store_time">{$component[$smarty.const.COMPONENT]['store_time']}</textarea>
</td></tr>
<tr><th>連絡先住所</th><td><textarea class="form-control" name="store_address">{$component[$smarty.const.COMPONENT]['store_address']}</textarea>
</td></tr>
<tr><th>連絡先（TEL）</th><td><input class="form-control" type="tel" name="store_phonenumber" value="{$component[$smarty.const.COMPONENT]['store_phonenumber']}
" placeholder=""></td></tr>
<tr><th>連絡先（FAX）</th><td><input class="form-control" type="tel" name="store_faxnumber" value="{$component[$smarty.const.COMPONENT]['store_faxnumber']}
" placeholder=""></td></tr>



</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存する"><i class="fa fa-fw fa-check"></i>保存する</button></p>

</form>


{include file='footer.tpl'}
