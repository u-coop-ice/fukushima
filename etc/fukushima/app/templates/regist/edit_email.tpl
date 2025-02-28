{capture assign="header_insert"}
{literal}
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-ja.js"></script>
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery.css" />
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
<h2 class="page_title">{$page_title}</h2>
{if $saved}
<p class="saved">アドレスを保存しました。</p>
{/if}
<form id="formID" method="post" enctype="multipart/form-data" action="{$self}?mode=save_email">
{if $email_id}
<input type="hidden" name="id" value="{$email_id}" />
{/if}

<div id="itsthetable">
<table>
<col width="100" />
<col width="400" />
<tr>
<th><label for="name">名前</label></th>
<td><input type="text" name="namef" id="namef" value="{$email_namef}" class="validate[required] " />
<input type="text" name="nameg" id="nameg"  value="{$email_nameg}" class="validate[required]" /></td>
</tr>
<tr>
<th><label for="email">アドレス</label></th>
<td><input type="text" name="email" id="email" size="50" value="{$email_email}" class="validate[required,custom[email]]" /></td>
</tr>
<tr>
<th><label for="regdate">登録日</label></th>
<td><input type="hidden" name="regdate" id="regdate" size="30" value="{$email_regdate | date_format:'%Y-%m-%d %H:%M:%S'}" />
{$email_regdate | date_format:'%Y-%m-%d %H:%M:%S'}</td>
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
<td><input type="text" name="status" id="status" value="{$email_status}" /></td>
</tr>
<tr>
<th><label for="memo">備考</label></th>
<td><textarea name="memo" id="memo">{$email_memo}</textarea></td>
</tr>

</table>
</div>
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
