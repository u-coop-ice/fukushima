<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<style>
sup {
	font-size: 60%;
}
</style>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">



<h2>TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Test情報</h2>

<?php
mobile_image('./images/toeic_01.jpg', '', 'img-responsive');
?>

<?php
/*
<div class="alert alert-danger" role="alert">
新型コロナウイルス感染拡大防止のため「旧カレッジTOEIC」の実施日程を見合わせております。（2020/04/20更新）
</div>
*/
?>

<?php
if (time() < strtotime("2020-11-11 12:45:00")){
?>
<div class="alert alert-danger" role="alert">
11月11日（水）のTOEIC IPテストの申込は締切りました。
</div>
<?php
}
?>


<?php /*?><p><a class="btn btn-primary" href="#schedule">2022年度 年間スケジュール<i class="fa fa-fw fa-chevron-right"></i></a></p>
<p><a class="btn btn-primary" href="#attraction">TOEIC<sup>&reg;</sup>公開テストと比べた3つの魅力<i class="fa fa-fw fa-chevron-right"></i></a></p><?php */?>

<h3>TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Testとは</h3>
<ol>
<li>大学生協が運営するTOEIC<sup>&reg;</sup>の団体受験制度です。</li>
<li>過去のTOEIC<sup>&reg;</sup>公開テストの問題を使います。</li>
<li>テストの内容・形式、採点方法はTOEIC<sup>&reg;</sup>公開テストと全く同じです。（どちらもリスニング100問、リーディング100問、2時間です。）</li>
<li>TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Test のスコアは、2年間有効なオフィシャルスコアとして認められています。<br />
（TOEIC<sup>&reg;</sup>公開テストでは、公式認定証が発行されますが、TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Test はスコアレポートのみです。公式認定証が必要な場合は、TOEIC<sup>&reg;</sup>公開テストの受験をおすすめします。なお、試験日程・会場が異なりますので、ご注意ください。）</li>
<li>申込みが簡単！購買カウンターで直接申込みができます。</li>
</ol>


<h3>TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Testの特徴</h3>

<h4 id="attraction">TOEIC<sup>&reg;</sup>公開テストと比較したTOEIC<sup>&reg;</sup> Listening &amp; Reading IP Testの3つの魅力とは？</h4>

<ol>
<li><span class="orange">安心の受験環境です。</span><br />受験会場は福島大学内の教室です。身近な環境で安心して受験できます。</li>
<li><span class="orange">受験料が安いです。</span><br />TOEIC<sup>&reg;</sup>公開テスト：7,810円に対し、<span class="marker yellow thin">TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Test：4,300円</span>と、約4割安いです。</li>
<li><span class="orange">試験結果が早くわかります。</span><br />TOEIC<sup>&reg;</sup>公開テスト：約4週間に対し、<span class="marker yellow thin">TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Test：約2週間</span>と、早くわかります。</li>
</ol>


<h4>TOEIC<sup>&reg;</sup>Listening &amp; Reading IP Testのスコアは、履歴書や単位と関係ありますか？</h4>

<p><span class="marker yellow thin">履歴書にも書けます！</span>TOEIC<sup>&reg;</sup> Listening &amp; Reading IP Testのスコアの有効性はTOEIC<sup>&reg;</sup>公開テストと同等です。ただし、教員採用試験における1次試験免除などでは、TOEIC<sup>&reg;</sup>公開テストの公式認定証が必要なケースもあります。出願の際は各自で必ず確認してください。</p>


<h3 id="schedule">2026年度 年間スケジュール等</h3>
<table class="tblFull" cellspacing="0">
<tr><th>実施日</th><th>試験時間</th><th>受付時間</th><th>実施教室</th></tr>
<tr><td>
<?php if (time() < strtotime("2026-05-20 15:00:00")) {
	?>
<strong>5/20(水)</strong>
<?php } else {?>
<del>5/20(水)</del><br /><span class="em09 red">終了しました</span>
<?php }?>
</td><td>13:00〜15:01</td><td>12時15分〜12時45分</td><td><strong>L-2教室</strong></td></tr>

<tr><td>
<?php if (time() < strtotime("2026-07-15 15:00:00")) {
	?>
<strong>7/15(水)</strong>
<?php } else {?>
<del>7/15(水)</del><br /><span class="em09 red">終了しました</span>
<?php }?>
</td><td>13:00〜15:01</td><td>12時15分〜12時45分</td><td><strong>L-2教室</strong></td></tr>

<tr><td>
<?php if (time() < strtotime("2026-09-16 15:00:00")) {
	?>
<strong>9/16(水)</strong>
<?php } else {?>
<del>9/16(水)</del><br /><span class="em09 red">終了しました</span>
<?php }?>
</td><td>13:00〜15:01</td><td>12時15分〜12時45分</td><td><strong>L-2教室</strong></td></tr>

<tr><td>
<?php if (time() < strtotime("2026-11-18 15:00:00")) {
	?>
<strong>11/18(水)</strong>
<?php } else {?>
<del>11/18(水)</del><br /><span class="em09 red">終了しました</span>
<?php }?>
</td>
<td>13:00〜15:01</td><td>12時15分〜12時45分</td><td><strong>L-2教室</strong></td>
</tr>

<tr><td>
<?php if (time() < strtotime("2027-01-20 15:00:00")) {
	?>
<strong>2027/01/20(水)</strong>
<?php } else {?>
<del>2027/01/20(水)</del><br /><span class="em09 red">終了しました</span>
<?php }?>
</td>
<td>13:00〜15:01</td><td>12時15分〜12時45分</td><td><strong>L-2教室</strong></td>
</tr>
</table>

<ul class="tri">
<li>受講料：4&#44;300円（1回あたり）</li>
<li>お申込先：福島大学生協　購買カウンター店</li>
</ul>
<span class="rev_ind">※申込は、定員になり次第締め切りです（各回：50名）。</span>
<span class="rev_ind">※当日、試験を欠席されても返金はできません。</span>




<br><br>
<div class="box">
<h5>お申し込み先・お問合せ</h5>
<p class="bold">福島大学生活協同組合 購買店<br />TEL：024-548-0091</p>
</div>


<br><br>
<p><a class="btn btn-primary" href="/career/"><i class="fa fa-fw fa-reply"></i>学内講座・資格トップへ戻る</a>
</p>



</div><!--content終了 -->



<?php
include $rootpath . '/include/footer.txt';
?>

