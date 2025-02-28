<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
?>

<?php
include_file($rootpath . '/include/js_index.txt');
?>




<?php
if ($career == 'pc') {
	?>

<link type="text/css" href="./css/articles.css" rel="stylesheet" media="screen,print" />

<?php
} else if ($career == 'sp') {
	?>

<?php
}
include_file($rootpath . '/include/header2.txt');
?>

<div id="main2" class="full">

<h2 id="cat2_articles">定款・規則・規約等</h2>

<h3>定款</h3>

<div class="list-group ic_list">
<a class="list-group-item ic_document" href="/home/teikan/"><h5 class="list-group-item-heading">福島大学生活協同組合 定款</h5></a>
</div>

<h3>規則・規約等</h3>
<div class="list-group ic_list">
<a class="list-group-item ic_document" title="大学生協アプリ（公式）利用規約" target="_blank" href="https://www.univ.coop/etc/etc_248.html"><h5 class="list-group-item-heading">大学生協アプリ（公式）利用規約</h5></a>
<a class="list-group-item ic_document" href="/home/regulation/#mealplan"><h5 class="list-group-item-heading">ミール定期マネー(ミールプラン)利用細則</h5></a>
<a class="list-group-item ic_document" href="/home/regulation/#course"><h5 class="list-group-item-heading">講座申込み規定</h5></a>
<a class="list-group-item ic_document" href="/home/aid/sd/"><h5 class="list-group-item-heading">ＣＯ･ＯＰ学生総合共済勧誘方針</h5></a>
</div>

<h3>個人情報保護</h3>
<div class="list-group ic_list">
<a class="list-group-item ic_document" href="/home/privacypolicy/"><h5 class="list-group-item-heading">福島大学生協の個人情報保護方針<small>（プライバシー・ポリシー）</small></h5></a>
</div>

<h3>従業員保護</h3>
<div class="list-group ic_list">
<a class="list-group-item ic_document" href="/home/customer_harassment/"><h5 class="list-group-item-heading">カスタマーハラスメント対応ポリシー</h5></a>
</div>

</div><!-- /main -->



<div class="clear">*</div>



<?php
include_file($rootpath . '/include/footer.txt');
?>
