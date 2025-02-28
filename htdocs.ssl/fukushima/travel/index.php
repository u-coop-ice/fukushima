<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>


<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main" class="left">

<h2 id="title_travel">旅行</h2>

<div class="row">


<div class="col-sm-4">
<p><a href="https://click.linksynergy.com/fs-bin/click?id=ENtgKTiuTLM&offerid=625672.10001945&type=4&subid=0" target="_blank">
<IMG alt="楽天トラベル" border="0" src="https://img.travel.rakuten.co.jp/easylink/bnr/logo.jpg" class="img"></a>
<IMG border="0" width="1" height="1" src="https://ad.linksynergy.com/fs-bin/show?id=ENtgKTiuTLM&bids=625672.10001945&type=4&subid=0">
</p>
</div>


</div>



<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog('../../data/whatsnewdata.xml');
$whatsnew->setCoop('fukushima');
?>

<?php
$whatsnew->setKey('travel,misc_travel,!domestic,!overseas,!rentacar');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_misc" class="topicshead">お知らせ</h3>
<?php
echo $whatsnew->getList();
}
?>

<?php
$whatsnew->setKey('domestic');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_domestic" class="topicshead">国内旅行</h3>
<?php
echo $whatsnew->getList();
}
?>

<?php
$whatsnew->setKey('overseas');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_overseas" class="topicshead">海外旅行</h3>

<?php
echo $whatsnew->getList();
}
?>

<?php /*?>
<?php
$whatsnew->setKey('rentacar');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_rentacar" class="topicshead">レンタカー</h3>
<?php
echo $whatsnew->getList();
}
?>
<?php */?>





</div><!--main終了 -->




<!-- col_sub -->

<div id="sub">
<?php /*
<div class="sidecolumn navi">
<div id="menu-inner">

<h4 class="top">Recomended Links</h4>
<!-- banners：バナー -->
<div id="banners"><img src="/js/banners/loading.gif" alt="loading" style="display: block; margin: 0 auto 0 auto; padding: 80px 0; border: none; background: transparent;" /></div>
<!-- /banners -->

</div>
</div>


<a href="https://manabi.univcoop.or.jp/trip/" target="_blank" >
<?php
mobile_image('/banners/250/bnr_manabi_trip_250.jpg', '', 'img-responsive hover hidden-xs');
?>
</a>
*/ ?>
</div><!-- sub終了 -->





<div id="sub">



<div class="center">
<?php
 include $rootpath . "/c/travel/banner/include/travel_banner.php";
?>
</div>


</div><!-- sub終了 -->


<?php
include $rootpath . '/include/footer.txt';
?>
