<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>


<link rel="stylesheet" href="./css/reaf.css" type="text/css" media="screen,print" />
<link type="text/css" href="/css/animate.css" rel="stylesheet" media="screen,print" />


<script type="text/javascript" src="/js/wow.min.js"></script>
<script>
new WOW().init();
</script>

<?php
include $rootpath . 'include/header2.txt';
?>

<h2>Dining ReaF（ダイニング リーフ ）</h2>
<div class="wow animated fadeInUp">
<?php
mobile_image( "./images/reaf_01.jpg", "dining reaf", 'img-responsive gallery' );
?>
</div>
<br>

<p class=""><span class="bold lead">1秒でも早く！</span>「いただきます」までを少しでも早く、<span class="bold lead">1℃でも熱く！</span>アツアツ＆よく冷えておいしいメニューがあり、<span class="bold lead">1皿でも多く！</span>選ぶ楽しみと栄養バランスのとれた食事ができ、<span class="bold lead">1人でも多く！</span>1人でも、仲間とでも、何度でも来たくなる。<span class="bold lead">1人でも笑顔に！</span>そんなおいしくて楽しく過ごせる食堂「楽食」そして、大学に行く楽しみが1つ増えるそんな食堂です。</p>

<h3>豊富なメニュー</h3>
<div class="row">
		<div class="col-xs-4 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_02.jpg", "", 'img-responsive gallery' );
				?>
		</div>
		<div class="col-xs-4 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_03.jpg", "", 'img-responsive gallery' );
				?>
		</div>
		<div class="col-xs-4 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_04.jpg", "", 'img-responsive gallery' );
				?>
		</div>
		<div class="col-xs-6 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_05.jpg", "", 'img-responsive gallery' );
				?>
		</div>
		<div class="col-xs-6 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_06.jpg", "", 'img-responsive gallery' );
				?>
		</div>
</div>
<p>温度にとことんこだわっています！出来立てのお弁当やお惣菜を常にアツアツの状態で提供できるようにしています。あったかいご飯は忙しい大学生活の中でも学生の心を“ほっと”落ち着かせてくれます。 </p>
<h3>広い飲食スペース</h3>
<div class="row">
		<div class="col-xs-4 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_07.jpg", "", 'img-responsive' );
				?>
		</div>
		<div class="col-xs-4 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_08.jpg", "", 'img-responsive' );
				?>
		</div>
		<div class="col-xs-4 wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_09.jpg", "", 'img-responsive gallery' );
				?>
		</div>
		<div class="col-sm-12">
				<p>福島大学の中でも一番大きい食堂です。<br>
						お昼はたくさんの福島大生が来店しおおきににぎわいます。もちろんテーブルの消毒等も徹底的に行っています。</p>
		</div>
</div>
<h3>エントランスには大きいメニューボード</h3>
<div class="row">
		<div class="col-sm-4 col-sm-offset-0 col-xs-6 col-xs-offset-3  wow animated fadeInUp">
				<?php
				mobile_image( "./images/reaf_10.jpg", "", 'img-responsive gallery' );
				?>
		</div>
		<div class="col-sm-8 col-xs-12">
				<p>食堂エントランスには大きなメニューボードが設置されています。今日何を食べようかここで決めてから食堂にご来店ください。</p>
		</div>
</div>


<br>
<div class="box">
		<p class="ttlgreen">Dining ReaF （ダイニング リーフ ）</p>
		<p>福島大学生活協同組合</p>
		<p class="em12"><span class="ttl">TEL</span>024-548-5142</p>
		<p>〒960-8151 福島市金谷川1番地　大学会館1F</p>
		<p><span class="ttl">平日</span>9:30〜19:00&ensp;<span class="ttl">土</span>11:00〜14:00&ensp;<span class="ttl">日祝</span>休業</p>
		<p>※長期休暇中は休業です。詳細は&ensp;<a class="btn btn-primary btn-sm" href="/store/time/">営業時間をご確認ください<i class="fa fa-fw fa-chevron-right"></i></a></p>
</div>
<div class="clear"></div>
<?php
include $rootpath . '/include/footer.txt';
?>
