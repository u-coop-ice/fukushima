{capture assign="header_insert"}
{literal}
<script type="text/javascript" src="./js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<link rel="stylesheet" href="./js/validationEngine.jquery.css" />
<script>
		$(document).ready(function() {
			$("#formID").validationEngine()
		});
</script>
{/literal}
{/capture}

{* ページタイトル 開始 *}
{capture assign="page_title"}アドレスの{if $view_email_id}編集{else}登録{/if}{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}



{* アドレス編集フォーム 開始 *}
{email}
<h3 class="page_title">{$page_title}</h3>
{if $saved}
<p class="note">アドレスを保存しました。</p>
{/if}
<form id="formID" method="post" enctype="multipart/form-data" action="{$self}?mode=save_email">
{if $email_id}
<input type="hidden" name="id" value="{$email_id}" />
{/if}

<table class="inputForm2" cellspacing="0">
<th><label for="email">アドレス</label></th>
<td><input type="text" name="email" id="email" size="50" value="{$email_email}" class="validate[required,custom[email]]" /></td>
</tr>
{if $email_group_id}
{group id=$email_group_id}

{if $group_ex_name}
<tr><th>氏名{if $group_ex_name==2}<span class="red">※</span>{/if}</th>
<td>
<div style="float:left"><span class="em08 deepgray">（姓）</span><br />
<input type="text" id="namef" name="namef" class="ABLE" maxlength="32" value="{$email_namef}" {if $group_ex_name==2}class="validate[required]"{/if} />
&nbsp;</div>
<div style="float:left"><span class="em08 deepgray">（名）</span><br />
<input type="text" id="nameg" name="nameg" class="ABLE" maxlength="32"  value="{$email_nameg}" {if $group_ex_name==2}class="validate[required]"{/if}/>
&nbsp;様
{if $nameF_err || $nameG_err}<span class="must_view">*必須項目です</span>{/if}</div>
<br class="clear" />
</td></tr>
{/if}
{if $group_ex_sex}
<tr><th>性別{if $group_ex_sex==2}<span class="red">※</span>{/if}</th>
<td>
<label><input type="radio" id="man" name="sex" {if $group_ex_sex==2}class="validate[required] radio"{/if} value="1"{if $email_sex=="1"}checked="checked"{/if}/> {$sexList[1]}</label>
&nbsp;／&nbsp;
<label><input type="radio" id="waman" name="sex" {if $group_ex_sex==2}class="validate[required] radio"{/if} value="2" {if $email_sex=="2"}checked="checked"{/if}/>  {$sexList[2]}</label>
&nbsp;{if $sex_err}<span class="must_view">*必須項目です</span>{/if}</div>
</td></tr>
{/if}
{if $group_ex1_use}
<tr><th class="vtop">
{$group_ex1_title}{if $group_ex1_use==2}<span class="red">※</span>{/if}
</th>
<td>
<input type="text" name="ex1" id="ex1" value="{$email_ex1}" />
{if $ex1_err}<span class="must_view">*必須項目です</span>{/if}
</td></tr>
{/if}
{if $group_extra1_use}
<tr><th class="vtop">
{$group_extra1_title}{if $group_extra1_use==2}<span class="red">※</span>{/if}
</th>
<td>
<select name="extra1" id="extra1" {if $group_extra1_use == 2}class="validate[required]"{/if}>
{html_options values=$extra1List output=$extra1List selected=$email_extra1}
</select>
{if $extra1_err}<span class="must_view">*必須項目です</span>{/if}
<p>{$group_extra1_note}</p>
</td>
</tr>
{/if}

{if $group_ex2_use}
<tr><th class="vtop">
{$group_ex2_title}{if $group_ex2_use==2}<span class="red">※</span>{/if}
</th>
<td>
<input type="text" name="ex2" id="ex2" value="{$email_ex2}" />
{if $ex2_err}<span class="must_view">*必須項目です</span>{/if}
</td></tr>
{/if}

{if $group_extra2_use}
<tr><th class="vtop">
{$group_extra2_title}{if $group_extra2_use==2}<span class="red">※</span>{/if}
</th>
<td>
<select name="extra2" id="extra2" {if $group_extra2_use == 2}class="validate[required]"{/if}>
{html_options values=$extra2List output=$extra2List selected=$email_extra2}
</select>
{if $extra2_err}<span class="must_view">*必須項目です</span>{/if}
<p>{$group_extra2_note}</p>
</td>
</tr>
{/if}

{if $group_ex3_use}
<tr><th class="vtop">
{$group_ex3_title}{if $group_ex3_use==2}<span class="red">※</span>{/if}
</th>
<td>
<input type="text" name="ex3" id="ex3" value="{$email_ex3}" />
{if $ex3_err}<span class="must_view">*必須項目です</span>{/if}
</td></tr>
{/if}

{if $group_extra3_use}
<tr><th class="vtop">
{$group_extra3_title}{if $group_extra3_use==2}<span class="red">※</span>{/if}
</th>
<td>
<select name="extra3" id="extra3" {if $group_extra3_use == 2}class="validate[required]"{/if}>
{html_options values=$extra1List output=$extra3List selected=$email_extra3}
</select>
{if $extra3_err}<span class="must_view">*必須項目です</span>{/if}
<p>{$group_extra3_note}</p>
</td>
</tr>
{/if}
{/group}
{/if}

<tr>
<th><label for="regdate">登録日</label></th>
<td><input type="hidden" name="regdate" id="regdate" size="30" value="{$email_regdate|date_format:'%Y-%m-%d %H:%M:%S'}" />
{$email_regdate|date_format:'%Y-%m-%d %H:%M:%S'}</td>
</tr>

<tr>
<th><label for="group_id">グループ</label></th>
<td>
<select name="group_id" id="group_id" class="validate[required]">
<option value="">選択してください</option>
{group no_class_first=1}
<option value="{$group_id}"{if $group_id == $email_group_id} selected="selected"{/if}>{$group_name}</option>
{/group}
</select>
</td>
</tr>
<tr>
<th><label for="status">配信状態</label></th>
<td>
{html_options name="status" id="status" options=$statusList selected=$email_status|default:1}
</td>
</tr>
<tr>
<th><label for="memo">備考</label></th>
<td><textarea name="memo" id="memo">{$email_memo}</textarea></td>
</tr>

</table>

<p><input type="submit" name="submit" value="保存" /></p>
</form>
{/email}
{* 商品編集フォーム 終了 *}

{* 商品が見つからなかった場合の出力等 開始 *}
{if $no_email}
<p>商品が見つかりませんでした。</p>
{/if}
{if $db_error}
<p>商品の読み込みに失敗しました。</p>
{/if}
{* 商品が見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
