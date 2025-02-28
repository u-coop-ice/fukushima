{* ヘッダー部分の組み込み *}
{if !$layout_class}
{assign var="layout_class" value="two-column"}
{/if}

{* ページタイトル 開始 *}
{capture assign="page_title"}ご利用案内{/capture}
{* ページタイトル 終了 *}

{include file='header.tpl'}


{$init_category['description']|htmlspecialchars_decode}

<h5>個人情報の取り扱いについて</h5>
<p class="pad_l">{$init_coopname}では、個人情報に関して適用される法令、規範を遵守するとともに、会員生協組合員及びその関係者に関する情報の適正な管理・利用と保護に努めております。［<span rel="tips" title="別ウィンドウで開く::個人情報の取り扱いについて"><a href="{$init_coopurl}home/privacypolicy/" target="_blank">詳細</a></span>］</p>



<div class="box">
<p>{$init_category['denomination']}についてのお問い合わせは…</p>
<h5>{$init_coopname} {$init_category['store_name']}</h5><p>TEL {$init_category['store_phonenumber']}<br />
FAX {$init_category['store_faxnumber']}</p>
<p><a class="btn btn-primary" href="/app/ask/">お問い合わせ<i class="fa fa-fw fa-chevron-right"></i></a></p>
</div>
<p><a class="btn btn-primary" href="javascript:history.back();"><i class="fa fa-fw fa-chevron-left"></i>前に戻る</a></p>
<div class="clear"></div>


{* フッター部分の組み込み *}
{include file='footer.tpl'}
