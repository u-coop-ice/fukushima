{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="お申込み一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 編集権限 *}

{if $saved}
<p class="alert alert-info">変更を保存しました。</p>
{/if}
{if $cancelled}
<p class="alert alert-info">お申込みをキャンセルしました。</p>
{/if}

{apps regist_id=$auth_id}
{if $app_header}
<div class="list-group">
{/if}
{get_app_info app_id=$app['id']}
<a href="{$self}?mode=show_app&ic={$app['code']}" class="list-group-item{if $app['cancelled'] || $app['status']==9} cancelled{/if}">


<h5>{$app['regist_code']}{if $app['cancelled']}<span class="label label-default">キャンセル済</span>{/if}</h5>

{if $app['component']=="shopping"}
<p class="list-group-item-text">{$app['category_name']}
{if $app["ship_flag"] <2}<i class="fa fa-fw fa-arrow-right"></i>{$app["ship_namef"]} {$app["ship_nameg"]}様{/if}</p>

{else if $app['component']=="htkt"}
<p class="list-group-item-text">{$component[$app['component']]['title']}
{htkt_entries ic=$app['code']}{if $entry['publish']}<span class="tag green">回答掲載済</span>{/if}{/htkt_entries}
</p>
{*else if $app['component']=="living"}
<p class="list-group-item-text">{get_init_category_info component=$app['component'] part=$app['part']}{$init_category['denomination']}</p>
*}

{else if $app['component']=="entry"}
<p class="list-group-item-text">{$app['category_denomination']}</p>

{else}
<p class="list-group-item-text">{$app['category_denomination']}</p>
{/if}

<p class="list-group-item-text">
{if $app['component']=="htkt"}{if $entry['title_edit']}{$entry['title_edit']|mb_truncate:30:"･･･"}{else}{$entry['title']|mb_truncate:30:"･･･"}{/if}
{else if $app['component']=="reserve"}
{$app['comedate']} {$app['cometime']}
{else}
{/if}
</p>

{if $app['memo']}
<p class="list-group-item-text">
{$app['memo']|mb_truncate:30:"･･･"}
</p>
{/if}

{if $app['regist_date']}<p class="app_regist_date">[{$app['regist_date']}]</p>{/if}
</a>
{if $app_footer}
</div>
{/if}
{/apps}

{* 記事一覧本体 終了 *}

{* ページ選択 *}
{include file='page_select.tpl'}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_app}
<p class="alert alert-info">お申込みが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">データベースの読み込みに失敗しました。</p>
{/if}

<p><a class="btn btn-primary" href="{$self}"><i class="fa fa-fw fa-reply"></i>ユーザーページに戻る</a></p>

{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
