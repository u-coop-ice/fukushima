{* ヘッダー部分の組み込み *}
{literal}

<!-- validationEngine.js -->

<link rel="stylesheet" href="/js/jquery/validationEngine/validationEngine.jquery-3.1.0.css" type="text/css"/>


<script type="text/javascript" src="/js/jquery/validationEngine/jquery.validationEngine-3.1.0.js"></script>
<script type="text/javascript" src="./js/jquery.validationEngine-ja.js"></script>

<script type="text/javascript">

$(function(){

	var fm =$("#form")
	var act = fm.attr("action");

fm.validationEngine('attach', {
	'promptPosition' : "inline",
	'onValidationComplete': function(form, status){

if (status == true){
		let cmp ={};

		cmp.name = $('#item_id option:selected').data('name');
		cmp.no = $('#item_id option:selected').data('no');
		cmp.index = $('#item_id').data('index');
		cmp.item_id = $('#item_id').val();
		cmp.num = $('#num').val();

			add ='<div class="composition_item_id" data-num="'+cmp.num+'"><input type="hidden" name="composition_item_ids['+cmp.index+'][item_id]" value="'+cmp.item_id+'"/>';
			add +='<input type="hidden" name="composition_item_ids['+cmp.index+'][num]" value="'+cmp.num+'"/>';
			add +='<input type="hidden" name="composition_item_ids['+cmp.index+'][name]" value="'+cmp.name+'"/>';
			add +='<input type="hidden" name="composition_item_ids['+cmp.index+'][no]" value="'+cmp.no+'"/>';
			add += '<span class="code">【'+cmp.no+'】'+cmp.name+'</span> x '+cmp.num+' <button type="button" class="btn-delete-compose-item btn btn-sm"><i class="fa fa-times"></i></button></div>';

		$('#compose_items').append(add);
		$("#apiModal").modal('hide');

}

  }
});

});


</script>

{/literal}

<h4>商品構成（セット）設定</h4>
<form id="form">

<div class="form-group">
<select class="form-control" id="item_id" name="item_id" data-index={$index}>
<option value="">（商品名）</option>
{items not_id=$item_id not_set=1 per_page=200}
<option value="{$item['id']}" data-no="{$item['no']}" data-name="{$item['name']}">【{$item['no']}】{$item['name']}</option>
{/items}
</select>
<p class="form-control-plaintext text-muted">セット商品は選択できません。</p>
</div>

<div class="form-group">
<div class="pull-left">
<input class="form-control validate[required,custom[number]]" size=5 type="text" id="num" name="num" value="1" />
</div>
<div class="pull-left">
<p class="form-control-static">個</p>
</div>
</div>

<div class="clearfix"></div>
<button class="btn btn-primary" type="submit">追加する</button>

</form>
