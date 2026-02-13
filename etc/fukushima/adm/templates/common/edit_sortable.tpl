<div id="sortable">
<table class="inputForm" cellspacing="0">
<thead>
<tr><th class="mh" colspan="2">フォーム項目設定（各項目の順序はクリックしてドラッグ、ドロップで変更可能です。）</th></tr>
<tr id="sort_email"><th>メールアドレス</th><td>必須項目（順序変更不可）</td></tr>
</thead>

<tbody>
<tr id="sort_name"><th>名前＋カナ</th><td>
<p><span class="label label-info">必須項目</span>
<input type="hidden" name="name[use]" value="2" /></p>
<input type="text" name="name[title]" id="name[title]" class="form-control" value="{$category['method']['name']['title']|default:"氏名"}" />

</td></tr>
<tr id="sort_sex"><th>性別</th><td><div class="radio">{html_radios name="sex[use]" options=$extraList selected=$category['method']['sex']['use'] separator="&nbsp;"}</div>
<input type="text" name="sex[title]" id="sex[title]" class="form-control" value="{$category['method']['sex']['title']|default:"性別"}" />

</td></tr>
<tr id="sort_age"><th>生年月日</th><td><div class="radio">{html_radios name="age[use]" options=$extraList selected=$category['method']['age']['use'] separator="&nbsp;"}</div>
<input type="text" name="age[title]" id="age[title]" class="form-control" value="{$category['method']['age']['title']|default:"生年月日"}" />
</td></tr>
<tr id="sort_number"><th>学籍番号</th><td><div class="radio">{html_radios name="number[use]" options=$extraList selected=$category['method']['number']['use'] separator="&nbsp;"}</div></td></tr>
<tr id="sort_membership"><th>組合員番号</th><td><div class="radio">{html_radios name="membership[use]" options=$extraList selected=$category['method']['membership']['use'] separator="&nbsp;"}</div></td></tr>
{*<tr id="sort_univ"><th>大学名</th><td>{html_radios name="univ[use]" options=$useList selected=$category['method']['univ']['use'] separator="&nbsp;"}
</td></tr>*}
<tr id="sort_schoolyear"><th>学年</th><td><div class="radio">{html_radios name="schoolyear[use]" options=$extraList selected=$category['method']['schoolyear']['use'] separator="&nbsp;"}</div></td></tr>

<tr id="sort_graduateyear"><th>卒業予定年</th><td><div class="radio">{html_radios name="graduateyear[use]" options=$extraList selected=$category['method']['graduateyear']['use'] separator="&nbsp;"}</div>
<input type="text" name="graduateyear[title]" id="graduateyear[title]" class="form-control" value="{$category['method']['graduateyear']['title']|default:"卒業予定年"}" />
<br />注意書き等：<textarea name="graduateyear[note]" class="form-control" id="graduateyear[note]">{$category['method']['graduateyear']['note']}</textarea>
</td></tr>

<tr id="sort_dept"><th>学類・学科</th><td><div class="radio">{html_radios name="dept[use]" options=$extraList selected=$category['method']['dept']['use'] separator="&nbsp;"}</div></td></tr>
<tr id="sort_major"><th>専攻等</th><td><div class="radio">{html_radios name="major[use]" options=$extraList selected=$category['method']['major']['use'] separator="&nbsp;"}</div></td></tr>
<tr id="sort_new_add"><th>現住所<br />
<span class="em08">実家（帰省先）住所とセットで使用して下さい。</span></th><td><div class="radio">{html_radios name="new_add[use]" options=$extraList selected=$category['method']['new_add']['use'] separator="&nbsp;"}</div>
<input type="text" name="new_add[title]" id="new_add[title]" class="form-control" value="{$category['method']['new_add']['title']|default:"現住所"}" />
</td></tr>
<tr id="sort_student_phone"><th>本人（現住所）電話番号<br />
<span class="em08">現住所とセットで使用して下さい。</span></th>
<td>
<div class="radio">{html_radios name="student_phone[use]" options=$extraList selected=$category['method']['student_phone']['use'] separator="&nbsp;"}</div>
<input type="text" name="student_phone[title]" id="student_phone[title]" class="form-control" value="{$category['method']['student_phone']['title']|default:"現住所電話番号"}" />
</td></tr>
<tr id="sort_mobilephone"><th>本人携帯電話番号</th><td>
<div class="radio">{html_radios name="mobilephone[use]" options=$extraList selected=$category['method']['mobilephone']['use'] separator="&nbsp;"}</div>
<input type="text" name="mobilephone[title]" id="mobilephone[title]" class="form-control" value="{$category['method']['mobilephone']['title']|default:"携帯電話番号"}" />
</td></tr>
<tr id="sort_address"><th>実家（帰省先）住所</th><td><div class="radio">{html_radios name="address[use]" options=$extraList selected=$category['method']['address']['use'] separator="&nbsp;"}</div>
<input type="text" name="address[title]" id="address[title]" class="form-control" value="{$category['method']['address']['title']|default:'実家（帰省先）住所'}" />
</td></tr>
<tr id="sort_phonenumber"><th>実家（帰省先）電話番号</th><td>
<div class="radio">{html_radios name="phonenumber[use]" options=$extraList selected=$category['method']['phonenumber']['use'] separator="&nbsp;"}</div>
<input type="text" name="phonenumber[title]" id="phonenumber[title]" class="form-control" value="{$category['method']['phonenumber']['title']|default:'実家（帰省先）電話番号'}" />

</td></tr>

<tr id="sort_parent_name"><th>保護者氏名</th><td>
<div class="radio">{html_radios name="parent_name[use]" options=$extraList selected=$category['method']['parent_name']['use'] separator="&nbsp;"}</div>
<input type="text" name="parent_name[title]" id="parent_name[title]" class="form-control" value="{$category['method']['parent_name']['title']|default:"保護者氏名"}" />

</td></tr>

<tr id="sort_bank"><th>銀行口座情報</th><td>
<div class="radio">{html_radios name="bank[use]" options=$extraList selected=$category['method']['bank']['use'] separator="&nbsp;"}</div>
項目名：<input type="text" name="bank[title]" id="bank[title]" class="form-control" value="{$category['method']['bank']['title']|default:'銀行口座'}" />

注意書き等：<textarea name="bank[note]" class="form-control" id="bank[note]">{$category['method']['bank']['note']}</textarea>
</td></tr>

<tr id="sort_ship_address"><th>予備住所</th><td><div class="radio">{html_radios name="ship_address[use]" options=$extraList selected=$category['method']['ship_address']['use']|default:0 separator="&nbsp;"}</div>
<input type="text" name="ship_address[title]" id="ship_address[title]" class="form-control" value="{$category['method']['ship_address']['title']|default:'住所'}" />
</td></tr>


{if !$category['method']['extra'][0]}
<tr id="sort_extra0"><th>項目設定(mail連動)<br /><span class="em08">選択別に設定したアドレスにメールが送信されれます</span></th>
<td>

<div class="radio">
{html_radios name="extra[use][0]" options=$extraList selected=$category['method']['extra'][0]['use']|default:0 separator="&nbsp;"}
</div>
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="【設定書式】選択項目名,メールアドレス（改行）<br />
選択した項目に紐づけられたメールアドレスに<br />
受注メール（生協管理側と同内容）が送信されます。<br />
項目名とメールアドレスは半角カンマで区切って下さい。
"></i>
<div class="clear" style="margin-bottom:0.4em;"></div>

<div class="radio">
{foreach from=$tagList item=i key=k}
{if $k!="text" && $k!="textarea" && $k!="datepicker"}
<label><input type="radio" name="extra[tag][0]" {if $category['method']['extra'][0]['tag']==$k}checked="checked"{/if} value="{$k}" />{$k}</label>&nbsp;
{/if}
{/foreach}
</div>

<div class="clear" style="margin-bottom:0.4em;"></div>


項目名：<input type="text" name="extra[title][0]" id="extra[title][0]" class="form-control" value="{$category['method']['extra'][0]['title']}" />
<textarea name="extra[select][0]" id="extra[select][0]" rows="5"  class="form-control" />{$category['method']['extra'][0]['select']}</textarea>
<br />注意書き等：<textarea name="extra[note][0]" class="form-control" id="extra[note][0]">{$category['method']['extra'][0]['note']}</textarea>
</td>
</tr>

{else if count($category['method']['extra'])}


{foreach from=$category['method']['extra'] key=k item=v}
<tr id="sort_extra{$k}"><th>項目設定({if $k==0}mail連動{else}{$k}{/if})<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio">
{html_radios name="extra[use][$k]" options=$extraList selected=$v['use']|default:0 separator="&nbsp;"}
</div>
{if $k==0}<i class="powertip fa fa-fw fa-lg fa-info-circle" title="【設定書式】選択項目名,メールアドレス（改行）<br />
選択した項目に紐づけられたメールアドレスに<br />
受注メール（生協管理側と同内容）が送信されます。<br />
項目名とメールアドレスは半角カンマで区切って下さい。
"></i>
{/if}
<div class="clear" style="margin-bottom:0.4em;"></div>

<div class="radio">
{foreach from=$tagList item=i}
{if $k==0}
{if $i!="text" && $i!="textarea" && $i!="datepicker"}
<label><input type="radio" name="extra[tag][{$k}]" {if $category['method']['extra'][{$k}]['tag']==$i}checked="checked"{/if} value="{$i}" />{$i}</label>&nbsp;
{/if}
{else}
<label><input type="radio" name="extra[tag][{$k}]" {if $category['method']['extra'][{$k}]['tag']==$i}checked="checked"{/if} value="{$i}" />{$i}</label>&nbsp;
{/if}
{/foreach}
</div>

<div class="clear" style="margin-bottom:0.4em;"></div>


項目名：<input type="text" name="extra[title][{$k}]" id="extra[title][{$k}]" class="form-control" value="{$v['title']}" />
<textarea name="extra[select][{$k}]" id="extra[select][{$k}]" cols="40" rows="5" class="form-control"
placeholder="{if $k==0}選択項目1,example@example.example.com(改行){else}選択項目1(改行)･･･{/if}">{$v['select']}</textarea>
<br />注意書き等：<textarea name="extra[note][{$k}]" class="form-control" id="extra[note][{$k}]">{$v['note']}</textarea>
</td>
</tr>
{/foreach}
{/if}


<tr id="sort_memo"><th>備考欄の項目テキスト<br /><span class="em08">（デフォルトは「備考欄」です）</span></th>
<td>
<div class="radio">{html_radios name="memo[use]" options=$extraList selected=$category['method']['memo']['use'] output=$extraLavel separator="&nbsp;"}</div>
<input type="text" name="memo[title]" id="memo[title]" class="form-control" value="{$category['method']['memo']['title']|default:"備考欄"}" /></td>
</tr>

<tr id="sort_agree"><th>規約に同意チェック</th>
<td>
<div class="radio">{html_radios name="agree[use]" options=$extraList selected=$category['method']['agree']['use'] output=$extraLavel separator="&nbsp;"}</div>
<input type="text" name="agree[title]" id="agree[title]" class="form-control" value="{$category['method']['agree']['title']}" placeholder="（カード情報提供について）" 
 /><br />

<input type="text" name="agree[select]" id="agree[select]" class="form-control" value="{$category['method']['agree']['select']}" placeholder="（○○に同意します）" />
<textarea name="agree[note]" id="agree[note]" class="form-control" rows="5" placeholder="（規約などを入力）">{$category['method']['agree']['note']}</textarea>
<p class="help-block">URLを自動でリンクに変換します。</p>
</td>
</tr>


<tr id="sort_stock_multi"><th>multi在庫設定<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<span class="tag min">必須項目</span>
<input type="hidden" name="stock_multi[use]" value="2" />
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="【設定書式】選択項目名,在庫(半角数字)（改行）<br />
項目名と在庫数は半角カンマで区切って下さい。
"></i>
<div class="clear" style="margin-bottom:0.4em;"></div>

<div class="radio-group clearfix">
{html_radios name="stock_multi[tag]" options=$tagstockList selected=$category['stock_multi']['tag'] assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>

<div class="clear" style="margin-bottom:0.4em;"></div>


項目名：<input type="text" name="stock_multi[title]" id="stock_multi[title]" class="form-control" value="{$category['stock_multi']['title']}" />
<textarea name="stock_multi[select]" id="stock_multi[select]" class="form-control" rows="5"
placeholder="選択項目1,在庫数(改行)">{$category['stock_multi']['select']}</textarea>
<br />注意書き等：<textarea name="stock_multi[note]" class="form-control" id="stock_multi[note]">{$category['stock_multi']['note']}</textarea>
</td>
</tr>
</tbody>

</table>

</div><!-- #sortable -->

<div class="right" id="create_method"><a class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>任意項目生成</a></div>

<div id="extra_method" class="none">

<div class="radio">
{html_radios name="extra[use][]" options=$extraList separator="&nbsp;"}
</div>

<div class="clear" style="margin-bottom:0.4em;"></div>

<div class="radio">
{html_radios name="extra[tag][]" options=$tagList separator="&nbsp;"}
</div>
<div class="clear" style="margin-bottom:0.4em;"></div>


項目名：<input type="text" name="extra[title][]" class="form-control" value="" disabled="disabled" />

<textarea name="extra[select][]" class="form-control" cols="40" rows="5" placeholder="選択項目1(改行)･･･" disabled="disabled" ></textarea>
注意書き等：<input type="text" class="form-control" name="extra[note][]" disabled="disabled" />
</div>
<script type="text/javascript">
//<![CDATA[

$(function(){
	var h = [];
$('[id^="sort_extra"]').each(function(){
	var id = $(this).attr('id').replace(/sort_extra/,'');
	h.push(id);
});

n = Math.max.apply(null, h)+1; 


$(document).on('click',"#create_method",function(){
	var td = $("#extra_method").html()
	td = (td.replace(/\[\]/g,'['+n+']'));
	$("#sortable tbody").append('<tr id="sort_extra'+n+'"><th>追加項目設定('+n+')<br ><span class="em08">選択項目ごとに改行してください。1行ごとに選択項目として設定されます。</span></th><td>'+td+'</td></tr>');
	n++;
});
});

//]]>
</script>



<input type="hidden" id="result" name="result" value="{$result}" />
