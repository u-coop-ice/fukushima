{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="one-two"}
{include file='header.tpl'}

<!-- STEPS -->
<table class="steps">
<tr>
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="cleared"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
<td class="cleared"><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td class="cleared"><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td class="cleared"><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td class="now"><span class="number">6</span><span class="hidden-xs description">ご注文完了</span></td>
</tr>
</table>
<!-- /STEPS -->


<p class="alert alert-success">ご注文内容の送信が完了しました。</p>
<p>このたびは<a href="{$self}">{$init_coopname}{$init_pagetitle} {$init_category['denomination']}</a>をご利用いただき、まことにありがとうございました。</p>

<p>受付控えのメールを自動送信しております。しばらくお待ちになった上で、ご確認ください。</p>
{*<p>また、送料を含んだご利用総額・お支払い方法等は、自動送信メールとは別途ご連絡さしあげます。</p>*}

<p><a class="btn btn-primary" href="{$self}">買い物を続ける<i class="fa fa-fw fa-chevron-right"></i></a></p>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
