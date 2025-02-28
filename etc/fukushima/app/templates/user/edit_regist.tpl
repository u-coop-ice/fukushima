{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
$(function($){
/*
	$("#theForm").validationEngine({
		promptPosition: 'inline',
			scrollOffset:200
	});
});*/
</script>


<script type="text/javascript" src="/js/jquery/zip2addr/jquery.zip2addr-utf8.js"></script>
<script type="text/javascript">
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
});
</script>
{/literal}
{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}登録内容の追加・編集{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* フォーム 開始 *}

<form id="theForm" class="form-horizontal" action="{$self}?mode=save_regist" method="post" enctype="x-www-form-urlencoded">

{*<tr><th>入学年度</th><td>{$regist['year']}年度</td></tr>*}

<div class="form-group">
<label class="col-sm-3 control-label">大学名</label>
<div class="col-sm-9"><p class="form-control-static input-lg">{$init_univname}</p>
</div>
</div>
{if $smarty.get.mode=="save_regist"}
{include file='post_dept.tpl'}
{include file='post_name.tpl'}
{include file='post_membership.tpl'}
{include file='post_sex.tpl'}
{include file='post_age.tpl'}
{include file='post_new_add.tpl'}
{include file='post_student_phone.tpl'}
{include file='post_mobilephone.tpl'}
{include file='post_address.tpl'}
{include file='post_phonenumber.tpl'}
{else}
{include file='edit_dept.tpl'}
{include file='edit_name.tpl'}
{include file='edit_membership.tpl'}
{include file='edit_sex.tpl'}
{include file='edit_age.tpl'}
{include file='edit_new_add.tpl'}
{include file='edit_student_phone.tpl'}
{include file='edit_mobilephone.tpl'}
{include file='edit_address.tpl'}
{include file='edit_phonenumber.tpl'}
{/if}
</table>

<br class="clear" />
{if $reffer["component"]}
<button class="btn btn-primary submit" type="submit" name="confirm" value="保存してお申込みを続ける">保存してお申込みを続ける<i class="fa fa-fw fa-chevron-right"></i></button>
{else}
<button class="btn btn-primary submit" type="submit" name="confirm" value="保存する"><i class="fa fa-fw fa-edit"></i>保存する</button>
{/if}
</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}

