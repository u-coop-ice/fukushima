<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link rel="stylesheet" href="./css/meal.css" type="text/css" media="screen,print" />


<?php
include $rootpath . 'include/header2.txt';
?>

<h2>ミールパス</h2>

<div class="content_full">
<div class="center">
<img src="./images/meal_top.jpg" alt="ミールトップイメージ" class="img-responsive">
</div>
</div>

<h3>【在校学類生・在校院生の方へ】</h3>



<h4>2025年度ミールパスお申込みのご案内</h4>

<div class="center">
<img class="img-responsive" src="./images/2025_meal_001.png" id="3type" alt="2025年度ミールパスお申込みのご案内">
</div>

<?php /*
<div class="note">
<div class="note_inbox white">
<?php
// if (time() < strtotime("2019-02-15 00:00:00")) {
?>
	<p class="em11">拝啓<br>
皆々様には益々ご清祥のこととお慶び申し上げます。<br />
現在、2022年度ミールプランのお申込を受け付けております。健康的で充実した食生活のサポートツールとしてぜひミールプランをご活用ください。<br />ミールプランの詳細に関しては店頭パンフレットをご覧頂くか、福島大学生協食堂へお問い合わせくださいますようお願いいたします。<br></p>
<p class="em11 note_right">敬具</p>
<br>
<p class="">
<strong class="orange em12">早期お申込・ご入金期限：2022年2月14日(木)</strong><br />※2/15(金)以降のお申込は早期特典はつきませんのでご了承ください。</p>
<?php
// }
?>

<?php
// if (time() < strtotime("2024-03-23 00:00:00")) {
	?>
<p class=""><strong class="orange em12">お申込期限：2024年3月22日(金)</strong></p>
<?php } else {?>
<p class="">＜受付は終了しました＞<br />
申込期間は終了となりました。お問い合わせ等がございましたら、024-548-5142にご連絡ください</p>
<?php
// }
?>
</div>
</div>
*/ ?>



<h4>福島大学生協ミールパス</h4>
<p class="alert alert-info"><b class="red em14">利用期間：2025年4月1日(火)～2026年3月31日(火)</b></p>
<div class="center">
<p><img class="img-responsive" src="./images/2025_meal_price.png" id="3type" alt="ミールプランは選べる3タイプ">
<a class="btn btn-warning" href="/store/time/" target="_blank">営業時間はこちら <i class="fa fa-fw fa-chevron-right"></i></a></p>
</div>

<?php /*?><div class="box_c">
<p>
<a class="btn btn-primary" href="./pdf/meal2019.pdf" target="_blank">パンフレット（PDF）のダウンロードはこちら</a></p>
</div><?php */?>


<div class="clear"></div>


<?php
include $rootpath . '/include/footer.txt';
?>
