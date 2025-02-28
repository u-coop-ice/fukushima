<?php
$rootpath = $_SERVER['DOCUMENT_ROOT'];
require_once $rootpath . '/include/config_lite.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>TOEIC Speaking & Writing Tests 受験半額キャンペーン :: 福島大学生活協同組合</title>

<link type="text/css" href="/css/import.css" rel="stylesheet" media="screen,print" />
<link type="text/css" href="/css/buttons.css" rel="stylesheet" media="screen,print" />

<?php
include $rootpath . '/include/js_index.txt';
?>

<script type="text/javascript">
var breadcrumb = '<a href="/">TOPページ</a>&nbsp;&gt;&nbsp;<a href="/career/">学内講座・資格</a>&nbsp;&gt;&nbsp;TOEIC Speaking & Writing Tests 受験半額キャンペーン';
</script>

</head>


<body>


<div id="topheader"></div>


<div id="wrapper">


<div id="pagebody">

<?php
include $rootpath . '/include/header.txt';
?>

<div class="clear"></div>

<?php
include $rootpath . '/include/navi.txt';
?>

<div class="clear"></div>


<!-- breadcrumb -->
<div id="breadcrumb"><script type="text/javascript">
document.write(breadcrumb);
</script></div><!-- /breadcrumb -->


<?php
$buffer = file_get_contents($rootpath . '/c/career/toeic-swt/2017toeic-swt.php');
$buffer = mb_convert_encoding($buffer, 'EUC-JP', 'UTF-8');
echo ($buffer);
?>




<div class="clear"></div>


</div><!-- pagebody終了 -->


<?php
include $rootpath . '/include/footer.txt';
?>


</div><!-- wrapper終了 -->


</body>

</html>

