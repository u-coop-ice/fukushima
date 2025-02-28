/*****************************************************************
 * 日程からプラン・パックの絞り込みetc
 *******************************************************************/
$(function(){
	var c = $("#category_id");
	var s = $("#subcategory_id");
	var i = $("#item_id");

	c.on('change',function(){
		var id = $(this).val();
		i.empty();
		i.append($("<option />").val("").text(""));
		getSubCategory(s,id,i);
	});
	s.on('change',function(){
		var scid = $(this).val();

	getItem(i,scid);
	});

	var iid = i.val();
	var scd = s.val();
	getSubCategory(s,iid,i);
	getItem(i,scd);
});

function getSubCategory(s,id,it){
	var op = $("<option />").val("").text("すべてのサブカテゴリ");
	if (!id){
		s.empty();
		s.append(op);
		s.prop('disabled',true);
		it.prop('disabled',true);
		return;
	} else {
		s.prop('disabled',false);
	}
	$.ajax({
		async:true,
		cache:false,
		type: "post",
		dataType:"json",
		data: {category_id:id},
		url:"./?mode=select_category",
		success: function(d){
			s.empty();
			s.append(op);
			var sid = s.attr("data");
			var sc = d['subcategory'];
			for (i=0;i<sc.length;i++){
				var ops = $("<option />").val(sc[i].id).text(sc[i].denomination);
				if (sc[i].id == sid){
				ops.prop("selected",true);
				}
				s.append(ops);
			}
		}
	});
}

function getItem(i,scid){
	var op = $("<option />").val("").text("すべての商品");
	if (!scid){
		i.empty();
		i.append(op);
		i.prop('disabled',true);
		return;
	} else {
		i.prop('disabled',false);
	}
	$.ajax({
		async:true,
		cache:false,
		type: "post",
		dataType:"json",
		data: {subcategory_id:scid},
		url:"./?mode=select_category",
		success: function(d){
			i.empty();
			i.append(op);
			var ii = i.attr("data");
			var item = d['item'];

			for (j=0;j<item.length;j++){
				var ops = $("<option />").val(item[j].id).text(item[j].name);
				if (item[j].id == ii){
				ops.prop("selected",true);
				}
				i.append(ops);
			}
		}
	});
}