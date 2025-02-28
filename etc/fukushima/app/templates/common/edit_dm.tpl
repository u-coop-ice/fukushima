<div id="form-group_dm" class="form-group">
<label class="control-label col-sm-3">メール送付の可否</label>
<div class="col-sm-9">
<input type="checkbox" id="dm" name="dm" value="1" {if !$regist['namef'] || $regist['dm']==1}checked="checked"{/if} /><label for="dm" > 生協からの情報をメールで受け取る</label>
</div>
</div>