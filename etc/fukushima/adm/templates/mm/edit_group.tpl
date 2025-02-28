{capture assign="header_insert"}
{literal}
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" />

{/literal}
{/capture}


{capture assign="page_title"}
アドレスグループの{if $view_group_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">ユーザーグループを保存しました。</p>
{/if}


<form name="formID" id="formID" method="post" action="{$self}?mode=save_group">

{groups id=$view_group_id}

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">基本設定</th></tr>
<tr>
<th>グループ名<span class="label label-danger">必須</span></th>
<td><input type="text" class="form-control" name="denomination" id="denomination" size="30" value="{$group['denomination']}" class="validate[required]" /></td>
</tr>
<tr>
<th>メルマガの送信元アドレス</th>
<td><input type="hidden" name="main_email" id="main_email" size="50" value="DO_NOT_REPLY@u-coop.or.jp" />
<p class="form-control-static">DO_NOT_REPLY@u-coop.or.jp</p></td>
</tr>
<tr>
<th>メルマガ本文末尾・署名定型文</th>
<td>
<textarea name="signature" id="signature" class="form-control" cols="50" rows="10">{$group['signature']}</textarea>
<pre>
---------------------

【送信専用】当メールは送信専用ですので、当メールには返信できません。

このメールはサインイン後、以下URLでも確認できます。
{$init_url}app/user/?mode=show_mail
&adic={$adic|default:"【メッセージCODE】"}

{if $group['unsubscribe']}
---------------------

※当メールは、{$init_coopname}にユーザー登録された方に対してお送りしております。
今後、このようなお知らせが不要な方は、大変お手数ですが下記のURLより
配信停止処理（要サインイン）をお願いいたします。
{$init_url}app/user/?mode=unsubscribe_mail
&username=[ユーザーアカウント]
{/if}

---------------------
{$init_coopname} {$init_url}
</pre>
</td>
</tr>
</table>

{assign var=unsubscribe value=$group['unsubscribe']}

{include file="edit_narrow.tpl"}

<table class="inputForm" cellspacing="0">
<tr>
<th>配信予定人数</th>
<td>
{if $group['id']}<strong class="prc" id="numberofperson">{get_regist_count group_id=$group['id']}</strong>人{/if}
</td>
</tr>

<tr><th class="mh" colspan="2">その他</th></tr>

<tr>
<th>並び順<br /><span class="em09">管理画面での並び順です。</span></th>
<td><p class="form-control-static">{$group['sort_order']}</p>
<input type="hidden" name="sort_order" value="{$group['sort_order']}" />
</td>
</tr>

<tr>
<th>アーカイブ化</th>
<td>
<div class="radio-group radio">
{html_radios name="archived" id="archived" options=$onoffList selected=$group['archived']|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="右メニューやカテゴリ一覧に（積極的に）表示しなくなります。"></i>

<div class="clear" style="margin-bottom:0.4em;"></div>

</tr>

<tr>
<th>概要・メモ<br /><span class="em08">生協管理用です。</span></th>
<td><textarea name="memo" id="text" cols="50" rows="10" class="form-control">{$group['memo']}</textarea></td>
</tr>


</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存">保存する</button></p>

{if $view_group_id}
<input type="hidden" name="id" value="{$view_group_id}" />
{/if}

{/groups}

</form>

{if $no_group && !$new}
<p>グループが見つかりませんでした。<br >no_cat = {$no_group}, new = {$new}</p>
{/if}
{if $db_error}
<p>グループの読み込みに失敗しました。</p>
{/if}

{include file='footer.tpl'}
