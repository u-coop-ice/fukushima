{$init_coopname}
ユーザーの退会がありました。
入力内容をご確認ください。

-----------------------------------------------------------------------------
[名前] {if $entry_namef}{$entry_namef} {$entry_nameg}
{else}{$auth_username}
{/if}
----------------
[理由]
{$reasonList[$post['reason']]}

{$post['reason_memo']}


以上になります。
