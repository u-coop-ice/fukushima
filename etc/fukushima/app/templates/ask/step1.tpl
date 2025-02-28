{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
$(function(){
$("#theForm").validationEngine({
	promptPosition : "inline",
	scrollOffset : 250
});



$("[name='rate']").on('click',function(){
	setRate();
})
	setRate();

});


function setRate(){

rate = $("[name='rate']:checked").val();
//	var rate = Boolean(Number($("[name='rate']:checked").val()));
	if (rate==1){
	$("#form-group_app_id").show().find('select').prop("disabled",false);
	$("#form-group_category_id").hide().find('select').prop("disabled",true);
	} else {
	$("#form-group_app_id").hide().find('select').prop("disabled",true);
	$("#form-group_category_id").show().find('select').prop("disabled",false);

	}
}

</script>

<script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>

{/literal}
{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}お問い合わせ{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}

{if $smarty.session.coop.univ_auth|@count==1}
{assign var=view_univ_id value=$smarty.session.coop.univ_auth[0]}
{/if}


{*if !$login}
<div class="contact">
<h5 class="">ユーザー登録済みの方はサインインしてください。入力項目を大幅に省略することができます。</h5>
<p><a class="btn btn-success btn-block" id="login" href="#form_signin">サインイン／新規登録</a></p>
</div>

{/if*}


<form id="theForm" class="form-horizontal" action="{$self}?mode=confirm" method="post" enctype="x-www-form-urlencoded">
{if !$login}
<h4>メールアドレス入力</h4>
{include file="post_email.tpl"}
<h4>基本情報入力</h4>
{include file="post_name.tpl"}
{include file="post_student_phone.tpl"}
{/if}
<h4>お問い合わせ内容入力</h4>

<div class="form-group">
<label class="control-label col-sm-3">お問い合わせ件名<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="title" name="subject" value="{$post['subject']}" placeholder="（「説明会ついて」など件名を入力ください）"  class="form-control input-lg validate[required]" />
{if $subject_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
{if $login}


{if $regist_app_count}
<div class="form-group">
<label class="control-label col-sm-3">関連するお申込み<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="radio">
<label><input type="radio" name="rate" value=1 {if $post['app_id']}checked="checked"{/if} />あり</label>
<label><input type="radio" name="rate" value=0 {if !$post['app_id']}checked="checked"{/if} />なし</label>
</div>
</div>
</div>


<div class="form-group {if $post['category_id']}none{/if}" id="form-group_app_id">
<label class="control-label col-sm-3">お申込みについて<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select id="app_id" name="app_id" class="form-control input-lg">
<option value="">（関連するお申込みを選択ください）</option>
{apps}
<option value="{$app['id']}" {if $post['app_id']==$app['id']}selected="selected"{/if}>【{$component[$app['component']]['infocode']}{if $app['component']=="entry"}{categories id=$app['category_id']}{if $category['cat_code']}-{$category['cat_code']}{/if}{/categories}{/if}:{$app['regist_date']|date_format:"%Y%m%d"}-{$app['app_count']|string_format:"%04d"}】{if $app['component']=="entry"}{$category['denomination']}{else}{$component[$app['component']]['title']}{/if}</option>
{/apps}
<optgroup></optgroup>>
</select>
{if $error['app_id']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
{else}
<input type="hidden" name="rate" value=0 />
{/if}

<div class="form-group {if $post['app_id']}none{/if}" id="form-group_category_id">
<label class="control-label col-sm-3">お問い合わせ先<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select id="category_id" name="category_id" class="validate[required] form-control input-lg">
<option value="">（宛先を選択）</option>
{ask_categories}
<option value="{$category['id']}" {if $post['category_id']==$category['id']}selected="selected"{/if}>{$category['denomination']}</option>
{/ask_categories}
</select>
{if $error['category_id']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>


{else}

<div class="form-group">
<label class="control-label col-sm-3">お問い合わせ先<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<select id="category_id" name="category_id" class="form-control input-lg validate[required]">
<option value="">（宛先を選択）</option>
{ask_categories}
<option value="{$category['id']}" {if $post['category_id']==$category['id']}selected="selected"{/if}>{$category['denomination']}</option>
{/ask_categories}
</select>
{if $app_id_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>


{/if}

<div class="form-group">
<label class="control-label col-sm-3">お問い合わせ内容<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<textarea rows="8" name="memo" id="memo" placeholder="内容はできるだけ詳しくお書き下さい。" class="form-control input-lg validate[required]" >{$post['memo']}</textarea>

{if $memo_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

{if !$login}
<div class="form-group">
<div class="col-sm-9 col-sm-offset-3">
<div class="g-recaptcha" data-sitekey="{$smarty.const.SITEKEY}" data-action="SUBMIT"></div>
</div>
</div>
{/if}

<div class="contact">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<p class="center"><button class="submit btn btn-primary btn-block" type="submit" name="confirm" value="入力内容の確認">入力内容の確認に進む<i class="fa fa-fw fa-chevron-right"></i></button></p>
</div>
</div>
</div>

</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}

