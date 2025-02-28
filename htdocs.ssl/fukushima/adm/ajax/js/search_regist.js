
$(function() {
	$('#username').prop('disabled',true);
	$('#regist_id').prop('disabled',true);
	setUser();

	$('[name="regist_user"]').on('click',function(){
	$('#theForm').validationEngine('hide');
	setUser();
});

$(function() {
	$('#visible').on('click',function(){
	setUser();
	});
});


function setUser(){
	var regist = (Number($('[name="regist_user"]:checked').val()) > 0);

	$('#username').prop('disabled',!regist);
	$('#regist_id').prop('disabled',!regist);


	if ($('[name="visible"]').size()){
	$('#visible').prop('disabled',!regist).prop('checked',regist);
	}

	if ($('[name="admitted"]').size()){
		$('#admitted_fixed').prop('checked',!regist);
		$('#admitted_unfixed').prop('disabled',!regist);
	}

	$("button[type='submit']").prop('disabled',regist);
	if ($('[name="regist_id"]').val()){
	$("button[type='submit']").prop('disabled',false);
	} else {
	if (regist){$("#username").focus();}
	}
}

});

/*
$(function() {
var sp = $('[name="said_person"]');
sp.on('click',function(){
	setUser(sp);
});
	setUser(sp);
});

function setUser(e){
if($('[name="said_person"]:checked').val()==1){
	$('#the_said_person').hide();
} else {
	$('#the_said_person').show();
}
}
*/


// インクリメントユーザー検索


$(function() {

  var timeout = null;

	$("#username").on("input", function() {
	if (timeout) {
	clearTimeout(timeout);
	}
	timeout = setTimeout(function() {
	searchUser();
	}, 900);
	});

	searchUser();

});

function searchUser() {
var rankList = ['','本人','保護者'];
		$("#username").autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/adm/ajax/?mode=search_regist",
					type: "POST",
					dataType: "json",
					data: {
						term: request.term
					}
				}).done(function( data ) {
						response( $.map(data, function(item){
							var lv = item.username;
							var lb = lv;
							if (item.namef){
							lv =item.namef + ' ' + item.nameg;
							lb += " "+lv;
							}
							lb += ' ('+ rankList[item.rank] +')';
							return {
								'label': lb,
								'value': lv,
								'user': item
							}
						}));
				}).fail(function(e){
					});
				},

			minLength: 1,
			select: function( event, ui ) {
				$("#loading").hide();
				setId(ui.item.user);
			},
			open: function(){
				delId();
			},
		});
	}

		function setId(u) {

			$('#regist_id').val(u.id);
			var user_info = u.username;
			if (u.namef){
			user_info += "<br />"+u.namef+' '+u.nameg;
			} else {
			user_info += "<br />氏名未登録";
			}
			if (u.zipcodef){

			var zipcodef = ('000' + u.zipcodef).slice(-3);
			var zipcodes = ('0000' + u.zipcodes).slice(-4);

			user_info += "<br />〒"+zipcodef+"-"+zipcodes+"<br />"+u.pref+u.addressf
			if (u.addresss){
			user_info += u.addresss;
			}
			if (u.addresst){
			user_info += u.addresst;
			}
			} else {
			user_info += "<br />住所未登録";
			}

			$('#regist_info').html(user_info);
				$("button[type='submit']").prop('disabled',false);
		}

		function delId() {
			$('#user_id').val('');
			$('#user_info').html('');
			$("button[type='submit']").prop('disabled',true);
		}


