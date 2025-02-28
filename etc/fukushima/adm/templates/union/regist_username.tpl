

<tr>
<th>アカウント</th><td>{$regist['username']}{if $regist['status']==-9}<span class="tag min gray">非登録</span>{else if $app['regist_status']==9}<span class="tag black min">退会</span>{else}
{if $regist['send_error']}<span class="tag black min">送信エラー</span>{/if}


<form class="mailForm" method="post" action="{$init_url}adm/ask/?mode=edit_mail">
<input type="hidden" name="regist_id" value="{$regist['id']}" />

{if $app['id']}
<input type="hidden" name="app_id" value="{$app['id']}" />
{/if}

<button type="submit" name="edit_mail" class="btn btn-primary" value="{if $app['id']}このお申込みに紐づいた{/if}システムメールの作成"><i class="fa fa-fw fa-edit"></i>{if $app['id']}このお申込みに紐づいた{/if}システムメールの作成</button>
</form>



{/if}</td>
</tr>
<tr><th>最終更新日</th><td>{$regist['date']}</td></tr>
<tr><th>登録日</th><td>{$regist['regist_date']}</td></tr>
