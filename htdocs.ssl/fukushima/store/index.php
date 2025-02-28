<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>


<link type="text/css" href="/css/base_home_new.css?210804" rel="stylesheet" media="screen,print" />
<link type="text/css" href="/css/animate.css" rel="stylesheet" media="screen,print" />
<link type="text/css" href="./css/store.css?231023" rel="stylesheet" media="screen,print" />


<?php
include $rootpath . 'include/header2.txt';
?>

<h2 id="title_store">店舗</h2>

<div id="main2">


<div class="row">
		<div class="col-xs-6 wow animated fadeInUp">
		<div class="s_name">
		<a href="/insurance/">
				<?php
				mobile_image( "./images/store_01.jpg", "生協本部", 'img-responsive gallery hover' );
				?>
  <p>生協本部<i class="fa fa-fw fa-chevron-right"></i></p>	
		</a></div>
		</div>


		<div class="col-xs-6 wow animated fadeInUp">
		<div class="s_name">
		<a href="/store/react/">
				<?php
				mobile_image( "./images/store_02.jpg", "購買店(Re;act)", 'img-responsive gallery hover' );
				?>
  <p>購買店(Re;act)<i class="fa fa-fw fa-chevron-right"></i></p>	
		</a></div>
		</div>

		<div class="col-xs-6 wow animated fadeInUp">
		<div class="s_name">
		<a href="/foodservice/reaf/">
				<?php
				mobile_image( "./images/store_03.jpg", "食堂店(Dining ReaF)", 'img-responsive gallery hover' );
				?>
		<p><span class="hidden-xs">食堂店(</span>Dining ReaF<span class="hidden-xs">)</span><i class="fa fa-fw fa-chevron-right"></i></p>	
		</a></div>
		</div>

		<div class="col-xs-6 wow animated fadeInUp">
		<div class="s_name">
		<a href="/foodservice/green/">
				<?php
				mobile_image( "./images/store_04.jpg", "食堂店(Quick Lunch グリーン)", 'img-responsive gallery hover' );
				?>
		<p><span class="hidden-xs">食堂店(</span>Quick Lunch  グリーン<span class="hidden-xs">)</span><i class="fa fa-fw fa-chevron-right"></i></p>	
		</a></div>
</div>

</div>






<h3 class="ver">Information</h3>

<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog(
	array('../../data/whatsnewdata.xml'));
$whatsnew->setCoop('fukushima');
$whatsnew->setKey('store');
$whatsnew->setBefore(360);
if ($whatsnew->getList()) {
	echo $whatsnew->getList();
}
?>

<div class="list-group ic_list">
<a class="list-group-item ic_hour" href="/store/time/">
<h5 class="list-group-item-heading">【営業時間】本部、購買店、食堂店</h5>
</a>
</div>


<h3 id="store_ask">お問い合わせ先一覧</h3>
<p class="pad_l">〒960-1296 福島市金谷川1番地</p>
<div class="row">

<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-body">
<h5 class="top">本部（総務/経理/共済）</h5>
<p>TEL: 024-548-5141<br />FAX: 024-548-3477</p>
</div>
</div>
</div>


<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-body">
<h5 class="top">本部（不動産）</h5>
<p>TEL: 024-548-8660<br />FAX: 024-548-3477</p>
</div>
</div>
</div>


<?php /*?><div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-body">
<h5 class="top">図書館店（書籍/講座関連）</h5>
<p>TEL: 024-572-7707<br />FAX: 024-572-7737</p>
</div>
</div>
</div><?php */?>

<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-body">
<h5 class="top">食堂店</h5>
<p>TEL: 024-548-5142<br />FAX: 024-548-7300</p>
</div>
</div>
</div>

<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-body">
<h5 class="top">購買店（購買/旅行/サービス/講座関連）</h5>
<p>TEL: 024-548-0091<br />FAX: 024-548-7200</p>
</div>
</div>
</div>






</div>


<?php /*?><p><a href="/app/ask/" class="btn btn-primary">WEBフォームからのお問い合わせ<i class="fa fa-fw fa-chevron-right"></i></a></p><?php */?>



<!-- モーダルリンク元 -->
<div class="row">
<div class="col-sm-6">
<div class="contact_box">
<p class="contact01" >
<a data-target="#ask01" data-toggle="modal" style="cursor:pointer;">
WEBフォームからのお問い合わせ
</a>
</p>
</div>
</div>
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

<?php /*
<p>
<a href="https://newlife.u-coop.or.jp/fukushima/app/ask/" class="btn btn-info2 btn-block btn-lg">
受験生・新入生の方はこちら
</a>
</p>
<p>
<a href="https://www.fukushima.u-coop.or.jp/app/ask/" class="btn btn-primary2 btn-block btn-lg">
在校生･教職員その他の方はこちら
</a></p>
*/ ?>

<br>
</div>
</div>
</div>
</div>
</div>

<h3 id="store_access">アクセスマップ</h3>


<iframe src="https://www.google.com/maps/d/embed?mid=1P0oikeIOeveuhghpPiGSukDHz1H8nvo&ehbc=2E312F&z=18" width="100%" height="480"></iframe>




<div class="clear"></div>


</div><!-- end of main -->

<?php
include $rootpath . '/include/footer.txt';
?>
