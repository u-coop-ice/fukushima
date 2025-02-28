<?php
require_once '../../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>


<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">

<?php
mobile_image('./images/top.png', '3店舗のお米が“天のつぶ”に変わります！', 'img-responsive');
?>

<div class="alert alert-danger center" role="alert"><strong class="bold lead">実施期間；5月15日から2週間程度</strong></div>


<div class="box">
<div class="row">
<div class="col-sm-10">
<h4>“ 天のつぶ ”とは、、、</h4>

<p class="">天に向かってまっすぐ伸びる稲の力強さが名前由来の「天のつぶ」は、奇しくも東日本大震災が起きた平成23年にデビュー。復興のシンボルという農家もいます。<br />
米粒の光沢、大きさ、張り、粒ぞろい、炊きあがりの香りも良好。噛むごとに粒の中からうまみがほとばしり、一粒一粒の力に感動。すべてにおいて申し分ないお米です。</p>
</div>


<div class="col-sm-2 col-sm-offset-0 col-xs-6 col-xs-offset-3">
<?php
mobile_image('./images/tennotsubu.png', '天のつぶロゴマーク', 'img-responsive');
?>

</div>
</div>

</div>




<div class="clear"></div>

<p><a class="btn btn-primary" href="/foodservice/"><i class="fa fa-fw fa-reply"></i>食堂トップへ戻る</a></p>

<?php
include $rootpath . '/include/footer.txt';
?>