{orders}
{if $order['return_message']}
{assign var="total_price_all" value=$order['total_price_all']}
{assign var="postage" value=$order['postage']}
{eval var=$order['return_message']}{/if}
{/orders}

ご注文内容の詳細は下記となっております。

{include file="../shopping/content_order_mail.tpl"}
