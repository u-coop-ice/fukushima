<link rel="shortcut icon" href="/favicon.ico">

<!-- jquery.js -->
<script type="text/javascript" src="/js/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.easing.1.3.js"></script>

<link rel="stylesheet" href="/js/jquery/jquery.flexnav/jquery.flexnav.newlife.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.flexnav/jquery.flexnav.tabnav.js"></script>
<script type="text/javascript" src="/js/jquery/hoverIntent.js"></script>

<link type="text/css" href="/js/jquery/jquery.fancybox2/jquery.fancybox.css" rel="stylesheet" media="screen,print" />
<script type="text/javascript" src="/js/jquery/jquery.fancybox2/jquery.fancybox.pack.js"></script>


<link rel="stylesheet" href="/css/import.css?{$smarty.now}" />
<link rel="stylesheet" href="/app/css/import.css?{$smarty.now}" type="text/css" media="screen,print" />

<script type="text/javascript" src="/css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.cookie/jquery.cookie.js"></script>

<script type="text/javascript" src="/lib/common.js"></script>


{if !$login}
{literal}
<script type="text/javascript">
$(function(){
  var tempURL = "https://" + location.hostname;

if (location.port){
  tempURL += ':'+location.port;
}
  tempURL += location.pathname+location.search;


  tempURL = encodeURI(tempURL);
  $("#login").fancybox({
  'padding': 20,
  'maxWidth': 380,
  'maxHeight': 320,
  'autoSize': false,
  'autoHeight': false,
  'scrolling'   : 'no',
  'type'    : 'iframe',
  'href'  : "/app/user/signin.php?tempURL="+tempURL
  });
});
</script>
{/literal}
{/if}


<!--横スライドドロワーメニュー-->
<script type="text/javascript">
$(function(){
$('.menu-trigger').on('click',function(){
  if($(this).hasClass('active')){
    $(this).removeClass('active');
    $('nav').removeClass('open');
    $('.overlay').removeClass('open');
  } else {
    $(this).addClass('active');
    $('nav').addClass('open');
    $('.overlay').addClass('open');
  }
});
$('.overlay').on('click',function(){
  if($(this).hasClass('open')){
    $(this).removeClass('open');
    $('.menu-trigger').removeClass('active');
    $('nav').removeClass('open');      
  }
});
});
</script>
