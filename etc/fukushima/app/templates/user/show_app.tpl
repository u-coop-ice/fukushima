{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<![CDATA[

$(document).ready( function(){
    $(".cb-enable").click(function(){
        var parent = $(this).parents('.switch');
        $('.cb-disable',parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox',parent).attr('checked', true);
    });
    $(".cb-disable").click(function(){
        var parent = $(this).parents('.switch');
        $('.cb-enable',parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox',parent).attr('checked', false);
    });
});
//]]>
</script>

<script type="text/javascript">
//<[!CDATA[
function cancelCheck() {
    return confirm('お申込みをキャンセルしてもよろしいですか？（この操作は取り消せません）');
}
//]]>
</script>

{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}お申込み内容の確認{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{*apps*}


{if $app['cancelled']==1 || $app['status']==9}
<p class="alert alert-info">このお申込みはキャンセル済です。</p>
{/if}


{if $app["component"]=="shopping"}
{include file="show_app_shopping.tpl"}
{else if $app['component']=="entry"}
{include file="show_app_entry.tpl"}
{else if $app['component']=="reserve"}
{include file="show_app_reserve.tpl"}
{else if $app['component']=="living"}
{*include file="show_app_living.tpl"*}
{else if $app['component']=="htkt"}
{include file="show_app_htkt.tpl"}
{else if $app['component']=="bicycle"}
{include file="show_app_bicycle.tpl"}
{else if $app['component']=="leave"}
{include file="show_app_leave.tpl"}
{else}
{*include file="show_app_other.tpl"*}
{/if}
{*/apps*}

<p><a class="btn btn-primary" href="./?mode=list_app"><i class="fa fa-fw fa-chevron-left"></i>お申込み一覧に戻る</a></p>

<br />

{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_app}
<p class="alert alert-info">お申込み情報が見当たりません。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
