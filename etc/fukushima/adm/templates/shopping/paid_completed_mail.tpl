{if $regist_namef}{$regist_namef} {$regist_nameg}{else}{$regist_username}{/if}さま

{$category_paid_completed_message}

ご注文内容の詳細は下記となっております。

{include file="content_order_mail.tpl"}

----------------------------------------------------------------------------
【送信専用】当メールは送信専用ですので、当メールには返信できません。
{if $regist_status==1}
このメールはサインイン後、以下URLでも確認できます。
{$init_url}app/user/?mode=show_mail&adic={$adic}
{/if}
----------------------------------------------------------------------------
{$init_coopname} {$init_url}


