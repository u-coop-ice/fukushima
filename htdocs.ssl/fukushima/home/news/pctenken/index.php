<?php
require_once '../../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link type="text/css" href="./css/pctenken.css" rel="stylesheet" media="screen,print" />

<?php
include $rootpath . 'include/header2.txt';
?>


<div id="main2" class="full">
<div class="content_inner">

<h2 class="">生協Surface点検会</h2>

<div class="alert alert-danger center lead bold" role="alert">【1･2年生必見！】【参加無料】</div>

<?php
mobile_image('./images/pc001.png?', '生協パソコン点検会', 'img-responsive');
?>

<div class="row row-center va-middle">
<div class="col-sm-6">
<?php
mobile_image('./images/pc002.jpg', '生協パソコン点検会', 'img-responsive gallery');
?>
</div>
<div class="col-sm-6">
<a class="btn btn-info btn-block" href="https://www.fukushima.u-coop.or.jp/app/reserve/?cd=PBzEX62y
" target="_blank"><span class="lead"><span class="hidden-xs">点検会参加の</span>ご予約はこちら<span class="hidden-xs">から</span>	<i class="fa fa-fw fa-chevron-right"></i></span></a>
</div>
</div>

<br />
<p class="center">
<span class="marker yellow thin em12 bold">※パソコンを持ち込む際に、ログインパスワードの開錠をお願いします。</span>
</p>


<div class="contact center">
<span class="lead bold">主催：福島大学生協 新生活サポートセンター</span></div>


<br><br>
<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-home"></i>トップへ戻る</a></p>


</div><!-- /content -->

<div class="clear">*</div>



<?php
include $rootpath . '/include/footer.txt';
?>
