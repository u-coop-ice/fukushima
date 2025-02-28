{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

{/literal}
{/capture}


{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}{$init_coopname}サイト 会員規約{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{include file='rule_membership.tpl'}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
