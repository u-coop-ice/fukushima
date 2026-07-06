<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>

<link rel="stylesheet" href="./css/green.css" type="text/css" media="screen,print" />
<link type="text/css" href="/css/animate.css" rel="stylesheet" media="screen,print" />


<script type="text/javascript" src="/js/wow.min.js"></script>
<script>
new WOW().init();
</script>


<?php
include $rootpath . 'include/header2.txt';
?>

<h2>Quick Lunch グリーン</h2>

<h4 class="ttlgreen">テイクアウト、またはイートイン、お好きなスタイルでどうぞ！</h4>
<div class="point">

<div class="row">
<div class="col-sm-6 wow animated fadeInUp">
<p class="arrow_box"><span class="highlighter">テイクアウトで手軽にランチ！</span></p>

<?php
mobile_image('./images/photo_001.jpg', '', 'img img-responsive');
?>
<br />
<img src="./images/icon_takeout.png" class="center icongreen" width="150" height="106" alt="イートインアイコン">

<p>お好みのものをお求めになり、お持ち帰りいただけます。<br />
お気に入りの場所でお召し上がりください。</p>
</div><!-- /col-sm-6 -->


<div class="col-sm-6 wow animated fadeInUp">
<p class="arrow_box"><span class="highlighter">今すぐ食べたいならイートイン!</span></p>
<?php
mobile_image('./images/photo_002.jpg', '', 'img img-responsive');
?>
<br />
<img src="./images/icon_eatin.png" class="center icongreen" width="150" height="106" alt="持ち帰りアイコン">

<p>店内には、座って食べることができるコーナーもご用意。<br />
お急ぎですぐに食べたい方におすすめです。</p>
</div><!-- /col-sm-6 -->
</div><!-- /row -->

</div><!-- /point -->


<h3>Quick Lunch グリーン店内の様子</h3>

<?php /*
<div class="embed-responsive embed-responsive-16by9 center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/g_wE7njkYNQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<br />
*/ ?>



<div class="row">
<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_003.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_004.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_005.jpg', '', 'img img-responsive');
?>
</div>

</div><!-- /row -->


<br />


<div class="row">

<div class="col-xs-4 wow animated fadeInUp"><?php
mobile_image('./images/photo_006.jpg?23', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_007.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_008.jpg', '', 'img img-responsive');
?>
</div>

</div><!-- /row -->


<br />


<div class="row">

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_009.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_010.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_011.jpg', '', 'img img-responsive');
?>
</div>

</div><!-- /row -->


<br />


<div class="row">

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_012.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_013.jpg', '', 'img img-responsive');
?>
</div>

<div class="col-xs-4 wow animated fadeInUp">
<?php
mobile_image('./images/photo_014.jpg', '', 'img img-responsive');
?>
</div>

</div><!-- /row -->


<h4 class="ttlgreen">美味しいお弁当を準備してみなさまのご来店をお待ちしております！</h4>

<br />




<?php /*
<hr class="hrs_green">

<div class="row wow animated fadeInUp">

<h4 class="ttlgreen">美味しいお弁当を準備してみなさまのご来店をお待ちしております！</h4>



<ul id="pic_list">
<li><img src="./images/partition.jpg" class="center" width="190" height="140"></li>
<li><img src="./images/entrance.jpg" class="center" width="190" height="140"></li>
<li><img src="./images/instore_02.jpg" class="center" width="190" height="140"></li>
<li><img src="./images/instore_03.jpg" class="center" width="190" height="140"></li>
<li><img src="./images/counter_02.jpg" class="center" width="190" height="140"></li>
<li><img src="./images/instore_01.jpg" class="center" width="190" height="140"></li>
</ul>
</div>
*/ ?>

<div class="box">
<p class="ttlgreen">Quick Lunch グリーン(クイックランチグリーン)</p>
<p>福島大学生活協同組合</p>
<p class="em12"><span class="ttl">TEL</span>024-548-5142</p>
<p>〒960-8151 福島市金谷川1番地 大学会館2F</p>

<p><span class="ttl">平日</span>11:00〜14:00&ensp;<span class="ttl">土日祝</span>休業</p>
<p>※長期休暇中は休業です。詳細は&ensp;<a class="btn btn-primary btn-sm" href="/store/time/">営業時間をご確認ください<i class="fa fa-fw fa-chevron-right"></i></a></p>
</div>


<div class="clear"></div>


<?php
include $rootpath . '/include/footer.txt';
?>








