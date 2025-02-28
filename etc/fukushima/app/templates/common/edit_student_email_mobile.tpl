{if $regist['rc_sem']}
<div id="form-group_student_email_mobile" class="form-group">
<label class="control-label col-sm-3">携帯電話 E-mail</label>
<div class="col-sm-9">
<p class="form-control-static">{$regist['student_email_mobile']}</p>
</div>
</div>
{else}
<div id="form-group_student_email_mobile" class="form-group">
<label class="control-label col-sm-3">携帯電話 E-mail{if $note_student_email_mobile==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="student_email_mobile" name="student_email_mobile" class="form-control input-lg validate[custom[email]]" maxlength="64" value="{$regist['student_email_mobile']}" />
<br /><span class="help-block">「@u-coop.or.jp」からのメールを受信可能にしてください。</span>
{if $error['student_email_mobile']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_student_email_mobile']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
</div>
</div>
<div id="form-group_student_emailcfrm_mobile" class="form-group">
<label class="control-label col-sm-3">携帯電話 E-mail<span class="em08">（確認）</span>{if $note_student_email_mobile==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="student_emailcfrm_mobile" name="student_emailcfrm_mobile" class="form-control input-lg validate[custom[email],equals[student_email_mobile]]" maxlength="64" value="{$regist['student_email_mobile']}" />
{if $error['non_student_email_mobile']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
</div>
</div>
{/if}