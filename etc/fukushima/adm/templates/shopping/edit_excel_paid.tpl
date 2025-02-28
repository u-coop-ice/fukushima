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

$("input:checked").parent('label').addClass("checked");

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

$(function(){
	$('[name="paid"]').click(function() {
		setDatePaid();
	});
		setDatePaid();
});

function setDatePaid(){
		if ($('[name="paid"]:checked').val()==1){
			$("#tr_date_paid").show().find('input').prop("disabled",false);

		} else {
			$("#tr_date_paid").hide().find('input').prop("disabled",true);
		}
}




//]]>
</script>
{/literal}
{/capture}
{* HTMLのヘッダー部分に挿入するJavaScript 終了 *}

{* ページタイトル 開始 *}
{assign var="page_title" value="支払いフラグでのデータの書き出し"}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}


{* 記事本体 開始 *}
<h4 class="page_title">{$page_title}</h4>


{* 絞り込み *}
<p><strong class="">データの絞り込み条件</strong></p>
<form method="post" action="{$self}?mode=export_excel_paid" class="filter_entry">
<table class="inputForm">
<col style="width:30%" /><col style="width:70%" />
<tr>
<th>カテゴリ</th>
<td>
<select name="category_id" id="category_id" class="form-control" >
<option value=""></option>
{sp_categories}
<option value="{$category['id']}" {if $condition['category_id']==$category['id']}selected="selected"{/if}>{$category['denomination']}</option>
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
<th>期間設定（注文日基準）</th>
<td>
<div class="pull-left"><input type="text" id="term1" name="term1" value="{$condition['term1']}" class="form-control date datetime" placeholder="期間開始"></div>
<div class="pull-left"><p class="form-control-static">〜</p></div>
<div class="pull-left"><input type="text" id="term2" name="term2" value="{$condition['term2']}" class="form-control date datetime" placeholder="期間終了"></div>
<div class="clearfix"></div>
<span class="tag min dismiss"><a><i class="fa fa-remove">リセット</i></a></span>
</td>
</tr>


<tr>
<th>入金管理</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="paid" options=$paidList output=$paidList selected=$condition['paid'] assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>

{*<label class="tag green"><input type="hidden" name="paid" value="1">入金済</label>*}
</td></tr>

<tr id="tr_date_paid">
<th>口座入金日</th>
<td>
<div class="pull-left"><input type="text" name="date_paid1" id="date_paid1" class="form-control date datetime" placeholder="（日付）" value="{$condition['date_paid1']}"></div>
<div class="pull-left"><p class="form-control-static">〜</p></div>
<div class="pull-left"><input type="text" name="date_paid2" id="date_paid2" class="form-control date datetime" placeholder="（日付）" value="{$condition['date_paid1']}"></div>

<span class="tag min dismiss"><a><i class="fa fa-remove">リセット</a></i></span><br />
<div class="clearfix"></div>

</td>
</tr>


</table>

<button class="btn btn-primary" type="submit" value="書き出し"><i class="fa fa-fw fa-file"></i>書き出し</button>
</form>

{* 記事本体 終了 *}


{* フッター部分の組み込み *}
{include file='footer.tpl'}
