{get_init_category_info component=$app['component'] part=$app['part']}
<h4>{$init_category['denomination']}</h4>

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">お申込み情報</th></tr>
<tr><th>{$init_category['comedate_title']}</th><td>{$app['comedate']}</td></tr>
<tr><th>{$init_category['cometime_title']}</th><td>{$app['cometime']}</td></tr>
{if $app['part']=="tour"}
<tr><th>代金受領番号</th><td>{$post['account']|default:"入力なし"}</td></tr>
{/if}

{foreach from=$method key=f item=v}

{if strpos($f, 'extra') !== false }

{include file="app_extra.tpl"}

{else}
{if $notes[4][$f]}
{include file="app_$f.tpl"}
{/if}
{/if}
{/foreach}
</table>

{if $app['part']=="tour"}
<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">下見希望物件</th></tr>
{assign var='view_order_id' value=$app['id']}
{suborders}
<tr><th>第{$suborder['num']}希望</th><td>【{$suborder['no']}】{$suborder['name']}</td></tr>

{/suborders}

</table>
{/if}

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">基本情報（最新の情報になります）</th></tr>

{foreach from=$method key=f item=v}

{if $notes[2][$f] || $notes[3][$f]}
{include file="regist_$f.tpl"}
{/if}

{/foreach}

</table>

{if $init_category['oncancel'] && !$app['cancelled']}

{if $init_category['date_limit_cancel']}
{if $app['comedate']|strtotime - $init_category['date_limit_cancel']*60*60 > $smarty.now}
<div class="contact">
<form id="theForm" action="{$self}?mode=cancel_app" method="post" enctype="x-www-form-urlencoded" onsubmit="return cancelCheck();">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<p>
<button class="submit btn btn-primary btn-block" type="submit" name="cancel" value="お申込をキャンセルする（この操作は取り消せません）">お申込をキャンセルする<br class="visible-xs-block">（この操作は取り消せません）</button></p>
</div>
</div>
<input type="hidden" name="app_id" value="{$app['id']}" />
</form>
<p class="pad_l">お申込みを変更される場合は、お手数ですが、このお申込みをキャンセル後、再度お申込みください。</p>
</div>
{else}
<p class="alert alert-info">WEBからのキャンセルは締め切りました</p>
{/if}
{/if}
{/if}
