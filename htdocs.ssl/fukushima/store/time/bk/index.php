<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link type="text/css" href="/css/print.css" rel="stylesheet" media="print" />
<link type="text/css" href="./css/time.css" rel="stylesheet" media="screen,print" />

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">

<h2>営業時間</h2>


<?php

/*
./include/に20XXMM.phpで名付けたファイルを置いておくと、アクセス日時を評価して自動的にファイルを読み込み、
タブ生成します。
 */

require 'setFileByMonth.class.php';
$tbl = new setFileByMonth();
$tbl->setAbsolutePath(realpath('./include/')); //ファイルへ相対パス、絶対パスでも指定可能です。
$tbl->includeFile();
?>

<p><a class="btn btn-primary" href="/store/"><i class="fa fa-fw fa-reply"></i>店舗トップに戻る</a></p>

</div><!-- main終了 -->


<?php
include $rootpath . '/include/footer.txt';
?>
