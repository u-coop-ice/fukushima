{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<![CDATA[
//]]>
</script>

<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>

<script>
//<![CDATA[
$(function(){
$("#theForm").validationEngine('attach', {promptPosition : "inline"});
});
//]]>
</script>

{/literal}
{/capture}

{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}

<form id="theForm" action="{$self}?mode=save_config" method="post" accept-charset="utf-8">
<h4>基本設定</h4>
<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">システム基本設定</th></tr>
<tr><th>コンポーネント</th><td>{$smarty.const.COMPONENT}</td></tr>
<tr><th>システム名</th><td>
<input type="text" id="pagetitle" name="pagetitle" value="{$config['pagetitle']}" placeholder="" />
</td></tr>
<tr><th>初期設定アドレス</th><td>
<input type="email" id="email" name="email" value="{$config['email']}" placeholder="" />
</td></tr>
<tr><th>INFO CODE</th><td>
<input type="text" id="infocode" name="infocode" value="{$config['infocode']}" placeholder="" />
</td></tr>
<tr><th>組合員番号上4桁</th><td>
<input type="text" id="membershipfirst4" name="membershipfirst4" value="{$config['membershipfirst4']}" class="validate[custom[onlyNumberSp]]" placeholder="半角数字4桁" />
</td></tr>
</table>
<p class="center">
<input type="submit" name="submit" value="設定を保存する">
</p></form>

<br />

{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_entry}
<p>記事が見つかりませんでした。</p>
{/if}
{if $db_error}
<p>記事の読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
