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
if (time() < strtotime("2020-05-01 00:00:00")){
?>

<h3>2019年度 通常総代会招集通知</h3>
<div class="center">
<?php
mobile_image('./images/19/19shoushuu.png', '2019年度 通常総代会招集通知', 'img-responsive');
?>
</div>

<?php
} else {
?>

<h3>2020年度 通常総代会招集通知</h3>
<div class="center">
<?php
mobile_image('./images/20/20notice.png', '2020年度 通常総代会招集通知', 'img-responsive');
?>
</div>

<?php
}
?>


</div><!--content終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>

