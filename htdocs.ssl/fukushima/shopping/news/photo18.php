<?php
$rootpath= $_SERVER['DOCUMENT_ROOT'];
require_once($rootpath.'/include/config_lite.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>アルバム祭り開催</title>

<link type="text/css" href="/css/import.css" rel="stylesheet" media="screen,print" />
<link type="text/css" href="./css/f4.css" rel="stylesheet" media="screen,print" />

<?php
include($rootpath.'/include/js_index.txt');
?>

<script type="text/javascript">
var breadcrumb = '<a href="/">TOPページ</a>&nbsp;&gt;&nbsp;<a href="/shopping/">ショッピング・各種サービス</a>&nbsp;&gt;&nbsp;アルバム祭り開催';
</script>

</head>


<body>


<div id="topheader"></div>


<div id="wrapper">


<div id="pagebody">

<?php
include($rootpath.'/include/header.txt');
?>

<div class="clear"></div>

<?php
include($rootpath.'/include/navi.txt');
?>

<div class="clear"></div>

<!-- breadcrumb -->
<div id="breadcrumb"><script type="text/javascript">
document.write(breadcrumb);
</script></div><!-- /breadcrumb -->


<div id="content">


<h3>アルバム祭り開催！！！</h3>
<h4>参加者にはキャラメルポップコーンプレゼント!!!</h4>
<table class="tbl">
<tr><th>日時</th><td>4月26日（木）・4月27日（金）10：00〜15：00（両日とも）</td></tr>
<tr><th>場所</th><td>大学会館（生協）前広場（悪天候時は中止する場合がございます）</td></tr>
<tr><th>参加企画</th><td>
<ul class="tri">
<li><span class="btn min "><a  href="/shopping/4graduate/photo.php#personal">"あなた"の個人写真撮影会<i class="fa fa-fw fa-chevron-right" aria-hidden="true"></i></a></span>
<br />
→平成30年度卒業記念アルバム掲載用：4年生対象</li>

<li>キャンパススマイルフォト撮影会<br />
→新入生の方：平成30年度入学記念アルバム掲載用<br />
→2年生〜4年生の方：ご参加いただいた方の卒業年度CDアルバム収録用</li>
</ul>
</td></tr>
</table>
<p class="em12"><strong>お誘い合わせのうえ、ご参加ください！</strong></p>


</div><!--content終了 -->

<!-- col_sub -->

<div id="col_sub">

<?php
include($rootpath.'/include/side_pickup.txt');
?>

<!-- side_banners：バナー -->
<div id="banners_head"></div>

<!-- banners：バナー -->
<div id="banners"><img src="/js/banners/loading.gif" alt="loading" style="display: block; margin: 0 auto 0 auto; padding: 80px 0; border: none; background: transparent;" /></div>
<!-- /banners -->

<div class="sub_bottom_bnr"></div>
<!-- banners終了 -->


</div><!-- col_sub終了 -->


<div class="clear"></div>


<?php
include($rootpath.'/include/footer.txt');
?>


</div><!-- wrapper終了 -->


</body>

</html>


