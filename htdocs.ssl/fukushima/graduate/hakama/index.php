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

<p class="">卒業式当日のお仕度は「福島大学キャンパス内」で完結！</p>

<p class="">新作や人気の柄は早い者勝ちとなっています。<br />
ご相談だけでも構いませんので、学内展示予約会にご参加ください！</p>

<h4>日時</h4>
<ul class="bold">
<li>6月8日(月)　11:00〜17:00</li>
<li>6月9日(火)・10日(水)　10:00〜16:00</li>
<li>7月6日(月)　11:00〜17:00</li>
<li>7月7日(火)　10:00〜16:00</li>
</ul>

<p>予約不要となっていますので、お気軽にご参加ください！</p>

<p>
<?php
mobile_image('./images/hkm01.jpg', '', 'img-responsive img center');
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
