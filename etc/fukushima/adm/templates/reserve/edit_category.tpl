{capture assign="header_insert"}
{literal}



<link type="text/css" href="/js/jquery/jquery-ui-1.10.4.custom/bootstrap/jquery-ui.custom.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>



{/literal}

<link rel="stylesheet" href="/{$smarty.const.ADM_DIR}css/jquery.powertip.css" type="text/css" media="all" />

{literal}
<script type="text/javascript" src="/js/jquery/jquery.powertip-1.2.0/jquery.powertip.min.js"></script>


<script type="text/javascript">
//<![CDATA[
$(function(){
	$(".powertip").powerTip({
	placement: 'ne' // north-east tooltip position
	});
});
//]]>
</script>


<script type="text/javascript">
//<![CDATA[

$(function(){
	var radio = $('div.radio-group');
	$('input', radio).css({'opacity': '0'});

$("input:checked").next().addClass("checked");
$("input:checked").parent().addClass("checked");

	$(document).on('click','label,radio',function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');	
		});
		$(this).addClass('checked');
	});
});
//]]>
</script>

<script type="text/javascript">
//<![CDATA[

$(function(){
	var s = $('[name="onstock"]');
	s.on('click',function(){
//		setStock();
	});
//		setStock();


function setStock(){
	var stk = $('#stock');
		if ($('[name="onstock"]:checked').val()==1){
			stk.prop('disabled',false);
		} else {
			stk.prop('disabled',true);
		}
}


});
//]]>
</script>


<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
$(".datetime").AnyTime_picker(
{ format: "%Y-%m-%d %H:%i:%S" } );
})

$(function(){
	$('.reset').each(function(){
		$(this).on('click',function(){
			if ($(this).prev('input').attr('id')=="date_limit"){
			$(this).prev('input').val('2038-01-01 23:59:59');
			}
			else if ($(this).prev('input').attr('id')=="date_start"){
			$(this).prev('input').val('1970-01-01 00:00:00');
			} else {
			$(this).prev('input').val('');
			}
		});
	});
});

//]]>
</script>

<script type="text/javascript" src="/adm/js/sortable.js"></script>

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-2.6.2.css" type="text/css"/>

<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){
$("#cat").validationEngine({
promptPosition : "inline"
});
});
//]]>
</script>

{/literal}

{/capture}

{capture assign="page_title"}
カテゴリの{if $view_category_id}{if $copy}複製{else}編集{/if}{else}新規作成{/if}
{/capture}

{include file='header.tpl'}



{*categories id=$view_category_id*}

{*if $category_header*}

<h4 class="page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">カテゴリーを保存しました。</p>
{/if}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_category">
{if $view_category_id}
{if !$copy}
<input type="hidden" name="id" value="{$view_category_id}" />
{/if}
{/if}

<table class="inputForm" cellspacing="0">
<tr><th class="mh" colspan="2">フォーム基本設定
{if $category['id']}<div class="pull-right">
<a id="preview" class="btn btn-primary btn-sm" href="/adm/ajax/?mode=preview_form&component={$smarty.const.COMPONENT}&category_id={$category['id']}"><i class="fa fa-comment-alt"></i> プレビュー</a>
</div>{/if}
</th></tr>
<tr><th>カテゴリ名<span class="label label-danger">必須</span></th>
<td>
<input type="text" name="denomination" id="denomination" class="form-control validate[required]" value="{if $copy}（コピー）{/if}{$category['denomination']}" /></td>
</tr>
<tr>
<th>登録データ（生協管理側）のメール送信先<br /><span class="em08">空欄の場合は初期設定アドレスに送信されます。</span></th>
<td><input type="text" name="ordermail" id="ordermail" class="form-control" value="{$category['ordermail']}" />
<br />初期設定アドレス：{$init_ordermail}<i class="powertip fa fa-fw fa-lg fa-info-circle" title="基本設定から変更できます。"></i><br />複数追加の場合は、",（カンマ）"で区切って入力してください。改行不可。</td>
</tr>

<tr>
<th>問い合わせ先メールアドレス<br /><span class="em08">自動返信メールの問い合わせ先として記載されます。</span></th>
<td><input type="text" name="pressmail" id="pressmail" class="form-control" value="{$category['pressmail']}" /><br />空欄の場合、問い合わせフォームのURLが記載されます。</td>
</tr>

<tr>
<th>概要（自動返信メール記載）</th>
<td><textarea name="description" id="description" cols="50" rows="5" class="form-control">{$category['description']}</textarea></td>
</tr>

<tr>
<th>概要（WBEフォーム記載）</th>
<td><textarea name="description_web" id="description_web" cols="50" rows="5" class="form-control">{$category['description_web']}</textarea>
<p class="help-block">htmlタグが使用できます。リンクや文字装飾が可能です。</p>
</td>
</tr>

<tr>
<th>INFO CODE<br /><span class="em08">シリアル番号の表記アルファベット</span></th>
<td>{$infocode}&nbsp;<input type="text" name="cat_code" id="cat_code" class="form-control" value="{$category['cat_code']}" />&nbsp;-20YYMMDD</td>
</tr>

<tr>
<th>日付選択項目の名称</th>
<td><input name="comedate_title" id="comedate_title" class="form-control" value="{$category['comedate_title']|default:"ご来店予定日"}" /></td>
</tr>

<tr>
<th>時間等選択項目の名称</th>
<td><input name="cometime_title" id="cometime_title" class="form-control" value="{$category['cometime_title']|default:"予定時間"}" /></td>
</tr>


<tr>
<th>デフォルトの選択肢</th>
<td><textarea name="select_time" id="select_time" cols="50" rows="5" class="form-control">{$category['select_time']}</textarea></td>
</tr>


<tr>
<th>ユーザー登録必須</th>
<td>
<p class="form-control-static"><label class="label label-info"><input type="hidden" name="authorization" value="0">OFF</label></p>

{*<div class="radio-group clearfix">
{html_radios name="authorization" options=$onoffList selected=$category['authorization']|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="ユーザー登録必須のお申込みに設定できます。"></i>
<div class="clear" style="margin-bottom:0.4em;"></div>*}
</td>
</tr>

<tr>
<th>フォームの運用開始期日</th>
<td><input type="text" name="date_start" class="datetime form-control" id="date_start" value="{$category['date_start']|default:'1970-01-01 00:00:00'}" /> <span class="reset"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span></td>
</tr>


<tr>
<th>フォームの運用終了期日</th>
<td><input type="text" name="date_limit" class="datetime form-control" id="date_limit" value="{$category['date_limit']|default:'2038-01-01 23:59:59'}" /> <span class="reset"><a class="btn btn-primary btn-sm"><i class="fa fa-remove"></i>リセット</a></span></td>
</tr>

<tr>
<th>フォーム運用終了後に表示する記載</th>
<td><textarea name="description_closed" id="description_closed" cols="50" rows="5" class="form-control">{$category['description_closed']}</textarea>
<p class="help-block">htmlタグが使用できます。リンクや文字装飾が可能です。</p>
</td>
</tr>


<tr>
<th>並び順<span class="label label-danger">必須</span></th>
<td><label><input type="text" name="sort_order" id="sort_order" class="form-control" value="{$category['sort_order']}" /></label>
</td>
</tr>

<tr>
<th>フォームURL</th>
<td>{if $copy}<p class="alert alert-info">保存するとURLが発行されます。</p>{else}{if $category['denomination']}<code class="btn-copy-clipboard" title="クリップボードに保存する"><i class="fa fa-fw fa-clipboard"></i>{$init_url}app/reserve/?cd={$category['code']}</code><br />
<span class="red em09">変更を行った場合は表示は必ず確認しましょう。{/if}</span>{/if}
</td>
</tr>

<tr>
<th>フォームの日付選択の表示期限</th>
<td>
{html_options name="limit_time" id="limit_time" class="form-control" options=$limitTimeList selected=$category['limit_time']|default:0}

</td>
</tr>


{*<tr>
<th>最大申込数（在庫）設定</th>
<td>

<div class="radio-group clearfix">
{html_radios name="onstock" id="onstock" class="form-control" options=$onoffmultiList selected=$category['onstock']|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="申込数が上限に達するとをフォームが自動で閉じます。"></i>
<div class="clear" style="margin-bottom:0.4em;"></div>

<input type="text" name="stock" id="stock" value="{$category['stock']}" class="form-control" placeholder="（半角）">
</td>
</tr>
*}
<script type="text/javascript">
//<![CDATA[
$(function(){
	var osk = $('[name="onstock"]');
			setMultiStock();
osk.on('click',function(){
			setMultiStock();
});

function setMultiStock(){
	var e = $('[name="onstock"]:checked').val();
	var ssm = $("#sort_stock_multi");
	var ssmi = ssm.find('input,textarea');

			ssmi.prop("disabled",true);
			ssm.hide();

		if (e==1){
			$("#stock").prop("disabled",false);
		} else if(e==2) {
			$("#stock").prop("disabled",true);
			ssmi.prop("disabled",false);
			ssm.show();
		} else {
			$("#stock").prop("disabled",true);
		}
}


});
//]]>
</script>
<tr>
<th>キャンセル可オプション</th>
<td>
<p class="form-control-static"><label class="label label-info"><input type="hidden" name="oncancell" value="0">OFF</label></p>
{*<div class="radio-group clearfix">
{html_radios name="oncancel" id="oncancel" options=$onoffList selected=$category['oncancel']|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="ユーザー登録必須とセットで設定ください。"></i>
<div class="clear" style="margin-bottom:0.4em;"></div>

<p>キャンセル期限：日付選択の表示期限の6時間後まで</p>*}
</td>
</tr>


<tr>
<th>重複申込不可オプション</th>
<td>
<p class="form-control-static"><label class="label label-info"><input type="hidden" name="onduplicate" value="0">OFF</label></p>
{*<div class="radio radio-group clearfix">
<div><label><input type="radio" name="onduplicate" value="0" {if $category['onduplicate']|default:0==0}checked="checked"{/if}>OFF</label></div>
<div><label><input type="radio" name="onduplicate" value="1" {if $category['onduplicate']==1}checked="checked"{/if}>申込日に関わらず不可</label></div>
<div><label><input type="radio" name="onduplicate" value="9" {if $category['onduplicate']==9}checked="checked"{/if}>同日申込のみ不可</label></div>
</div>
<div class="clear" style="margin-bottom:0.4em;"></div>
<p><i class="powertip fa fa-fw fa-lg fa-info-circle" title="ユーザー登録必須とセットで設定ください。"></i></p>*}


</tr>

<tr>
<th>アーカイブ化</th>
<td>
<div class="radio-group clearfix">
{html_radios name="archived" id="archived" options=$onoffList selected=$category['archived']|default:0 assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<i class="powertip fa fa-fw fa-lg fa-info-circle" title="右メニューやカテゴリ一覧に（積極的に）表示しなくなります。"></i>

<div class="clear" style="margin-bottom:0.4em;"></div>

</tr>

{*<tr>
<th>フォーム制御Javacript</th>
<td><textarea name="js" id="js" cols="50" rows="5" class="form-control">{$category['js']}</textarea></td>
</tr>*}

</table>

{include file="edit_sortable.tpl"}



{*if $category_footer*}

<p><button class="btn btn-success" type="submit" id="submit" value="1">保存する</button></p>
</form>
{*/if*}


{*/categories*}
{if $no_category && !$new}
<p class="note">カテゴリーが見つかりませんでした。</p>
{/if}



{if $db_error}
<p class="error">カテゴリーの読み込みに失敗しました。</p>
{/if}

{literal}
<style type="text/css">
  #previewModal iframe {
    border:none;
    padding: 0px;
  }

  #previewModal .modal-body {
    padding: 15px;
  }

</style>

<script type="text/javascript">
//<[!CDATA[


$(function(){
  $('#preview').on('click',function(){
//  hideLoading();

  var ih = window.innerHeight
  var href = $(this).attr('href');
  var iframe = $('<iframe>').attr('src',href).attr('width','100%').attr('height','100%');
    $("#previewModal").find(".modal-body").css('height',ih*0.9).html(iframe);



//  $("#mailModal").find(".modal-body").load(href);
  $("#previewModal").modal();
	return false;
	});
});
//]]>
</script>
{/literal}

<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-body"></div>
</div>
</div>
</div>

{include file='footer.tpl'}
