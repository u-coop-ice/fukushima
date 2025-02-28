/*****************************************************************
 * ユーザー情報のポップアップ 要jquery.fancybox.js
 *******************************************************************/
$(function(){

$('.get_regist').on('click',function(){
	var eid = $(this).attr('data');

$.fancybox.showLoading();

	$.ajax({
		async:false,
		cache:false,
		type: "post",
		data: {regist_id:eid},
		url:"../regist/?mode=get_regist",
		success: function(d){
$.fancybox.hideLoading();
$.fancybox(d,{
	width : 750,
	height: $(document).height()*.8,
	autoSize: false
});
		}
	});
});


});
