{if $regist_namef}{$regist_namef} {$regist_nameg}{else}{$regist_username}{/if}さま

ご利用ありがとうございます。{$init_coopname}でございます。
このたびは、{$init_coopname}{$init_pagetitle} {$init_category['denomination']}にて以下の商品をご注文いただき、
ありがとうございました。

----------------
クレジットカード決済のご利用確認が完了いたしました
（このメールは、配信専用のアドレスで配信されています）
----------------

下記のご注文に関してご利用いただきましたクレジットカードでの決済を
確認させていただきました。ご注文商品の出荷に向けて手続きを進めてまいります。

ご注文内容の詳細は下記となっております。

{include file="content_order_mail.tpl"}

以上になります。

