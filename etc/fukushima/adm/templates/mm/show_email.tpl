{capture assign="header_insert"}
{literal}
{/literal}
{/capture}

{* ページタイトル 開始 *}
{capture assign="page_title"}登録ユーザー情報{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{* アドレス編集フォーム 開始 *}
{entries}
<h4 class="page_title">{$page_title}</h4>


<table class="inputForm" cellspacing="0">
<col style="width:30%;"/>
<col style="width:70%;"/>
<tr><th class="mh" colspan="2">大学・受験内容</th></tr>
<tr><th>受験／入学</th><td>{$entry_year}年度</td></tr>
<tr><th>大学名</th><td>{univ id=$entry_univ_id pfx=$pfx}{$univ_name}{/univ}</td></tr>

{if $entry_exam}
<tr><th>受験日程</th><td>{code name=24 id=$entry_exam}{$code_value}{/code}</td></tr>
{/if}

{if $entry_dept}
<tr><th>学部・学科</th><td>{code name=23 id=$entry_dept}{$code_value}{/code}</td></tr>
{/if}

{if $entry_examnumber}
<tr><th>受験番号</th><td>{$entry_examnumber}</td></tr>
{/if}
<tr><th class="mh" colspan="2">メインe-mail</th></tr>
<tr>
<th>E-mail</th>
<td>{$entry_email}</td>
</tr>
<tr><th class="mh" colspan="2">新入生（受験生）本人</th></tr>
{if $entry_namef}
<th>お名前</th><td>{$entry_namef} {$entry_nameg}（{$entry_kanaf} {$entry_kanag}）</td></tr>
{/if}
{if $entry_sex}
<th>性別</th><td>{$sexList[$entry_sex]}</td></tr>
{/if}
{if $entry_birthday}
<th>生年月日</th><td>{$entry_birthday}</td></tr>
{/if}

{if $entry_mobilephone}
<th>携帯電話番号</th><td>{$entry_mobilephone}</td></tr>
{/if}


{if $entry_student_email}
<tr><th>E-mail</th><td>{$entry_student_email} {if $entry_rc_se}<span class="{$healthList[$entry_rc_se]}">{$healthList[$entry_rc_se]}!!</span>{/if}</td></tr>
{/if}


{if $entry_student_email_mobile}
<tr><th>携帯E-mail</th><td>{$entry_student_email_mobile} {if $entry_rc_sem}<span class="{$healthList[$entry_rc_sem]}">{$healthList[$entry_rc_sem]}!!</span>{/if}</td></tr>
{/if}


{if $entry_highschool}
<th>出身校</th><td>{$entry_highschool}</td></tr>
{/if}

<tr><th class="mh" colspan="2">実家・資料送付先</th></tr>

{if ($entry_zipcodef !="" || $entry_zipcodes !="" || $entry_pref !="" || $entry_addressf !="")}
<tr><th>住所</th><td>
〒&nbsp;{$entry_zipcodef|string_format:"%03d"}−{$entry_zipcodes|string_format:"%04d"}<br />
{$entry_pref}&nbsp;{$entry_addressf}
{if $entry_addresss}
<br />{$entry_addresss}
{/if}
</td></tr>
{/if}

{if ($entry_phonenumber)}
<tr><th>自宅電話番号</th><td>{$entry_phonenumber}</td></tr>
{/if}

<tr><th class="mh" colspan="2">保護者さま</th></tr>
{if ($entry_parentnamef)}
<tr><th>保護者氏名</th><td>{$entry_parentnamef} {$entry_parentnameg}（{$entry_parentkanaf} {$entry_parentkanag}）</td></tr>
{/if}
{if ($entry_parent_sex)}
<tr><th>保護者性別／続柄</th><td>{$sexList[$entry_parent_sex]} ／ {$entry_parent_relation}</td></tr>
{/if}

{if ($entry_parent_mobile)}
<tr><th>保護者携帯</th><td>{$entry_parent_mobile} {$healthList[$entry_rc_pem]}</td></tr>
{/if}


{if ($entry_parent_email)}
<tr><th>保護者E-mail</th><td>{$entry_parent_email} {$healthList[$entry_rc_pe]}</td></tr>
{/if}
{if ($entry_parent_email_mobile)}
<tr><th>保護者携帯E-mail</th><td>{$entry_parent_email_mobile} {if $entry_rc_pem}<span class="healthy">healthy!!</span>{/if}</td></tr>
{/if}

{if ($entry_parent_com)}
<tr><th>保護者勤務先</th><td>{$entry_parent_com}</td></tr>
{/if}
{if ($entry_parent_com_phone)}
<tr><th>保護者勤務先電話番号</th><td>{$entry_parent_com_phone}</td></tr>
{/if}
</table>


{/entries}

{* 商品編集フォーム 終了 *}

{* 商品が見つからなかった場合の出力等 開始 *}
{if $no_email}
<p>商品が見つかりませんでした。</p>
{/if}
{if $db_error}
<p>商品の読み込みに失敗しました。</p>
{/if}
{* 商品が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
