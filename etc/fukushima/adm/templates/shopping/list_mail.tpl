{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[
//]]>
</script>
{/literal}
{/capture}

{assign var="page_title" value="システムメール{if $mail=="mail"}送信{else}送信{/if}履歴（すべて）"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $deleted}
<p class="note deleted">メールを削除しました。</p>
{/if}
{adds add=mail}
{if $add_header}
<table class="inputForm">
<tr>
<th class="mh" style="width:60%;">件名</th>
<th class="mh" style="width:20%;">送信先／送信元</th>
<th class="mh" style="width:20%;">送信日時</th>
</tr>
{/if}
<tr{if $is_odd} class="odd"{/if}>
<td><a href="{$self}?mode=show_mail&adid={$add_id}">{$add_subject}</a></td>
<td><i class="icon-{if $add_send}arrow-right{else if $add_recieve}mail-reply{/if}"></i> {$add_namef} {$add_nameg}</td>
<td>{$add_date}</td>
</tr>
{if $add_footer}
</table>
{/if}
{/adds}
{if $no_add}
<p class="ind">送信履歴が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="ind">送信履歴の読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
