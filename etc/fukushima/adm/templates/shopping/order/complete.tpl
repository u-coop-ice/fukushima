{* ヘッダー部分の組み込み *}
{assign var="layout_class" value="one-two"}

{assign var="page_title" value="新規注文登録完了"}

{include file='header.tpl'}

<!-- STEPS -->
<table class="steps">
<tr>
<td class="first cleared"><span class="number">1</span><span class="hidden-xs description">ご注文内容編集</span></td>
<td class="cleared"><span class="number">2</span><span class="hidden-xs description">発送先等入力</span></td>
<td class="cleared"><span class="number">3</span><span class="hidden-xs description">発送オプション入力</span></td>
<td class="cleared"><span class="number">4</span><span class="hidden-xs description">お支払方法入力</span></td>
<td class="cleared"><span class="number">5</span><span class="hidden-xs description">入力内容確認</span></td>
<td class="now"><span class="number">6</span><span class="hidden-xs description">登録完了</span></td>
</tr>
</table>

<!-- /STEPS -->


<h3 class="header">注文データの登録が完了しました。</h3>
<div class="row">

<div class="col-sm-6">
<p><a class="btn btn-primary btn-block" href="{$self}?continue=1">同じユーザーで登録を続ける</a></p>
</div>

<div class="col-sm-6">
<p><a class="btn btn-primary btn-block" href="{$self}">続けて登録する</a></p>
</div></div>

{* フッター部分の組み込み *}
{include file='footer.tpl'}
