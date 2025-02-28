{$init_coopname}{$init_pagetitle} {$init_category["name"]}からの自動受注メールです。

【管理画面】
{$init_url}adm/shopping/
からログインし内容を確認してください。
-----------------------------------------------------------------------------

【ご注文者様】

{if !$login}
{if $regist['namef']}
{$regist['namef']} {$regist['nameg']}様
{else}
{$post['namef']} {$post['nameg']}様
{/if}
{else}
{$regist['namef']} {$regist['nameg']}様
{/if}

{$content_order}