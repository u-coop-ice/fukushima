{capture assign="header_insert"}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">
$(function(){
	$("#theForm").validationEngine({
	promptPosition: "inline",
	scrollOffset: 200
	});
});
</script>

{/literal}
{/capture}

{* ページタイトル 開始 *}
{capture assign="page_title"}アカウント登録{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}

{if $page_title}<h4>{$page_title}</h4>{/if}


<form id="theForm" class="form-horizontal" action="{$self}?mode=confirm" method="post" enctype="x-www-form-urlencoded">

<h5>入力したアドレスに受信確認メールを送信します。</h5>

<div class="form-group">
<label class="col-sm-3 control-label">E-mail<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="email" name="email" id="email" maxlength="128" class="form-control input-lg validate[required,custom[email]]" value="{$post['email']}"/>
{if $error['no_email']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
{if $error['no_same_email']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
{if $error['duplicate_email']}<p><span class="must_view">*このメールアドレスでは登録できません</span></p>{/if}
{if $error['email']}<span class="must_view">*必須項目です</span>{/if}
<p class="help-block">携帯メールアドレスを登録の場合、<code>u-coop.or.jp</code>ドメインからのメールを受信可能に設定してください。</p>
</div>
</div>

{*<div class="form-group">
<label class="col-sm-3 control-label">E-mail（確認）<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="email" name="emailcfrm" id="emailcfrm" maxlength="128" class="form-control input-lg validate[required,custom[email],equals[email]]" value="{$post['emailcfrm']}"/>
{if $error['no_emailcfrm']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
{if $error['no_same_email']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
{if $error['emailcfrm']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>*}

<h4>{$init_coopnameOfficial}サイト 会員規約の確認と同意</h4>

<div class="form-group">
<div class="rule_membership">

{include file="rule_membership.tpl"}
</div>

<p class="checkbox center">
<label for="agreement" ><input type="checkbox" id="agreement" name="agreement" {if $post['agreement']}checked="checked"{/if}value="1" {*class="validate[required]"*} />
{$init_coopnameOfficial}サイト 会員規約へ同意します。</label>
</p>

{if $error['agreement']}<p class="tag red">*会員規則にご同意いただけませんと、ユーザー登録を完了できません。</span></p>{/if}

</div>

<div class="contact">
<div class="row">
<div class="col-sm-8 col-sm-offset-2"><button class="btn btn-primary btn-block" type="submit" name="confirm" value="入力内容確認">入力内容確認へ進む<i class="fa fa-fw fa-chevron-right"></i></button>
</div></div>
</div>

</form>


{* フッター部分の組み込み *}
{include file='footer.tpl'}

