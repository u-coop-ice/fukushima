{capture assign="header_insert"}
{literal}
<script type="text/javascript">
//<[!CDATA[

$(function(){
	$('#flag_send').click(function() {
		setTerm();
		});
		setTerm();
});

function setTerm() {
	if ($('#flag_send').prop('checked')){
	$('#term').find('input,select').prop('disabled',false);
	$('#term').show();
	} else {
	$('#term').find('input,select').prop('disabled',true);
	$('#term').hide();
	}
}


//]]>
</script>

<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){
$(".setDateTime").AnyTime_picker(
{ format: "%Y-%m-%d %H:%i:%S" } ),
$(".setDate").AnyTime_picker(
{ format: "%Y-%m-%d" } );
});


$(function(){
	$('.icon-remove').click(function() {
			var tt = $(this).parent();
			$("input",tt).val("");
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

	$('label', radio).click(function() {
		$(this).parent().parent().each(function() {
			$('label',this).removeClass('checked');	
		});
		$(this).addClass('checked');
	});
});

//]]>
</script>


{/literal}
{/capture}

{capture assign="page_title"}
カテゴリの{if $view_category_id}編集{else}新規作成{/if}
{/capture}

{include file='header.tpl'}

{sp_categories id=$view_category_id}
<h4 class="page_title top">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">カテゴリを保存しました。</p>
{/if}
<form name="cat" id="cat" method="post" action="{$self}?mode=save_category">
{if $view_category_id}
<input type="hidden" name="category_id" value="{$view_category_id}" />
{/if}
<table class="inputForm">
<tr>
<th>カテゴリ名称<span class="label label-danger">必須</span></th>
<td><input class="form-control" type="text" name="denomination" id="denomination" value="{$category['denomination']}" /></td>
</tr>

<tr>
<th>URL</th>
<td>
{if $category['part']}
{$init_url}app/{$smarty.const.COMPONENT}/{$category['part']}/
{else}
公開用ディレクトリが設定されていません。
{/if}
<span class="help-block">※この設定は管理画面からは行えません。</span>
</td>
</tr>

<tr>
<th>受注メールアドレス</th>
<td><input class="form-control" type="text" name="ordermail" id="ordermail" value="{$category['ordermail']}" />
<p class="help-block">空欄の場合はショッピング管理メールアドレス{$init_ordermail}に設定されます。</p>
</td>
</tr>

<tr>
<th>INFOCODE</th>
<td><input class="form-control" type="text" name="infocode" id="infocode" value="{$category['infocode']|default:$component[$smarty.const.COMPONENT]['infocode']}" />
</td>
</tr>

<tr>
<th>担当店舗名</th>
<td><input class="form-control" type="text" name="store_name" id="store_name" value="{$category['store_name']|default:$component[$smarty.const.COMPONENT]['store_name']}" />
</td>
</tr>

<tr>
<th>連絡先住所</th>
<td><textarea class="form-control" name="store_address" id="store_address">{$category['store_address']|default:$component[$smarty.const.COMPONENT]['store_address']}</textarea>
</td>
</tr>

<tr>
<th>店舗営業時間</th>
<td><textarea class="form-control" name="store_time" id="store_time">{$category['store_time']|default:$component[$smarty.const.COMPONENT]['store_time']}</textarea>
</td>
</tr>

<tr>
<th>連絡先（TEL）</th>
<td><textarea class="form-control" name="store_phonenumber" id="store_phonenumber">{$category['store_phonenumber']|default:$component[$smarty.const.COMPONENT]['store_phonenumber']}</textarea>
</td>
</tr>

<tr>
<th>連絡先（FAX）</th>
<td><input class="form-control" type="text" name="store_faxnumber" id="store_faxnumber" value="{$category['store_faxnumber']|default:$component[$smarty.const.COMPONENT]['store_faxnumber']}" />
</td>
</tr>


<tr>
<th>概要（ご利用案内ページ上部に表示）</th>
<td><textarea class="form-control" name="description" id="text" cols="50" rows="10">{$category['description']}</textarea></td>
</tr>

<tr>
<th>受注の自動返信メール追記設定</th>
<td>
（注文内容の上側）

<textarea name="autosend_message" cols="50" rows="6" class="form-control">{$category['autosend_message']}</textarea>
</td>
</tr>


<tr>
<th>受注処理後の返信メールのデフォルト追記設定</th>
<td>
<pre>●● ●●様

ご利用ありがとうございます。{$init_coopname}でございます。</pre>

<p>（注文内容の上側）</p>
<textarea name="return_message" cols="50" rows="10" class="form-control">{$category['return_message']}</textarea>

<pre>ご注文内容の詳細は下記となっております。

【ご注文内容】
----------------------------------------------------------
受付No| {$category['infocode']|default:$smarty.session.config['component']['shopping']['infocode']}:2017xxxx-xxxx
…
</pre>


<div class="checkbox">
<label><input type="checkbox" name="include_return_message" value="1" {if $category['include_return_message']}checked="checked"{/if}>注文時の自動返信メールに含める</label></div>

</td>
</tr>

<tr>
<th>入金確認メールのデフォルト設定</th>
<td>
○○ ○○さま<br />


<textarea name="paid_completed_message" cols="50" rows="10" class="form-control" placeholder="{$init_coopname}です。
ご注文いただいた商品代金のご入金を確認いたしました。
">{$category['paid_completed_message']}</textarea><br />

（以下注文内容記載）
</td>
</tr>


<tr>
<th>入金督促メールのデフォルト設定</th>
<td>
○○ ○○さま<br />


<textarea name="nopaid_message" cols="50" rows="10" class="form-control" placeholder="ご利用ありがとうございます。{$init_coopname}です。
このたびは、{$init_coopname}にて{$category['name']}をご注文いただき、ありがとうございます。

商品代金のお支払いについてはご注文後一週間以内のご入金をお願いしております。">{$category['nopaid_message']}</textarea><br />
（ご請求金額。入金確認額等記載）<br />

（以下注文内容記載）
</td>
</tr>

<tr>
<th>発送方法<span class="label label-danger">必須</span></th>
<td>
<div class="checkbox">
{html_checkboxes name="opt_ship" options=$shipAdminList checked=$category["opt_ship"] separator="<br />"}
</div>


{literal}
<script type="text/javascript">
$(function(){

	$('input[name^="opt_ship"]').each(function(){
		if ($(this).prop('checked')){
			if ($(this).val()==-9){
				$(this).parent().prevAll().find('input').prop('disabled',true);
		}
	}


	});

	$('input[name^="opt_ship"]').on('click',function(){
		if ($(this).prop('checked')){
			var that = $(this);
			if (that.val()==-9){
				that.parent().prevAll().find('input').prop('disabled',true);
			} else {
				that.parent().prevAll().find('input').prop('disabled',false);
			}
		} else {
				$(this).parent().prevAll().find('input').prop('disabled',false);
		}
	});
});
</script>
{/literal}

</td>
</tr>


<tr>
<th>配送日時指定フラグ</th>
<td>
<div class="checkbox">
<label><input type="checkbox" name="flag_send" id="flag_send" value="1" {if $category['flag_send']}checked="checked"{/if} /> このカテゴリの商品は配送日時は一括指定になります。</label></div>
</td>
</tr>
<tbody id="term">
<tr>
<th>配送希望日設定</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="nominate" options=$ableList selected=$category['nominate']|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear"></div>
</td>
</tr>
<tr>
<th>配送日指定</th>
<td>
<div class="pull-left"><input type="text" name="term_start" id="term_start" class="form-control setDate datetime" value="{$category['term_start']}" />
〜
<input type="text" name="term_end" id="term_end" class="form-control setDate datetime" value="{$category['term_end']}" />
<span class="icon-remove"><a class="btn btn-primary btn-sm"><i class="fa fa-times"></i>リセット</a></span><span class="em09">（通年運用の場合は空欄でOK）</span>
</div><div class="clear"></div>
<div class="pull-left"><p>指定可能日は
<select name="intervals" class="form-control">
{html_options options=$intervalList selected=$category['intervals']}
</select>
日後以降</p>
</div></td>
</tr>
</tbody>

<tr><th class="mh" colspan="2">支払方法の設定</th></tr>

<tr>
<th>支払方法<span class="label label-danger">必須</span></th>
<td>
{foreach from=$paymentAdminList key=i item=payment}
{if $i!=4}{* PAY.JP除外*}
<div class="checkbox">
<label><input type="checkbox" name="payment[]" value="{$i}" {if is_array($category['payment']) && in_array($i,$category['payment'])}checked="checked"{/if}>{$payment}</label>
</div>
{/if}
{/foreach}

{*html_checkboxes name="payment" options=$paymentAdminList checked=$category["payment"] separator="<br />"*}
</div>
</td>
</tr>


<tr>
<th>クレジット決済のモード</th>
<td>
<div class="radio radio-group clearfix">
<div><label><input type="radio" name="test_mode" value="1" {if $category['test_mode']==1}checked="checked"{/if}>テストモード</label></div>
<div><label><input type="radio" name="test_mode" value="0" {if $category['test_mode']==0}checked="checked"{/if}>ライブモード</label></div>
</div>
<div class="clear" style="margin-bottom:0.8em;"></div>
クレジットカード決済のテスト／ライブモードを設定します。これはサービスごとに切り替えられます。
</td></tr>



<tr>
<th>請求書／払込用紙について</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="opt_bill" options=$onoffList selected=$category['opt_bill']|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear"></div>
<p class="help-block">請求書／払込用紙を同梱するか郵送するか等の選択肢の項目表示設定</p>
</td>
</tr>

{*
<tr><th class="mh" colspan="2">利用方法・特定商取引法に基づく表示</th></tr>

<tr><th>送料・商品のお渡し、お支払い方法について</th>
<td><textarea style="height: 20em;" class="form-control" id="usage" name="usage">{$category['usage']}</textarea>

<h4>個人情報の取り扱いについて</h4>
<p>{$site_coopname}では、個人情報に関して適用される法令、規範を遵守するとともに、生協組合員及びその関係者に関する情報の適正な管理・利用と保護に努めております。［<span rel="tips" title="別ウィンドウで開く::個人情報の取り扱いについて"><a href="{$init_coopurl}{{$smarty.session.auth_db}}/home/privacypolicy.php" target="_blank">詳細</a></span>］</p>
</td></tr>
<tr><th>特定商取引法に基づく表示</th>
<td><textarea style="height: 20em;" class="form-control" id="low" name="low">{$category['low']}</textarea>
</td></tr>

<tr>
<th>表示設定</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="visible" options=$visibleList selected=$category['visible']|default:"1" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear"></div>
</td>
</tr>
*}
<tr>
<th>並び順</th>
<td><input type="text" name="sort_order" id="sort_order" class="form-control" value="{$category['sort_order']}" /></td>
</tr>


</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存">保存する</button></p>
</form>
{/sp_categories}
{if $no_category && !$new}
<p class="alert alert-info">カテゴリが見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">カテゴリの読み込みに失敗しました。</p>
{/if}
{include file='footer.tpl'}
