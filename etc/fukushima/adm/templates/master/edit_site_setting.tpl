{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[

$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").next().addClass("checked");
$("input:checked").parent().addClass("checked");

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');	
		});
		$(this).addClass('checked');
	});
});


$(function(){
	$('[name^=set]').on('click',function(){
		setDis();
	});
	setDis();
});

function setDis(){
	var a = $('[name="set[app]"]:checked').val();
	$('.app_on').each(function(){
	if (a==1){
		$(this).removeClass('DIS');
	setDis1();
	} else {
		$(this).addClass('DIS');
	}
	});
}

function setDis1(){
	var a = $('[name="set[member]"]:checked').val();
	$('.app_mb_on').each(function(){
	if (a==1){
		$(this).removeClass('DIS');
	} else {
		$(this).addClass('DIS');
	}
	});
}



//]]>



</script>
{/literal}
{/capture}

{assign var="page_title" value="{$init_coopname}サイトの初期設定"}

{include file='header.tpl'}

<h4 class="page_title">{$page_title}</h4>

{if $saved}
<p class="note">設定を保存しました。</p>
{/if}

<form method="post" action="{$self}?mode=save_site_setting">
<table class="inputForm_free" cellspacing="0">
<col style="width:30%;" />
<col style="width:70%;" />
<tr><th class="mh" colspan="2">サイトの初期設定</th></tr>
<tr><th>大学生協名</th><td>{$init_coopname} {$init_coopnameE}<br />{$init_url}
</td></tr>
<tr><th>大学生協コード</th><td>{$smarty.session.config['membershipfirst4']}
</td></tr>
<tr><th>大学生協システムID</th><td>{$smarty.session.config['univ_id']}</td></tr>
<tr><th>大学名</th><td>{$init_univname}<br />{$init_univurl}</td></tr>
<tr><th>基本メールアドレス</th><td>{$init_ordermail}</td></tr>
<tr><th>Return-Path:</th><td>{$init_errormail}</td></tr>
<tr>
<th>カード決済の設定</th>
<td>秘密鍵：{#payjp_api#}
<br />公開鍵：{#payjp_public_api#}<br />
失効期限：{#expiry_days#}日後<br />
支払い処理：{#capture#}（falseの場合、カードの認証と支払い額の確保のみ行う）
</td>
</tr>
<tr>
<th>newlifeからのユーザーアカウント引き継ぎ</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="inherit" options=$onoffList selected=$init_inherit|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
</td>
</tr>

</table>

<p><button class="btn btn-primary" type="submit" name="submit" value="保存する"><i class="fa fa-fw fa-check"></i>保存する</button></p>
</form>

{include file='footer.tpl'}
