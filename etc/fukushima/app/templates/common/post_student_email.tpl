<div id="form-group_student_email" class="form-group">
{if $post['rc_se']}
<label class="col-sm-3 control-label">E-mail</label>
<div class="col-sm-9">
<p class="form-control-static">{$post['student_email']}</p>
</div>
{else}
<label class="col-sm-3 control-label">E-mail{if $note_student_email==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="student_email" name="student_email" class="form-control input-lg validate[custom[email]]" maxlength="64" value="{$post['student_email']}" />
<br /><span class="em09 red">「@u-coop.or.jp」からのメールを受信可能にしてください。</span>
{if $error['student_email']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_student_email']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
</div>
<label class="col-sm-3 control-label">E-mail<span class="em08">（確認）</span>{if $note_student_email==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="student_emailcfrm" name="student_emailcfrm" class="form-control input-lg validate[custom[email],equals[student_email]]" maxlength="64" value="{$post['student_email']}" />
{if $error['non_student_email']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
</div>
{/if}</div>