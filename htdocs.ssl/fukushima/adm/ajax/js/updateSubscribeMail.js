$(function(){
  $(".update_subscribe_mail").on('click', function(){
    var appid = $(this).attr('app_id');
    updateSubscribeMail(appid);
    return false;
  });
});

function updateSubscribeMail(i) {
  var act = "../ajax/?mode=edit_subscribe_mail";
  if (i) {act += "&regist_id="+i;}
  $.fancybox({
  'width': 380,
  'height': 250,
  'padding': 15,
  'autoSize': false,
  'autoHeight': false,
  'scrolling'   : 'no',
  'href': act,
  'type': "iframe",
  'helpers': {
          overlay: {
            locked: false,
          }
        }
  });
}