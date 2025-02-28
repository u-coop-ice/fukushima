{if !$login}
{if $regist['namef']}
{$regist['namef']} {$regist['nameg']}様
{else}
{$post['namef']} {$post['nameg']}様
{/if}
{else}
{$regist['namef']} {$regist['nameg']}様
{/if}

ご利用ありがとうございます。{$init_coopname}でございます。

このたびは、{$init_coopname}{$init_pagetitle} {$init_category['denomination']}にて以下の商品をご注文いただき、ありがとうございました。

本メールはお客様のご注文情報がサーバに到達した時点で送信される、自動配信メールです。

{if $init_category['autosend_message']}
{$init_category['autosend_message']}
{/if}

{if $init_category['include_return_message'] && $init_category['return_message']}
{eval var=$init_category['return_message']}
{/if}

★こちらの注文に覚えがない場合は？
他の方が誤ってあなたのメールアドレスで注文した可能性があります。
その場合は、たいへんお手数ですが、下記の受付番号をご記入の上
本メール最後尾記載の問い合わせ先までお知らせください。


{$content_order}


{if $post['payment']==4}
ご注文様と異なる名義のクレジットカードをご利用の場合は、カード会社の承認を得られない場合がございます。
※決済完了を確認後の商品発送となります。
{/if}

以上になります。

ご質問・お問い合わせは、上記の受付番号・お名前を明記の上、
{$init_url}app/ask/
までお問い合わせください。

【送信専用】当メールは自動配信メールですので、当メールにご返信いただいてもご対応できません。

ご利用ありがとうございました。

----------------------------------------------------------------------------
{$coopname}　{$init_coopurl}
