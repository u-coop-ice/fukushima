{* ページタイトル 開始 *}
{capture assign="page_title"}商品の{if $view_item_id}編集{else}登録{/if}{/capture}
{* ページタイトル 終了 *}

{capture assign="header_insert"}
{literal}

<link rel="stylesheet" href="/js/jquery/anytime/anytime.5.1.2.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery/anytime/anytime.5.1.2.min.js"></script>

<script type="text/javascript">
//<![CDATA[
$(function(){
$("#limit_date").AnyTime_picker(
{ format: "%Y-%m-%d %H:%i:%S" } );
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

$(function($){
	setAttr();
	for (m=1;m<=3;m++){
	$('input[name=extra'+m+'_use]').click( function(){setAttr()});
	$('input[name=cart'+m+'_use]').click( function(){setAttr()});
	}
});

function setAttr() {
	for (n=1;n<=3;n++){
		if ($('input[name=extra'+n+'_use]:checked').val() == 0) {
		$('#extra'+n+'_select').prop("disabled",true);
		$('#extra'+n+'_title').prop("disabled",true);
		$('#extra'+n+'_note').prop("disabled",true);
		$('#extra'+n).slideUp();
		} else {
		$('#extra'+n+'_select').prop("disabled",false);
		$('#extra'+n+'_title').prop("disabled",false);
		$('#extra'+n+'_note').prop("disabled",false);
		$('#extra'+n).slideDown().removeClass("none");
		}

		if ($('input[name=cart'+n+'_use]:checked').val() == 0) {
		$('#cart+n *').attr("disabled","disabled");
		$('#cart'+n).slideUp();
		} else {
		$('#cart+n *').removeAttr("disabled");
		$('#cart'+n).slideDown().removeClass("none");
		}

	}
	}


$(function(){
	$('#reset_ld').click(function() {
			$('#limit_date').val('');	
		});
});

$(function(){
	$('.delete_image').on('click',function(){

		var index = $(this).data();
		var item_id = $("input[name='item_id']").val();
		var json = [{"name":"index","value":index['index']},{"name":"item_id","value":item_id}];


if (!confirm('商品画像を削除しますか? \nこの操作は取り消せません。')){
	return false;
}
		$.ajax({
		url:"./?mode=delete_image",
		type: "post",
		data: json,
		cache	: false,
		async	: false,
		dataType: "json"
		}).done(function(r){
			if (r['errmsg']){
			alert(r['errmsg']);
			return false;
			} else {
			$("#image_uploaded"+r['index']).hide();
			alert('商品画像ファイルの削除が完了しました。');
			}
		}).fail(function(r){
			alert('通信に失敗しました。');
			return false;
		});

		return false;
	});
});


//]]>
</script>

<!-- validationEngine.js -->

<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-2.6.2.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>
<script type="text/javascript">
$(function(){
$("#formID").validationEngine({
	promptPosition: "inline"
});
});
</script>


{/literal}
{/capture}



{* ヘッダー部分の組み込み *}
{include file='header.tpl'}

{* 商品編集フォーム 開始 *}
{items}
<h4 class="top page_title">{$page_title}</h4>
{if $saved}
<p class="alert alert-success">商品を保存しました。</p>
{/if}
<form id="theForm" method="post" enctype="multipart/form-data" action="{$self}?mode=save_item">
{if $item["id"]}
<input type="hidden" name="item_id" value="{$item["id"]}" />
{/if}
<table class="inputForm">
<col style="width:20%;" />
<col style="width:80%;" />
<tr>
<th>商品ID</th>
<td>{$item["id"]}（このシステムの商品管理IDです）</td>
</tr>
<tr>
<th>商品番号<span class="label label-danger">必須</span></th>
<td><input type="text" name="no" id="no" value="{$item["no"]}" class="form-control validate[required]" /></td>
</tr>
<tr>
<th>商品名<span class="label label-danger">必須</span></th>
<td><input type="text" name="name" id="name" size="50" value="{$item["name"]}" class="form-control validate[required]" /></td>
</tr>
<tr>
<th>商品名（ふりがな）</th>
<td><input type="text" name="furigana" id="furigana" class="form-control" value="{$item["furigana"]}" /></td>
</tr>
<tr>
<th>生産国・メーカー</th>
<td><input type="text" name="maker" id="maker" class="form-control" value="{$item["maker"]}" /></td>
</tr>
<tr>
<th>お届けサイズ</th>
<td><input type="text" name="size" id="size" class="form-control" value="{$item['size']}" /></td>
</tr>

<tr>
<th>商品重量</th>
<td>
<select name="weight" id="weight" class="form-control">
<option value=""></option>
{html_options options=$weightList selected=$item["weight"]}

</select>
</td>
</tr>

<tr>
<th>登録日</th>
<td><input type="text" name="regist_date" id="regist_date" class="form-control" value="{$item['regist_date']|date_format:'%Y-%m-%d %H:%M:%S'}" />
</tr>
<tr>
<th>値段<span class="label label-danger">必須</span></th>
<td><input type="text" name="price" id="price" class="form-control" value="{$item["price"]}" class="validate[required]" />円</td>
</tr>
<tr>
<th>送料<span class="label label-danger">必須</span></th>
<td>
<select name="postage" id="postage" class="form-control validate[required]">
{html_options options=$postageList selected=$item["postage"]}
</select>
</td>
</tr>

<tr>
<th>著者・編者等</th>
<td><input class="form-control" type="text" name="author" id="author" value="{$item['author']}" /></td>
</tr>

<tr>
<th>商品（ISBN）コード</th>
<td><input class="form-control" type="text" name="item_code" id="item_code" value="{$item['item_code']}" /></td>
</tr>
<tr>
<th>発行日</th>
<td><input class="form-control" type="text" name="release" id="release" value="{$item['release']}" /></td>
</tr>

<tr>
<th>判型・頁数等</th>
<td><input class="form-control" type="text" name="page" id="page" value="{$item['page']}" /></td>
</tr>


<tr>
<th>カテゴリ<span class="label label-danger">必須</span></th>
<td>
<select name="subcategory_id" id="subcategory_id" class="form-control">
{sp_subcategories}
<option value="{$subcategory['id']}"{if $subcategory['id'] == $item['subcategory_id']} selected="selected"{/if}>【{$subcategory['category_denomination']}】{$subcategory['denomination']}</option>
{/sp_subcategories}
</select>
</td>
</tr>
<tr>
<th>孫カテゴリ</th>
<td>
<select class="form-control" name="sub2category_id" id="sub2category_id">
<option value="">孫カテゴリなし</option>
{sp_sub2categories subcategory_id=$item['subcategory_id']}
<option value="{$sub2category['id']}"{if $sub2category['id'] == $item['sub2category_id']} selected="selected"{/if}>【{$sub2category['subcategory_denomination']}】{$sub2category['denomination']}</option>
{/sp_sub2categories}
</select>
</td>
</tr>

<tr>
<th>商品の説明</th>
<td>
<textarea name="description" id="description" class="form-control">{$item["description"]}</textarea>
</td>
</tr>
<tr>
<th>商品の内容</th>
<td>
<textarea name="content" id="contents" class="form-control">{$item["content"]}</textarea>
</td>
</tr>
<tr>
<th>商品写真<br />
retinaディスプレイやスマホに対応するために、横幅640px以上の画像をUPしてください。
</th>
<td>
{if $item["image"]}
<div id="image_uploaded0">
{capture assign="image_dir"}{$smarty.const.DOMAIN}/app/{$smarty.const.COMPONENT}/images/{/capture}

{image_display_gcs calc_width=125 image_dir=$image_dir file_image=$item['image']}
アップロード済み：{$item["image"]}<br />
<img class="itemImg" src="{$image_src}" {$image_attr} alt="{$item_name}" title="{$item_name}" />
<button class="btn btn-primary btn-sm delete_image" data-index=0 type="button"><i class="fa fa-fw fa-times"></i>削除</button>
</div>
{/if}
<input type="file" name="image[]" id="image[]" size="50" />
</td>
</tr>
<tr>
<th>包装状態</th>
<td>
<select name="package" class="form-control">
{html_options values=$packageList options=$packageList selected=$item["package"]}
</select>
</td>
</tr>
<tr>
<th>配送方法</th>
<td>
<select name="temperature" class="form-control">
{html_options options=$temperatureList selected=$item["temperature"]}
</select>
</td>
</tr>

<tr>
<th>賞味期限</th>
<td>
<input type="text" name="bestbefore" id="bestbefore" class="form-control" value="{$item["bestbefore"]}" />
</td>
</tr>


<tr>
<th>お届け期間</th>
<td>
<input class="form-control" type="text" name="send_date" id="send_date" value="{$item["send_date"]}" />
</td>
</tr>


<tr><th class="mh" colspan="2">商品在庫設定</th></tr>
<tr><th>在庫引当</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="onstock" options=$onoffmultiList selected=$item["onstock"]|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear"></div>
</td>
</tr>
<tbody id="tbody_stock">
<tr><th>在庫数</th>
<td>
<div class="pull-left">
<div class="form-control-static"><span class="em12">『{$item['stock']}』</span> 仕入数：</div>
</div>
<div class="pull-left">
<input class="form-control number" type="text" name="stock" value=""/>
</div>
<div class="clearfix"></div>
{if $item['id']}
{logs log="stock_log" item_id=$item['id'] before=1 sort="DESC"}
{if $log_header}
<div style="margin-top:0.8rem;"></div>
<table>
<thead>在庫関係の管理ログ（過去3ヶ月）</thead>
{/if}
<tr><td>{$log['date']}</td><td>{$log['num']|number_plus}</td><td><a class="" target="_blank" href="{$self}?mode=show_order&app_id={$log['app_id']}">{$log['regist_code']}</a></td><td>{$log['auth_username']}</td></tr>
{if $log_footer}
</table>
{/if}
{/logs}
{/if}
</td>
</tr>
</tbody>
<tbody id="tbody_composition">
<tr><th>商品構成</th>
<td>
<div id="compose_items">
{if $item['composition_item_ids']}{foreach from=$item['composition_item_ids'] item="composition_item_id" key=i}

<div class="composition_item_id">
<input type="hidden" name="composition_item_ids[{$i}][item_id]" value="{$composition_item_id['item_id']}"/>
<input type="hidden" name="composition_item_ids[{$i}][num]" value="{$composition_item_id['num']}"/>
<input type="hidden" name="composition_item_ids[{$i}][no]" value="{$composition_item_id['no']}"/>
<input type="hidden" name="composition_item_ids[{$i}][name]" value="{$composition_item_id['name']}"/>
<span class="code">【{$composition_item_id['no']}】{$composition_item_id['name']}</span> x {$composition_item_id['num']} <button type="button" class="btn-delete-compose-item btn btn-sm"><i class="fa fa-times"></i></button>
</div>
{/foreach}
{/if}
</div>
<div><button class="btn btn-primary btn-sm" type="button" id="btn_compose_item"><i class="fa fa-plus"></i> 商品（セット）を構成する</button></div>

</td>
</tr>

{literal}
<script type="text/javascript">
$(function(){
	let onstock = $('[name="onstock"]:checked').val();
	setStock(onstock);

	$('[name="onstock"]').on('click',function(){
			setStock($(this).val());
	});
})

function setStock(s){
	switch (s){
	case "1":
		$('#tbody_stock').find('input').prop('disabled',false);
		break;
	case "2":
		$('#tbody_stock').find('input').prop('disabled',true);
		break;
	default:
		$('#tbody_stock').find('input').prop('disabled',true);
	}
}

$(function(){
	$('#btn_compose_item').on('click',function(){
		dialogComposeItem();
	});
});

function dialogComposeItem() {
	var index = $('.composition_item_id').length;
	var item_id = $('[name="item_id"]').val();
  var act = "./?mode=dialog_compose_item&index="+index;
  if (item_id){
  	act += '&item_id='+item_id;
  }
  execModal($('#btn_compose_item'),act);
}


$(document).on('click','.btn-delete-compose-item',function(e) {
	$(this).parent('div').data('num',0).html("");
});

</script>


</script>
{/literal}

<tr><th class="mh" colspan="2">商品選択時のオプション設定</th></tr>

<tr>
<th>商品オプション<br />ドロップダウン追加<br />
項目設定(1)<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio radio-group clearfix">


{html_radios name="cart1_use" options=$extraList selected=$item['cart1_use']|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
<div id="cart1" class="none">
項目名:<input type="text" class="form-control" name="cart1_title" id="cart1_title" value="{$item['cart1_title']}" />
ドロップダウン項目:
<textarea name="cart1_select" class="form-control" id="cart1_select" cols="10" rows="5" />{$item['cart1_select']}</textarea>
項目の下に記載する注意書き等:
<textarea name="cart1_note" class="form-control" id="cart1_note" />{$item['cart1_note']}</textarea>
</div>
</td>
</tr>

<tr>
<th>商品オプション<br />ドロップダウン追加<br />
項目設定(2)<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="cart2_use" options=$extraList selected=$item['cart2_use']|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
<div id="cart2" class="none">
項目名:<input type="text" class="form-control" name="cart2_title" id="cart2_title" value="{$item['cart2_title']}" />
ドロップダウン項目:
<textarea name="cart2_select" class="form-control" id="cart2_select" cols="10" rows="5" />{$item['cart2_select']}</textarea>
項目の下に記載する注意書き等:
<textarea name="cart2_note" class="form-control" id="cart2_note" />{$item['cart2_note']}</textarea>
</div>
</td>
</tr>

<tr>
<th>商品オプション<br />ドロップダウン追加<br />
項目設定(3)<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio radio-group clearfix">


{html_radios name="cart3_use" options=$extraList selected=$item['cart3_use']|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
<div id="cart3" class="none">
項目名:<input type="text" class="form-control" name="cart3_title" id="cart3_title" value="{$item['cart3_title']}" />
ドロップダウン項目:
<textarea name="cart3_select" class="form-control" id="cart3_select" cols="10" rows="5" />{$item['cart3_select']}</textarea>
項目の下に記載する注意書き等:
<textarea name="cart3_note" class="form-control" id="cart3_note" />{$item['cart3_note']}</textarea>
</div>
</td>
</tr>

<tr><th class="mh" colspan="2">配送希望入力時のオプション設定</th></tr>


<tr>
<th>配送日指定</th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="nominate" options=$ableList selected=$item["nominate"]|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear"></div>
<p class=""><span class="tag min">可</span>の場合サブカテゴリでの設定が適応されます。</p>
</td>
</tr>

<tr>
<th>配送不可情報</th>
<td>
<select class="form-control" name="nosend">
{html_options options=$nosendList selected=$item["nosend"]}
</select>
</td>
</tr>

<tr>
<th>のしオプション</th>
<td>
<select name="noshi_use" id="noshi_use" class="form-control">
<option value="" {if !$item["use_noshi"]}selected="selected"{/if}>オプション不要</option>
<option value="1"{if $item["noshi_use"]=="1"}selected="selected"{/if}>標準型（オリジナルグッズ等）</option>
<option value="2"{if $item["noshi_use"]=="2"}selected="selected"{/if}>ギフト型（みやぎ生協夏ギフト等）</option>
</select>

</td>
</tr>

<tr>
<th>ドロップダウン追加項目設定(1)<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio radio-group clearfix">


{html_radios name="extra1_use" options=$extraList selected=$item["extra1_use"]|default:"0" assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
<div id="extra1" class="none">
項目名：<input type="text" class="form-control" name="extra1_title" id="extra1_title" value="{$item["extra1_title"]}" /><br />
ドロップダウン項目<br />
<textarea class="form-control" name="extra1_select" id="extra1_select" cols="10" rows="5" />{$item["extra1_select"]}</textarea>
項目の下に記載する注意書き等
<textarea class="form-control" name="extra1_note" id="extra1_note" />{$item["extra1_note"]}</textarea>
</div>
</td>
</tr>

<tr>
<th>ドロップダウン追加項目設定(2)<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="extra2_use" options=$extraList selected=$item['extra2_use']|default:"0" output=$extraList assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
<div id="extra2" class="none">
項目名：<input class="form-control" type="text" name="extra2_title" id="extra2_title" value="{$item["extra2_title"]}" /><br />
ドロップダウン項目<br />
<textarea class="form-control" name="extra2_select" id="extra2_select" cols="10" rows="5" />{$item["extra2_select"]}</textarea>
項目の下に記載する注意書き等
<textarea class="form-control" name="extra2_note" id="extra2_note" />{$item["extra2_note"]}</textarea>
</div>
</td>
</tr>

<tr>
<th>ドロップダウン追加項目設定(3)<br /><span class="em08">1項目毎に改行して入力してください。</span></th>
<td>
<div class="radio radio-group clearfix">
{html_radios name="extra3_use" options=$extraList selected=$item['extra3_use']|default:"0" output=$extraList assign=radioTags}
{section name=radioButtons loop=$radioTags}
<div>{$radioTags[radioButtons]}</div>
{/section}
</div>
<div class="clear" style="margin-bottom: 0.8em;"></div>
<div id="extra3" class="none">
項目名：<input class="form-control" type="text" name="extra3_title" id="extra3_title" value="{$item["extra3_title"]}" /><br />
ドロップダウン項目<br />
<textarea class="form-control" name="extra3_select" id="extra3_select" cols="10" rows="5" />{$item["extra3_select"]}</textarea>
項目の下に記載する注意書き等<textarea class="form-control" name="extra3_note" id="extra3_note" />{$item["extra3_note"]}
</textarea>
</div>
</td>
</tr>

<tr><th class="mh" colspan="2">受注制御設定</th></tr>

<tr>
<th>受注終了</th>
<td>
<div class="pull-left"><input type="text" name="limit_date" id="limit_date" value="{$item["limit_date"]}" class="form-control datetime" />
<span id="reset_ld"><a class="btn btn-primary btn-sm"><i class="fa fa-fw fa-remove"></i>リセット</a></span>
</div></td>
</tr>

<tr>
<th>受注終了時のメッセージ</th>
<td>
<input class="form-control" type="text" name="limit_note" id="limit_note" value="{$item["limit_note"]|default:"取り扱いは終了しました。"}" />
</td>
</tr>


<tr>
<th>商品をリストに表示</th>
<td>
<div class="radio radio-group clearfix">
<div><label for="visible_off"><input type="radio" name="visible" id="visible_off" value="0"{if !$item["visible"]} checked="checked"{/if}>非表示</label></div>
<div><label for="visible_on"><input type="radio" name="visible" id="visible_on" value="1"{if $item["visible"]} checked="checked"{/if}>表示</label></div>
</div>
</td>
</tr>
</table>
<p><button class="btn btn-primary" type="submit" name="submit" value="保存"><i class="fa fa-fw fa-check"></i>保存する</button></p>
</form>
{/items}
{* 商品編集フォーム 終了 *}

{* 商品が見つからなかった場合の出力等 開始 *}
{if $no_item}
<p class="alert alert-info">商品が見つかりませんでした。</p>
{/if}
{if $db_error}
<p class="alert alert-danger">商品の読み込みに失敗しました。</p>
{/if}
{* 商品が見つからなかった場合の出力等 終了 *}

<div class="modal fade" id="apiModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div style="position:absolute; top:5px;right:5px;z-index: 1;"><button type="button" class="btn-close" data-dismiss="modal"><i class="fa fa-times"></i></button></div>
<div class="modal-body"></div>
</div>
</div>
</div>

{literal}
<script type="text/javascript">

  function execModal(_target,_href){

  $("#apiModal").find(".modal-body").load(_href);
  $("#apiModal").modal('show');
  return false;

  }


</script>
{/literal}

{* フッター部分の組み込み *}
{include file='footer.tpl'}
