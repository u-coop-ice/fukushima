<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="content">

<h3 id="sodaikai">総代会</h3>

<?php
if (time() < strtotime("2020-04-01 00:00:00")){
?>
<h4><a class="arrow" href="/home/sodaikai/shoushuu.php">2019年度 通常総代会招集通知</a></h4>
<h4><a class="arrow" href="/home/sodaikai/kaisaiannai.php">第88回通常総代会開催のご案内</a></h4>
<h4><a class="arrow" href="/home/sodaikai/sodaikai.php">第88回通常総代会告示</a></h4>
<h4><a class="arrow" href="/home/sodaikai/senkyo.php">総代選挙公示</a></h4>
<h4><a class="arrow" href="/home/sodaikai/yakuin.php">役員選挙公示</a></h4>

<?php
} else {
?>

<?php
if (time() > strtotime("2020-05-01 00:00:00")){
?>
<h4><a class="arrow" href="/home/sodaikai/notice.php">2020年度 通常総代会招集通知</a></h4>
<h4><a class="arrow" href="/home/sodaikai/kaisaiannai.php">第89回通常総代会開催のご案内</a></h4>
<?php
}
?>
<h4><a class="arrow" href="/home/sodaikai/sodaikai.php">第89回通常総代会告示</a></h4>
<h4><a class="arrow" href="/home/sodaikai/senkyo.php">総代選挙公示</a></h4>
<h4><a class="arrow" href="/home/sodaikai/yakuin.php">役員選挙公示</a></h4>
<h4><a class="arrow" href="/home/sodaikai/report.php">第89回通常総代会終了報告</a></h4>

<?php
}
?>

<hr />


<h3 id="sodaikai_w">総代会って？</h3>

<div class="row">

<div class="col-sm-7">
<p class="ind">総代会とは生協の意思決定のための最高議決機関です。と言われても、総代会で何を決めるのでしょうか？そもそも総代とは何者なのでしょうか？
そんな疑問をマンガにて解決いたします！</p>
<p>（※画像をクリックするとPDFファイルが開きます）</p>
</div>

<div class="col-sm-5">
<p class="center">
<a href="./pdf/sodai_comic.pdf" target="_blank">
<img class="img img-responsive hover" src="/home/sodaikai/images/sodai_comic.jpg" width="150" height="212" alt="PDF：総代会って" />
<br />
PDF <i class="fa fa-file-pdf-o"></i>（1.8MB）：「総代会って」
</a>
</p>
</div>
</div>


</div><!--content終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>
