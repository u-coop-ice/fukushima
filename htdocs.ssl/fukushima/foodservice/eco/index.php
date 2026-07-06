<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>

<link rel="stylesheet" href="./css/eco.css" type="text/css" media="screen,print" />
<link type="text/css" href="/css/animate.css" rel="stylesheet" media="screen,print" />


<script type="text/javascript" src="/js/wow.min.js"></script>
<script>
new WOW().init();
</script>


<?php
include $rootpath . 'include/header2.txt';
?>

<h2>環境への取り組み</h2>

<p class="ind">福島大学生協では国産材・間伐材を再利用した「樹恩割り箸」を使用しています(一部を除く)。</p>
<p class="ind">「樹恩割り箸」について詳しくは <a href="https://juon.or.jp/activity/activity_53.html" target="_blank">こちらから（JUON NETWORK）<i class="fa fa-fw fa-chevron-right"></i></a></p>

<div class="center">
<?php
mobile_image('./images/juon_001.jpg', '樹恩割り箸', 'img-responsive');
?>
</div>



<div class="clear"></div>


<?php
include $rootpath . '/include/footer.txt';
?>








