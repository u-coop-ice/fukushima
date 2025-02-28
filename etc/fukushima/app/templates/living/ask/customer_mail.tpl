{if $name}{$name}さま
{/if}
ご利用ありがとうございます。{$init_coopname}です。

{$init_coopname}へのお問い合わせを承りました。
このメールは、サーバーに正常に送信された際に送信される、
自動返信メールです。

入力された内容をご確認ください。

----------------
[件名]{$post['subject']}
----------------
{if $post['target']}
[対象物件]{$post['target']}
{/if}
[お問い合わせ内容]
{if $post['purpose']|@count}
{$post['purpose']|implode:"/"}
{/if}

{$post['memo']}
----------------

{if $login}【要サインイン】
サイト右上の「各種設定→{$init_coopname}との連絡」または、以下URLからもこのメールの内容を確認できます。
{$init_url}app/user/?mode=show_mail&adic={$adic}

{/if}

以上になります。

----------------
{$init_coopname}