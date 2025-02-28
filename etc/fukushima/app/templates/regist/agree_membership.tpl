
<h3>{$init_coopname}サイト 会員規約</h3>
<div class="rule_membership">
{include file="rule_membership.tpl"}
</div>

<div class="form-group">
<div class="checkbox">
<p class="center"><label><input type="checkbox" data-role="none" id="agreement" name="agreement" {if $post['agreement']}checked="checked"{/if}value="1" class="validate[required]" />
 {$init_coopname}サイト 会員規約へ同意します。</label>
</p>
</div>
{if $agreement_err}<span class="must_view">*ユーザー登録には、規約への同意が必要になります</span>{/if}
</div>
