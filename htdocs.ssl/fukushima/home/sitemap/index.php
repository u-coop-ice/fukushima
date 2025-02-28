<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link href="./css/sitemap.css<?php ft('./css/sitemap.css'); ?>" rel="stylesheet" media="screen,print" />





<?php
include $rootpath . 'include/header2.txt';
?>



<div id="main2" class="full">

<div class="section">
<div class="bloLineRound">
<ul class="ulLink p0">
<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/tabmenu.txt');
?>
</ul>
</div>
</div>





<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-home"></i>トップページへ戻る</a></p>

</div><!-- /main -->

<?php
include $rootpath . '/include/footer.txt';
?>
