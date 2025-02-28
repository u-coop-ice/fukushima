<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">

<h2 id="cat2_whatsnew">What&#039;s new</h2>

<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setlog(array('../../../data/whatsnewdata.xml'));
$whatsnew->setCoop('fukushima');
$whatsnew->setKey('ALL,!private');
$whatsnew->setBefore(365);
echo $whatsnew->getList();
?>

<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-reply"></i>トップへ戻る</a></p>

</div><!-- /content -->

<div class="clear">*</div>



<?php
include $rootpath . '/include/footer.txt';
?>
