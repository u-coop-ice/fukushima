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

<div class="col-sm-5">
<p><a href="https://click.linksynergy.com/fs-bin/click?id=ENtgKTiuTLM&offerid=625672.10001945&type=4&subid=0" target="_blank">
<IMG alt="楽天トラベル" border="0" src="https://img.travel.rakuten.co.jp/easylink/bnr/logo.jpg" class="img hover"></a>
<IMG border="0" width="1" height="1" src="https://ad.linksynergy.com/fs-bin/show?id=ENtgKTiuTLM&bids=625672.10001945&type=4&subid=0">
</p>
</div>

<div class="col-sm-5">
<p><a href="https://manabi.univcoop.or.jp/trip/webtyoku-kaigai.php" target="_blank">
<?php
mobile_image( "./images/bnr_uctrip.jpg", "海外旅行web直", 'img-responsive gallery hover' );
?>
</a></p>
</div>
</div>

<div class="pad_l">
<p>海外旅行の手配は楽天トラベルもしくは「海外旅行Web直」からお申込みをお願いします。<br />
<a class="btn btn-info" href="https://manabi.univcoop.or.jp/trip/webtyoku-kaigai.php" target="_blank">web直のお申込みはこちらから</a></p>

<p>国内旅行に関しては、福島大学生協にてお申込みいただくことが可能です。サークル・ゼミ合宿の宿などについては購買カウンターまでご相談ください。</p>

<p class="rev_ind">※「大学生協の旅行Webサイト」内の「異文化体験・現地体験ツアー」・「海外旅行」欄の「旅行業登録生協店舗のみ」と記載された項目や海外旅行・ツアーについては、福島大学生協ではお取り扱いすることができません。ご了承ください。</p>
</div>





<h3>アソビュー × 大学生協</h3>

<div class="pad_l">
<p>観光施設チケットや体験アクティビティを提供する『アソビュー！』が『Web直』に登場！<br />
初回のご利用は、10&#37;OFFクーポンがついてきます。</p>

<p><a href="https://manabi.univcoop.or.jp/trip/asoview-coupon.php" target="_blank">
<?php
mobile_image( "./images/bnr_asoview.jpg", "アソビュー", 'img-responsive gallery hover' );
?>
</a></p>

<p>大学生協組合員限定の特典です！</p>
<p>定番施設からダイビングやラフティング、BBQなど大学生活の思い出づくりに最適な遊びスポットをご紹介。
ゼミやサークルの幹事さん必見です！</p>
</div>




<h3>レンタカー</h3>

<div class="pad_l">
<p>お得な生協料金でレンタカーをご利用いただけます。レンタカーのお問い合わせは購買カウンターまでお越しください。<br />
校費などでの利用も可能です。お気軽にご相談ください。</p>

<div class="row">
<div class="col-sm-7 col-xs-9">
<p><a href="https://manabi.univcoop.or.jp/rentacar/" target="_blank">
<?php
mobile_image( "./images/bnr_rentacar.jpg", "レンタカー", 'img-responsive gallery hover' );
?>
</a></p>
</div></div>

</div>

<br />






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
