<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
//include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . '/GI/include/header.php';
?>

<div class="main-wrapper about-us">


  <!-- ====================================
  ---	BREADCRUMB
  ===================================== -->
<section class="breadcrumb-bg" style="background-image: url(assets/img/background/page-title-bg-img_06.jpg?26); ">
	<div class="container">
		<div class="breadcrumb-holder">
			<div>
				<h1 class="breadcrumb-title">学生委員とは</h1>
				<ul class="breadcrumb breadcrumb-transparent">
					<li class="breadcrumb-item">
						<a class="text-white" href="index.php">Home</a>
					</li>
					<li class="breadcrumb-item text-white active" aria-current="page">
						学生委員とは
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<?php /*?><p class="alert alert-danger mt-3">現在ページは準備中です。今しばらくお待ちください。</p><?php */?>



<!-- ====================================
---	学生委員とは
===================================== -->
<section class="py-7 py-md-10">
	<div class="container">
	
		<div class="section-title mb-4">
			<h2 id="orientation" class="text-danger ps-0">福島大学生協学生委員会とは</h2>
		</div>
		
		
		<div class="row">
			<div class="col-sm-8 col-xs-12">
				<div class="">
          <p class="text-dark font-size-15 mb-4">こんにちは！福島大学生協学生委員会です。私たちは、学生委員会は、生協の学生組合員によって運営される団体です。活動方針に基づき、組合員である学生がよりよい大学生活を送れるよう、“組合員のため”を大切にした活動を行っています。
年間を通して、「通常期班」という5つの班に分かれて、組合員の食や健康、様々な学びなどの視点から活動を行っています。</p>
        </div>
			</div>

			<div class="col-sm-4 col-xs-12">
				<div class="image mb-4 mb-md-3">
					<?php
					mobile_image( 'assets/img/gi/gi-img1.jpg', '学生委員とは', 'img-fluid rounded');
					?>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-sm-8 col-xs-12  order-md-1">
				<div class="">
										<p class="text-dark font-size-15 mb-4">また10月から5月にかけて、「新歓期班」という部局にも分かれて活動を行っています。この部局は、新入生を対象としたオリエンテーションなどの運営を中心に組合員の大学生活をより良くするために活動しています。<br />
また、福島大学内の活動に留まらず、他大学生協との関わりや、大学外の施設への視察研修など、学生委員会の活動の幅は無限大。よりよい大学生活をサポートするために、日々の努力を惜しまない組織です！</p>
        </div>
			</div>
			
			<div class="col-sm-4 col-xs-12">
				<div class="image mb-4 mb-md-0">
					<?php
					mobile_image( 'assets/img/gi/gi-img2.jpg', '学生委員とは', 'img-fluid rounded');
					?>
				</div>
			</div>
		</div>
			
			
	</div>
</section>



					<?php /* 
<!-- ====================================
---	新入生相談会
===================================== -->
<section class="py-7 py-md-10">
	<div class="container">

		<div class="section-title mb-4">
			<h2 id="soudan" class="text-danger ps-0">新入生相談会</h2>
		</div>
		
		
		<div class="row">
			<div class="col-sm-8 col-xs-12">
				<div class="">
          <p class="text-dark font-size-15 mb-4">新入生相談会は4月初めに行われ、入学してきた新入生の不安や悩みを一緒に解決する企画です。新入生は履修登録、部活・サークル活動、アルバイト、一人暮らし、恋愛などの様々な不安や悩みを抱えています。基本的には新入生と同じ学類・コースの先輩が相談に乗ってくれるので、新入生は頼れる先輩と相談することができます！</p>
        </div>
			</div>
				
				<div class="col-sm-4 col-xs-12">
					<div class="image mb-4 mb-md-3">
						<?php
						mobile_image( 'assets/img/spling/spling-img3.jpg', '新入生相談会', 'img-fluid rounded');
						?>
					</div>
				</div>

		</div>
		
		
		
		<div class="row">

			<div class="col-sm-8 col-xs-12 order-md-1">
				<div class="">
          <p class="text-dark font-size-15 mb-4">新入生相談会は学生委員会だけではなく、新入生アドバイザーと共に一丸となって行います。<br>
					私たちは相談会を通し、新入生が不安や悩みを解決して今後の学生生活がより楽しみに思ってもらえるように活動しています。さらに、新入生にとって私たち学生委員が頼れる先輩になっていたらとても嬉しいです！</p>
        </div>
			</div>
			
			<div class="col-sm-4 col-xs-12">
				<div class="image mb-4 mb-md-0">
					<?php
						mobile_image( 'assets/img/spling/spling-img4.jpg', '新入生相談会', 'img-fluid rounded');
						?>
				</div>
			</div>

		</div>
	</div>
</section>
*/ ?>

<p class="center"><a href="/GI/" class="btn_home">Topページに戻る</a></p>


</div> <!-- element wrapper ends -->




<?php
include $rootpath . '/GI/include/footer.php';
?>



