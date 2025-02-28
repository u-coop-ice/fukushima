<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>


<link type="text/css" href="<?php fp_ft('./css/goods.css'); ?>" rel="stylesheet" media="screen,print" />

<?php
include $rootpath . 'include/header2.txt';
?>


<div id="main2" class="full">

<div class="center">
<p>
<?php
mobile_image('.//images/head_ichi001.jpg', '純米吟醸酒　食農学類　壱', 'img-responsive');
?>
</div>

<br />

<div class="center">
<p class="sm lh15"><strong class="">福島大学食農学類附属醸造研究所</strong>と<br class="visible-xs-block"><strong class="">未来農業株式会社</strong>が<br  class="hidden-xs">共同開発した酒蔵好適米を<br class="visible-xs-block">鈴木酒造店の酒蔵で醸造しました</p>
</div>

<h3>開発の経緯</h3>

<div class="row">
<div class="col-sm-7">
<p class="ind lh17">醗酵醸造研究所の酒造好適米研究チームは、これまでに、既存の酒造好適米系統を親株として作成された酒米変異株の中から、生育が良好で寒くなる前に登熟して収穫が可能な「早生」の性質をもつ系統をいくつか選抜してきました。昨年度、酒造好適米「山田錦」を親系統とする有望な一系統を未来農業株式会社(福島市松川町)の圃場で試験栽培し、秋には米粒の姿かたちは親系統と遜色ない米を収穫することができました。今後、この有望系統の改良を進めていきますが、今回収穫した新米を使って鈴木酒造店(双葉郡浪江町)の酒蔵で3月初めに純米吟醸酒の試験醸造の仕込みを始め3月末には醸造が完了しました。福島大学生協を通して搾りたての新酒「食農学類-壱」を<strong class="sm bold">限定販売</strong>します。</p>

<br>
<p class="md center red bold alert alert-danger2 lh13">20歳未満の方の飲酒は法律で禁止されています。<br>
20歳未満の方に対しては酒類を販売しません。</p>

<br>


</div>

<div class="col-sm-5">

<?php
mobile_image('./images/ichi.jpg', '純米吟醸酒　食農学類　壱', 'img-responsive');
?>
</div>
</div>


<div class="row">
<div class="col-sm-7">
<div class="contact gray lh12">
<h5>【品目】日本酒</h5>
<p class="em09">原材料 / 米(国産)、米麹(国産米)<br />
精米歩合  / 55%　アルコール分 / 15度<br />
内容量 / 720ml<br />
製造者　株式会社鈴木酒造店　福島県双葉郡浪江町大字幾世橋知命寺40番</p>

<p class="em09">研究開発：福島県食農学類附属醗酵醸造研究所(IFeS)<br />
水稲栽培：未来農業 株式会社(福島市松川町)<br />
販売　　：福島大学生活協同組合</p>

</div>
</div>
</div>


<div class="box">
<div class="row">
<div class="col-sm-10">
<h4>醗酵醸造研究所とは</h4>
<p class="">発酵醸造に関する総合的な基盤研究と地域の課題を解決する橋渡し研究を推進し、これを国際的な課題や地球規模の課題の解決にも貢献する学際的先端研究として発展させることを目的として令和3年(2021年)4月1日に設置されました。</p>
</div>

<div class="col-sm-2 col-sm-offset-0 col-xs-6 col-xs-offset-3">
<?php
mobile_image('./images/ifes.jpg', '醗酵醸造研究所', 'img-responsive');
?>
</div>
</div>
</div>

<br />




<?php
// 6/8 17:00〜8/13 00:00まで販売
if (time() > strtotime('2023-04-08 17:00:00') && time() < strtotime('2024-08-16 00:00:00')) {
?>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<a href="https://www.fukushima.u-coop.or.jp/app/shopping/sake/" target="_blank" class="btn btn-success btn-block btn-lg sm" >純米吟醸酒 食農学類 壱 お申込はこちら</a>
</div>
</div>	<!-- /row -->


<?php
// 8/13 00:00で販売終了
} else if (strtotime('2024-08-16 00:00:00') < time()) {
?>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<a target="_blank" class="btn btn-success btn-block btn-lg sm disabled">【受付終了】<br class="visible-xs-block">純米吟醸酒 食農学類 壱 お申込</a>
</div>
</div>	<!-- /row -->


<?php
// 販売開始時間までは下記情報を掲載
} else {
?>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<a  <?php /*?>href="https://www.fukushima.u-coop.or.jp/app/shopping/sake/" <?php */?>target="_blank" class="btn btn-success btn-block btn-lg sm disabled">【まもなく販売開始予定】<br class="visible-xs-block">お申し込みはこちらから<i class="fa fa-fw fa-chevron-right"></i></a>
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
