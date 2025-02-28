{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/newlife/requestDB/css/cb.css" type="text/css" media="screen,print" />
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
{capture assign="page_title"}記事の{if $view_entry_id}編集{else}新規作成{/if}{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事編集フォーム 開始 *}



{entries}

{if $saved}
<p class="saved">変更を保存しました。</p>
{/if}

<form action="javascript:history.back();">
<p><input type="submit" name="submit" value="前のページ" />
</p>
</form>


{* 編集権限 *}
{if ($auth1 < 999 && $entry_auth != $auth1)}
<p>閲覧権限がありません。</p>
{else}

<table class="inputForm" cellspacing="0">
<col style="width:30%" /><col style="width:70%" />

{if $entry_comedate}
<tr><th class="mh" colspan="2">サポートセンター来場予約</th></tr>
<tr><th>来場予約日時</th><td><span class="prc">{$entry_comedate}　{$entry_comehour}時{if $entry_comemin}{$entry_comemin}分{/if} 頃</span></td></tr>
{else}
<tr><th class="mh" colspan="2">説明会・イベントエントリー</th></tr>
<tr><th>説明会・イベント名称</th><td><span class="prc">{categories id=$entry_cat_id}{$category_name}{/categories}</span></td></tr>
{/if}
</table>

<table class="inputForm" cellspacing="0">
<col style="width:30%" /><col style="width:70%" />
<tr><th class="mh" colspan="2">大学・受験内容</th></tr>
<tr><th>大学名</th><td><span class="prc">{univ id=$entry_univ_id pfx=$pfx}{$univ_name}{/univ}</span></td></tr>

{if $entry_exam}
<tr><th>受験日程</th><td>{code id=$entry_exam}{$code_value}{/code}</td></tr>
{/if}

{if $entry_dept}
<tr><th>学部</th><td>{code id=$entry_dept}{$code_value}{/code}</td></tr>
{/if}
{if $entry_major}
<tr><th>学科・専攻</th><td>{$entry_major}</td></tr>
{/if}

{if $entry_examnumber}
<tr><th>受験番号</th><td>{$entry_examnumber}</td></tr>
{/if}
</table>


<table class="inputForm" cellspacing="0">
<col style="width:30%" /><col style="width:70%" />
<tr><th class="mh" colspan="2">メールアドレス</th></tr>
<tr>
<th>E-mail</th>
<td>
{$entry_email}
<input type="hidden" id="email" name="email" value="{$entry_email}" /></td>
<input type="hidden" id="emailCfrm" name="emailCfrm" value="{$entry_emailCfrm}" /></td>
</tr>
<tr><th class="mh" colspan="2">本人について</th></tr>
<th>お名前（漢字）</th>
<td>
{$entry_nameF} {$entry_nameG}（{$entry_kanaF} {$entry_kanaG}）
</td>

<tr><th>性別</th><td>{$sexList[$entry_sex]}</td></tr>
<tr><th>生年月日</th><td>{$entry_birthday}</td></tr>

{if ($entry_mobilephone)}
<tr><th>携帯電話番号</th><td>{$entry_mobilephone}</td></tr>
{/if}

{if ($entry_highschool)}
<tr><th>出身高校</th><td>{$entry_highschool}</td></tr>
{/if}

<tr><th class="mh" colspan="2">保護者について</th></tr>

<tr><th>保護氏名（漢字）</th><td>{$entry_parentNameF} {$entry_parentNameG}（{$entry_parentKanaF} {$entry_parentKanaG}）</td></tr>
{if ($entry_parentSex)}
<tr><th>保護者性別／続柄</th><td>{$sexList[$entry_parentSex]} ／ {$entry_parentRelation}</td></tr>
{/if}
{if ($entry_zipcodeF !="" || $entry_zipcodeS !="" || $entry_pref !="" || $entry_addressF !="")}
<tr><th>実家住所</th><td>
〒&nbsp;{$entry_zipcodeF|string_format:"%03d"}−{$entry_zipcodeS|string_format:"%04d"}<br />
{$entry_pref}&nbsp;{$entry_addressF}
{if $entry_addressS}
<br />{$entry_addressS}
{/if}
</td></tr>
{/if}

{if ($entry_phonenumber)}
<tr><th>ご自宅電話番号</th><td>{$entry_phonenumber}</td></tr>
{/if}
{if ($entry_phonenumber)}
<tr><th>保護者携帯番号</th><td>{$entry_pMobilephone}</td></tr>
{/if}
{if ($entry_parentCom)}
<tr><th>保護者勤務先</th><td>{$entry_parentCom}</td></tr>
{/if}
{if ($entry_parentComPhone)}
<tr><th>保護者勤務先電話番号</th><td>{$entry_parentComPhone}</td></tr>
{/if}

<table class="inputForm" cellspacing="0">
<col style="width:30%" /><col style="width:70%" />
<tr><th class="mh" colspan="2">その他</th></tr>
{if ($entry_number)}
<tr><th>参加人数</th><td>{$entry_number} 人</td></tr>
{/if}
{if $entry_cat_id}
{categories id=$entry_cat_id}
{if $category_extra1_use}
<tr><th>{$category_extra1_title}</th>
<td>{$entry_extra1}</td></tr>
{/if}
{if $category_extra2_use}
<tr><th>{$category_extra2_title}</th>
<td>{$entry_extra2}</td></tr>
{/if}
{if $category_extra3_use}
<tr><th>{$category_extra3_title}</th>
<td>{$entry_extra3}</td></tr>
{/if}

{/categories}
{else}
{if $conf_extra1_use}
<tr><th>{$conf_extra1_title}</th>
<td>{$entry_extra1}</td></tr>
{/if}
{if $conf_extra2_use}
<tr><th>{$conf_extra2_title}</th>
<td>{$entry_extra2}</td></tr>
{/if}
{if $conf_extra3_use}
<tr><th>{$conf_extra3_title}</th>
<td>{$entry_extra3}</td></tr>
{/if}

{/if}
<tr><th>備考欄</th><td>{$entry_memo|nl2br}</td></tr>
</table>

{if ($entry_mst == 'ask')}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_entry">
<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">対応状況</th></tr>
<tr><th>状況</th><td>
<div class="field switch">
<input type="radio" id="status1" name="status" value="1" {if $entry_status==1}checked="checked"{/if} />
<input type="radio" id="status2" name="status" value="0" {if $entry_status==0}checked="checked"{/if} />
<label for="status1" class="cb-enable{if $entry_status==1} selected{/if}"><span>対応済</span></label>
<label for="status2" class="cb-disable{if $entry_status==0} selected{/if}"><span>未対応</span></label>
</div>
</td></tr>
<tr>
<th>内部メモ</th>
<td>
<textarea id="status_memo" name="status_memo" rows="5" >{$entry_status_memo}</textarea>
</td>
</tr>

</table>
<input type="hidden" name="id" value="{$view_entry_id}" />
<p class="center"><input type="submit" name="submit" value="保存する" /></p>
{else}
<table class="inputForm" cellspacing="0">
<col style="width:30%" /><col style="width:70%" />
<tr><th class="mh" colspan="2">データ書き出し</th></tr>
<tr><th>書き出し日時</th><td>
{if $entry_date_export}{$entry_date_export}{else}未書き出し{/if}
</td></tr>
</table>
{/if}
{/if}
{/entries}
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

{* フッター部分の組み込み *}
{include file='footer.tpl'}
