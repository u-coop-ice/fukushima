{get_entry_category_info component=$app['component'] category_id=$app['category_id']}
<div class="contact">
<h5 class="top">{$category['denomination']}</h5>
<div>{$category['description']|nl2br}</div>
</div>


<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">お申込み情報</th></tr>
{foreach from=$method key=f item=v}

{if strpos($f, 'extra') !== false }

{include file="app_extra.tpl"}

{else}
{if $app['fields']['app'][$f]}
{include file="app_$f.tpl"}
{/if}
{/if}
{/foreach}
</table>

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">基本情報（最新の情報になります）</th></tr>

{foreach from=$method key=f item=v}

{if $app['fields']['regist'][$f]}
{include file="regist_$f.tpl"}
{/if}

{/foreach}

</table>

{if $app["component"]}

{if $category['oncancel'] && !$app['cancelled']}

{if $category['date_limit_cancel']}
{if $category['date_limit_cancel'] > $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
<div class="contact">
<form id="theForm" action="{$self}?mode=cancel_app" method="post" enctype="x-www-form-urlencoded" onsubmit="return cancelCheck();">
<p><button class="submit btn btn-primary" type="submit" name="cancel" value="お申込をキャンセルする（この操作は取り消せません）">お申込をキャンセルする（この操作は取り消せません）</button></p>
<input type="hidden" name="app_code" value="{$app['code']}" />
</form>
<p class="pad_l">お申込みを変更される場合は、お手数ですが、このお申込みをキャンセル後、再度お申込みください。</p>
</div>
{else}
<p class="alert alert-info">WEBからのキャンセルは締め切りました</p>
{/if}
{/if}

{/if}

{/if}
