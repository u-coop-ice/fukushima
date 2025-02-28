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

<h2 id="title_graduate">卒業</h2>

<h3>学類ご卒業予定の皆さんへ</h3>

<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog('../../data/whatsnewdata.xml');
$whatsnew->setCoop('fukushima');
$whatsnew->setKey('graduate');
echo $whatsnew->getList();
?>



<div class="list-group ic_list">

<?php
/*
<a class="list-group-item ic_newlife" href="/graduate/album/">
<h5 class="list-group-item-heading">卒業アルバムのご案内</h5>
</a>
<a class="list-group-item ic_newlife" href="/graduate/album/photo.php">
<h5 class="list-group-item-heading">卒業アルバム 個人撮影について</h5>
</a>
<a class="list-group-item ic_newlife" href="/graduate/album/photo.php#group">
<h5 class="list-group-item-heading">卒業アルバム 集合写真の撮影について</h5>
</a>

<a class="list-group-item ic_newlife" href="/graduate/album/pdf/g_photo2018.pdf" target="_blank"><h5 class="list-group-item-heading">卒業記念写真ついて <i class="fa fa-file-pdf-o"></i></h5></a>

<a class="list-group-item ic_newlife" href="https://www.univcoop-housing.co.jp/room-grad-pre/index.html" target="_blank">
<h5 class="list-group-item-heading">新社会人向けのお部屋探し <i class="fa fa-external-link"></i></h5>
<img src="/banners/210/bnr_uch_room_grad_210.png" class="img" style="margin-left:1.8em;" >
<p>新社会人向けのお部屋探しも生協がお手伝いします。大学生協で提携している仲介会社を通じてお部屋探しができる新社会人向けのサイトです。ぜひご活用ください。</p></a>
*/ ?>



<a class="list-group-item ic_newlife" href="https://www.univ.coop/suit/" target="_blank"><h5 class="list-group-item-heading">リクルートスーツ <i class="fa fa-fw fa-external-link"></i></h5></a>

<?php
if (time() > strtotime("2021-05-06 00:00:00")) {
	?>
<a class="list-group-item ic_newlife" href="/graduate/album/photo.php" target="_blank"><h5 class="list-group-item-heading">卒業アルバム 個人撮影/集合写真撮影について</h5></a>
<?php
}
?>
</div>


<?php /*
<h3>引越し</h3>
<div class="list-group ic_list">
<a onclick="ga('send', 'event', 'link', 'click', '大学生協の引越しプラン');" class="list-group-item ic_store" href="https://career.u-coop.or.jp/move/" target="_blank"><h5 class="list-group-item-heading">大学生協の引越しプラン <i class="fa fa-external-link"></i></h5>
<p>面倒な引越しは、大学生協にすべておまかせ！</p>
</a>
</div>
 */?>

</div><!--content終了 -->



<?php /*
<!-- sub -->
<div id="sub">


<div class="sidecolumn navi">

<h4 class="top">Recomended Links</h4>

<div id="menu-inner">

<!-- banners：バナー -->
<div id="banners"><img src="/js/banners/loading.gif" alt="loading" style="display: block; margin: 0 auto 0 auto; padding: 80px 0; border: none; background: transparent;" /></div>
<!-- /banners -->

</div>
</div>



</div><!-- sub終了 -->
 */?>

<div class="clear"></div>


<?php
include $rootpath . '/include/footer.txt';
?>
