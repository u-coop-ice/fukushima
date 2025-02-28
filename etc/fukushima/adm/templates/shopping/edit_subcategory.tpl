{capture assign="header_insert"}
{literal}


<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
$(".date_time").AnyTime_picker(
{ format: "%Y-%m-%d %H:%i:%S" } );
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
サブカテゴリの{if $view_subcategory_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

{sp_subcategories id=$view_subcategory_id}
<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">サブカテゴリを保存しました。</p>
{/if}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_subcategory">
{if $view_subcategory_id}
<input type="hidden" name="subcategory_id" value="{$view_subcategory_id}" />
{/if}
<table class="inputForm">
<tr>
<th>親カテゴリ<span class="label label-danger">必須</span></th>
<td>
<select name="category_id" id="category_id" class="form-control">
<option value=""></option>
{sp_categories}
<option value="{$category['id']}" {if $category['id']==$subcategory['category_id']}selected="selected"{/if}>{$category['denomination']}</option>
{/sp_categories}
</select>
</td>
</tr>
<tr>
<th>サブカテゴリ名称<span class="label label-danger">必須</span></th>
<td><input  class="form-control" type="text" name="denomination" id="denomination" size="50" value="{$subcategory['denomination']}" /></td>
</tr>
<tr>
<th>ご利用案内のサブカテゴリ毎の記載設定</th>
<td><textarea name="description" class="form-control" id="text" cols="50" rows="10" >{$subcategory['description']}</textarea></td>
</tr>

<tr>
<th>お酒フラグ</th>
<td><div class="checkbox">
<label><input type="checkbox" name="flag_drink" id="flag_drink" value="1" {if $subcategory['flag_drink']}checked="checked"{/if} /> このサブカテゴリの商品を選択の場合、年齢入力が必須になります。</label></div>
</td>
</tr>

<tbody id="term">
<tr>
<th>配送日指定<br />
<span class="em08">配送日指定のON/OFFは商品設定で行います。</span>
</th>
<td>
{if $subcategory['category_flag_send']}<strong class="em09 red"><i class="fa fa-exclamation-triangle"></i> 親カテゴリで配送日時一括指定の場合は設定不可</strong><br />{/if}
<div class="pull-left">
<input type="text" name="term_start" id="term_start" class="form-control date datetime" value="{$subcategory['term_start']}" {if $subcategory['category_flag_send']}disabled="disabled"{/if} /></div>
<div class="pull-left"><p class="form-control-static">〜</p></div>
<div class="pull-left">
<input type="text" name="term_end" id="term_end" class="form-control date datetime" value="{$subcategory['term_end']}" {if $subcategory['category_flag_send']}disabled="disabled"{/if} /></div>
<span class="dismiss"><a class="btn btn-primary btn-sm"><i class="fa fa-remove">リセット</i></a></span>
<div class="clear"></div>
<p class="help-block">（通年運用の場合は空欄でOK）</p>

<div class="pull-left">
<p class="form-control-static">指定可能日は</p></div>
<div class="pull-left">
{if $subcategory['category_flag_send']}
<select name=intervals class="form-control" disabled="disabled">
{html_options options=$intervalList selected=$subcategory['intervals']}
</select>
{else}
<select name=intervals class="form-control">
{html_options options=$intervalList selected=$subcategory['intervals']}
</select>
{/if}
</div>
<div class="pull-left">
<p class="form-control-static">営業日後</p></div>
</td>
</tr>
</tbody>

<tr>
<th>受注開始</th>
<td>
<div class="pull-left"><input type="text" name="open_date" class="form-control date_time datetime" id="open_date" value="{$subcategory['open_date']}" />
<span class="reset" id="reset_ld"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span></div>
<div class="clearfix"></div>
</td>
</tr>


<tr>
<th>受注終了</th>
<td>
<div class="pull-left"><input type="text" name="limit_date" class="form-control date_time datetime" id="limit_date" value="{$subcategory['limit_date']}" />
<span class="reset" id="reset_ld"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span>
</div>
</td>
</tr>

<tr>
<th>サブカテゴリをショッピングサイトに表示</th>
<td>
<div class="radio radio-group clearfix">
<div><label for="visible_off"><input type="radio" name="visible" id="visible_off" value="0"{if !$subcategory['visible']} checked="checked"{/if}>非表示</label></div>
<div><label for="visible_on"><input type="radio" name="visible" id="visible_on" value="1"{if $subcategory['visible']} checked="checked"{/if}>表示</label></div>
</div>
</td>
</tr>


<tr>
<th>並び順</th>
<td><input type="text" name="sort_order" id="sort_order" class="form-control" size="10" value="{$subcategory['sort_order']}" /></td>
</tr>
{*
<tr>
<th><label for="return_message">返信メールのデフォルト追記設定</label></th>
<td><textarea name="return_message" id="text" cols="50" rows="10" style="width : 90%;">{$subcategory_return_message}</textarea></td>
</tr>
*}

</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存">保存する</button></p>
</form>
{/sp_subcategories}
{if $no_category && !$new}
<p class="note">サブカテゴリが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="error">サブカテゴリの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
