{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
$(function($){
	top.location.href="{/literal}{$SITE_URL}?mode=logout&remove=1{literal}";
})
</script>


{/literal}
{/capture}

{include file='header.tpl'}



{* ページタイトル 開始 *}
{capture assign="page_title"}退会手続きが完了しました。{/capture}
{* ページタイトル 終了 *}

<div id="content">
<p class="note">{$msg}</p>

</div><!-- content -->
{include file='footer.tpl'}
