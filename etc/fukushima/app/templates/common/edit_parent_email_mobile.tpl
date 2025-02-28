<div id="form-group_parent_email_mobile" class="form-group">
{if $regist['rc_pem']}
<label class="control-label col-sm-3">携帯電話 E-mail</label>
<div class="col-sm-9">
<p class="form-control-static">{$regist['parent_email_mobile']}</p>
</div>
{else}
<label class="control-label col-sm-3">携帯電話 E-mail{if $methods['parent_email_mobile']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="parent_email_mobile" name="parent_email_mobile" class="form-control input-lg validate[custom[email]]" maxlength="64" value="{$regist['parent_email_mobile']}" />
<br /><span class="em09 red">「@u-coop.or.jp」からのメールを受信可能にしてください。</span>
{if $error['parent_email_mobile']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_parent_email_mobile']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}

<label>携帯電話 E-mail<span class="em08">（確認）</span>{if $methods['parent_email_mobile']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<input type="text" id="parent_emailcfrm_mobile" name="parent_emailcfrm_mobile" class="form-control input-lg validate[custom[email],equals[parent_email_mobile]]" maxlength="64" value="{$regist['parent_email_mobile']}" />
{if $error['non_parent_email_mobile']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
</div>
{/if}
</div>