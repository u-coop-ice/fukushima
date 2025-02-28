<div id="form-group_ship_from_name" class="form-group">
<label class="col-sm-3 control-label">発送元名称<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="ship_from_name" name="ship_from_name" maxlength="64" value="{$post["ship_from_name"]}" class="form-control input-lg validate[required]" placeholder="（発送元名）" />
{if $error['ship_from_name']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">発送元フリガナ<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<input type="text" id="ship_from_kana" name="ship_from_kana" maxlength="64" value="{$post["ship_from_kana"]}" class="form-control input-lg validate[required]" placeholder="（ハッソウモトメイ）" />
{if $error['ship_from_kana']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>