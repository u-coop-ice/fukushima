{if $regist['rc_se']}
<div id="form-group_student_email" class="form-group">
<label class="control-label col-sm-3">E-mail</label>
<div class="col-sm-9">
<p class="form-control-static">{$regist['student_email']}</p>
</div>
</div>
{else}
<div id="form-group_student_email" class="form-group">
<label class="control-label col-sm-3">E-mail{if $note_student_email==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="student_email" name="student_email" class="form-control input-lg validate[custom[email]]" maxlength="64" value="{$regist['student_email']}" />
<br /><span class="help-block">「@u-coop.or.jp」からのメールを受信可能にしてください。</span>
{if $error['student_email']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_student_email']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
</div>
</div>

<div id="form-group_student_emailcfrm" class="form-group">
<label class="control-label col-sm-3">E-mail<span class="em08">（確認）</span>{if $note_student_email==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="student_emailcfrm" name="student_emailcfrm" class="form-control input-lg validate[custom[email],equals[student_email]]" maxlength="64" value="{$regist['student_email']}" />
{if $error['non_student_email']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
</div>
</div>
{/if}
