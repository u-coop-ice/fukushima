{if $post['namef']}{$post['namef']} {$post['nameg']}様{/if}

ご利用ありがとうございます。{$init_coopname}です。
{$category_denomination}
を承りました。

本メールはお客様のご登録情報がサーバーに到達した時点で送信される自動配信メールです。

フォームより送信された内容をご確認ください。

---------------
《受付番号》{$regist_code}
---------------
{$category_denomination}
---------------
{if $category_description}
{$category_description}
---------------
{/if}

{$text}

---------------

{if $category['authorization']}
サインイン後、「お申込み内容の確認」または以下のURLからお申込み内容を確認できます。
{$init_url}app/user/?mode=show_app&ic={$app_code}
{/if}

ご質問・お問い合わせは、上記の受付番号・お名前を明記の上、
{if $pressmail}
{$pressmail}
{else}
{$init_url}app/ask/
{/if}
までお問い合わせください。

ご利用ありがとうございました。

本メールは、お申込みいただいた方にお送りしております。
もしお心当たりが無い場合は、このまま本メールを破棄してください。
またその旨を、{if $pressmail}
{$pressmail}
{else}
{$init_url}app/ask/
{/if}

までご連絡いただければ幸いです。

以上よろしくお願いいたします。
---------------
{$init_coopname}