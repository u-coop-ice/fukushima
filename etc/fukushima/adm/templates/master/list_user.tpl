{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('管理アカウントを削除してもよろしいですか');
}
//]]>
</script>

<style type="text/css">
#content table.inputForm_free {
	word-break: break-all;
}

#content table.inputForm_free td {
	min-width: 10%;
}
</style>
{/literal}
{/capture}

{assign var="page_title" value="管理アカウントの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-success">管理アカウントを削除しました。</p>
{/if}
{if $saved}
<div id="msg" class="alert alert-success">管理アカウントを保存しました。</div>
{/if}


<p><a class="btn btn-primary" href="{$self}?mode=edit_user"><i class="fa fa-user-plus"></i> 管理アカウントの新規作成</a></p>

{users}

{if $user_header}
<table class="inputForm_free" cellspacing="0">
<tr>
<th class="mh vmid">ID</th>
{foreach from=$authList key=k item=au}
{if $k!="master"}
<th class="mh vmid nowrap">{$k}</th>
{/if}
{/foreach}
</tr>
{/if}

<td class="vmid"><div style="white-space: nowrap;">{if $user['auth']['master'][0] < 9}<a href="{$self}?mode=edit_user&uid={$user['id']}">{$user['username']}{if $user['secret']}<i class="fa fa-shield"></i>{/if}</a>{else}<span class="tag">{$user['username']}{if $user['secret']}<i class="fa fa-shield"></i>{/if}</span>{/if}

{if $user['auth']['master'][0] < 9}
<form method="post" action="{$self}?mode=delete_user" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$user['id']}" />
<input type="submit" class="btn btn-primary btn-sm" value="削除" />
</form>
{/if}
</div>
<p class="em09">{$user['email']}</p>
</td>
{foreach from=$authList key=k item=au}
{if $k!="master"}
<td class="vmid">{if $user["auth"][$k][0]}
<div style="white-space: nowrap;"><span class="tag min {$subAuthColorList[$user["auth"][$k][0]]}">{$subAuthList[$k][$user["auth"][$k][0]]}</div>
{if is_array($user["auth"][$k]["category_id"])}{$user["auth"][$k]["category_id"]|implode:","}{/if}
{/if}
</td>
{/if}
{/foreach}
</tr>
{if $user_footer}
</table>
{/if}
{/users}

{if $no_user}
<p class="alert alert-info">管理アカウントが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">データベースの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
