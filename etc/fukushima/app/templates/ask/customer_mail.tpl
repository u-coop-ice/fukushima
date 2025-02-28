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
[お問い合わせ内容]
{$post['memo']}
----------------

{if $post['app_id']}
[関連お申込み]
{apps app_id=$post['app_id']}【{$component[$app['component']]['infocode']}{if $component[$app['component']]=="entry"}{categories id=$app['category_id']}{if $category['cat_code']}-{$category['cat_code']}{/if}{/categories}{/if}:{$app['regist_date']|date_format:"%Y%m%d"}-{$app['app_count']|string_format:"%04d"}】{/apps}

お申込みの内容は以下URLからご確認ください。
{$init_url}app/user/?mode=show_app&ic={$app['code']}
{else if $post['category_id']}
[お問い合わせ先]
{ask_categories id=$post['category_id']}{$category['denomination']}{/ask_categories}
{/if}

{if $login}【要サインイン】
サイト右上の「各種設定→{$init_coopname}との連絡」または、以下URLからもこのメールの内容を確認できます。
{$init_url}app/user/?mode=show_mail&adic={$adic}
{/if}

以上になります。

----------------
{$init_coopname}