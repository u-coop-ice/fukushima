{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<![CDATA[
$(function(){

var tt = $('[name="dept_all"]');

tt.on("click",function(){

if (tt.prop('checked')){
		$("[name='dept[]']").prop("disabled",true);
} else {
		$("[name='dept[]']").prop("disabled",false);
}
});

$("#component").on("change",function(){
	var cp = $(this).val();
		$("[id^='set_']").hide();

	if (cp){
		$("#set_"+cp+"_category").show();
	}
});

});
//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="ユーザーデータの書き出し"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}</h4>


{* 絞り込み *}
<h5>データの絞り込み条件</h5>

<form method="post" action="{$self}?mode=export_excel_regist" class="filter_entry">
<table class="inputForm">

<tr>
<th>入学年度</th>
<td>
<div class="pull-left"><select  class="form-control" id="year" name="year">
{html_options options=$registYearList}
</select></div>
<div class="pull-left"><span class="form-control-static">年度</span></div>
</td>
</tr>


<tr>
<th>学部・学科</th>
<td>
<div class="checkbox">
<label class="em14"><input type="checkbox" name="dept_all" value="1" /> すべて</label></div>

{code public=1 name=23}
<div class="checkbox"><label><input name="dept[]" type="checkbox" value="{$code['id']}"> {$code['value']}</label><div>
{/code}
</td>
</tr>

<tr>
<th>component</th>
<td>
<div class="pull-left">
<select class="form-control" id="component" name="component">
<option value=""></option>
{if $authority['entry']['master']}
<option value="entry">汎用エントリ</option>
{/if}
{if $authority['shopping']['master']}
<option value="shopping">ショッピング</option>
{/if}
</select>
</div>
</td>
</tr>

<tbody id="set_entry_category" class="none">
<tr>
<th>汎用エントリのカテゴリ</th>
<td>
<div class="pull-left">
<select class="form-control" name="entry_category_id">
<option value=""></option>
{categories}
<option value="{$category.id}">{$category.denomination}</option>
{/categories}
</select>
</div>
</td>
</tr>
</tbody>

<tbody id="set_shopping_category" class="none">
<tr>
<th>ショッピングのカテゴリ</th>
<td>
<div class="pull-left">
<select class="form-control" name="shopping_category_id">
<option value=""></option>
{sp_categories}
<option value="{$category.id}">{$category.name}</option>
{/sp_categories}
</select>
</div>
</td>
</tr>
</tbody>

<tr>
<th>status</th>
<td>
<input type="hidden" id="status" name="status" value="1" />
<p class="form-control-static">valid</p>
<input type="hidden" id="tmp_update_password" name="tmp_update_password" value="1" /><p class="help-block">新サイト以降ユーザー登録をした／以前のユーザーでも新サイトでサインインをしたユーザーのみ</p>

</td>
</tr>


<th>書き出し履歴</th>
<td>
<p class="form-control-static">すべて</p>
<input type="hidden" id="export_date" name="export_date" value="all" />
</td>
</tr>
</table>

<button class="btn btn-primary" type="submit" value="書き出し">書き出し</button>
</form>

{* 記事本体 終了 *}

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
