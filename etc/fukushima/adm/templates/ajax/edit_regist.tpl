{* ヘッダー部分の組み込み *}
{assign var="init_pagetitle" value="登録情報の編集"}

{capture assign="header_insert"}
{literal}


<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.autoKana/jquery.autoKana.js"></script>
<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>


<script type="text/javascript">
$(function(){

var fm =$("#form")

fm.validationEngine('attach', {
	'promptPosition' : "inline",
	'onValidationComplete': function(form, status){
if (status == true){
	var act = fm.attr("action");
	$.fancybox.showLoading();
	$.ajax({
	url: act,
	type: "post",
	data: form.serializeArray(),
	cache: false,
	async: false,
	dataType: "json"
	}).done(function(e){
		if(e==""){
		parent.$.fancybox.close();
		parent.location.reload();
		$.fancybox.hideLoading();
		return false;
		} else if (e.errmg){
		$.fancybox.hideLoading();
		alert('保存に失敗しました。'+e.errmg);
		return false;
		}
	}).fail(function($e){
		console.log($e);
		$.fancybox.hideLoading();
		alert('保存に失敗しました。');
		return false;
		});
}

  }
});
});


$(function($){
	$('#zipcodef').zip2addr({
	zip2:'#zipcodes',
	pref:'#pref',
	addr:'#addressf'
	}),
	$('#new_zipcodef').zip2addr({
	zip2:'#new_zipcodes',
	pref:'#new_pref',
	addr:'#new_addressf'
	})
$.fn.autoKana('#namef', '#kanaf', {katakana:true});
$.fn.autoKana('#nameg', '#kanag', {katakana:true});

$.fn.autoKana('#parent_namef', '#parent_kanaf', {katakana:true});
$.fn.autoKana('#parent_nameg', '#parent_kanag', {katakana:true});

});


</script>

{/literal}
{/capture}

{include file='preview_header.tpl'}

<form id="form" method="post" class="form-horizontal" enctype="multipart/form-data" action="{$init_url}adm/ajax/?mode=save_regist">

{$html}


{*foreach from=$method key=f item=v}

{if strpos($f, 'extra') !== false }
{include file="post_extra.tpl"}
{else if $notes[4][$f]}
{include file="post_$f.tpl"}
{else if $notes[2][$f] || $notes[3][$f]}
{include file="edit_$f.tpl"}
{/if}
{/foreach*}

<p><button class="btn btn-primary" type="submit" id="submit" value="基本情報を更新する"><i class="fa fa-fw fa-check"></i>基本情報を更新する</button></p>

<input type="hidden" name="regist_id" value="{$post['regist_id']}" />
<input type="hidden" name="app_id" value="{$post['app_id']}" />
<input type="hidden" name="regist_status" value="{$post['status']}" />
<input type="hidden" name="category_id" value="{$post['category_id']}" />

</form>


{if $db_error}
<p>データベースからデータを読み込むのに失敗しました。</p>
{/if}
{* 商品がない場合など 終了 *}

{* フッター部分の組み込み *}
{include file='preview_footer.tpl'}
