<div id="form-group_parent_email" class="form-group">
{if $post['rc_pe']}
<label class="col-sm-3 control-label">E-mail</label>
<div class="col-sm-9">
<p class="fom-control-static input-lg">{$post['parent_email']}</p>
</div>
{else}
<label class="col-sm-3 control-label">E-mail{if $note_parent_email==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="parent_email" name="parent_email" class="form-control input-lg validate[custom[email]]" maxlength="64" value="{$post['parent_email']}" />
<br /><span class="help-block">「@u-coop.or.jp」からのメールを受信可能にしてください。</span>
{if $error['parent_email']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_parent_email']}<span class="must_view">*メールアドレスの形式が不正です</span>{/if}
</div>

<label class="col-sm-3 control-label">E-mail<span class="em08">（確認）</span>{if $note_parent_email==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<input type="text" id="parent_emailcfrm" name="parent_emailcfrm" class="form-control input-lg validate[custom[email],equals[parent_email]]" maxlength="64" value="{$post['parent_email']}" />
{if $error['non_parent_email']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
</div>
{/if}
</div>
