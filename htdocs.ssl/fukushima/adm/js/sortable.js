$(function(){
	$(document).on('click','#sortable input[type="radio"]',function(){
		var parent = $(this).parents('tr');
		noUse(parent);
	});

	$('input[name*="[use]"]','#sortable').each(function(){
	var parent = $(this).parents('tr');
	noUse(parent);
	});

});

function noUse(parent) {
		let u = parent.find('input[name*="[use]"]');
		var tmp = u.attr("name");
		if (tmp.match("extra")){
			if($('input[name="'+tmp+'"]:checked').val()==0){
				parent.addClass("no_use").find('[name*="extra[tag]"]').prop('disabled',true);
				parent.find('input[type="text"],textarea').prop('disabled',true);
			} else {
				parent.removeClass("no_use")
				.find('*').prop('disabled',false).removeClass('DIS');
			}
			noSelect(parent);

		} else if (tmp!="stock_multi[use]"){
		if($('input[name="'+tmp+'"]:checked').val()==0){

		parent.addClass("no_use")
			.find('input[type="text"],textarea').prop('disabled',true);
		parent.find('label').addClass('DIS');
		} else {
		parent.removeClass("no_use")
		.find('*').prop('disabled',false).removeClass('DIS');
		}
	}
}

function noSelect(p) {
			let tag = p.find('input[name*="[tag]"]');

			let tg = "text";
			tag.each(function(){
			if (!$(this).prop('disabled')){
				if ($(this).prop('checked')){
				tg = $(this).val();
				}
			}
			});
			p.find("[name*='extra\[select\]']").prop('disabled',tg.match('text'));
}

$(function(){
		var options = {
		placeholder: "placeholder",
		connectWith: "#sortable tbody",
		update: function(ev, ui) {
			var result =  $("#sortable tbody").sortable("toArray");
        $("#result").val(result);
		}
	}
	$("#sortable tbody").sortable(options);

	preResult = $('#result').val().split(",").reverse();

$.each(
			preResult,
			function(index, value) {
				if (value!="sort_email"){
			$('#'+value).prependTo("#sortable tbody");
				}
			}
		);

$('#submit').click(function() {
		var rs = $("#sortable tbody").sortable("toArray");
		$("#result").val(rs);
		$("form").submit();
	});

});
