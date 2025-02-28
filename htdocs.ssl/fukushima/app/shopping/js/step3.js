$(function(){
$("#theForm").validationEngine({
	promptPosition : "inline",
	scrollOffset: 200
});
});

$(function(){
$('.cardnumber').autotab();
});

$(function($){
	$("[name='payment']").on('click', function(){
	setCardInfo();
	});

	$('[name="payjp-card_id"]').on('click',function(){
		set_btn_submit();
	});

    $('[name="veritrans-card_id"]').on('click',function(){
        $('#regist_card_number').val($(this).parent('label').attr('data'));
        $('#inputTokenInfo').hide().find('input,select').prop('disabled',true);
        $('#check_regist_card').hide().find('input,select').prop('disabled',true);
        $('#inputCardnumber').find('input').prop('disabled',true);
        set_btn_submit();
    });

	setCardInfo();
});


function setCardInfo() {
    if ($("[name='payment']").attr("type")=="hidden"){
        var p = $("[name='payment']").val();
    } else {
        var p = $("[name='payment']:checked").val();
    }

    $("#setCvsInfo_veritrans").hide();

    set_reinput_cardnumber();

    var t = $("#setBillInfo");

    	if(p==4){
		$("#setCardInfo_payjp").show();
		$("#setCardInfo_veritrans").hide().find('input,select').prop('disabled',true);
        set_regist_card(false);

        if (t.size()){
        t.hide().find("input").prop('disabled',true);
        }
        set_btn_submit(false);

		if ($("[name='payjp-token']").val()){
            if($("#token-card").size()) {
            $("#token-card").hide();
            }
        set_regist_card();
        set_btn_submit();
		} else if($("#token-card").size()) {
        set_regist_card();
        set_btn_submit();
		}
	} else if(p==5){;
		$("#setCardInfo_payjp").hide();
		$("#setCardInfo_veritrans").show().find('input,select').prop('disabled',false);
                set_btn_submit(false);

        var card = ($('#inputCardInfo').find('input:radio').size());
        if (card>0){
            $("#inputTokenInfo").hide().find('input,select').prop('disabled',false);
        }

       if (t.size()){
        t.hide().find("input").prop('disabled',true);
        }

		if ($("#inputCardnumber").attr('data')){
        set_btn_submit();
		}
    } else if(p==6){;
        $("#setCardInfo_payjp").hide();
        $("#setCardInfo_veritrans").hide();
        set_regist_card(false);

        t.hide().find("input").prop('disabled',true);
        $("#setCvsInfo_veritrans").show();
        set_btn_submit();

	} else if (p==1) {
        $("[id^='setCardInfo']").hide();
        set_regist_card(false);
       if (t.size()){
        t.show().find("input").prop('disabled',false);
        }
        set_btn_submit();
    } else if (p>=2 && p<=3) {
        $("[id^='setCardInfo']").hide();
        set_regist_card(false);
       if (t.size()){
        t.hide().find("input").prop('disabled',true);
        }
        set_btn_submit();
    } else if (p>=7 && p<=8) {
        $("[id^='setCardInfo']").hide();
        set_regist_card(false);
       if (t.size()){
        t.hide().find("input").prop('disabled',true);
        }
        set_btn_submit();
	} else {
       if (t.size()){
        t.hide().find("input").prop('disabled',true);
        }
		$("[id^='setCardInfo']").hide();
        set_regist_card(false);
        set_btn_submit(false);
	}
}

function set_regist_card(e){
    if (e==false){
    $("#check_regist_card").addClass('none').find('input').prop('disabled',!e);
    } else {
    $("#check_regist_card").removeClass('none').find('input').prop('disabled',false);
    }

}

function set_reinput_cardnumber(){
    $('#btn_input_newcardnumber').on('click',function(){
    $('[name="veritrans-card_id"]').prop('checked',false);
    $('#inputCardnumber').find('input').prop('disabled',false);
    $('#inputTokenInfo').show().find('input,select').prop('disabled',false);
    });
}


function set_btn_submit(e){
    if (e==false){
	$("#btn_submit").hide().find('button').attr('disabled',true);
} else {
    $("#btn_submit").show().find('button').attr('disabled',false);
    if ($("[name='payjp-token']").val() || $("[name='token_id']").val()){
        set_regist_card();
    }

}
}

$(function(){
$("#vtForm").validationEngine('attach', {
    'promptPosition' : "inline",
    'scrollOffset': 200,
    'onValidationComplete': function(form, status){
if (status == true){
    submitToken(form);
    return false;
}
    return false;
  }
});
});


$(function(){
$("#btn_reinput_cardnumber").one('click',function(){
    $(this).hide();
    set_btn_submit(false);
    $("#inputCard").show();
});
});

        function submitToken(e) {
            var data = {};
            data.token_api_key = e.attr("data");
            var url = e.attr("action");
                data.card_number = $('#cardnumber1').val()+$('#cardnumber2').val()+$('#cardnumber3').val()+$('#cardnumber4').val();
                data.card_expire = $('#exp_month').val()+'/'+($('#exp_year').val()-2000);
                data.security_code = $('#cvc').val();
                data.cardholder_name = $('#holdername').val();
                data.lang = "ja";
            var jpo = $('#select_jpo').val();

            var xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
            xhr.addEventListener('loadend', function () {
                if (xhr.status === 0) {
                    alert("トークンサーバーとの接続に失敗しました");
                    return;
                }
                var response = JSON.parse(xhr.response);
                if (xhr.status == 200) {
                    $('#inputTokenInfo').slideUp().find("input,select").prop('disabled',true);
                    $('#token_id').val(response.token);
                    $('#jpo').val(jpo);
                    var label_req_card_number = "<span class='em14 green'><i class='fa fa-fw fa-check-circle'></i></span>";
                    label_req_card_number +=response.req_card_number;
                    if (jpo){label_req_card_number += "<br />支払種別: "+getJpoName(jpo);}
                    $('#label_req_card_number').html(label_req_card_number).addClass('');
                    $('#req_card_number').val(response.req_card_number);
                    $('#btn_submit_token').hide().prop('disabled',true);
                    set_btn_submit();
                    $('#inputCardnumber').show();
                    $(window).scrollTop($('#inputCardnumber').offset().top-50);
                }
                else {
                    $('#token_id').val(response.token);
                    alert(response.message);
                    $(window).scrollTop($('#cardnumber1').offset().top-50);
                }

            });
            xhr.send(JSON.stringify(data));
        }
