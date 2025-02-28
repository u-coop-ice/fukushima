<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . 'include/header2.txt';
?>

<h2>大学生のうちに自動車免許を取得しよう！</h2>

<?php
if (time() < strtotime("2024-11-29 17:00:00")){
?>
<div class="alert alert-warning center" role="alert">
<strong class="em18">★【通学制】★<br class="visible-xs-block">「秋のキャンペーン」<br class="visible-xs-block">開催中！</strong>
<p class="">購買店Re;actカウンターへお越しください<br />
申込締切：2024年11月29日(金)17時</p>
</div>
<?php
}
?>




<div class="row">
<div class="col-sm-6">
<p>
<a class="btn btn-success btn-block" href="/menkyo/fukushima/school.php"><strong class="lead">福島大学生協の<br class="visible-xs-block">提携校はコチラ【福島県】 <i class="fa fa-fw fa-chevron-right"></i></strong></a>
</p>
</div>
</div>




<div class="row">
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_matsuki.jpg" alt="マツキドライビングスクール" title="マツキドライビングスクール"></p>
</div>
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_motomiya.jpg" alt="本宮自動車学校" title="本宮自動車学校"></p>
</div>
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_sugitsuma.jpg" alt="杉妻自動車学校" title="杉妻自動車学校"></p>
</div>
</div><!-- /row -->

<div class="row">
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_hokubu.jpg" alt="北部自動車学校" title="北部自動車学校"></p>
</div>
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/comment.png" alt="生協組合員だけの特別価格でお申込みいただけます！" title="生協組合員だけの特別価格でお申込みいただけます！"></p>
</div>
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_yasuhara.jpg" alt="保原自動車学校" title="保原自動車学校"></p>
</div>
</div><!-- /row -->

<div class="row">
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_toua.jpg" alt="東亜自動車学校" title="東亜自動車学校"></p>
</div>
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_fukuyama.jpg" alt="冨久山自動車学校" title="冨久山自動車学校"></p>
</div>
<div class="col-xs-4">
<p class="center"><img class="img-responsive" src="./images/f_fukushima.jpg" alt="福島自動車学校" title="福島自動車学校"></p>
</div>
</div><!-- /row -->


<?php
if (time() < strtotime("2021-12-01 00:00:00")){
?>
<div class="center">
<a href="./school.php">
<img class="img-responsive" src="/js/billboard/bbdimg592/bbd592_fukushima_career_car_21aut.png" alt="秋キャンペーン開催中！" title="秋キャンペーン開催中！"></a>
</div>
<?php
}
?>




<h3><a href="https://newlife.u-coop.or.jp/fukushima/standby/carlicense/" target="_blank"><strong>新入生ふくふくプラン <i class="fa fa-external-link"></i></strong></a></h3>
<p class="">福島大学に入学する新入生のためのプランです。<br />
提携8校よりお申込みいただくとユニコチャージの特典がもらえるお得なプランです。</p>

<h4 class="green">～ふくふくプランの流れ～</h4>
<div class="row center">
<div class="col-sm-4">
<div class="panel panel-success">
	<div class="panel-heading">
		<strong class="em12">STEP1<br class="hidden-xs">（11～4月入学式前日）</strong>
	</div>
	<div class="panel-body">
		<strong>新入生サポートセンター</strong>で<br class="hidden-xs"><span class="marker yellow thin">エントリー</span>
	</div>
</div>
</div>
<div class="col-sm-4">
<div class="panel panel-success">
	<div class="panel-heading">
		<strong class="em12">STEP2<br class="hidden-xs">（7月末まで）</strong>
	</div>
	<div class="panel-body">
		<strong>購買店</strong>で<br class="hidden-xs"><span class="marker yellow thin">入校する自動車学校を決めてお支払い</span>
	</div>
</div>
</div>
<div class="col-sm-4">
<div class="panel panel-success">
	<div class="panel-heading">
		<strong class="em12">STEP3<br class="hidden-xs">（8月末まで）</strong>
	</div>
	<div class="panel-body">
		<strong>入校する自動車学校</strong>で<br class="hidden-xs"><span class="marker yellow thin">入校手続き</span>
	</div>
</div>
</div>

</div><!-- /row -->

<br />




<div class="row">
<div class="col-sm-6">
<p>
<a class="btn btn-info btn-block" href="https://career.u-coop.or.jp/menkyo/" target="_blank"><strong class="lead">福島県外の<br class="visible-xs-block">自動車学校はコチラ <i class="fa fa-external-link"></i></strong></a>
</p>
</div>
</div>

<br />





<h4>［自動車学校混雑状況はこちら］</h4>
<div>
<img class="img-responsive" src="./images/konzatsu.png" alt="自動車学校混雑状況" title="自動車学校混雑状況" >
</div>


<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog('../../../data/whatsnewdata.xml');
$whatsnew->setCoop('fukushima');
?>


<?php
$whatsnew->setKey('menkyo');
if ($whatsnew->getList()) {
	?>
<h3>Information</h3>
<?php
echo $whatsnew->getList();
}
?>



<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-reply"></i>トップへ戻る</a>
</p>


<?php
include $rootpath . '/include/footer.txt';
?>
