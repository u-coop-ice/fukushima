<div id="form-group_parent_mobile" class="form-group">
<label class="col-sm-3 control-label">保護者携帯電話番号{if $note_parent_mobile==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>
<div class="col-sm-9">
<div class="pull-left">
<input type="text" id="parent_mobile1" name="parent_mobile1" class="form-control input-lg validate[{if $note_parent_mobile==2}required,{/if}custom[onlyNumberSp]]" maxlength="3" value="{$post['parent_mobile1']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="parent_mobile2" name="parent_mobile2" class="form-control input-lg validate[{if $note_parent_mobile==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['parent_mobile2']}" />
</div>
<div class="pull-left"><p class="form-control-static">&#8194;&#8211;&#8194;</p></div>
<div class="pull-left">
<input type="text" id="parent_mobile3" name="parent_mobile3" class="form-control input-lg validate[{if $note_parent_mobile==2}required,{/if}custom[onlyNumberSp]]" maxlength="4" value="{$post['parent_mobile3']}" />
</div>
<span class="help-block">（半角数字）</span>
{if $error['parent_mobile1'] || $error['parent_mobile2'] || $error['parent_mobile3']}<span class="must_view">*必須項目です</span>{/if}
{if $error['no_num_parent_mobile1'] || $error['no_num_parent_mobile2'] || $error['no_num_parent_mobile3']}<span class="must_view">*半角数字で入力してください</span>{/if}
{if $smarty.const.APP_DIR=='stay'}<br /><span class="em09">悪天候などで交通機関が乱れるなど緊急にご連絡することがございます。携帯電話をお持ちでしたら、ぜひご入力ください。</span>{/if}
</div>
</div>