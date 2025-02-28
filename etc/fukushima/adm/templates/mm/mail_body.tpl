{if $mail4send['namef']}{$mail4send['namef']} {$mail4send['nameg']}{else}{$mail4send['username']}{/if}さま

{$body}

{if $unsubscribe}

---------------------

※当メールは、{$init_coopname}にユーザー登録された方に対してお送りしております。
今後、このようなお知らせが不要な方は、大変お手数ですが下記のURLより
配信停止処理（要サインイン）をお願いいたします。
{$init_url}app/user/?mode=unsubscribe_mail&username=%urlencode_email%

{/if}
{$signature}

