<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link rel="stylesheet" href="./css/f4.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="./css/hakama.css" type="text/css" media="screen,print" />

<script>
jQuery(function($){
    $('[rel="lightbox[ph]"]').fancybox({
helpers: {
  overlay: {
    locked: false
  }
}
    });
});
</script>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">


<h2>卒業袴</h2>


<h3>卒業レンタル袴　学内展示予約会のご案内</h3>

<p class="pad_l">卒業式当日のお仕度は「福島大学キャンパス内」で完結！</p>

<p class="pad_l">新作や人気の柄は早い者勝ちとなっています。<br />
ご相談だけでも構いませんので、学内展示予約会にご参加ください！</p>

<div class="pad_l">
<h4>日時</h4>
<ul class="bold">
<li>10月20日(火)・21日(水)</li>
</ul>
</div>


<p class="pad_l">上記日程より早くお申込みをしたい方は、鈴乃屋レンタル仙台店様へお問い合わせください。</p>
<p class="pad_l"><a class="btn btn-info" href="https://www.suzunoya.com/shop/cpt_shop/rental_sendai/?srsltid=AfmBOoqCOat9J7hDuY9Uf2Pvl_EWN4t4nXWdMthU7G_mHf1OKq7HrRrv" target="_blank">鈴乃屋レンタル仙台店様のHPはこちら <i class="fa fa-external-link"></i></a></p>

<br />

<?php /*
<p>予約不要となっていますので、お気軽にご参加ください！</p>*/ ?>

<p>
<?php
mobile_image('./images/hkm02.jpg', '', 'img-responsive img center');
?>
</p>




<div class="row">
<div class="col-sm-4 col-sm-offset-3 col-xs-12 col-xs-offset-0">
<p class="">ご相談は福島大学生協公式LINEよりお願いします。</p>
</div>
<div class="col-sm-2 col-xs-2">
<?php
mobile_image('./images/line.png', '福島大学生協公式LINE', 'img-responsive img center');
?>
</div>
</div>


<p><a class="btn btn-primary" href="../"><i class="fa fa-fw fa-reply"></i>卒業に戻る</a></p>

</div><!--content終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>
