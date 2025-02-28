
<div id="form-group_ship_name" class="form-group">
<label class="col-sm-3 control-label">氏名<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-4 col-xs-6">
<input type="text" id="ship_namef" name="ship_namef" maxlength="32" value="{$post["ship_namef"]}" class="form-control input-lg validate[required]" placeholder="（姓）" />
</div>
<div class="col-sm-4 col-xs-6">
<input type="text" id="ship_nameg" name="ship_nameg" maxlength="32" value="{$post["ship_nameg"]}" class="form-control input-lg validate[required]" placeholder="（名）" />
</div>
</div>
{if $error['ship_namef'] || $error['ship_nameg']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">フリガナ<span class="label label-danger">必須</span></label>
<div class="col-sm-9">
<div class="row">
<div class="col-sm-4 col-xs-6">

<input type="text" id="ship_kanaf" name="ship_kanaf" maxlength="32" value="{$post["ship_kanaf"]}" class="form-control input-lg validate[required]" placeholder="（セイ）" />
</div>
<div class="col-sm-4 col-xs-6">
<input type="text" id="ship_kanag" name="ship_kanag" maxlength="32" value="{$post["ship_kanag"]}" class="form-control input-lg validate[required]" placeholder="（メイ）" />
{if $error['ship_kanaf'] || $error['ship_kanag']}<span class="must_view">*必須項目です</span>{/if}
</div>
</div>
</div>
</div>