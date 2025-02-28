<div id="form-group_email" class="form-group">
<label class="control-label col-sm-3">E-mail<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="email" name="email" class="form-control input-lg validate[required,custom[email]]" maxlength="64" value="{$regist['email']}" />
<p><span class="em09 red">入力内容確認の自動返信メールを送信します。携帯のアドレスを入力の場合は「@u-coop.or.jp」からのメールを受信可能にしてください。</span></p>
{if $error['email']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div id="form-group_emailcfrm" class="form-group">
<label class="control-label col-sm-3">E-mail<span class="em08">（確認）</span><span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="emailcfrm" name="emailcfrm" class="form-control input-lg validate[required,custom[email],equals[email]]" maxlength="64" value="{$regist['emailcfrm']}" />
{if $error['nonemail']}<span class="must_view">*メールアドレスが一致しません</span>{/if}
</div>
</div>