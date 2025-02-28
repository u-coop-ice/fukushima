<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link type="text/css" href="/css/animate.css" rel="stylesheet" media="screen,print" />
<link type="text/css" href="./css/about.css" rel="stylesheet" media="screen,print" />

<script type="text/javascript" src="/js/wow.min.js"></script>
<script>
new WOW().init();
</script>



<?php
include $rootpath . 'include/header2.txt';
?>

<h2 id="title_about">福島大学生協とは</h2>

<div id="main2">

<?php
include './inc/btn_univ.txt';
?>



<div class="box_yellow">
<h3 id="coop" class="bold em16">福島大学生協とは</h3>
<ul class="tri">
<li>大学生協は組合員一人ひとりの加入と参加によって成り立っています。<br />
出資金をお預かりし、それをもとに組合員の皆さまに様々な商品やサービスを提供しています。</li>
<li>福島大学より業務委託を受けてお部屋探し、新生活準備、学生生活、学生食堂、教科書販売、学生・教職員の福利厚生を担っています。</li>
<li>みんなが「協同」して支えあう、それが大学生協です。</li>
</ul>
</div>

<div class="box_green">
<h4>福島大学生協の役割</h4>
<p class="">福島大学生協は福島大学より業務委託を受けて、<br />
<strong class="deepblue"><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>お部屋探し&nbsp;
<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>新生活準備&nbsp;
<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>学生生活&nbsp;
<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>学生食堂&nbsp;
<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>教科書販売&nbsp;
<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>学生・教職員の福利厚生</strong>&nbsp;を担っています。</p>
</div>

<div class="container-fluid">
<div class="row wow animated fadeInUp">
<div class="col-sm-10 col-sm-offset-1">
<h4>福島大学生協の仕組み</h4>
<?php
mobile_image('./images/about_001.png', '福島大学生協の仕組み', 'img-responsive');
?>
</div>
</div>
</div>


<div class="box_yellow_line">
<span class="lead"><strong class="red">50口20,000円</strong>の出資をお願いいたします。<br />
福島大学生協は組合員からお預かりした出資金で運営されています。</span>

<dl>
<dt class="">【加入を希望される方】</dt>
<dt>◆新入生</dt>
<dd>福島大学生協の資料を請求された方には合格時にお送りする書類に「加入申込書」を同封しています。<br />
お手元にない方は生協本部(TEL:024-548-5141)までご連絡ください。</dd>

<dt>◆在校生　◆教職員</dt>
<dd>生協本部までお越しください。</dd>
</dl>

<span class="lead">出資金は卒業時(脱退時)に定款の定めに基づき返還いたします。</span>

<p><a class="btn btn-default btn-sm" href="/graduate/"><span class="black">卒業（脱退）についてはこちら <i class="fa fa-fw fa-chevron-right"></i></span></a></p>
</div>


<br />


<div class="row wow animated fadeInUp">
<div class="center lead bold">お手続きの際は生協本部までお越しください。</div>
<div class="col-xs-8 col-xs-offset-2">

<?php
mobile_image("/insurance/images/insurance_top.jpg", "生協本部", 'img-responsive');
?>
</div>
</div>




<?php /*
<h3 class="right_line"><span>新入生の方へ</span></h3>
<p>ご加入の際は「加入申込書」を記入していただき、福島大学生協へご提出ください。
<span class="rev_ind">※加入申込書は福島大学生協に資料請求された方には合格時に発送される書類に同封されています。</span></p>
<ul>
<li>サポートセンターご来場予定方･･････ご来場時に記入申込みを行うことができます。</li>
<li>郵送をご希望の方･･････同封の封筒にいれて送付ください。</li>
</ul>
<hr class="double_line">
*/ ?>




<br>
<h3>出資金Q&amp;A</h3>

<div class="row">
<div class="col-sm-10 col-sm-offset-1">

<table>
<tr><td><img src="./images/img_q.png" width="35" height="35" alt="" /></td><td style="vertical-align:middle;"><strong>なぜ、組合員になるのに出資金が必要なのですか?</strong></td></tr>
<tr><td><img src="./images/img_a.png" width="35" height="35" alt="" /></td><td>生協は構成員(組合員)自身が協同して、より良い生活を目指す自主的な組織です。その事業は、組合員みんなが少しずつお金を出し合って支えられています。出資金は事業活動の元手として、設備資金や、商品の仕入れの為の運用資金として使われていますが、その出資金があってはじめて、生協は様々な事業活動を行うことができるのです。</td></tr>

<tr><td><img src="./images/img_q.png" width="35" height="35" alt="" /></td><td style="vertical-align:middle;"><strong>なぜ50口20,000円なのですか?</strong></td></tr>
<tr><td><img src="./images/img_a.png" width="35" height="35" alt="" /></td><td>福島大学生協の出資金の1口は定款の規定では400円ですが、生協の事業活動の内容が約60年前の設立当時から年々拡大しています。その結果、事業活動に必要とされる資金量も多くなっています。現在の事業規模と組合員数を考慮し、一人あたり50口20,000円の出資をお願いしております。</td></tr>

<tr><td><img src="./images/img_q.png" width="35" height="35" alt="" /></td><td style="vertical-align:middle;"><strong>組合員にならないと生協のお店は利用できないのですか?</strong></td></tr>
<tr><td><img src="./images/img_a.png" width="35" height="35" alt="" /></td><td>生協は組合員による組合員のための組織で、生協の事業は組合員の出資金により支えられています。生協店舗やサービスをご利用になるには、原則としてまず生協にご加入いただく必要があります。</td></tr>
</table>
</div>
</div>




<div class="row">
<div class="col-sm-10">
<div class="box_yellow">
<h3 id="ucapp" class="bold em16">アプリで組合員証</h3>
<p>スマホアプリが組合員証になります。</p>
<ul>
<li>レジの支払いは大学生協アプリのスマホアプリ決済が可能です。</li>
<li>生協電子マネーのチャージや残高照会が可能です</li>
<li>営業時間、お問い合わせ、住所変更などにアクセスができます。</li>
</ul>
</div>
</div>

<div class="col-sm-2">
<div class="row wow animated fadeInUp">
<div class="center">
<?php
mobile_image("./images/about_ucapp.jpg", "アプリ（サンプル画像）", 'img-responsive img');
?>
</div>
</div>
</div>
</div><!-- /row -->



<div class="row">
<div class="col-sm-4">

<div class="panel panel-info thumbnail">
<div class="panel-heading">
<strong class="lead">プリペイド機能</strong>
</div>
<div class="panel-body">
事前にチャージをしておけばレジでかざすだけでお会計ができます。<br />
チャージを希望される場合は生協店舗のレジにてお声がけください。
</div>
</div>

</div>
<div class="col-sm-4">

<div class="panel panel-warning thumbnail">
<div class="panel-heading">
<strong class="lead">ミールプラン機能</strong>
</div>
<div class="panel-body">
ミールプランをお申込みいただくと、アプリにミールプランの機能が付きます。<br />お財布の中身を気にすることなく生協食堂でバランスよく食事ができます。
</div>
</div>

</div>
<div class="col-sm-4">

<div class="panel panel-success thumbnail">
<div class="panel-heading">
<strong class="lead">ポイント機能</strong>
</div>
<div class="panel-body">
対象商品などを購入の際に電子マネーで支払うことでポイントが付きます。<br />お買い上げレシートやアプリの決済画面で確認ができます。
</div>
</div>

</div></div>

<br />



<div class="box_yellow">
<h3 id="store" class="bold em16">福島大学生協の店舗紹介</h3>
</div>

<h4 class="page-header">大学会館1F食堂 Dining ReaF（リーフ）</h4>

<div class="row">
<div class="col-sm-offset-2 col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/univcoop01.jpg', 'Dining ReaF（リーフ）の写真', 'img-responsive gallery');
?>

</div>
<div class="col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/univcoop02.jpg', 'Dining ReaF（リーフ）の写真2', 'img-responsive gallery');
?>
</div>

</div><!--/row-->

<table>
<tr>
<td style="width:90px;padding-left:0;">
<?php
mobile_image('./images/meal_ok_icon.png', 'ミールカード使えますアイコン', 'img-responsive gallery');
?>
</td>
<td>
<p>お昼はもちろん、サークル終わるなど夜を食べて帰宅する人も多いです。<br>
毎日多忙な大学生活を送ることになる福島大学の学生にとって、息抜きのできる楽しい食堂でありたいと願い、フレンドリーで温かい、学生一人ひとりに寄り添った食堂を目指しています。<br>
<a href="https://www.fukushima.u-coop.or.jp/foodservice/reaf/" class="btn btn-sm btn-primary em09">くわしくはこちら <i class="fa fa-fw fa-chevron-right"></i></a>
</p>
</td>
</tr>
</table>

<div class="clear"></div>



<h4 class="page-header">大学会館2F　Quick Lunch グリーン</h4>
<div class="row">
<div class="col-sm-offset-2 col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/univcoop04.jpg', 'Quick Lunch グリーンの写真1', 'img-responsive gallery');
?>
</div>


<div class="col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/univcoop05.jpg', 'Quick Lunch グリーンの写真2', 'img-responsive gallery');
?>
</div>

</div><!--/row-->

<table>
<tr>
<td style="width:90px;padding-left:0;">
<?php
mobile_image('./images/meal_ok_icon.png', 'ミールカード使えますアイコン', 'img-responsive gallery');
?>
</td>
<td><p>あたたかい、できたてのお弁当をテイクアウトすることができます。またイートインスペースもありますので、店内で召し上がることも可能です。<br>
温かいお弁当の他にサラダやお総菜もあり、食事バランスを考えた組み合わせができます。<br>
<a href="https://www.fukushima.u-coop.or.jp/foodservice/green/" class="btn btn-sm btn-primary em09">くわしくはこちら <i class="fa fa-fw fa-chevron-right"></i></a><br>
<a href="http://www.fukushima.u-coop.or.jp/foodservice/" class="btn btn-sm btn-primary em09" target="_blank">メニューのアレルギーについてはこちら<i class="fa fa-fw fa-external-link"></i></a></p></td>
</tr>
</table>



<h4 class="page-header">購買店 Re:act（リアクト）</h4>
<p>&#9679;コンビニ&nbsp;&#9679;生協パソコン修理&nbsp;&#9679;官製品&nbsp;&#9679;自動車学校&nbsp;&#9679;語学研修や留学の相談&nbsp;&#9679;新入生向け/公務員&nbsp;&#9679;各種検定申込み&nbsp;&#9679;書籍&nbsp;など</p>
<div class="row">
<div class="col-sm-offset-2 col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/univcoop07.jpg', '購買店の写真1', 'img-responsive gallery');
?>
</div>

<div class="col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/univcoop08.jpg', '購買店の写真2', 'img-responsive gallery');
?>
</div>

</div><!--/row-->

<p>お弁当、飲料、お菓子などを販売しているコンビニ店と旅行、切手、自動車学校などを販売しているサービス店が一緒になった複合店です。生協でパソコンなどを購入された方へのサポートはこちらになります。その他、講義などで必要になってくる教材も販売しております。<br>
</p>
<div class="clear"></div>



<h4 class="page-header">本部・不動産部</h4>
<p>アパートの相談・学生総合共済、保険窓口</p>

<div class="row">
<div class="col-sm-offset-2 col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/about_honbu1.jpg', '本部外観', 'img-responsive gallery');
?>
</div>

<div class="col-sm-4 wow animated fadeInUp">
<?php
mobile_image('./images/about_honbu2.jpg', '本部窓口', 'img-responsive gallery');
?>
</div>
</div><!--/row-->

<p>学生総合共済の加入手続き及び給付申請ができます。何かあったらまずは生協本部までお越しください。</p>

<div class="row">
<div class="col-sm-6">
<p><a href="/store/time/" class="btn btn-primary btn-block"><i class="fa fa-clock-o" aria-hidden="true"></i> 福島大学生協の店舗営業時間はこちら<i class="fa fa-fw fa-chevron-right"></i></a></p>
</div>
</div>

<br />

<p><a class="btn btn-primary" href="/"><i class="fa fa-fw fa-reply"></i>TOPページに戻る</a></p>

<div class="clear"></div>


</div><!-- end of main -->

<?php
include $rootpath . '/include/footer.txt';
?>
