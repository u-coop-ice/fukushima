<?php
require_once './adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link rel="stylesheet" href="/js/jquery/nivo-slider3/nivo-slider.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="/js/jquery/nivo-slider3/themes/default/default.css" type="text/css" media="screen,print" />
<script src="/js/jquery/nivo-slider3/jquery.nivo.slider.pack.js"></script>

<link type="text/css" href="<?php fp_ft('/css/base_home_new.css');?>" rel="stylesheet" media="screen,print" />

<script src="/js/jquery/jquery.matchHeight/jquery.matchHeight.min.js"></script>
<script>
$(function() {
	$('.btn-default').matchHeight();
});
</script>


<script>
//<![CDATA[
$(window).load(function() {
	$('#slider').nivoSlider({
	effect:'fade',
	slices:5,
	animSpeed:250, //画像が切り替わるスピード
	pauseTime:4000, //画像が切り替わるまでの時間
	startSlide:0, //最初に表示する画像
	directionNav:true, //矢印を表示する
	directionNavHide:true, //マウスを乗せたときに矢印を表示
	controlNav:true, //1,2,3...
	controlNavThumbs:false, //下にサムネイルを使う場合
	controlNavThumbsSearch: '.jpg',
	controlNavThumbsReplace: '_thumb.jpg',
	keyboardNav:true, //Use left & right arrows
	pauseOnHover:true, //オンマウスで画像が止まる
	manualAdvance:false, //Force manual transitions
	captionOpacity:0.75, //Universal caption opacity
	beforeChange: function(){},
	afterChange: function(){},
	slideshowEnd: function(){}
	});
});
//]]>

</script>

<?php
include $rootpath . 'include/header2.txt';
?>


<div id="mainheader">

<div id="mainbb">
<!-- billboard -->
<?php
include $rootpath . '../../php/billboard.php';
?>
<!-- /billboard -->


</div><!-- /mainbb -->


<?php /*?><div id="topics">
<h3 class="top">Topics</h3>
<div class="list-group ic_list">

<a class="list-group-item ic_hour" href="/store/time/"><h5 class="list-group-item-heading">営業時間</h5></a>

<a class="list-group-item ic_newlife" href="https://newlife.u-coop.or.jp/fukushima/" target="_blank"><h5 class="list-group-item-heading">福島大学生協 受験生･新入生サポート（受験生・新入生はこちら）
<i class="fa fa-fw fa-external-link"></i></h5></a>

</div><!-- /list-group -->

<div class="top_button">
<a class="svg__container back_blue" href="/home/ucapp/" >
<img src="./images/bnr_ucapp.svg" alt="大学生協アプリ" class="img-responsive center">
</a>
</div>

<!-- スマホで表示 -->
<div class="visible-xs-block">
<?php
include $rootpath . 'include/bousai_button.php';
?>
</div>

<!-- モーダルリンク元 -->
<div class="contact_box">
<p class="contact01" >
<a data-target="#ask01" data-toggle="modal" style="cursor:pointer;">
お問い合わせはこちら
</a>
</p>
</div>

<!-- モーダル・ダイアログ -->
<div class="modal fade" id="ask01" tabindex="-1">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<p class="right"><button type="button" class="close" data-dismiss="modal">
<span aria-hidden="true" class="em15">&times;</span>
</button></p>
</div>
<div class="modal-body">
<div id="fukushima" class="none" style="display: block;">
<h4 class="top">お問い合わせ</h4>

<p>
<a href="https://lin.ee/kXxJOrF" class="btn btn-success btn-block btn-lg" target="_blank">
福島大学生協　公式LINE
</a>
</p>

<p><strong class=""><i class="fa fa-user" aria-hidden="true"></i> 個人情報について</strong><br />
福島大学生協では、個人情報に関して適用される法令、規範を遵守するとともに、組合員及びその関係者に関する情報の適正な管理・利用と保護に努めております。[<a href="/home/privacypolicy/" target="_blank">詳細</a>]</p>

<br>
</div>
</div>
</div>
</div>
</div>

</div><?php */?>

</div><!-- /mainheader -->


<div class="clear"></div>

<?php
if (time() < strtotime("2025-01-12 17:00:00")) {
	?>

<div class="alert alert-info">
<h4>【復旧済】12/30 11:40ごろ〜 1/1 18:30ごろまで、当サイトからメールが送信されておりません</h4><p>
現在は復旧しております。その間、当サイトにて各種お申込みを行われた方は、お申込み完了後に送信されるメールが送信されておりません。ただし、お申込みの情報は正常に生協に届いております。お申込みの内容などご確認が必要な場合は、お手数ですが、お問い合わせフォームよりご連絡ください。</p>
</div>

<?php
}
?>


<div id="whatsnew_column">


<div class="row">

<?php
if (time() < strtotime("2022-02-06 00:00:00")) {
	?>
<div class="col-sm-12">
<div class="notice">
<a class="btn btn-danger btn-block btn-square" href="/home/news/220128_time/"><i class="fa fa-fw fa-exclamation-triangle"></i>遠隔授業に伴い営業時間変更のお知らせ</a>
</div>
</div>
<?php
}
?>





<?php
if (time() < strtotime("2021-07-28 00:00:00")) {
	?>
<div class="col-sm-12">
<div class="alert alert-danger"><span class="bold">【台風接近に伴い店舗営業時間の変更について】</span><br>
7月27日(火)台風接近よりJR東北本線の計画運休が決まりました。<br>
それに合わせて大学生協の各店舗の営業時間を14:00までとさせていただきます。ご不便ご迷惑をおかけいたしますが、何卒ご理解いただきますようよろしくお願い申し上げます。命を守る行動を心掛けてください。<br>
<a class="btn btn-primary btn-sm em09" href="/store/time/">営業時間<i class="fa fa-fw fa-chevron-right"></i></a></div>

</div>
<?php
}
?>

<?php /*
<div class="col-sm-12">
<div class="notice">
<a class="btn btn-default btn-block btn-square" href="/home/news/2020covid19/"><i class="fa fa-fw fa-exclamation-triangle"></i>講義開始に向けた福島大学生協の対応<br class="visible-xs-block" />（福島大学生協の新型コロナウイルス感染症対応）</a>
</div>
</div>
 */?>

<?php /*
<div class="col-sm-12">
<div class="notice">
<div class="center">
<a class="btn btn-warning btn-block  btn-square" href="https://www.fukushima.u-coop.or.jp/frm/textorder/"><strong>【教職員の皆様へ】<br class="visible-xs-block">教科書・参考書承りWebフォーム</strong></a>
</div>
</div>
 */?>

</div><!-- /row -->

<?php
/*
<div class="notice">
<a class="btn btn-block btn-lightgreen btn-square" href="/store/time/">Quick Lunch グリーンの営業を再開しました!<br class="visible-xs-block">アツアツのお弁当を用意してお待ちしております!<br class="visible-xs-block"><span class="label label-outline label-lightgreen">営業時間はこちら</span></a>
</div>
 */
?>

<?php
/*
<div class="notice">
<div class="btn-block btn-lightgreen btn-square">
<div class="flex">
<a href="/career/public_startin/" class="btn btn-block label-lightgreen  btn-square">公務員採用試験対策準備【スタートイン講座】<br class="visible-xs-block">お申込み受付中！</a>
</div>
</div>
</div>
 */
?>

<?php
/*
<div class="notice">
<div class="btn-block btn-lightgreen btn-square">2021年度 福島大学入学をお考えの方へ<br>
<div class="flex">
<a href="/home/news/online_consultation/" class="btn btn-block label-lightgreen  btn-square">オンライン<br class="visible-xxs-block">相談会はこちら</a>
<a href="/home/news/youtube/" class="btn btn-block label-lightgreen btn-square">YouTube<br class="visible-xxs-block">はじめました！</a>
</div>
</div>
</div>
 */
?>

<?php
/*
<div class="notice">
<div class="btn-block btn-lightgreen btn-square">新入生・保護者のみなさまへ<br />
<div class="flex">
<a href="/home/news/210401.php" class="btn btn-block label-lightgreen  btn-square">組合員証（コプリカ）<br />お渡しのご案内</a>
<a href="/home/news/210401starterkit.php" class="btn btn-block label-lightgreen  btn-square">パソコン購入なしでDECS・関数電卓・アルクTOEIC Testスターターキットをお申込みされた方へお引き渡しのご案内</a>
</div>
<div class="flex" style="margin:4px;">
<a href="https://www.fukushima.u-coop.or.jp/app/entry/?cd=xYFLn6Lr" target="_blank" class="btn btn-block label-success btn-square"><span class="lead bold white">新入生の保護者様向け『就活』説明会のご案内 <i class="fa fa-fw fa-chevron-right"></i></span></a>
</div>
</div>
</div>
 */
?>


<div class="row">
<div id="whatsnew1_column" class="col-sm-6">

<h2 id="whatsnew">What&#146;s new</h2>

<?php

$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog(
	array('../data/whatsnewdata.xml'));

$whatsnew->setCoop('fukushima');
$whatsnew->setKey('ALL,!private');
$whatsnew->setBefore(30);
//$whatsnew->setNum(16);
echo $whatsnew->getList();
?>


<div class="viewall"><a class="btn btn-primary btn-sm" href="/home/whatsnew/">全てを見る<i class="fa fa-fw fa-chevron-right"></i></a></div>
</div><!-- /whatsnew1_column -->



<div id="whatsnew2_column" class="col-sm-6">

<h2 id="pickup">Pickup</h2>


<p><a href="https://newlife.u-coop.or.jp/fukushima/"  target="_blank">
				<img src="./images/bnr_newlife_fukushima.jpg" alt="受験生新入生サポート" class="hover img-responsive center">
		</a>
</p>
<div class="list-group ic_list">





<?php
/*
<a class="list-group-item ic_twitter" href="https://twitter.com/fukudaicoop" target="_blank"><h5>福島大学生協twitter <i class="fa fa-external-link"></i></h5></a>
<a class="list-group-item ic_event" href="http://fukudai01.blog.fc2.com/" target="_blank"><h5>福島大学生協学生委員会 <i class="fa fa-external-link"></i></h5></a>
 */
?>

<?php /*?><a onclick="ga('send', 'event', 'banner', 'click', '運転免許についてのお得な情報はこちら - <?php echo $_SERVER['PHP_SELF']; ?>');" class="list-group-item ic_career" href="/menkyo/fukushima/" target="_blank"><h5 class="list-group-item-heading">運転免許についてのお得な情報はこちら<i class="fa fa-fw fa-chevron-right"></i></h5></a><?php */?>

<?php /*?><a class="list-group-item ic_info" href="https://univcoop-job.net/jobfind-pc/area/HokkaidoTohoku/All" target="_blank"><h5 class="list-group-item-heading">大学生協　アルバイト・パート求人サイト<i class="fa fa-external-link"></i></h5></a><?php */?>

<?php /*?><a class="list-group-item ic_important" href="https://www.tohoku.u-coop.com/fukushima_university" target="_blank">
<h5 class="list-group-item-heading">住まい・アパート物件検索 <i class="fa fa-external-link"></i></h5></a><?php */?>


<?php /*?><a class="list-group-item ic_document" href="https://www.fukushima.u-coop.or.jp/app/entry/?cd=cz1Tbi3I" target="_blank">
<h5 class="list-group-item-heading">住所・電話番号・氏名変更はこちらから<i class="fa fa-fw fa-chevron-right"></i></h5></a><?php */?>

</div><!-- /list-group -->


<div class="contact_box">
<p class="pink_btn02" >
<a href="https://www.tohoku.u-coop.com/fukushima_university" target="_blank">
住まい・アパート物件検索 <i class="fa fa-external-link"></i>
</a>
</p>
</div>


<div class="contact_box">
<p class="blue_btn02" >
<a href="/GI/">
生協学生委員会
</a>
</p>
</div>






<?php /*?><dl id="bnr">
<?php
$banners = new setBanners();
$banners->setCoop(DOMAIN);
echo $banners->getBannerList();
?>
</dl><?php */?>



<dl>
<dt><a class="btn btn-insta btn-block" onclick="ga('send', 'event', 'text', 'click', '福島大学生協instagram - <?php echo $_SERVER['PHP_SELF']; ?>');" href="https://www.instagram.com/fukudaicoop/" target="_blank"><i class="fa fa-instagram"></i> 福島大学生協【公式】instagram </a></dt>

<?php /*?><dt><a class="btn btn-info btn-block" onclick="ga('send', 'event', 'text', 'click', '福島大学生活協同組合公式Facebookページ - <?php echo $_SERVER['PHP_SELF']; ?>');" href="https://www.facebook.com/fukushima.univcoop/" target="_blank"><i class="fa fa-facebook-square"></i> 福島大学生活協同組合公式Facebookページ</a></dt><?php */?>

<dt class="X">
<a class="btn btn-primary btn-block" onclick="ga('send', 'event', 'text', 'click', '福島大学生協twitter - <?php echo $_SERVER['PHP_SELF']; ?>');" href="https://twitter.com/fukudaicoop" target="_blank">
<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
<style>
dt.X svg{fill:#ffffff;}dt.X a {
line-height: 1.5;}dt.X svg{margin-top: 5px;position: relative;top: 2px;}dt.X .btn-primary {background-color: #333;}#whatsnew2_column .btn {margin-top: 5px;}
</style>
<path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
</svg>
福島大学生協 (旧Twitter)</a></dt>
</dl>






</div><!-- /whatsnew2_column -->

</div><!-- row -->






</div><!-- /whatsnew_column -->


</div><!-- /pagebody -->



<br>

<div class="footer_top">

<div id="banners" class="container">


<dl id="bnr">
<?php
$banners = new setBanners();
$banners->setCoop(DOMAIN);
echo $banners->getBannerList();
?>
</dl>


</div>








<?php
include $rootpath . '/include/footer.txt';
?>
