{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
function deleteCheck() {
    return confirm('管理ユーザーを削除してもよろしいですか');
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

{assign var="page_title" value="管理ユーザーの一覧"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="alert alert-success">ユーザーを削除しました。</p>
{/if}
{if $saved}
<div id="msg" class="alert alert-success">ユーザー権限を保存しました。</div>
{/if}


<p><a class="btn btn-primary" href="{$self}?mode=edit_user"><i class="fa fa-user-plus"></i> 管理ユーザーの新規作成</a></p>

{users}
{if $user_header}
<table class="inputForm_free" cellspacing="0">
<tr>
<th class="mh">ID</th>
{foreach from=$authList key=k item=au}
{if $k!="master"}
<th class="mh vmid" style="white-space: nowrap;">{$k}</th>
{/if}
{/foreach}
<th class="mh">&nbsp;</th>
</tr>
{/if}

<td class="vmid">{if !$user['auth']['master']['master']}<a href="{$self}?mode=edit_user&uid={$user['id']}">{$user['username']}</a>{else}<span class="tag">{$user['username']}</span>{/if}
<p class="em09">{$user['email']}</p>
</td>

{foreach from=$authList key=k item=au}
{if $k!="master"}
<td class="vmid">{if $user["auth"][$k]}
{foreach from=$user["auth"][$k] key=key item=v}
{if $v}<div><i class="fa fa-check"></i>{$key}</div>{/if}
{if $key=="category_id"}{","|implode:$v}{/if}
{/foreach}
{/if}</td>
{/if}
{/foreach}

<td>
{if !$user['auth']['master']['master']}
<form method="post" action="{$self}?mode=delete_user" onsubmit="return deleteCheck();">
<input type="hidden" name="id" value="{$user['id']}" />
<input type="submit" class="btn btn-primary btn-sm" value="削除" />
</form>
{/if}
</td>
</tr>
{if $user_footer}
</table>
{/if}
{/users}

{if $no_user}
<p class="note">管理ユーザーが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">データベースの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
