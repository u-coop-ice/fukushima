{capture assign="header_insert"}
{literal}

<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
$("#limit_date").AnyTime_picker(
{ format: "%Y-%m-%d %H:%i:%S" } );
});

$(function(){
	$('.reset').each(function(){
		$(this).on('click',function(){
//			$(this).prev('input').val('');
			if ($(this).prev('input').attr('id')=="limit_date"){
			$(this).prev('input').val('2036-01-01 23:59:59');
			}
			if ($(this).prev('input').attr('id')=="open_date"){
			$(this).prev('input').val('1970-01-01 00:00:00');
			}
		});
	});
});

//]]>
</script>

<script type="text/javascript">
//<![CDATA[

$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").next().addClass("checked");
$("input:checked").parent().addClass("checked");

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');	
		});
		$(this).addClass('checked');
	});
});
//]]>
</script>

{/literal}
{/capture}

{capture assign="page_title"}
孫カテゴリの{if $view_sub2category_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

{sp_sub2categories id=$view_sub2category_id}
<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">孫カテゴリを保存しました。</p>
{/if}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_sub2category">
{if $view_sub2category_id}
<input type="hidden" name="sub2category_id" value="{$sub2category['id']}" />
{/if}
<table class="inputForm">
<tr>
<th>カテゴリ &gt; サブカテゴリ</th>
<td>
<select class="form-control" name="subcategory_id" id="subcategory_id">
<option value=""></option>
{sp_subcategories}
<option value="{$subcategory['id']}" {if $subcategory['id']==$sub2category['subcategory_id']}selected="selected"{/if}>{$subcategory['category_denomination']} &gt; {$subcategory['denomination']}</option>
{/sp_subcategories}
</select>
</td>
</tr>
<tr>
<th>名前</th>
<td><input type="text" name="denomination" id="denomination" class="form-control" value="{$sub2category['denomination']}" /></td>
</tr>
<tr>
<th>概要</th>
<td><textarea name="description" id="text" class="form-control">{$sub2category['description']}</textarea></td>
</tr>

<tr>
<th>受注終了</th>
<td>
<div class="pull-left"><input type="text" class="form-control datetime" name="limit_date" id="limit_date" value="{$sub2category['limit_date']}" />
<span class="reset" id="reset_ld"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span>
</div>
</td>
</tr>

<tr>
<th>孫カテゴリをショッピングサイトに表示</th>
<td>
<div class="radio-group radio">
<div><label for="visible_off"><input type="radio" name="visible" id="visible_off" value="0"{if !$sub2category['visible']} checked="checked"{/if}>非表示</label></div>
<div><label for="visible_on"><input type="radio" name="visible" id="visible_on" value="1"{if $sub2category['visible']} checked="checked"{/if}>表示</label></div>
</div>
</td>
</tr>


<tr>
<th>並び順</th>
<td><input type="text" name="sort_order" id="sort_order" class="form-control" value="{$sub2category['sort_order']}" /></td>
</tr>
</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存">保存</button></p>
</form>
{/sp_sub2categories}
{if $no_sub2category && !$new}
<p class="alert alert-info">孫カテゴリが見つかりませんでした。<br >no_cat = {$no_sub2category}, new = {$new}</p>
{/if}
{if $db_error}
<p class="alert alert-danger">孫カテゴリの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
