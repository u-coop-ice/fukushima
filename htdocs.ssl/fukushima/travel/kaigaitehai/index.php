<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link rel="stylesheet" href="./css/kaigaitehai.css" type="text/css" media="screen,print" />

<?php
include $rootpath . 'include/header2.txt';
?>



<div id="main2">
<br>
<h2>海外航空券手配</h2>
<div class="lineh18">
<p class="em11">いつも福島大学生協をご利用いただき誠にありがとうございます。<br>
生協店舗へ来店不要で、海外航空券手配を承ります。</p>
</div>


<div class="module module-yellow em12">
	<p class="em14 bold">ご利用の流れ</p>
		<div class="frame_number top_space30">
			<p class="em11 bold"><span class="square size_normal yellow1 letter1">1</span>お問い合わせ・お申込み</p>
		</div>
			<div class="content_inner">
				<a href="https://www.odekake.coop/kaigaitehai/" class="top_space20 btn btn-info em10" >お問い合わせ・お申込みはこちらから <i class="fa fa-fw fa-external-link"></i></a>
				<div class="top_space20">
				<?php
				mobile_image("./images/kaigaitehai_01.png", "", "img-responsive");
				?>
				</div>
				<p>&rArr;「問い合わせ」フォームに入力して送信</p>
			</div>
		<div class="frame_number top_space30">
			<p class="em11 bold"><span class="square size_normal yellow1 letter1">2</span>手配・回答</p>
		</div>
			<div class="content_inner">
				<p class="rev_ind">&#10112;ご要望に沿って手配、または提案いたします。</p>
				<p class="rev_ind">&#10113;当日中にメールにて回答します。<br>
				<span class="rev_ind">※手配センター休業日や16時以降のお問い合わせは翌営業日の回答になります。</span>
				<span class="rev_ind">※お問い合わせ内容によってはお時間をいただく場合があります。</span></p>
			</div>
		<div class="frame_number top_space30">
			<p class="em11 bold"><span class="square size_normal yellow1 letter1">3</span>ご精算方法</p>
		</div>
		<div class="content_inner">
			<p>　クレジットカードにてお支払いください。入金確認でき次第、メールにてEチケットを送付いたします。<br>
			校費のお取り扱いも可能です。(校費ご利用の場合には、生協カウンターにご相談ください)</p>
		</div>
	<br>
	<p class="em14 bold top_space30">取扱内容</p>
		<div class="content_inner">
		<p>
		<span class="bold">&#9678;海外航空券</span><br>
		・日本発着の航空券（エコノミー／ビジネスクラス、他）<br>
		・海外発着航空券<br>
		・海外発日本行航空券
		</p>
		</div>
</div>




<div class="clear"></div>

<p><a class="btn btn-primary" href="/travel/"><i class="fa fa-fw fa-reply"></i>旅行トップに戻る</a></p>

</div><!-- main -->



<?php
include $rootpath . '/include/footer.txt';
?>
