<div id="form-group_dm" class="form-group">
<label class="col-sm-3 control-label">メール送付の可否</label>
<div class="col-sm-9">
<div class="checkbox">
<input type="checkbox" id="dm" name="dm" value="1" {if !$post['namef'] || $post['dm']==1}checked="checked"{/if} /><label for="dm" > 生協からの情報をメールで受け取る</label>
</div>
</div>
</div>