{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="生協との連絡履歴一覧"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


{* 編集権限 *}

{if $saved}
<p class="alert alert-success">変更を保存しました。</p>
{/if}
{if $cancelled}
<p class="alert alert-success">お申込みをキャンセルしました。</p>
{/if}

{adds regist_id=$regist['id'] per_page=10}
{if $add_header}
<p>{$add_count}件中の{$first_add_no}〜{$last_add_no}件目</p>
<div class="list-group">
{/if}
<a class="list-group-item{if $add['send']} send{/if}" href="{$self}?mode=show_mail&adic={$add['code']}">
<h5>{$add['subject']}{if !$add['user_read'] && $add['send']}<span class="tag micro">未読</span>{/if}</h5>

<p class="list-group-item-text"><i class="fa fa-fw {if $add['send']}fa-reply{else if $add['recieve']}fa-arrow-right{/if}"></i>{$init_coopname}</p>
<p class="app_regist_date">[{$add['regist_date']}]</p>
</a>
{if $add_footer}
</div>
{/if}
{/adds}

{* 記事一覧本体 終了 *}

{* ページ選択 *}
{include file='../common/page_select.tpl'}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_add}
<p class="alert alert-info">大学生協との連絡履歴はありません。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">データベースの読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}
<p><a class="btn btn-primary" href="{$self}"><i class="fa fa-fw fa-reply"></i>ユーザーページに戻る</a></p>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
