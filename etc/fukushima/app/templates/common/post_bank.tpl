{literal}
<script type="text/javascript">
$(function(){
	$("input[name='bank']").on('click',function(){setSR();});
	setSR();
});

function setSR(){
	var b=$("input[name='bank']:checked").val();
		$('#bank_2').hide().find('input').prop('disabled',true);
		$('#bank_1').hide().find('input').prop('disabled',true);

		if(b>0){
		$('#bank_'+b).show().find('input').prop('disabled',false);
		}


}
</script>
{/literal}

<div class="form-group" id="form-group_bank">
<label class="col-sm-3 control-label">{$methods['bank']['title']|default:"銀行口座"}{if $methods['bank']['use']==2}<span class="label label-danger">必須</span>{else}<span class="label label-default">任意</span>{/if}</label>


<div class="col-sm-9">

<div class="radio">
<label><input type="radio" id="bank1" name="bank" {if $post['bank']==1}checked="checked"{/if} {if $methods['bank']['use']==2}class="validate[required]"{/if} value="1"> ゆうちょ銀行</label>
<label><input type="radio" id="bank2" name="bank" {if $post['bank']==2}checked="checked"{/if} {if $methods['bank']['use']==2}class="validate[required]"{/if} value="2"> ゆうちょ銀行以外</label>
</div>
{if $methods['bank']['note']}<p class="help-block">{$methods['bank']['note']|nl2br}</p>{/if}
</div>
</div>


<div id="bank_1" class="none">
<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9">

<dl>
<dt>銀行名</dt>
<p class="form-control-static"><input type="hidden" id="bank_name" name="bank_name" value="ゆうちょ銀行" />ゆうちょ銀行</p>

<dt>記号</dt>
<div class="row">
<div class="col-xs-6 col-sm-5"><input type="text" id="bank_branch" name="bank_branch" class="form-control input-lg validate[{if $methods['bank']['use']==2}required,{/if}custom[number]]" placeholder="（半角数字 5桁）" maxlength="5" value="{$post['bank_branch']}" />
</div>
</div>
<p class="help-block">1から始まり0で終わる5桁の数字です。記号と番号の間の数字は不要です。</p>

{if $error['bank_branch']==1}<span class="must_view">*半角数字で入力してください</span>{/if}
<input type="hidden" name="bank_sort" value="1" />

<dt>番号</dt>
<div class="row">
<div class="col-xs-6 col-sm-6">
<input type="text" id="bank_account" name="bank_account" class="form-control input-lg validate[{if $methods['bank']['use']==2}required,{/if}custom[number]]" maxlength="8" placeholder="（半角数字 最大8桁）"  value="{if $post['bank_account']}{$post['bank_account']|string_format:"%08d"}{/if}" />
</div>
</div>
<p class="help-block">1で終わる4～8桁の数字です。8桁未満の場合は前に0を足して8桁になるようご入力ください。</p>
{if $error['bank_account']==1}<span class="must_view">*必須項目です</span><br />{/if}
{if $no_num_account_err==1}<span class="must_view">*半角数字で入力してください</span><br />{/if}


<dt>口座名義名（カナ）</dt>
<div class="row">
<div class="col-xs-6 col-sm-6">
<input type="text" id="bank_holder_kana" name="bank_holder_kana" class="form-control input-lg validate[{if $methods['bank']['use']==2}required{/if},custom[onlyLetterKana]]" maxlength="64" value="{$post['bank_holder_kana']}" />
</div>
</div>
{if $error['bank_holder_kana']==1}<span class="must_view">*必須項目です</span>{/if}
</dl>

</div>
</div>
</div>{* #bank1 *}


<div id="bank_2" class="none">
<div class="form-group">
<label class="col-sm-3 control-label"></label>
<div class="col-sm-9">


<dl>
<dt>銀行名</dt>
<input type="text" id="bank_name" name="bank_name" class="form-control input-lg{if $methods['bank']['use']==2} validate[required]{/if}" maxlength="64" value="{$post['bank_name']}" />
{if $error['bank_name']==1}<span class="must_view">*必須項目です</span>{/if}

<dt>本支店名</dt>
<input type="text" id="bank_branch" name="bank_branch" class="form-control input-lg{if $methods['bank']['use']==2} validate[required]{/if}" maxlength="64" value="{$post['bank_branch']}" />
{if $error['bank_branch']==1}<span class="must_view">*必須項目です</span>{/if}

<dt>支店コード</dt>
<input type="text" id="code_branch" name="code_branch" class="form-control input-lg  validate[{if $methods['bank']['use']==2}required{/if},custom[number],minSize[3]]" maxlength="3" value="{$post['code_branch']}" placeholder="数字3桁" />
{if $error['code_branch']==1}<span class="must_view">*必須項目です</span>{/if}

<dt>口座種別 </dt>
<div style="padding-top:0;" class="radio">
{foreach $bankSortList key=k item=v}
<label><input type="radio"  name="bank_sort" {if $methods['bank']['use']==2}class="validate[required]"{/if} value="{$k}" {if $post['bank_sort']==$k}checked="checked"{/if} />{$v}</label>
{/foreach}
</div>

{if $error['bank_sort']==1}<span class="must_view">*必須項目です</span>{/if}

<dt>口座番号</dt>
<div class="row">
<div class="col-xs-6 col-sm-6">
	<input type="text" id="bank_account" name="bank_account" class="form-control input-lg validate[{if $methods['bank']['use']==2}required,{/if}custom[number]]" maxlength="7" placeholder="数字7桁"  value="{$post['bank_account']}" />
</div>
</div>
{if $error['bank_account']==1}<span class="must_view">*必須項目です</span>{/if}
{if $no_num_account_err==1}<span class="must_view">*半角数字で入力してください</span>{/if}

<dt>口座名義名（カナ）</dt>
<div class="row">
<div class="col-xs-12 col-sm-6">
<input type="text" id="bank_holder_kana" name="bank_holder_kana" class="form-control input-lg validate[{if $methods['bank']['use']==2}required{/if},custom[onlyLetterKana]]" maxlength="128" value="{$post['bank_holder_kana']}" />
</div>
</div>
{if $error['bank_holder_kana']==1}<span class="must_view">*必須項目です</span>{/if}
</dl>

</div>
</div>
</div>
