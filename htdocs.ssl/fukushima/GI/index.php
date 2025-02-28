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
					<div class="card bg-primary card-hover">
						<div class="card-body text-center p-0">
							<div class="card-icon-border-large border-primary">
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


<section class="pt-9 pb-6 py-md-7 d-none d-sm-block">
	<div class="container">
		<div id="twitter">
			<div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
				<h2 class="text-danger">お知らせ</h2>
				<p class="">News</p>
			</div>
			<a class="twitter-timeline" data-height="600" href="https://twitter.com/fukudai01?ref_src=twsrc%5Etfw">Tweets by fukudai01</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div><!-- twitter -->
	</div>
</section>

<section class="pt-9 pb-6 py-md-7 d-block d-sm-none">
	<div class="container">
		<div id="twitter">
			<div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
				<h2 class="text-danger">お知らせ</h2>
				<p class="">News</p>
			</div>
			<a class="twitter-timeline" data-height="400" href="https://twitter.com/fukudai01?ref_src=twsrc%5Etfw">Tweets by fukudai01</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div><!-- twitter -->
	</div>
</section>


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
					<div class="media-icon-large bg-primary me-xl-4">
					<a href="./spring.php#orientation">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-primary"><a href="./spring.php#orientation">生協オリエンテーション</a></h3>
            <p>生協オリエンテーションは3月の末に行われる新入生のための企画です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-primary me-xl-4">
					<a href="./spring.php#soudan">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-primary"><a href="./spring.php#soudan">新入生相談会</a></h3>
            <p>新入生相談会は4月初めに行われ、入学してきた新入生の不安や悩みを一緒に解決する企画です。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-primary me-xl-4">
					<a href="./spring.php#soudai">
						<?php
						mobile_image( 'assets/img/icon/icon_1_w.svg', '春アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-primary"><a href="./spring.php#soudai">総代会</a></h3>
            <p>総代会は1年間の生協運営を決めるとても重要な会議です。</p>
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
            <p>福島大学のオープンキャンパスにおいて、来場した高校生と保護者に福大生の生活を紹介しています。</p>
          </div>
        </div>
      </div>

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
            <h3 class="text-success"><a href="./summer.php#riripack">リリパック工場見学</a></h3>
            <p>学食のお持ち帰りに使われている容器リ・リパックをリサイクル、生産している工場の見学に行きました。</p>
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
            <p>Summer Up Seminarは毎年夏に開催される東北各地の学生委員と生協職員が集まるセミナーです。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-success me-xl-4">
					<a href="./summer.php#heiwa">
						<?php
						mobile_image( 'assets/img/icon/icon_2_w.svg', '夏アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-success"><a href="./summer.php#heiwa">平和学習</a></h3>
            <p>学生委員会では平和に関する学習も行っています。</p>
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
					<a href="./autumn.php">
						<?php
						mobile_image( 'assets/img/icon/icon_3_w.svg', '秋アイコン', 'nav-icon');
						?>
					</a>
					</div>

          <div class="media-body">
            <h3 class="text-danger"><a href="./autumn.php">秋の健康フェスタ</a></h3>
            <p>秋の健康フェスタは福大祭スポーツフェスティバル期間中に開催される学生委員会と新入生アドバイザーの共同企画です。</p>
          </div>
        </div>
      </div>



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
            <h3 class="text-danger"><a href="./autumn.php#kyosai">秋の共済セミナー</a></h3>
            <p>東北版秋の共済セミナーは、東北各地の大学の学生委員とアドバイザーと生協職員が集まり、共済について考えるセミナーです。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-danger me-xl-4">
					<a href="./autumn.php#shinsai">
						<?php
						mobile_image( 'assets/img/icon/icon_3_w.svg', '秋アイコン', 'nav-icon');
						?>
					</a>
					</div>

          <div class="media-body">
            <h3 class="text-danger"><a href="./autumn.php#shinsai">震災学習</a></h3>
            <p>福島大学生協学生委員会では震災関連施設を訪問しました。</p>
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
            <h3 class="text-info"><a href="./other.php#gasshuku">学委集中会議</a></h3>
            <p>年度方針や今後の活動計画について、丸一日を使って検討する会議です。立場や学年関係なく、もっとよくするために真剣な議論を行います。学生委員会の活動を考える重要な場面です！</p>
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
            <h3 class="text-info"><a href="./other.php#love">LOVE is COMMUNICATION</a></h3>
            <p>恋愛と就職活動なんて結びつきあるの？と思うかもしれません。ですが、「相手を知ることは企業分析」、「告白することは面接で自分の思いを伝えること」など意外なところで共通点がたくさんあります！</p>
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
            <h3 class="text-info"><a href="./other.php#tuujyou_shinkan"><span class="em09">通常期･新歓期の活動風景</span></a></h3>
            <p>通常期では、4つの班に分かれ調査、アンケートの実施や学習会を行っています。新歓期の活動は主に新入生を対象とした活動を行っています。</p>
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
            <h3 class="text-info"><a href="./other.php#kachikan"><span class="em09">価値観の学習会</span></a></h3>
            <p>お題をグループで話し合うことで、お互いが持つ多様な価値観について知り、認め合う大切さを学びました。</p>
          </div>
        </div>
      </div>

			<!-- Media -->
      <div class="col-sm-6 col-xl-4 col-xs-12">
        <div class="media mb-6">
					<div class="media-icon-large bg-info me-xl-4">
					<a href="./other.php#bousai">
						<?php
						mobile_image( 'assets/img/icon/icon_5_w.svg', 'その他アイコン', 'nav-icon');
						?>
					</a>
					</div>
          <div class="media-body">
            <h3 class="text-info"><a href="./other.php#bousai"><span class="em09">防災学習会</span></a></h3>
            <p>1人ひとりが災害への備えを具体的に考える機会となりました。</p>
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


