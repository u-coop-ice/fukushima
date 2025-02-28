<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>

<style>
.list-group.mb05 {
    margin-bottom: 5px;
}
.ic_list h5.bg {
	padding-top: 0px;
	font-size: 150%;
}
</style>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main" class="left">

<h2 id="title_shopping">ショッピング・各種サービス</h2>

<h3 class="ver">Information</h3>


<?php
if (time() < strtotime("2022-08-16 00:00:00")) {
	?>
<div class="list-group ic_list">
<a onclick="ga('send', 'event', 'link, 'click', 'インターネット ショッピング（福島のフルーツ）');" class="list-group-item ic_shopping" href="/shopping/fruits/"><h5 class="list-group-item-heading">インターネット ショッピング（福島のフルーツ）</h5>
<p>福島の特産品（旬の果物）をお届けします。</p>
</a>
</div>
<?php
}
?>


<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog(
	array('../../data/whatsnewdata.xml'));
$whatsnew->setCoop('fukushima');
$whatsnew->setKey('shopping');
$whatsnew->setBefore(360);
if ($whatsnew->getList()) {
	echo $whatsnew->getList();
}
?>

<h3>教科書・書籍・CD</h3>

<?php
/*
<div class="list-group ic_list">
<a class="list-group-item ic_book" href="http://www.honyaclub.com/" target="_blank">
<h5 class="list-group-item-heading">和書・CD・DVD【Honya Club.com】<i class="fa fa-external-link"></i></h5></a>
</div>

<p class="right">
<a class="" data-toggle="collapse" href="#accordionDiv">
Honya Club.comの特徴・ご利用手順を詳しく見る</a>
</p>

<div class="collapse" id="accordionDiv">

<div class="box">

<h5>Honya Club.comのご利用にあたって</h5>
<ul class="tri">
<li><strong class="red">組合員の方には、10％割引が適用されます。（1,000円未満の場合は5％割引）</strong></li>
<li><strong class="red">会員登録</strong>をすると<strong>ユーザIDとパスワード</strong>でご利用いただけるようになります。<br />
その際、会員登録画面から、<strong class="red">〔マイショップ登録〕</strong>してください。</li>
<li>お受け取り方法を宅配に変更した場合は、いずれのお支払い方法であっても、組合員価格は適用されません。予めご了承ください。ポイントは宅配利用時のみ付与され、利用も宅配利用時のみとなります。</li>
</ul>

<div class="hr">_______</div>
<ol>
<li>「マイショップ」から、「書店選択」をクリック。</li>
<li>都道府県から「福島県」を選択。</li>
<li>「サテライト店一覧」から、現在ご利用の〔<strong class="red">福島大学生活協同組合</strong>〕を選択。</li>
</ol>
<div class="hr">_______</div>

<ul class="tri">
<li>欲しい本の在庫・品切れ情報がすぐにわかります。検索注文すると在庫状況と入荷日数が画面表示されます。</li>
<li>150万点以上の書誌データベースから検索。書誌データは常時更新され、最新の情報がご覧になれます。</li>
<li>入荷日数が大幅に短縮されます。流通センター（日販Web-Bookセンター）に在庫している商品は最短で3日で入荷します。</li>
<li>ご不明な点は、福島大学生協までお問い合わせください。</li>
</ul>

<h4>本のお受取りについて</h4>
<p class="ind">本が生協に届くまでは、Honya Club.comから「ご注文承りました」「調達状況更新のご案内」などのメールが届きます。店舗に本が届いた時点で入荷案内のメールが届きます。
</p>

</div>

</div>
 */
?>


<div class="list-group ic_list mb05">
<a class="list-group-item ic_book" href="https://bpos.univcoop.or.jp/whs/main/kyoukasyo/K16-M01.php?cd=0000218101" target="_blank">
<h5 class="list-group-item-heading bg">【教職員の皆様へ】教科書・参考書承りWebフォーム</h5>
<p>
<img class="img" src="/banners/210/bnr_textorder.png" alt="【教職員の皆様へ】教科書・参考書承りWebフォーム" /></p>
</a>
</div>

<?php
if (time() > strtotime('2024-03-26 00:00:00') && time() < strtotime('2024-05-27 00:00:00')) {
	?>
<p class="">
<a href="./text/" class="btn btn-success">
2024年度の前期教科書販売についてはこちら<i class="fa fa-fw fa-chevron-right"></i></a>
</p>
<?php
}
?>


<div class="list-group ic_list">

<a class="list-group-item ic_book" href="https://www.honyaclub.com/shop/default.aspx?isb=a621" target="_blank">
<h5 class="list-group-item-heading">オンライン書店 HonyaClub.com<i class="fa fa-external-link"></i></h5>
<span class="red">※教科書以外のご注文</span>
<p>
<img class="img" src="/banners/210/bnr_honyaclub_210.png" alt="オンライン書店 HonyaClub.com" /></p>
</a>

<a class="list-group-item ic_book" href="http://coop-ebook.jp/" target="_blank">
<h5 class="list-group-item-heading">電子書籍サイト VarsityWave eBooks <i class="fa fa-external-link"></i></h5>
<p><img class="img" src="/banners/250/bnr_vwe_250.png" width="250" height="68" alt="電子書籍サイト VarsityWave eBooks" /></p>
</a>

<a class="list-group-item ic_book" href="https://yosho.univcoop.jp/" target="_blank">
<h5 class="list-group-item-heading">洋書【<span class="ver">大学生協洋書オンライン</span>】<i class="fa fa-external-link"></i></h5>
<p>24時間いつでもインターネットで洋書を注文できます。<br />
<img class="img" src="/banners/250/bnr_ystore_250.png" alt="大学生協洋書オンライン" /></p>
</a>

<a class="list-group-item ic_book" href="https://online.univ.coop/book_front/" target="_blank">
<h5 class="list-group-item-heading">大学生協 書籍Portal Site <i class="fa fa-external-link"></i></h5>
<p><img class="img" src="/banners/210/bnr_uc_books_210.jpg" alt="大学生協 書籍Portal Site" /></p>
</a>

</div>

<h3>印刷・製本サービス</h3>
<div class="list-group ic_list">
<a class="list-group-item ic_book" href="https://www.printkopas.com/" target="_blank">
<h5 class="list-group-item-heading">大学生協の印刷サービス <i class="fa fa-external-link"></i></h5>
<p>これまでの名刺印刷に加え、デジタル印刷のWEB受付サービスを開始しました。</p>
</a>
</div>


</div><!--content終了 -->


<!-- sub -->

<div id="sub">


<div class="sidecolumn navi">

<h4 class="top">Recomended Links</h4>

<div id="menu-inner">

<!-- banners：バナー -->
<div id="banners"><img src="/js/banners/loading.gif" alt="loading" style="display: block; margin: 0 auto 0 auto; padding: 80px 0; border: none; background: transparent;" /></div>
<!-- /banners -->

</div>
</div>



</div><!-- sub終了 -->


<div class="clear"></div>


<?php
include $rootpath . '/include/footer.txt';
?>
