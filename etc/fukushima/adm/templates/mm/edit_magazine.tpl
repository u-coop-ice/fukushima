{capture assign="header_insert"}
{literal}
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" />


<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>


<script type="text/javascript">
$(function() {
$("#formID").validationEngine({
	promptPosition: "inline"
})
});
</script>




<script type="text/javascript">

$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").parent().addClass("checked");

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');
		});
		$(this).addClass('checked');
	});
});


$(function(){
	$("[name='onetime']").on('click',function(){
	setOnetime();
	});
	setOnetime();
});


function setOnetime(){
	var e = $("[name='onetime']:checked").val();
	if (e==1){
	$("#set_onetime").show().find('input,select').prop('disabled',false);
	$("#set_group_id").hide().find('input,select').prop('disabled',true);
	} else {
	$("#set_onetime").hide().find('input,select').prop('disabled',true);
	$("#set_group_id").show().find('input,select').prop('disabled',false);
	}
}





$(function() {
$("#reserve").AnyTime_picker({
	format: "%z-%m-%d %H:%i:00",
	firstDOW: 0,
	inputHide: true
});
$(".reset").click( function(e) {
$("#reserve").val("").change();
  });
});
</script>

{/literal}
{/capture}


{* ページタイトル 開始 *}
{capture assign="page_title"}メールマガジンの{if $id}編集{else}作成{/if}{/capture}
{* ページタイトル 終了 *}

{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}
{magazines}
<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">メルマガを保存しました。</p>
{/if}
<form id="formID" method="post" enctype="multipart/form-data" action="{$self}?mode=save_magazine">
{if $magazine['id']}
<input type="hidden" name="id" value="{$magazine['id']}" />
{/if}

<table class="inputForm" cellspacing="0">
<col style="width:30%;" />
<tr>
<th>件名<span class="label label-danger">必須</span></th>
<td><input type="text" id="mail_subject" name="subject" value="{$magazine['subject']}" class="form-control validate[required]" />
</td>
</tr>
<tr>
<th>本文<span class="label label-danger">必須</span></th>

<td>
<p>○○ ○○さま<span class="tag min">自動で登録名が入ります。</span></p>

<textarea id="mail_body" name="body" class="form-control validate[required]">{$magazine['body']}</textarea>
<pre>
{$magazine['group_signature']}
---------------------

【送信専用】当メールは送信専用ですので、当メールには返信できません。

このメールはサインイン後、以下URLでも確認できます。
{$init_url}app/user/?mode=show_mail<br />&adic={$adic|default:"【メッセージCODE】"}

{if $magazine['group_unsubscribe']}
---------------------

※当メールは、{$init_coopname}にユーザー登録された方に対してお送りしております。
今後、このようなお知らせが不要な方は、大変お手数ですが下記のURLより
配信停止処理（要サインイン）をお願いいたします。
{$init_url}app/user/?mode=unsubscribe_mail<br />&username=[ユーザーアカウント]
{/if}

---------------------
{$init_coopname} {$init_url}
</pre>

</td>

</tr>


<tr>
<th>配信先の設定<span class="label label-danger">必須</span></th>
<td>
<div class="radio radio-group clearfix">
{if $authority['master']['master']}
<div><label><input type="radio" name="onetime" {if $magazine['onetime']==0}checked="checked"{/if} value="0"> ユーザーグループ</label></div>
<div><label><input type="radio" name="onetime" {if $magazine['onetime']==1}checked="checked"{/if} value="1"> one time send</label></div>
{else}
<div><label><input type="radio" checked="checked" name="onetime" {if $magazine['onetime']==1}checked="checked"{/if} value="1"> one time send</label></div>
{/if}
</div>
</td>
</tr>

<tbody id="set_group_id">
<tr>
<th>宛先<span class="label label-danger">必須</span></th>
<td>
<select name="group_id" id="group_id" class="form-control validate[required]">
<option value="">（宛先を選択）</option>
{groups no_class_first=1}
<option value="{$group['id']}"{if $group['id'] == $magazine['group_id']} selected="selected"{/if}>{$group['denomination']}</option>
{/groups}
</select>
</td>
</tr>
</tbody>
</table>

{assign var=condition value=$magazine['condition']}
{assign var=unsubscribe value=$magazine['unsubscribe']}

{include file="edit_narrow.tpl"}

<table class="inputForm" cellspacing="0">
<col style="width:30%;" />
<tr>
<th>配信予定人数</th>
<td>
{if $magazine['id']}<strong class="prc" id="numberofperson">{if $magazine['group_id']}{get_regist_count group_id=$magazine['group_id']}{else}{get_regist_count condition=$magazine['condition']}{/if}</strong>人{/if}
</td>
</tr>


<tr>
<th>送信予約</th>
<td>
<div class="checkbox"><label for="onreserve"><input type="checkbox" id="onreserve" name="onreserve" value="1" {if $magazine['onreserve']}checked="checked"{/if}>
予約送信する</label>&nbsp;
<input type="text" class="form-control datetime" id="reserve" name="reserve" value="{$magazine['reserve']}"><span class="reset"><a class="btn btn-primary btn-sm"><i class="fa fa-fw fa-times"></i>リセット</a></span>
</div>
</td>
</tr>
</table>

<p>

<button class="btn btn-primary" type="submit" name="submit" value="保存">保存</button>

<button class="btn btn-primary" type="submit" name="test" value="テスト送信">テスト送信して保存</button>&nbsp;&nbsp;{if $magazine['test_date'] !=''}
<span class="sended">{$magazine['test_date']|date_format:"%Y-%m-%d %H:%M"}にテストメールを送信しました。</span>
{*<input type="submit" name="send" value="メルマガ本送信" />*}{/if}
</p>
<p class="pad_l">テストメールは{if $auth_usermail}{$auth_usermail}{else}{$init_ordermail}{/if}に送信されます。</p>
</form>
{/magazines}

<p class="alert alert-warning">【本送信】機能は廃止しました。予約送信で送信ください。<br />
配信スケジュールがは30分ごとになります。例）送信予約設定を15:01、15:20にしても、どちらも15:30に配信となります。</p>
{* メール編集フォーム 終了 *}

{* メールが見つからなかった場合の出力等 開始 *}
{if $no_item}
<p>メールが見つかりませんでした。</p>
{/if}
{if $db_error}
<p>メールの読み込みに失敗しました。</p>
{/if}
{* メールが見つからなかった場合の出力等 終了 *}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
