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
<img class="img-responsive" src="./images/2026_head_fruits_momo.jpg" alt="福島のもも・なし" /><br />
<img class="img-responsive" src="./images/2026_mn_photo.jpg" alt="福島のもも・なし 品名" /><br />
</div>



<?php /*
<div class="row">
<div class="col-md-3 col-xs-6">
<div class="center"><img class="img-responsive" src="./images/2026_m_akatsuki.jpg"  alt="あかつき" /></div>
</div>
<div class="col-md-3 col-xs-6">
<div class="center"><img class="img-responsive" src="./images/2026_m_kawanakajima.jpg"  alt="川中島" /></div>
</div>
<div class="col-md-3 col-xs-6">
<div class="center"><img class="img-responsive" src="./images/2026_m_gold.jpg"  alt="黄金桃" /></div>
</div>
<div class="col-md-3 col-xs-6">
<div class="center"><img class="img-responsive" src="./images/2026_n_housui.jpg"  alt="豊水" /></div>
</div>
</div>
*/?>

<?php /*?>
<div class="row">
<div class="col-md-4">
<h3 class="pink bold"><span class="em08">皇室献上桃</span>&nbsp;あかつき</h3>
<p class="pad_l">白桃と白鳳を合わせてつくられ、福島で命名された福島の桃の代表品種です。<br class="hidden-xs">
きめの細かい肉質で甘みが強く、果汁が多いことが特徴で、人気があります。<br class="hidden-xs">
ご贈答の定番として、大変喜ばれています。</p>
<div class="center"><img class="img-responsive" src="./images/m_akatsuki.jpg" width="300" alt="イメージ：あかつき" /></div>
</div>

<div class="col-md-4">
<h3 class="blue bold"><span class="em08">桃の王様</span>&nbsp;川中島</h3>
<p class="pad_l">大粒で食べ応えのある白桃品種で、盆明けに出荷される日持ちの良い品種です。<br class="hidden-xs">
柔らかくなると、糖度も高く食べ応えのあるおいしい桃です。<br class="hidden-xs">
お中元のお返し、残暑見舞いにどうぞ。</p>
<div class="center"><img class="img-responsive" src="./images/m_kawanakajima.jpg" width="300" alt="イメージ：川中島" /></div>
</div>

<div class="col-md-4">
<h3 class="orange bold"><span class="em08">南国の香り</span>&nbsp;黄金桃</h3>
<p class="pad_l">果肉が綺麗な黄金色をし栽培量が少なく希少な品種です。<br class="hidden-xs">
独特なトロピカルな味わいから別名「マンゴーピーチ」とも呼ばれ、近年、大変人気があります。</p>
<div class="center"><img class="img-responsive" src="./images/m_gold.jpg" width="300" alt="イメージ：黄金桃" /></div>
</div>
</div><!-- /row -->
<br />
<?php */?>


<div class="center">
<?php
mobile_image('./images/2026_momo_list.png', '商品一覧表', 'img-responsive');
?>
</div>


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




<?php
// 6/？ 10:00〜8/18 00:00まで販売
if (time() > strtotime('2026-06-15 00:00:00') && time() < strtotime('2026-08-17 00:00:00')) {
?>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<a href="https://www.fukushima.u-coop.or.jp/app/shopping/fruits/" target="_blank" class="btn btn-success btn-block btn-lg em15" >福島の桃お申込みはこちら<i class="fa fa-fw fa-chevron-right"></i></a>
</div>
</div>	<!-- /row -->


<?php
// 8/18 00:00で販売終了
} else if (strtotime('2026-08-18 00:00:00') < time()) {
?>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<a target="_blank" class="btn btn-success btn-block btn-lg em15 disabled">【受付終了】<br class="visible-xs-block">福島の桃お申込み<i class="fa fa-fw fa-chevron-right"></i></a>
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
