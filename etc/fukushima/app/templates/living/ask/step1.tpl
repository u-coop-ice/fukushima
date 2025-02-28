{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
$(function(){
$("#theForm").validationEngine({
	promptPosition : "inline",
	scrollOffset : 250
});
});
</script>

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

<div class="contact">
<h4 class="top">受験生・新入生の方は</h4>



<p>受験生・新入生の方は「受験生・新入生サポートサイト」よりお問い合わせください。</p>
<p><a class="btn btn-primary" href="https://newlife.u-coop.or.jp/{$smarty.const.DOMAIN}/app/ask/" target="_blank"><i class="wf_newlife"></i>受験生・新入生のお問合せ<i class="fa fa-fw fa-chevron-right"></i></a></p>
</div>

{*if !$login}
<div class="contact">
<h5 class="">ユーザー登録済みの方はサインインしてください。入力項目を大幅に省略することができます。</h5>


<p><a class="btn btn-info" id="login" href="{$init_url}app/user/">サインイン（新規登録）<i class="fa fa-fw fa-chevron-right"></i></a></p>


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
<input type="text" id="title" name="subject" value="{$post['subject']|default:"物件のお問い合わせ"}" placeholder="（件名を入力ください）"  class="form-control input-lg validate[required]" />
{if $subject_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
{*if $login}
<div class="form-group">
<label class="control-label col-sm-3">関連するお申込み</label>
<div class="col-sm-9">
<select type="text" id="app_id" name="app_id" class="form-control input-lg">
<optgroup></optgroup>
<option value="">（関連するお申込みがありましたら選択ください）</option>
{apps}
{get_app_info app_id=$app['id']}
<option value="{$app['id']}" {if $post['app_id']==$app['id']}selected="selected"{/if}>【{$app['regist_code']}】{$app['category_denomination']}</option>
{/apps}
</select>
{if $app_id_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
{/if*}

<div class="form-group">
<label class="control-label col-sm-3">対象物件<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<p class="form-control-static">{$post['target']|default:"対象物件なし"}</p>
<input type="hidden" name="target" value="{$post['target']}" />
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-3">お問い合わせ内容<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="checkbox">
<p class="">{html_checkboxes output=$purposeList values=$purposeList name="purpose" selected=$post['purpose'] }</p>
</div>



<textarea rows="8" name="memo" id="memo" placeholder="内容はできるだけ詳しくお書き下さい。" class="form-control input-lg validate[required]" >{$post['memo']}</textarea>

{if $memo_err}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
<br class="clear" />
<div class="box">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<p class="center"><button class="submit btn btn-primary btn-block" type="submit" name="confirm" value="入力内容の確認">入力内容の確認に進む<i class="fa fa-fw fa-chevron-right"></i></button></p>
</div>
</div>
</div>

</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}

