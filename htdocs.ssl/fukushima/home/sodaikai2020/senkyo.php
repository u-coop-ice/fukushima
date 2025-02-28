<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="free">

<h3>総代選挙公示</h3>

<div class="center">
<?php
if (time() < strtotime("2020-04-01 00:00:00")){
?>
<?php
mobile_image('./images/19/19senkyo.png', '総代選挙公示', 'img-responsive');
?>

<?php
} else {
?>

<?php
mobile_image('./images/20/20senkyo.png', '総代選挙公示', 'img-responsive');
?>

<?php
}
?>
</div>




</div><!--content終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>

