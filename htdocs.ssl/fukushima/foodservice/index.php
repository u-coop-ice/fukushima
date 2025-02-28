<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>

<link type="text/css" href="./css/foodservice.css" rel="stylesheet" media="screen,print" />


<?php
include $rootpath . 'include/header2.txt';
?>





<h2 id="title_foodservice">食</h2>


<h3>ミールパス</h3>

<p><a href="https://newlife.u-coop.or.jp/fukushima/meal/" class="btn btn-info"  target="_blank">新入生向けミールパスはこちら <i class="fa fa-fw fa-external-link"></i></a></p>

<p><a href="./meal/" class="btn btn-info" >在学生向けミールパスはこちら <i class="fa fa-fw fa-chevron-right"></i></a></p>

<br>



<h3>店舗</h3>

<div class="row">
<div class="col-sm-6">

<div class="wow animated fadeInUp">
<h4 class="mplus1p em20"><a href="/foodservice/reaf/">Dining ReaF</a></h4>
<p>カフェテリア形式の大きな食堂です。</p>
<a href="/foodservice/reaf/">
<?php
mobile_image('./images/foodservice_01.jpg', '', 'img-responsive hover');
?>
</a>
</div>
</div>

<br class="visible-xs-block">

<div class="col-sm-6">
<div class="wow animated fadeInUp">
<h4 class="mplus1p em20"><a href="/foodservice/green/">Quick lunch グリーン</a></h4>
<p>テイクアウトのできるお弁当屋さんです。</p>
<a href="/foodservice/green/">
<?php
mobile_image('./images/foodservice_02.jpg', '', 'img-responsive hover');
?>
</a>
</div>
</div>
</div>



<br><br>




<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog('../../data/whatsnewdata.xml');
$whatsnew->setCoop('fukushima');
?>

<?php
$whatsnew->setKey('foodservice,!menu,!meal,!event,!eat,!fs');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_info" class="topicshead">お知らせ・月／週替わりメニュー</h3>
<?php
echo $whatsnew->getList();
}
?>

<?php
$whatsnew->setKey('menu');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_foodev" class="topicshead">食堂フェアのご案内</h3>
<?php
echo $whatsnew->getList();
}
?>

<?php
$whatsnew->setKey('event');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_foodparty" class="topicshead">イベント用メニュー</h3>
<?php
echo $whatsnew->getList();
}
?>



<?php
$whatsnew->setKey('meal');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_meal" class="topicshead">ミールパス</h3>
<?php
echo $whatsnew->getList();
}
?>

<?php
$whatsnew->setKey('eat');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_teian" class="topicshead">食生活提案</h3>
<?php
echo $whatsnew->getList();
}
?>

<?php
$whatsnew->setKey('fs');
if ($whatsnew->getList()) {
	?>
<h3 id="anc_fs" class="topicshead">食の安全に関するお知らせ</h3>

<?php
echo $whatsnew->getList();
}
?>

<div class="list-group ic_list">
<a class="list-group-item ic_foodservice" data-toggle="modal" data-target="#gakushoku" style="cursor: pointer;"><h5 class="list-group-item-heading">食堂で提供しているメニューが一目でわかる【学食どっとコープ】</h5><span class="list-group-item-date">[2012/02/21]</span></a>
</div>













<div class="clear"></div>



<?php
include $rootpath . "/include/modal_gakushoku.php";
include $rootpath . '/include/footer.txt';
?>
