{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/newlife/adm/css/cb.css" type="text/css" media="screen,print" />
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
{/literal}
{/capture}



{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{capture assign="page_title"}お申込み内容の確認{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}

<div id="content">

{apps}

{capture assign="pagetitle"}
{if $app_app == 'ask'}
お問い合わせ
{elseif $app_app == 'request'}
資料請求
{elseif $app_category_id}
{notes id=$app_category_id}{$note_cat_name}{/notes}
{elseif $app_app == 'sc'}
{notes app=$app_app}{$note_cat_name}{/notes}
{else}
{notes app=$app_app}{$note_cat_name}{/notes}
{/if}
{/capture}

<h4>{$pagetitle}</h4>


{if $app_app=="sc"}
<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">サポートセンター来場予定</th></tr>
<th>来場予定日時</th>
<td><span class="prc">{$app_comedate} {$app_cometime}</span></td>
</table>
{/if}

{entries eid=$app_user_id}

<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">お申込みについて</th></tr>
{if $app_category_id}
{notes id=$app_category_id}
<tr><th>{$note_cat_name}</th><td>{$note_description|nl2br}</td>
{/notes}
{/if}
<tr><th>受付番号</th><td>
{$app_date|date_format:"%Y%m%d"}-{$app_entry_count|string_format:"%04d"}</td></tr>
<tr><th>日時</th><td>{$app_date}</td></tr>
</table>

{/entries}

{if $app_app!="ask"}
<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">その他・追加項目</th></tr>

{if $app_app=="sc"}{assign var="app_univ_id" value=""}{/if}

{notes app=$app_app uid=$app_univ_id cid=$app_category_id}
{if ($note_number)}
<tr><th>参加人数</th><td>{if $app_number}{$app_number}人{else}未入力{/if}</td></tr>
{/if}
{if ($note_ext1)}
<tr><th>{$note_ext1_title}</th><td>{$app_ext1|default:"未入力"}</td></tr>
{/if}
{if ($note_ext2)}
<tr><th>{$note_ext2_title}</th><td>{$app_ext2|default:"未入力"}</td></tr>
{/if}
{if ($note_ext3)}
<tr><th>{$note_ext3_title}</th><td>{$app_ext3|default:"未入力"}</td></tr>
{/if}
{if ($note_ex1)}
<tr><th>{$note_ex1_title}</th><td>{$app_ex1|default:"未入力"}</td></tr>
{/if}
{if ($note_ex2)}
<tr><th>{$note_ex2_title}</th><td>{$app_ex2|default:"未入力"}</td></tr>
{/if}
{if ($note_ex3)}
<tr><th>{$note_ex3_title}</th><td>{$app_ex3|default:"未入力"}</td></tr>
{/if}
{if ($note_extra1)}
<tr><th>{$note_extra1_title}</th><td>{$app_extra1|default:"未入力"}</td></tr>
{/if}
{if ($note_extra2)}
<tr><th>{$note_extra2_title}</th><td>{$app_extra2|default:"未入力"}</td></tr>
{/if}
{if ($note_extra3)}
<tr><th>{$note_extra3_title}</th><td>{$app_extra3|default:"未入力"}</td></tr>
{/if}
<tr><th>{$note_memo_title}</th><td>{$app_memo|nl2br}</td></tr>
{/notes}
</table>
{/if}

{if ($app_app == 'ask')}

<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">お問い合わせ内容</th></tr>
<tr><th>内容</th><td>{$app_memo|nl2br}</td></tr>
</table>
{/if}
{/apps}

<div class="btn"><a href="javascript:history.back();">前のページへ戻る</a></div>

<br />

{* 記事編集フォーム 終了 *}

{* 記事が見つからなかった場合の出力等 開始 *}
{if $no_entry}
<p>投稿が見当たりません。</p>
{/if}
{if $db_error}
<p>記事の読み込みに失敗しました。</p>
{/if}
{* 記事が見つからなかった場合の出力等 終了 *}

</div><!-- content -->

{* フッター部分の組み込み *}
{include file='footer.tpl'}
