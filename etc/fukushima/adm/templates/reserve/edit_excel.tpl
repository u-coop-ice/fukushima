{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}
<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){
$(".date").AnyTime_picker(
{ format: "%Y-%m-%d" } );
})

$(function(){
	$('.reset').each(function(){
		$(this).on('click',function(){
			$(this).parent('td').find('input,select').val('');
		});
	});
});

$(function(){
$("#exportForm").validationEngine({
promptPosition : "inline"
});
});
//]]>
</script>

{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="登録データの書き出し"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 記事本体 開始 *}
<h4 class="page_title">{$category['denomination']} {$page_title}</h4>


{* 絞り込み *}
<h5>データの絞り込み条件</h5>
<form id="exportFrom" method="post" action="{$self}?mode=export_excel" class="filter_entry">
<table class="inputForm">
<tr><th>カテゴリ</th>
<td>
<select class="form-control" id="category_id" name="category_id">
<option></option>
{categories component="reserve" no_archived=1}
<option value="{$category['id']}">{$category['denomination']}</option>
{/categories}
</select>

</td>
</tr>

{literal}
<script type="text/javascript">
$(function(){
$('#category_id,[name="opt_cancelled"]').on('change',function(){
	var category_id = $('#category_id').val();
	var opt_cancelled = $('[name="opt_cancelled"]:checked').val();
	$.ajax({
	type: "post",
	url: "./?mode=select_comedate",
	async: true,
	dataType: "json",
	data: {category_id:category_id,opt_cancelled,opt_cancelled}
	}).done(function(r){
	if (r.error){
	$('#selectable_comedate').hide();
//	$('#cometime_spin').html('');
	$('button[type="submit"]').prop("disabled",true);
	} else {
		if (r.select){
		$('#selectable_comedate').html(r.select);
		$('button[type="submit"]').prop("disabled",false);
//		$('#cometime_spin').html('');
		$('#selectable_comedate').show();
		} else {
			$('#selectable_comedate').text('登録のある日付はありません');
		}
		}
}).fail(function(e){
			$('#selectable_comedate').text('データベース処理に失敗しました');
});





});
});
</script>
{/literal}


<tr>
<th>キャンセル</th>
<td>
<div class="radio">
<label><input type="radio" name="opt_cancelled" checked="checked" value="1"> 含めない</label>
<label><input type="radio" name="opt_cancelled" value="0"> 含める</label>
</div>
</td>
</tr>

<tr>
<th>登録日</th>
<td>
<div id="selectable_comedate"></div>
{*<select class="form-control" name="comedate">
<option></option>
{foreach from=$dateList item=date}
<option var="{$date}">{$date}</option>>
{/foreach}
</select>*}
{*<div class="pull-left"><input class="form-control datepicker date" type="text" id="term1" name="term1" value="{$post['term1']}" /></div><div class="pull-left"><p class="form-control-static">〜</p></div>
<div class="pull-left"><input class="form-control datepicker date" type="text" id="term2" name="term2" value="{$post['term2']}" /></div>*}
{*<div class="clearfix"></div><span class="reset"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span>*}
<span class="help-block">過去30日間で営業日設定から選択可能です。</span>
</td>
</tr>

{*<tr>
<th>アーカイブデータ</th>
<td>
<div class="radio">
<label><input type="radio" name="opt_archived" checked="checked" value="1"> 含めない</label>
<label><input type="radio" name="opt_archived" value="0"> 含める</label>
</div>
</td>
</tr>
<tr>
<th>書き出し履歴</th>
<td>
<p class="form-control-static">すべて
<input type="hidden" id="export_date" name="export_date" value="all" />
</p>
</td>
</tr>
*}
</table>

<button type="submit" class="btn btn-primary" value="書き出し"><i class="fa fa-fw fa-check"></i>書き出し（時間がかかる場合があります）</button>
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
