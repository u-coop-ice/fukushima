{* ヘッダー部分の組み込み *}
{assign var="init_pagetitle" value="システムメール"}

{capture assign="header_insert"}
{literal}
<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>
<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />


<script type="text/javascript">

$(function(){

	var opt_test = $("#opt_test");

	$("[name=test]").on('click',function(){
		opt_test.val(1);
	});

	$("[name=send]").on('click',function(){
		opt_test.val(0);
	});

$("#formID").validationEngine('attach', {
	'promptPosition' : "inline",
	'ajaxFormValidationMethod': "post",
	'onValidationComplete': function(form, status){
		if (status === true){
		if (opt_test.val()==0){
		$("#formID").find(':submit').prop('disabled',true);
		}
		setTimeout(sendMail,100);
		}//if
	}
	});

function sendMail(){

	var fm =$("#formID")
	var act = "/adm/ask/?mode=save_mail";
	var json = fm.serializeArray();
	$.fancybox.showLoading();
	$.ajax({
	url: act,
	type: "POST",
	data: json,
	cache: false,
	async: false,
	dataType: "json"
	}).done(function(e){
		if (e.error){
			$.fancybox.hideLoading();
			alert('データベースの処理に失敗しました。'+e.error);
			return false;
		} else if (e.test){
			$.fancybox.hideLoading();
			alert('テスト送信を行いました。');
			return false;
		} else {
			$.fancybox.hideLoading();

			var url = parent.location.pathname;
			alert('申込者さまに送信が完了しました。');
			parent.$.fancybox.close();
			if (url.match(/\/adm\/ask\//g)){
				url +='?mode=show_mail&add_id='+e.add_id;
				parent.location.href = url;
			} else {
				parent.location.reload();
			}


			return false;
		}
		}).fail(function(e){
		$.fancybox.hideLoading();
		alert('送信エラー');
		return false;
		});
}



});

$(function(){
	var mailbody = $('#mail_body').html();
	mb = mailbody.replace(/(\r{3,})?(\n{3,})/g, '\n');
	$('#mail_body').html(mb);
});

</script>



{/literal}
{/capture}

{include file='preview_header.tpl'}

<form id="formID" method="post" enctype="multipart/form-data" action="{$init_url}adm/ask/?mode=save_mail">
<table class="inputForm" cellspacing="0">
<tr>
<th>件名</th>
<td>
{if $view_root_id || $view_add_id}
<input type="text" id="mail_subject" name="mail_subject" value="{$return['subject']}" class="form-control validate[required]" />
{else}
<input type="text" id="mail_subject" name="mail_subject" value="{if $mail_subject}{$mail_subject}{else if $post['mail_subject']}{$post['mail_subject']}{/if}" class="form-control validate[required]" />
{/if}
</td>
</tr>
<tr>
<th>宛先</th>
<td>{$return['email']}（{$return['namef']} {$return['nameg']}）
<input type="hidden" name="email" value="{$return['email']}" />
</td></tr>
{if $return["status"]==1}
<tr><th>返信フラグ</th>
<td>
<div class="checkbox"><label for="noreply" ><input type="checkbox" id="noreply" name="noreply" value="9" /> このメール送信以降、ユーザー側で（関連するスレッドに対して）返信不可にし<span class="tag min black">対応済</span>となります。</label></div>
</td></tr>
{else}
<input type="hidden" id="noreply" name="noreply" value="9" />
{/if}
<tr>
<th>本文<br /><span class="em09">【送信専用】以下定型文が入ります。</span></th>
<td><textarea id="mail_body" name="mail_body" class="form-control validate[required]">
{if $post['mail_body']}{$post['mail_body']}{else}
{if $return['namef']}{$return['namef']} {$return['nameg']}{else}{$return['username']}{/if}様

ご利用ありがとうございます。{$init_coopname}でございます。

{if $view_app_id && $return['arrange']}
{get_app_info app_id=$view_app_id}
{if $app['component']=="entry"}
{include file="edit_entry_mail.tpl"}{else if $app['component']=="shopping"}{include file="edit_shopping_mail.tpl"}
{/if}
{/if}{/if}


{if $return['target']}
> [対象物件] {$return['target']}
{/if}

{if $return['purpose']}
> [お問い合わせ内容] {$return['purpose']}
{/if}

{if $return['memo']}
{$return['memo']|add_quote}
{/if}

</textarea>
<div style="font-family: monospace;">
<p>----------------------------------------------------------------------------</p>
<p>【送信専用】当メールは送信専用ですので、当メールには返信できません。<br />
<br />
{if $regist["status"]==1}
このメールに関する返信・お問い合わせは、サインイン後<br />
{$init_url}app/user/?mode=show_mail&adic=【システムからのメッセージCODE】<br />
より行ってください。<br />
{/if}
<br />
----------------------------------------------------------------------------<br />
{$init_coopname} {$init_coopurl}</p>
</div>
</td>
</tr>
<tr><th>担当者名</th>
<td><input type="text" id="cover" name="cover" class="form-control" value="{$post_cover}" /><br /><i class="fa fa-info-circle">メールには記載されません。内部管理用にご活用下さい。</i>
</td></tr>

</table>


<p class="center">
<button class="btn btn-primary" type="submit" name="test" value="テスト送信"><i class="fa fa-fw fa-pencil-square-o"></i>テスト送信</button>&nbsp;&nbsp;
<button class="btn btn-primary" type="submit" name="send" value="申込者へ送信（この操作は取り消せません）"><i class="fa fa-fw fa-paper-plane"></i>申込者へ送信（この操作は取り消せません）</button></p>
<p class="center">テストメールは{if $auth_usermail}{$auth_usermail}{else}{$init_ordermail}{/if}に送信されます。</p>

<input type="hidden" id="opt_test" name="test" value="0" />


{if $view_app_id}
<input type="hidden" name="app_id" value="{$view_app_id}" />
{/if}
{if $view_root_id}
<input type="hidden" name="root_id" value="{$view_root_id}" />
{/if}
{if $view_add_id}
<input type="hidden" name="add_id" value="{$view_add_id}" />
{/if}

<input type="hidden" name="regist_id" value="{$return['regist_id']}" />
<input type="hidden" name="regist_status" value="{$return['status']}" />
</form>



{if $db_error}
<p>データベースからデータを読み込むのに失敗しました。</p>
{/if}
{* 商品がない場合など 終了 *}

{* フッター部分の組み込み *}
{include file='preview_footer.tpl'}
