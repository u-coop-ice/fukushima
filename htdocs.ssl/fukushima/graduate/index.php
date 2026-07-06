<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>


<?php
include $rootpath . 'include/header2.txt';
?>



<h2 id="title_graduate">卒業</h2>

<p class="em12">2027年度卒業予定の方は【Information】から案内をご確認ください。</p>


<h3 class="bold">Information</h3>

<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog('../../data/whatsnewdata.xml');
$whatsnew->setCoop('fukushima');
$whatsnew->setKey('graduate');
echo $whatsnew->getList();
?>



<div class="alert alert-danger" role="alert">
以下に掲載されている情報は2026年度のものです。2027年度に向けてただいま準備中です。<br />
2026年度卒業生の方は以下の案内からお手続きをお願いします。</div>

<h2 id="title_store">2026年3月にご卒業予定のみなさまへ</h2>

<div class="container">
<div class="row">

<p class="pad_l">これまで福島大学生協をご利用いただき、ありがとうございます。<br />
福島大学生協では卒業までに必要な各種手続きをサポートいたします。<br />
すでにご実家宛にお送りしている資料「出資金返還・諸変更手続き　ご卒業にあたってのご案内」でも同様の内容をご案内しておりますので、ご家族様ともご確認のうえ忘れずにお手続きください。</p>



<h3 class="bold">出資金返還</h3>
<div class="row">
<div class="col-sm-9 col-xs-12">
<h5><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>2026年3月に卒業される方</h5>
<p class="pad_l"><a class="btn btn-success" href="https://www.fukushima.u-coop.or.jp/app/member/leave/" target="_blank">出資金返還手続き<i class="fa fa-fw fa-chevron-right"></i></a> を行ってください。<br />
<span class="rev_ind">※保護者の方とご本人様の二重でお手続きをされている場合があります。<br />
お手続き前にご家族とご確認をお願いします。</span>
</p>
</div>

<div class="col-sm-2 hidden-xs">
<?php
mobile_image("./images/qr_henkan.png", "出資金返還", 'img-responsive');
?>
</div>
</div>


<div class="row">
<div class="col-sm-9 col-xs-12">
<h5><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>2026年4月以降も福島大学に在籍される方</h5>
<p class="pad_l">（福島大学院へ進学される方、休学・留年等で卒業予定年が変更となる方、福島大学の職員になる方　が対象です。）<br />
<a class="btn btn-success" href="https://www.fukushima.u-coop.or.jp/app/member/transit/" target="_blank">組合員情報変更<i class="fa fa-fw fa-chevron-right"></i></a> より卒業予定年の変更手続きを行ってください。</p>
</div>

<div class="col-sm-2 hidden-xs">
<?php
mobile_image("./images/qr_vc.png", "諸変更", 'img-responsive');
?>
</div>
</div>



<h3 class="bold">学生総合共済</h3>
<h5><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>2026年3月に卒業される方</h5>
<p class="pad_l">「CO･OP学生総合共済　新社会人コース」は、CO・OP学生総合共済加入者の方が継続できる専用コースです。新社会人になっても保障が途切れることなく、ケガや病気の「もしも」にそなえられ、おすすめです。<br />詳しくはお送りした資料または以下ホームページを必ずご確認ください。</p>
<p class="pad_l"><a class="btn btn-info" href="https://kyosai.univcoop.or.jp/new-working/" target="_blank">CO･OP学生総合共済　新社会人コース <i class="fa fa-external-link"></i></a></p>
<p class="pad_l"><a class="btn btn-info" href="https://shakaijin110.jp/" target="_blank">新社会人生活110番 <i class="fa fa-external-link"></i></a></p>

<h5><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>2026年4月以降も福島大学に在籍される方</h5>
<p class="pad_l">CO･OP学生総合共済・学生賠償責任保険・就学費用保障保険・学生生活110番等の加入期間は2026年3月で終了します。<br />
2025年12月～2026年1月頃にご実家に案内が送付されますので、保障継続の手続きを行ってください。<br />
以下ホームページもご確認ください。</p>
<p class="pad_l"><a href="https://kyosai.univcoop.or.jp/procedure/graduation.html" target="_blank">https://kyosai.univcoop.or.jp/procedure/graduation.html <i class="fa fa-external-link"></i></a></p>
<strong class="pad_l red">毎年、お手続きを忘れてしまい「保障が終了してしまう」事例がありますのでご注意ください。</strong>



<h3 class="bold">卒業記念印鑑</h3>
<div class="pad_l">
<div class="row">
<div class="col-sm-8 col-xs-12">
<p>「出資金返還・諸変更手続き　ご卒業にあたってのご案内」に同封している申込用紙に必要事項を記入して、購買カウンターまでご提出、または郵送ください。<br />
申込用紙が見当たらない場合は、購買カウンターにてお渡しいたします。</p>
</div>

<div class="col-sm-2 col-xs-4">
<p class="center">
<?php
mobile_image("./images/img_inkan.jpg", "卒業記念印鑑", 'img-responsive img');
?>
<a class="btn btn-success btn-sm" href="./pdf/25_inkan.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> 申込用紙はこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</div>
</div>
</div>



<h3 class="bold">卒業論文</h3>
<p class="pad_l">論文作成に必要な綴込表紙、コピー用紙、インク、ファイル等は購買店に揃えております。<br />
また、大学への提出用や記念に上製本や簡易製本を作りませんか？<br />
申込方法、金額、納期などは購買カウンターにご相談ください。</p>



<h3 class="bold">卒業後（新社会人）向けWiFi</h3>
<div class="pad_l">
<div class="row">
<div class="col-sm-8 col-xs-12">
<p>社会人になってもお手軽お得なインターネットで快適に！</p>
<ul>
<li>WiMAX：<a class="btn btn-info btn-xs" href="https://dis.onl/wimaxplusS2612010630/" target="_blank">申し込みサイトはこちら <i class="fa fa-external-link"></i></a> から</li>
<li>トレミール：<a class="btn btn-info btn-xs" href="https://trepp.jp/shop/products/detail/2" target="_blank">申し込みサイトはこちら <i class="fa fa-external-link"></i></a> から</li>
</ul>
</div>

<div class="col-sm-2 col-xs-4">
<p class="center">
<?php
mobile_image("./images/img_wf_wm.jpg", "WiMAX", 'img-responsive');
?>
<a class="btn btn-success btn-sm" href="./pdf/25_wf_wm.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> チラシはこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</div>
<div class="col-sm-2 col-xs-4">
<p class="center">
<?php
mobile_image("./images/img_wf_tre.jpg", "トレミール", 'img-responsive');
?>
<a class="btn btn-success btn-sm" href="./pdf/25_wf_tre.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> チラシはこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</div>
</div>
</div><!-- /pad_l -->



<h3 class="bold">お部屋探し</h3>
<div class="pad_l">
<div class="row">
<div class="col-sm-8 col-xs-12">
<a class="btn btn-info" href="https://www.univcoop-housing.co.jp/room_grad/">卒業後（新社会人）のお部屋探しはこちら <i class="fa fa-external-link"></i></a></div>

<div class="col-sm-2 col-xs-4">
<p class="center">
<?php
mobile_image("./images/img_room.jpg", "社会人向けお部屋探し", 'img-responsive');
?>
<a class="btn btn-success btn-sm" href="./pdf/25_room.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> チラシはこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</div>
</div>
</div>



<h3 class="bold">引越</h3>
<div class="row">
<div class="col-sm-8 col-xs-12">
<p class="pad_l">年度末が近づくと引越業者はどこも混み合います。引越業者探しに苦労しないためにも、早めに手配をしましょう。</p>
<p class="pad_l"><a class="btn btn-info" href="https://art.0123.co.jp/ArtWebTohoku-U-Coop.nsf/" target="_blank">アート引越センター <i class="fa fa-external-link"></i></a></p>
<p class="pad_l"><a class="btn btn-info" href="https://www.hikkoshi-sakai.co.jp/est/tohoku/" target="_blank">サカイ引越センター <i class="fa fa-external-link"></i></a></p>
</div>

<div class="col-sm-2 col-xs-4">
<p class="center">
<?php
mobile_image("./images/img_move_art.jpg", "お引越し アート", 'img-responsive');
?>
<a class="btn btn-success btn-sm" href="./pdf/25_move_art.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> チラシはこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</div>

<div class="col-sm-2 col-xs-4">
<p class="center">
<?php
mobile_image("./images/img_move_sakai.jpg", "お引越し サカイ", 'img-responsive');
?>
<a class="btn btn-success btn-sm" href="./pdf/25_move_sakai.pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> チラシはこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</div>
</div>


<?php /*
<h3 class="bold">お金のはなしセミナー（2月開催）のご案内</h3>
<h5><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>お金のはなし（要申込）</h5>
<p class="pad_l">
<a class="btn btn-info" href="https://career.u-coop.or.jp/app/reserve/?cd=zc16eT72" target="_blank">ご視聴の申込みはこちら <i class="fa fa-external-link"></i></a></p>
<p class="pad_l">卒業前に知っておきたいお金のはなしをオンラインで配信します。<br />
学生はもちろん保護者の皆様の参加もOKです。</p>
*/ ?>


<h3 class="bold">スーツ</h3>
<p class="pad_l">社会人向けのスーツクーポンのご案内を「出資金返還・諸変更手続き　ご卒業にあたってのご案内」に同封してお送りしております。<br />
<strong>［提携会社］洋服の青山、コナカ、AOKI、はるやま</strong><br />
各店舗へ直接お問い合わせください。</p>

<br />


<div class="contact">

<div class="row">
<div class="col-sm-3 col-xs-12">
<h4>ご相談・問合せ先</h4>
<p class="pad_l"><a class="btn btn-success" href="https://lin.ee/Dr74uwZ" target="_blank">公式LINE</a>にて承ります</p>

</div>

<div class="col-sm-2 hidden-xs">
<?php
mobile_image("./images/qr_fukushima_line.png", "諸変更", 'img-responsive');
?>
</div>
</div>

</div><!-- /contact -->




<br />

<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-reply"></i>トップへ戻る</a>
</p>


</div>
</div><!-- /container -->









<?php
include $rootpath . '/include/footer.txt';
?>
