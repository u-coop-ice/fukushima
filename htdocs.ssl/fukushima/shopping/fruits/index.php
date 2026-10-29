<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>


<link type="text/css" href="./css/fruits.css" rel="stylesheet" media="screen,print" />

<?php
include $rootpath . 'include/header2.txt';
?>


<div id="main2" class="full">

<?php
if (time() < strtotime("2021-07-03 00:00:00")) {
?>
<div class="alert alert-danger">
あかつきの申込締切り迫る！お早めにご注文下さい！<br>
※「あかつき」申込み締切7/2まで
</div>
<?php
}
?>

<?php
if (time() < strtotime("2022-07-25 00:00:00")) {
?>
<div class="alert alert-danger">
川中島、黄金桃の申込締切り迫る！お早めにご注文下さい！<br>
※「川中島、黄金桃」好評につきお申込みを7/24まで延長します。
</div>
<?php
}
?>


<div class="center">
<img class="img-responsive" src="./images/2026_head_fruits_Apple.jpg" alt="福島のりんご" /><br />
<img class="img-responsive" src="./images/2026_fruits_apple.png" alt="福島のりんご 品名" /><br />
<img class="img-responsive" src="./images/2026_fruits_apple_list.png" alt="福島のりんご 品名" /><br />
<img class="img-responsive" src="./images/2026_fruits_apple_02.png" alt="福島のりんご 品名" /><br />
</div>




<?php /*
<div class="pad_l">
<ul>
<li>天候・収穫状況や商品番号により発送が前後する場合があります。収穫でき次第申込受付順に順次発送となりますので、<strong class="red">お届け日の指定はできません。</strong><br />
沖縄・離島への配送はお受けできません。</li>
<li>内容量が同一の場合、玉数が少ないほうが大玉になります。</li>
</ul>
<p>
産地：福島県（JAふくしま未来）　<br class="visible-xs">出荷元：JA農産物直売所　愛情館（JA全農福島　福島園芸センターPS）<br>
<br class="visible-xs">※写真はイメージです
</p>
</div>
*/ ?>



<?php
// 6/？ 10:00〜8/18 00:00まで販売
if (time() > strtotime('2026-10-20 00:00:00') && time() < strtotime('2026-11-16 00:00:00')) {
?>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<a href="https://www.fukushima.u-coop.or.jp/app/shopping/fruits/" target="_blank" class="btn btn-success btn-block btn-lg em15" >福島のりんごお申込みはこちら<i class="fa fa-fw fa-chevron-right"></i></a>
</div>
</div>	<!-- /row -->


<?php
// 8/18 00:00で販売終了
} else if (strtotime('2026-11-16 00:00:00') < time()) {
?>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<a target="_blank" class="btn btn-success btn-block btn-lg em15 disabled">【受付終了】<br class="visible-xs-block">福島のりんごお申込み<i class="fa fa-fw fa-chevron-right"></i></a>
</div>
</div>	<!-- /row -->


<?php
// 販売開始時間までは下記情報を掲載
} else {
?>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<a  <?php /*?>href="https://www.fukushima.u-coop.or.jp/app/shopping/fruits/" <?php */?>target="_blank" class="btn btn-success btn-block btn-lg em15 disabled">【まもなく販売開始予定】<br class="visible-xs-block">福島の桃お申込み<i class="fa fa-fw fa-chevron-right"></i></a>
</div>
</div>	<!-- /row -->


<?php
} 
?>




<br /><br />


<p><a class="btn btn-primary" href="./"><i class="fa fa-fw fa-reply"></i> ショッピングへ戻る</a></p>

</div><!-- /content -->

<div class="clear">*</div>



<?php
include $rootpath . '/include/footer.txt';
?>
