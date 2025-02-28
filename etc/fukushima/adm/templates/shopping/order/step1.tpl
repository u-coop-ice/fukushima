{capture assign="header_insert"}
{literal}

<script type="text/javascript" src="/js/jquery/gpObserveText/jquery.gpobservetext-1.0.min.js"></script>
<script type="text/javascript" src="/adm/ajax/js/search_regist.js"></script>


<link rel="stylesheet" href="/js/jquery/jquery-ui-1.11.4/bootstrap/jquery-ui.custom.css" type="text/css" media="all" />

<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>


<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="/app/js/jquery.validationEngine-ja.js"></script>


<script type="text/javascript">
//<[!CDATA[

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

$(function($){
	$("#theForm").validationEngine({
		promptPosition: "inline"
	});
});



//]]>
</script>

<style>
ul.ui-autocomplete li.ui-menu-item a {
	text-align:left !important;
}
</style>

{/literal}
{/capture}

{assign var="page_title" value="新規注文作成"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>

{if $saved}
<p class="alert alert-info">設定を保存しました。</p>
{/if}

<form id="theForm" method="post" action="{$self}?mode=confirm">
<table class="inputForm" cellspacing="0">

<tr>
<th>カテゴリ</th>
<td>
<select name="category_id" class="validate[required] form-control">
<option value="">（カテゴリの選択）</option>
{sp_categories}
<option value="{$category['id']}">{$category['denomination']}</option>
{/sp_categories}
</select>
{if $category_id_err}<span class="must_view">*必須項目です</span>{/if}

</td>
</tr>

{if $view_regist_id}
<tr>
<th>ユーザー情報</th>
<td>
{regists rid=$view_user_id}{$regist['namef']} {$regist['nameg']}<br />{$regist['username']}
{/regists}
<label for="regist_id"><input type="hidden" id="regist_id" name="regist_id" value="{$view_regist_id}" /></label>
</td>
</tr>


{literal}
<script type="text/javascript">
//<[!CDATA[
$(function() {
	$('#username').removeAttr('disabled').prop('readonly',true);
	$('#regist_id').removeAttr('disabled');
});
//]]>
</script>
{/literal}



{else}
<tr>
<th>ユーザー登録</th>
<td colspan="3">
<div class="radio radio-group clearfix">
{html_radios name="regist_user" class="validate[required]" options=$registList selected=$fix_registered output=$registList assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
</td>
</tr>

<tr>
<th>氏名</th>
<td colspan="3">
<input type="text" id="username" class="form-control validate[required]" placeholder="ユーザー名から検索" />
<label for="regist_id"><input type="hidden" id="regist_id" name="regist_id" /></label>
<div id="regist_info"></div>
<div id="loading" class="none"><i class="fa fa-spinner fa-pulse"></i></div>

</td>
</tr>
</table>
{/if}

<div class="box">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
	<button class="btn btn-primary btn-block" type="submit" name="order" value="1">商品選択に進む<i class="fa fa-fw fa-chevron-right"></i></button>
</div>
</div>
</div>
</form>


{include file='footer.tpl'}
