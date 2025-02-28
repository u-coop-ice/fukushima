{capture assign="header_insert"}
{literal}
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
宛先の{if $view_category_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

{ask_categories id=$view_category_id}
<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success saved">宛先を保存しました。</p>
{/if}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_category">
{if $category['id']}
<input type="hidden" name="category_id" value="{$category['id']}" />
{/if}
<table class="inputForm" cellspacing="0">
<tr>
<th>宛先名<span class="label label-danger">必須</span></th>
<td><input type="text" name="denomination" id="denomination" class="form-control" value="{$category['denomination']}" /></td>
</tr>
<tr>
<th>メール送信先<br /><span class="em09">初期設定アドレス以外に送信先が<br />必要な場合入力してください。</span></th>
<td>
<p class="em09">To:{if $component[$smarty.const.COMPONENT]['store_ordermail']}{$component[$smarty.const.COMPONENT]['store_ordermail']}{else}{$init_ordermail}{/if}</p>
<input type="text" name="ordermail" id="ordermail" class="form-control" value="{$category['ordermail']}" />
<p class="help-block">Ccでメールが送信されます。</p>
</td>
</tr>
<tr>
<th>概要</th>
<td><textarea name="description" id="category_text" cols="50" class="form-control">{$category['description']}</textarea></td>
</tr>
{*<tr>
<th>ラベルカラー</th>
<td><input type="text" name="color" id="color" class="form-control" value="{$category['color']}" /></td>
</tr>*}

<tr>
<th>公開設定</th>
<td>
<div class="radio radio-group clearfix">
<div><label for="visible_off"><input type="radio" name="visible" id="visible_off" value="0"{if !$category["visible"]} checked="checked"{/if}>非表示</label></div>
<div><label for="visible_on"><input type="radio" name="visible" id="visible_on" value="1"{if $category["visible"]} checked="checked"{/if}>表示</label></div>
</div>
</td>
</tr>

<tr>
<th>並び順<span class="label label-danger">必須</span></th>
<td><input type="text" name="sort_order" id="sort_order" class="form-control" value="{$category['sort_order']}" /></td>
</tr>
</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存"><i class="fa fa-fw fa-check"></i>保存する</button></p>
</form>
{/ask_categories}
{if $no_category && !$new}
<p class="alert alert-info">宛先が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">宛先の読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
