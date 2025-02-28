<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>



<link type="text/css" href="/css/base_home_new.css" rel="stylesheet" media="screen,print" />

<link type="text/css" href="<?php fp_ft('./css/ucapp.css'); ?>" rel="stylesheet" media="screen,print" />




<?php
include $rootpath . 'include/header2.txt';
?>

<h2 id="title_store">大学生協アプリ</h2>



<div id="main2">



<?php
$whatsnew = new whatsnew_bootstrap();
$whatsnew->setHeader(0);
$whatsnew->setLog(
	array('../../../data/whatsnewdata.xml'));
$whatsnew->setCoop('fukushima');
$whatsnew->setBefore(360);
?>

<?php
$whatsnew->setKey('ucapp');
if ($whatsnew->getList()) {
	echo '<h3 id="information">Information</h3>';
	echo $whatsnew->getList();
	

} else {
	echo '<h3 id="information">Information</h3><p class="alert alert-info">現在表示する項目はありません。</p>';
}
?>



<br>


<div class="row">

<div class="col-sm-2 col-sm-offset-0 col-xs-4 col-xs-offset-4 col-sm-push-10 ">
<?php
mobile_image('./images/ucapp_01.png', '', 'img-responsive img');
?>
</div>


<div class="col-sm-10 col-sm-pull-2 col-xs-12"

>
<div class="row">

<div class="col-sm-6">

<a href="https://krm-system.powerappsportals.com/" target="_blank">
<div class="contact yellow r20">
												<p class="em12 bold center"><span class="under yellow_underline">生協マイポータル
はこちら <i class="fa fa-fw fa-external-link"></i></span></p>
												<p>利用履歴の確認ができます！</p>
										</div>
										</a>

</div>

<div class="col-sm-6">

<a href="https://www.tohoku-ba.u-coop.or.jp/press/ucapp/" target="_blank">
<div class="contact blue r20">
												<p class="em12 bold center"><span class="under blue_underline">大学生協アプリ登録方法はこちら <i class="fa fa-fw fa-external-link"></i></span></p>
												<p>早めにご登録ください！</p>
										</div>
</a>
</div>

<div class="col-sm-6">
<a href="https://www.tohoku-ba.u-coop.or.jp/press/ucapp/pdf/22ucapp_hogosha_01.pdf" target="_blank">
<div class="contact orange r20">
												<p class="em12 bold center"><span class="under orange_underline">保護者様向けのご案内･手順はこちら <i class="fa fa-file-pdf-o"></i></span></p>
												<p>お子様の利用履歴が確認できます！</p>
										</div>
</a>
</div>
</div>

</div>



</div>

<br>

<p>登録中にエラーが発生する場合こちらの対処フローでご対応ください。</p>
<p><a class="btn btn-info btn-sm em09" href="https://www.tohoku-ba.u-coop.or.jp/press/ucapp/pdf/flow.pdf" target="_blank">対処方法（保護者以外）フロー<i class="fa fa-file-pdf-o"></i></a></p>
<br>

<p>その他エラーが発生する場合は福島大学生協公式LINEまでご連絡ください</p>
<p><a class="btn btn-success btn-sm em09" href="https://page.line.me/249saoqq?openQrModal=true" target="_blank">福島大学生協公式LINE<i class="fa fa-fw fa-external-link"></i></a>
</p>

<br><br>

<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-reply"></i>トップへ戻る</a>
</p>



<div class="clear"></div>


</div><!-- end of main -->

<?php
include $rootpath . '/include/footer.txt';
?>
