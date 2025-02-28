{* HTMLのヘッダー部分に挿入するJavaScript 開始 *}
{capture assign="header_insert"}
{literal}

<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>
<script type="text/javascript" src="./js/select_category.js"></script>

<script type="text/javascript">
//<[!CDATA[
$(function($){
	setAttr();
	$("#entry_flag").change( function(){setAttr()});
});

function setAttr() {
	}

$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").next().addClass("checked");

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');	
		});
		$(this).addClass('checked');
	});
});

$(function(){
$(".date").AnyTime_picker(
{ format: "%Y-%m-%d" } );
});

$(function(){
	$('.dismiss').click(function() {
			var pd = $(this).parent('td').find('input');
			$(pd).val('');	
		});
});


//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="受注データの書き出し"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}<span class="tag micro red">ゆうパック版</span></h4>


{* 絞り込み *}
<p><strong class="">データの絞り込み条件</strong></p>
<form method="post" action="{$self}?mode=export_excel_jp" class="filter_entry">
<table class="inputForm">
<col style="width:30%" /><col style="width:70%" />
<tr>
<th>カテゴリ</th>
<td>
<select name="category_id" id="category_id" class="form-control" >
<option value=""></option>
{sp_categories}
<option value="{$category['id']}">{$category['denomination']}</option>
{/sp_categories}
</select>
</td>
</tr>

<tr>
<th>サブカテゴリ</th>
<td>
<select name="subcategory_id" id="subcategory_id" class="form-control" >
</select>
</td>
</tr>

<tr>
<th>商品</th>
<td>
<select name="item_id" id="item_id" class="form-control" >
</select>
</td>
</tr>


<tr>
<th>期間設定（受注日基準）</th>
<td>
<div class="pull-left"><input type="text" id="term1" name="term1" value="" class="form-control date datetime" placeholder="書き出し開始日"></div>
<div class="pull-left"><p class="form-control-static">〜</p></div>
<div class="pull-left"><input type="text" id="term2" name="term2" value="" class="form-control date datetime" placeholder="書き出し終了日"></div>
<div class="clearfix"></div>
<span class="tag min dismiss"><a><i class="fa fa-remove">リセット</a></i></span><br />
<span class="em09">期間設定を使う場合は、受注日は「すべて」にしてください。</span>
</td>
</tr>


<tr>
<th>対応状況</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="status" options=$statusOrderList output=$statusOrderList assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
</td></tr>

<tr>
<th>フォーマット</th>
<td>
<div class="radio-group clearfix">
<div>
<label class="checked"><input type="radio" id="format_all" name="format" value="ALL" checked="checked" /> ゆうパック送り状用</label>
</div>
</div>
<div class="clear"></div>

</td>
</tr>

</table>

<button class="btn btn-primary" type="submit" value="書き出し"><i class="fa fa-fw fa-file"></i>書き出し</button>
</form>

{* 記事本体 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
