<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="free">


<?php
if (time() < strtotime("2020-04-01 00:00:00")){
?>

<h3>第88回通常総代会告示</h3>
<div class="center">
<?php
mobile_image('./images/19/19sodaikai.png', '通常総代会告示', 'img-responsive');
?>
</div>

<?php
} else {
?>

<h3>第89回通常総代会告示</h3>
<div class="center">
<?php
mobile_image('./images/20/20sodaikai.png', '通常総代会告示', 'img-responsive');
?>
</div>

<?php
}
?>



</div><!--content終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>
