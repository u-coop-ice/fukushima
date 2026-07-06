<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
//include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . '/GI/include/header.php';
?>


<div class="main-wrapper home">


<!--====================================
ーーー BEGIN MAIN SLIDE LIST
===================================== -->
<section class="rev_slider_wrapper fullwidthbanner-container over" dir="ltr">

	<!-- the ID here will be used in the JavaScript below to initialize the slider -->
	<div id="rev_slider_1" class="rev_slider rev-slider-kidz-school" data-version="5.4.5" style="display:none">

		<ul>
			<!-- SLIDE 1  -->

			<li data-transition="fade">

				<?php
				mobile_image( 'assets/img/banner/slider-1/img-1.jpg', '', 'bg rev-slidebg');
				?>	
			
			
				
        <!-- LAYER NR. 1 -->
        <div class="tp-caption tp-resizeme font-dosis font-weight-bold"
          data-frames='[{
          "delay":1600,"speed":1000,"frame":"500","from":"y:-50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},
          {"delay":"wait","speed":200,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'

          data-visibility="on"
          data-x="left"
          data-y="middle"
          data-hoffset="['20', '20', '20', '20']"
          data-voffset="['80', '55', '65', '150']"
          data-fontsize="['25', '25', '25', '30']"
          data-lineheight="['50', '45', '40', '30']"
					data-color="#FFF"
          data-width="auto"
          data-basealign="grid"
          data-responsive_offset="off"
          style="z-index: 1;">
           <div class="bg-textshadow-50 pe-2 ps-2 py-0 d-none d-md-block"><span class="font-PLUS1Code">福島大学生協学生委員会とは</span></div>
        </div>
				

				
				        <!-- LAYER NR. 2 -->
        <div class="tp-caption tp-resizeme"
          data-frames='[{
          "delay":2800,"speed":1300,"frame":"500","from":"y:-50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},
          {"delay":"wait","speed":200,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'

          data-visibility="on"
          data-x="left"
          data-y="bottom"
          data-hoffset="['20', '30', '30', '20']"
          data-voffset="['140', '110', '70', '-20']"
          data-width="['950','800','700','420']"
          data-fontsize="['16', '16', '16', '21']"
          data-lineheight="['30', '25', '25', '25']"
          data-color="#FFF"
          data-textAlign="left"
          data-basealign="grid"
          data-responsive_offset="on"
          data-responsive="on"
          data-type="text"
          data-whitespace="normal"
          style="z-index: 10;">
            <div class="bg-textshadow-50 pe-2 ps-2 py-0 d-none d-md-block"><span class="font-PLUS1Code">青ブルゾンが目印の学生委員会は、組合員がより充実した大学生活を送れるように様々な活動をしている学生団体です！</span></div>
        </div>
				
											        <!-- LAYER NR. 3 -->
        <div class="tp-caption tp-resizeme"
          data-frames='[{
          "delay":4200,"speed":1300,"frame":"500","from":"y:-50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},
          {"delay":"wait","speed":200,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'

          data-visibility="on"
          data-x="left"
          data-y="bottom"
          data-hoffset="['20', '30', '30', '0']"
          data-voffset="['100', '80', '40', '70']"
          data-width="['900','800','700','420']"
          data-fontsize="['16', '16', '16', '21']"
          data-lineheight="['30', '25', '25', '25']"
          data-color="#FFF"
          data-textAlign="left"
          data-basealign="grid"
          data-responsive_offset="on"
          data-responsive="on"
          data-type="text"
          data-whitespace="normal"
          style="z-index: 10;">
            <div class="bg-textshadow-50 pe-2 ps-2 py-0 d-none d-md-block"><span class="font-PLUS1Code">学生・生協・職員の皆さんの想いを繋げられる架橋となれるように日々活動しています。</span></div>
        </div>
			</li>
			
			<!-- SLIDE 2  -->
			<li data-transition="fade">
				<?php
				mobile_image( 'assets/img/banner/slider-1/img-2.jpg', '', 'rev-slidebg');
				?>
			</li>
			<!-- SLIDE 3  -->
			<li data-transition="fade">
				<?php
				mobile_image( 'assets/img/banner/slider-1/img-3.jpg', '', 'rev-slidebg');
				?>
			</li>
			<!-- SLIDE 4  -->
			<li data-transition="fade">
				<?php
				mobile_image( 'assets/img/banner/slider-1/img-4.jpg', '', 'rev-slidebg');
				?>
			</li>
			<!-- SLIDE 5  -->
			<li data-transition="fade">
				<?php
				mobile_image( 'assets/img/banner/slider-1/img-5.jpg', '', 'rev-slidebg');
				?>
			</li>
			<!-- SLIDE 6  -->
			<li data-transition="fade">
				<?php
				mobile_image( 'assets/img/banner/slider-1/img-6.jpg', '', 'rev-slidebg');
				?>
			</li>
			<!-- SLIDE 7  -->
			<li data-transition="fade">
				<?php
				mobile_image( 'assets/img/banner/slider-1/img-7.jpg', '', 'rev-slidebg');
				?>
			</li>

		</ul>
	</div>
</section>



<section class="d-block d-md-none mt-0  wow fadeInUp bg-dark-50 py-5">
<div class="container">
<h3><span class="font-PLUS1Code">福島大学生協学生委員会とは</span></h3>
 <span class="font-PLUS1Code">青ブルゾンが目印の学生委員会は、組合員がより充実した大学生活を送れるように様々な活動をしている学生団体です！</span>
 <span class="font-PLUS1Code">学生・生協・職員の皆さんの想いを繋げられる架橋となれるように日々活動しています。</span>
 </div>
</section>


<!-- ====================================
ーーー	BOX SECTION
===================================== -->
<section class="d-none d-md-block section-top">
  <div class="container">
    <div class="row wow fadeInUp">
      <div class="col-sm-3">
				<a href="#spring">
					<div class="card bg-pink card-hover">
						<div class="card-body text-center p-0">
							<div class="card-icon-border-large border-pink">
							<?php
							mobile_image( 'assets/img/icon/icon_1.svg', '春アイコン', '');
							?>
							</div>
							<h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Spring</h2>
							<div  class="btn-scroll-down d-block pb-4 pb-lg-5">
								<i class="fas fa-chevron-down" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</a>
      </div>

      <div class="col-sm-3">
				<a href="#summer">
					<div class="card bg-success card-hover">
						<div class="card-body text-center p-0">
							<div class="card-icon-border-large border-success">
								<?php
								mobile_image( 'assets/img/icon/icon_2.svg', '夏アイコン', '');
								?>
							</div>
							<h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Summer</h2>
							<div class="btn-scroll-down d-block pb-4 pb-lg-5">
								<i class="fas fa-chevron-down" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</a>
      </div>

      <div class="col-sm-3">
				<a href="#autumn">
					<div class="card bg-danger card-hover">
						<div class="card-body text-center p-0">
							<div class="card-icon-border-large border-danger">
								<?php
								mobile_image( 'assets/img/icon/icon_3.svg', '秋アイコン', '');
								?>
							</div>
							<h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Autumn</h2>
              <div href="#autumn" class="btn-scroll-down d-block pb-4 pb-lg-5">
                <i class="fas fa-chevron-down" aria-hidden="true"></i>
              </div>
						</div>
					</div>
				</a>
      </div>

      <div class="col-sm-3">
				<a href="#winter">
					<div class="card bg-info card-hover">
						<div class="card-body text-center p-0">
							<div class="card-icon-border-large border-info">
								<?php
								mobile_image( 'assets/img/icon/icon_5.svg', 'その他アイコン', '');
								?>
							</div>
							<h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Winter･Others</h2>
							<div href="#winter" class="btn-scroll-down d-block pb-4 pb-lg-5">
								<i class="fas fa-chevron-down" aria-hidden="true"></i>
							</div>
						</div>
					</div>
				</a>
      </div>
    </div>
  </div>
</section>






<?php /*
<section class="pt-9 pb-6 py-md-7 d-none d-sm-block">
	<div class="container">
		<div id="twitter">
			<div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
				<h2 class="text-danger">お知らせ</h2>
				<p class="">News</p>
			</div>
			
			


			<a class="twitter-timeline" data-height="600" href="https://twitter.com/fukudai01?ref_src=twsrc%5Etfw"><u>Tweets by fukudai01</u></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			
			<div class="rev_ind lh11">※Xタイムラインを表示するには、Xにログインする必要があります。</div>
			<p><a href="https://twitter.com/i/flow/signup" class="btn btn-primary btn-sm em09">Xサインアップまたはログインはこちら</a></p>
		</div><!-- X -->
	</div>
</section>

<section class="pt-9 pb-6 py-md-7 d-block d-sm-none">
	<div class="container">
		<div id="twitter">
			<div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
				<h2 class="text-danger">お知らせ</h2>
				<p class="">News</p>
			</div>
			<a class="twitter-timeline" data-height="400" href="https://twitter.com/fukudai01?ref_src=twsrc%5Etfw"><u>Tweets by fukudai01</u></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			
			<br>
			<div class="X">
<a class="btn btn-primary btn-block" onclick="ga('send', 'event', 'text', 'click', '福島大学生協学生委員会twitter - /index.php');" href="https://twitter.com/fukudai01?ref_src=twsrc%5Etfw" target="_blank">
<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

<path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
</svg>
福島大学生協学生委員会 ポストを見る</a>
</div>

		</div><!-- X -->
	</div>
</section>
 */ ?>








<!-- ====================================
ーーー	HOME FEATURE
===================================== -->
<section class="pt-9 pb-6 py-md-7">
  <div class="container">
    <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
      <h2 id="spring" class="text-danger"><a href="./spring.php">春の活動</a></h2>
								<p class="text-center font-dosis">Spring</p>
    </div>


    <div class="row wow fadeInUp">
			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-pink me-xl-4">
					<a href="./spring.php#orientation">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-pink"><a href="./spring.php#orientation">生協オリエンテーション</a></h3>
            <p>入学式直前に行われる新入生のための企画です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-pink me-xl-4">
					<a href="./spring.php#soudan">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-pink"><a href="./spring.php#soudan">おはなし会・相談会</a></h3>
												<p>おはなし会は、新入生同士が楽しく交流し新たな繋がりを作る場にしてもらうことを目的とした企画です。<br />相談会は、不安や相談したいことを先輩たちに気軽に聞くことで今後の学校生活を楽しみにしてもらうことを目的とした企画です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-pink me-xl-4">
					<a href="./spring.php#otameshi">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-pink"><a href="./spring.php#otameshi">おためし部会</a></h3>
            <p>学生委員会の活動のひとつである「部会」に参加してもらうことで、その魅力や活動内容を実感してもらうことを目的とした企画です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-pink me-xl-4">
					<a href="./spring.php#soudai">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-pink"><a href="./spring.php#soudai">総代会</a></h3>
            <p>1年間の生協運営を決めるとても重要な会議で、私たち組合員が入学時に支払った出資金を、今後どのように使用していくか意見交流する場です。</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



<!-- ====================================
ーーー	HOME FEATURE
===================================== -->
<section class="pt-9 pb-6 py-md-7">
  <div class="container">
    <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
      <h2 id="summer" class="text-danger"><a href="./summer.php">夏の活動</a></h2>
											<p class="text-center font-dosis">Summer</p>
    </div>
		
		
    <div class="row wow fadeInUp">
			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-success me-xl-4">
					<a href="./summer.php">
						<?php
						mobile_image( 'assets/img/icon/icon_2_w.svg', '夏アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-success"><a href="./summer.php#op">オープンキャンパス</a></h3>
            <p>来場者の皆さんに簡潔に情報を伝えること、そしてオープンキャンパスそのものを楽しんでもらうことに重点を置いて活動してきました。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-success me-xl-4">
					<a href="./summer.php#meguri">
						<?php
						mobile_image( 'assets/img/icon/icon_2_w.svg', '夏アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-success"><a href="./summer.php#meguri">夏休みにふくしまを巡ろうヨ！</a></h3>
            <p>学生委員に福島県の魅力を再認識してもらい、夏休みに自ら福島県を巡るきっかけ作りを目的とした学習会です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-success me-xl-4">
					<a href="./summer.php#comell">
						<?php
						mobile_image( 'assets/img/icon/icon_2_w.svg', '夏アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-success"><a href="./summer.php#comell">Come&apos;llワークショップ</a></h3>
            <p>Come&apos;llに込められた想いや秘密を知り、魅力を伝えていくために、ワークショップを実施しました。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-success me-xl-4">
					<a href="./summer.php#sus">
						<?php
						mobile_image( 'assets/img/icon/icon_2_w.svg', '夏アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-success"><a href="./summer.php#sus">Summer Up Seminar</a></h3>
            <p>毎年夏に開催される東北各地の学生委員と生協職員が集まるセミナーです。</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ====================================
ーーー	HOME FEATURE
===================================== -->
<section class="pt-9 pb-6 py-md-7">
  <div class="container">
    <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
      <h2 id="autumn" class="text-danger"><a href="./autumn.php">秋の活動</a></h2>
											<p class="text-center font-dosis">Autumn</p>
    </div>


    <div class="row wow fadeInUp">
			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-danger me-xl-4">
					<a href="./autumn.php#kyosai">
						<?php
						mobile_image( 'assets/img/icon/icon_3_w.svg', '秋アイコン', 'nav-icon');
						?>
					</a>
					</div>

          <div class="media-body">
            <h3 class="text-danger"><a href="./autumn.php#kyosai">福大版秋の共済セミナー</a></h3>
            <p>福島大学生協の学生スタッフが集まり共済について考えるセミナーです。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-danger me-xl-4">
					<a href="./autumn.php#comellg">
						<?php
						mobile_image( 'assets/img/icon/icon_3_w.svg', '秋アイコン', 'nav-icon');
						?>
					</a>
					</div>

          <div class="media-body">
            <h3 class="text-danger"><a href="./autumn.php#comellg">Come&apos;ll学習会</a></h3>
            <p>事前に実施したCome&apos;llワークショップで学んだ内容をより多くの人に伝えていくため、Come&apos;ll学習会を実施しました。</p>
          </div>
        </div>
      </div>


    </div>
  </div>
</section>



<!-- ====================================
ーーー	HOME FEATURE
===================================== -->
<section class="pt-9 pb-6 py-md-7">
  <div class="container">
    <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
      <h2 id="winter" class="text-danger"><a href="./other.php">冬･その他の活動</a></h2>
											<p class="text-center font-dosis">Winter･Others</p>
    </div>

    <div class="row wow fadeInUp">
			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-info me-xl-4">
					<a href="./other.php#gasshuku">
						<?php
						mobile_image( 'assets/img/icon/icon_4_w.svg', '冬アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-info"><a href="./other.php#investment">投資学習会</a></h3>
            <p>投資や資産運用を身近に感じてもらうことを目的とした学習会です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-info me-xl-4">
					<a href="./other.php#love">
						<?php
						mobile_image( 'assets/img/icon/icon_4_w.svg', '冬アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-info"><a href="./other.php#mbti">MBTIの学習会</a></h3>
            <p>MBTIを通してお互いの価値観の理解を深め、認め合うことの大切さを伝えていくために実施しました。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-info me-xl-4">
					<a href="./other.php#tuujyou_shinkan">
						<?php
						mobile_image( 'assets/img/icon/icon_4_w.svg', '冬アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-info"><a href="./other.php#kachikan"><span class="em09">共済学習会</span></a></h3>
            <p>共済推進委員資格の取得を目指す学習会です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-info me-xl-4">
					<a href="./other.php#oosouji">
						<?php
						mobile_image( 'assets/img/icon/icon_4_w.svg', '冬アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-info"><a href="./other.php#oosouji"><span class="em09">大掃除学習会</span></a></h3>
            <p>組合員に自立した生活を送れるようになってほしいという思いから企画されました。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-info me-xl-4">
					<a href="./other.php#tuujyou_shinkan">
						<?php
						mobile_image( 'assets/img/icon/icon_5_w.svg', 'その他アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-info"><a href="./other.php#tuujyou_shinkan"><span class="em09">通常期・新歓期の活動風景</span></a></h3>
												<p>充実した日々を送れるようサポートする活動を行っています。</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



</div> <!-- element wrapper ends -->



<?php
include $rootpath . '/GI/include/footer.php';
?>


