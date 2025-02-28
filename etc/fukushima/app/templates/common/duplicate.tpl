{capture assign="header_insert"}
{literal}


{/literal}

{/capture}



{include file='header.tpl'}




<p class="alert alert-info">{$errmsg}</p>
<p class="pad_l">{$regist['namef']}{$regist['nameg']}さんは
すでにお申込みをいただいております。お申込み内容はユーザーページ「お申込み内容の確認」からご確認ください。</p>

<h4>お申込み内容の変更／キャンセルについて</h4>

<p class="pad_l">お申込みの内容によっては、お申込みのキャンセルをWEBから受け付けているものあります。以下お申込み内容の確認からご確認ください。</p>
<p><a class="btn btn-primary" href="{$init_coopurl}app/user/?mode=list_app">お申込み内容の確認<i class="fa fa-fw fa-chevron-right"></i></a><p>
<br />
<br />


<p><a class="btn btn-primary" href="{$init_coopurl}"><i class="fa fa-fw fa-reply"></i>{$init_coopname} トップページに戻る</a></p>

{include file='footer.tpl'}
