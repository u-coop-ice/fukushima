<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link type="text/css" href="/css/print.css" rel="stylesheet" media="print" />
<link type="text/css" href="./css/time.css?200508" rel="stylesheet" media="screen,print" />

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">

<h2>営業時間</h2>

<div class="box">
<h4 class="top">新型コロナウイルス感染対策における営業時間変更について</h4>

<p>日頃、福島大学生協をご利用いただきまして誠にありがとうございます。<br />
昨今の事情により、福島大学生協では各店舗の営業を一部自粛及び営業時間を変更しております。<br />
状況が変わり次第徐々にではありますが営業を再開する予定でございます。<br />
ご利用者の方にはご不便をおかけしますが、ご理解とご協力の程何卒よろしくお願いいたします。</p>
</div>


<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setlog(array('../../../data/whatsnewdata.xml'));
$whatsnew->setCoop('fukushima');
$whatsnew->setBefore(365);
?>

<h3>営業時間の変更等</h3>
<?php
$whatsnew->setKey('covid19-time');
if ($whatsnew->getList()) {
	echo $whatsnew->getList();
} else {
	echo '<p class="alert alert-info">準備中</p>';
}
?>

<?php
if (time() < strtotime("2020-10-01 00:00:00")){
?>

<h3>2020年 営業時間のご案内（2020年7月1日より）<span class="small">※変更が出た場合は随時更新致します</span></h3>

<div class="table-responsive">
<table cellspacing="0" class="table tblFull em09">
<tr><th colspan="2">店舗名</th><th>連絡先</th><th>平日</th><th>土曜</th><th>日曜</th><th>祝日</th><th>備考</th></tr>
<tr><td rowspan="2">購買書籍店</td><td>コンビニ</td><td rowspan="2">024-548-0091</td><td>11:00〜14:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
<tr><td>カウンター</td><td>11:00〜14:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
<tr><td colspan="2">図書館店</td><td>024-572-7707</td><td>閉店</td><td>閉店</td><td>閉店</td><td>閉店</td><td>2月28日(日)まで閉店いたします。</td></tr>
<tr><td colspan="2">本部･新入生サポートセンター</td><td>024-548-5141</td><td>11:00〜16:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
<tr><td colspan="2">1階食堂 Dining ReaF</td><td>024-548-5142</td><td>閉店</td><td>閉店</td><td>閉店</td><td>閉店</td><td>10月1日(木)より営業を再開します！</td></tr>
<tr><td colspan="2">2階食堂 Quick Lunchグリーン</td><td>-</td><td>11:30〜14:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
</table>
</div>

<?php
}
?>

<h4>Dining ReaFの営業が再開しました！<a class="btn btn-primary" href="foodservice/meal/">後期ミールプラン<span class="hidden-xs">についてはこちら</span><i class="fa fa-fw fa-chevron-right"></i></a></h4>

<h3>2020年 営業時間のご案内（2020年10月1日より）<span class="small">※変更が出た場合は随時更新致します</span></h3>

<div class="table-responsive">
<table cellspacing="0" class="table tblFull em09">
<tr><th colspan="2">店舗名</th><th>連絡先</th><th>平日</th><th>土曜</th><th>日曜</th><th>祝日</th><th>備考</th></tr>
<tr><td rowspan="2">購買書籍店</td><td>コンビニ</td><td rowspan="2">024-548-0091</td><td>9:30〜18:30</td><td>11:00〜14:00</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
<tr><td>カウンター</td><td>11:00〜14:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
<tr><td colspan="2">図書館店</td><td>024-572-7707</td><td>閉店</td><td>閉店</td><td>閉店</td><td>閉店</td><td>2月28日(日)まで閉店いたします。</td></tr>
<tr><td colspan="2">本部･新入生サポートセンター</td><td>024-548-5141</td><td>11:00〜16:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
<tr><td colspan="2">1階食堂 Dining ReaF</td><td>024-548-5142</td><td>11:00〜18:00</td><td>11:00〜14:00</td><td>閉店</td><td>閉店</td><td>10月1日(木)より営業を再開</td></tr>
<tr><td colspan="2">2階食堂 Quick Lunchグリーン</td><td>-</td><td>11:00〜14:00</td><td>閉店</td><td>閉店</td><td>閉店</td><td>&nbsp;</td></tr>
</table>
</div>


<ul class="tri">
<li>祝日は全店閉店となります。</li>
<li>大学学事により営業時間が変更になる場合があります。その場合は、各店掲示板に掲示いたします。</li>
</ul>
<br />



<h3>営業時間カレンダー</h3>

<?php
if (time() < strtotime("2020-10-01 00:00:00")){
?>

<ul class="tri">
<li>コロナ禍の影響により図書館店・Dining ReaFに関しては営業を一時的に自粛させていただいております。皆様にはより安心かつ快適にご利用いただけるよう現在再開のタイミングを検討しており、方針が定まり次第営業時間を表示いたします。ご不便をおかけしますが何卒よろしくお願いいたします。</li>
<li>図書館店は2月28日(日)まで閉店となります。それまでの対応等についてはこちらをご確認ください。<a class="btn btn-info btn-xs em09" href="/store/">こちら<i class="fa fa-fw fa-chevron-right"></i></a>をご確認ください。</li>
<li><span class="red">Dining ReaFは10月1日(木)より営業再開を予定しております！</span></li>
</ul>

<?php
} else {
?>

<ul class="tri">
<li>コロナ禍の影響により図書館店に関しては営業を一時的に自粛させていただいております。皆様にはより安心かつ快適にご利用いただけるよう現在再開のタイミングを検討しており、方針が定まり次第営業時間を表示いたします。ご不便をおかけしますが何卒よろしくお願いいたします。</li>
<li>図書館店は2月28日（日）まで閉店となります。それまでの対応等についてはこちらをご確認ください。<a class="btn btn-info btn-xs em09" href="/store/">こちら<i class="fa fa-fw fa-chevron-right"></i></a>をご確認ください。</li>
<li><span class="red">Dining ReaFは10月1日（木）より営業再開しております！</span><a class="btn btn-primary btn-xs em09" href="foodservice/meal/">後期ミールプラン<span class="hidden-xs">についてはこちら</span><i class="fa fa-fw fa-chevron-right"></i></a></li>
</ul>

<?php
}
?>



<div class='sticky_table_wrapper center'>
<table class="sticky_table">


<?php
if (time() < strtotime("2020-07-01 10:00:00")){
?>

<thead>
<tr><th rowspan="2" colspan="2"></th><th colspan="2">購買書籍店</th><th rowspan="2">図書館店</th><th rowspan="2">Dining ReaF<br /><span class="em09 js70">(ラストオーダー 閉店15分前)</span></th><th rowspan="2">QuickLunch<br>グリーン</th><th rowspan="2"><span class="em09 js70">本部･<br>新入生サポートセンター</span></th><?php /*?><th rowspan="2" class="last">教科書販売<br /><span class="em09 js70">(会場:Dining ReaF内特設会場)</span></th><?php */?></tr>
<tr><th class="child2">購買</th><th class="child2">カウンター</th></tr>
</thead>


<?php
} else {
?>

<thead>
<tr><th rowspan="2" colspan="2"></th><th colspan="2">購買書籍店</th><th rowspan="2">図書館店</th><th rowspan="2">Dining ReaF<br /><span class="em09 js70">(ラストオーダー 閉店15分前)</span></th><th rowspan="2">QuickLunch<br>グリーン</th><th rowspan="2" class="last"><span class="em09 js70">本部･<br>新入生サポートセンター</span></th></tr>
<tr><th class="child2">購買</th><th class="child2">カウンター</th></tr>
</thead>


<?php
}
?>


<tbody>
<?php
/*
./include/に20XXMM.phpで名付けたファイルを置いておくと、アクセス日時を評価して自動的にファイルを読み込み、
タブ生成します。
 */

require 'setFileByMonth.class.php';
$tbl = new setFileByMonth();
$tbl->set_no_tab();
$tbl->setAbsolutePath(realpath('./include/')); //ファイルへ相対パス、絶対パスでも指定可能です。
$tbl->includeFile();
?>
</tbody>

</table>
</div>

<br>
<p><a class="btn btn-primary" href="/store/"><i class="fa fa-fw fa-reply"></i>店舗トップに戻る</a></p>

</div><!-- main終了 -->


<?php
include $rootpath . '/include/footer.txt';
?>
