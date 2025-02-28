{$init_coopname}
問い合わせフォームからの送信です。

入力内容をご確認ください。

-----------------------------------------------------------------------------
《受付番号》{$regist_code}
-----------------------------------------------------------------------------
[名前] {if $name}{$name}
{/if}
----------------
{$post['subject']}
----------------
[内容]
{$post['memo']}
----------------
{if $post['app_id']}
[関連お申込み]
{apps app_id=$post['app_id']}【{$component[$app['component']]['infocode']}{if $component[$app['component']]=="entry"}{categories id=$app['category_id']}{if $category['cat_code']}-{$category['cat_code']}{/if}{/categories}{/if}:{$app['regist_date']|date_format:"%Y%m%d"}-{$app['app_count']|string_format:"%04d"}】
お申込みの内容は以下URLからご確認ください。
{$init_url}adm/{$app['component']}/?mode=show_app&aid={$app['id']}
{/apps}
{else if $post['category_id']}
[お問い合わせ先]
{ask_categories id=$post['category_id']}{$category['denomination']}{/ask_categories}
{/if}


管理画面からご確認ください。
{$init_url}adm/ask/?mode=show_mail&add_id={$adid}


以上になります。
