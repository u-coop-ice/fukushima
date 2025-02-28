{$init_coopname}
問い合わせフォームからの送信です。

入力内容をご確認ください。

----------------
[名前] {if $name}{$name}
{/if}
[mail] {$email}
----------------
{$post['subject']}
----------------
{if $post['target']}
[対象物件]{$post['target']}
{/if}
[内容]
{if $post['purpose']|@count}
{$post['purpose']|implode:"/"}
{/if}

{$post['memo']}
----------------

管理画面からご確認ください。
{$init_url}adm/ask/?mode=show_mail&add_id={$post['add_id']}


以上になります。
