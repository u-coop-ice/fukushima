$(function() {
    //    initialize FlexNav
    $(".flexnav ").flexNav({
                'hoverIntent': true,
        'hoverIntentTimeout': 300,

    });
});

// detective retina display

$(function() {
    if (!$.cookie('device_pixel_ratio')) {
        if (window.devicePixelRatio > 0) {
            $.cookie('device_pixel_ratio', window.devicePixelRatio, {
                expires: 1,
                path: '/'
            });
            //    $.cookie('device_pixel_ratio',2,{ expires: 1,path:'/'});
        } else {
            $.cookie('device_pixel_ratio', -1, {
                expires: 1,
                path: '/'
            });
        }
//        window.location.reload();
    }

});

$(function() {
    $(".hover img,img.hover").hover(function() {
        $(this).fadeTo("fast", 0.75); // マウスオーバーで透明度を75%にする
    }, function() {
        $(this).fadeTo("fast", 1.0); // マウスアウトで透明度を100%に戻す
    });
});


$(function() {
    $('.ui-user > a').on('click', function() {
        var v = $(this).next("ul");
        v.toggleClass('over');

        if (v.hasClass('over')) {
            $("body").on('click', function() {
                v.removeClass('over');
            })
        };

    });
});

$(function() {
    var topBtn = $('#page2top');
    topBtn.hide();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
});


$(document).ready(function(){
  //URLのハッシュ値を取得
  var urlHash = location.hash;
  //ハッシュ値があればページ内スクロール
  if(urlHash) {
    //スクロールを0に戻す
    $('body,html').stop().scrollTop(0);
    setTimeout(function () {
      //ロード時の処理を待ち、時間差でスクロール実行
      scrollToAnker(urlHash) ;
    }, 100);
  }

  $('a').click(function() {
        if ($(this).attr("rel") == 'external'){
            return;
        } else if ($(this).attr("target") == '_blank'){
            return;
        } else if ($(this).attr('id') == 'login') {
            return;
        } else if ($(this).attr('id') == 'user_toggle') {
            return false;
        } else if ($(this).attr('class') == 'entry_step') {
            return;
        } else if ($(this).attr('data-toggle')) {
            return;
        } else if ($(this).parents("#slider-wrapper").size()) {
            return;
        }
    var href= $(this).attr("href");

    if (href=="javascript:void(0)"){
        return;
    }

    if (href.match(/^(#.+$)/)){
        var hash = href == "#" || href == "" ? 'html' : href;
        //スクロール実行
        scrollToAnker(hash);
        //リンク無効化
        return false;
    } else if (href.match(/(#.+$)/)){

    var ma = href.match(/(#.+$)/);
    var target = ma[0];

    var abs_href = convertAbsUrl(href);
    abs_href = removeHash(abs_href);
    var now_href = location.href;
    var now_href = removeHash(now_href);

    if (abs_href == now_href){
        scrollToAnker(target);
    //リンク無効化
        return false;
    } else {
        $.fancybox.showLoading();
        setTimeout(() => {
        $.fancybox.hideLoading();
        }, 1000);
        return;
    }

    } else {
        $.fancybox.showLoading();
        setTimeout(() => {
        $.fancybox.hideLoading();
        }, 1000);
        return;
    }
  });

  function scrollToAnker(hash) {
    var target = $(hash);
    var position = target.offset().top;
    var offset = -120;
    $('body,html').stop().animate({scrollTop:position + offset}, 400);
  }

    function convertAbsUrl(src){
    return $("<a>").attr("href", src).get(0).href;
    }

    function removeHash(src){
    url = src.replace(/#.+/,"");
    return url.replace(/\?.+/,"");
    }

});
