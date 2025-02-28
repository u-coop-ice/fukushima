{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

{/literal}
{/capture}


{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}ユーザー マイページ{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


<h5>{if $regist['namef']}{$regist['namef']} {$regist['nameg']}{else}{$regist['username']}{/if}さん</h5>


<p class="pad_l hidden-xs">右メニューから選択してください。</p>

<div class="visible-xs-block">
<div class="list-group">
<a class="list-group-item" href="/app/user/?mode=show_regist"><i class="fa fa-user"></i>登録情報の確認・変更</a>
<a class="list-group-item" href="/app/user/?mode=list_app"><i class="fa fa-list"></i>お申込み内容の確認</a>
<a class="list-group-item" href="/app/user/?mode=list_mail"><i class="fa fa-envelope"></i>{$init_coopname}との連絡{if $app_add_ct} <span class="badge">{$app_add_ct}</span>{/if}</a>
<a class="list-group-item" href="/app/user/?mode=membership"><i class="fa fa-file-text-o"></i>サイト会員規約</a>
<a class="list-group-item" href="{$self}?signout=1"><i class="fa fa-sign-out"></i>サインアウト</a>
</div>
</div>
{* フッター部分の組み込み *}
{include file='footer.tpl'}
