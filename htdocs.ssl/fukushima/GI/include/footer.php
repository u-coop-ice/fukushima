
<!-- ====================================
ーーー	FOOTER
===================================== -->
<footer class="footer-bg-img">
  <!-- Footer Color Bar -->
  <div class="color-bar">
    <div class="container-fluid">
      <div class="row">
        <div class="col color-bar bg-warning"></div>
        <div class="col color-bar bg-danger"></div>
        <div class="col color-bar bg-success"></div>
        <div class="col color-bar bg-info"></div>
        <div class="col color-bar bg-purple"></div>
        <div class="col color-bar bg-pink"></div>
        <div class="col color-bar bg-warning d-none d-md-block"></div>
        <div class="col color-bar bg-danger d-none d-md-block"></div>
        <div class="col color-bar bg-success d-none d-md-block"></div>
        <div class="col color-bar bg-info d-none d-md-block"></div>
        <div class="col color-bar bg-purple d-none d-md-block"></div>
        <div class="col color-bar bg-pink d-none d-md-block"></div>
      </div>
    </div>
  </div>

  <div class="pt-8 pb-7  bg-repeat" style="background-image: url(assets/img/background/footer-bg-img-1.png);">
    <div class="container">
      <div class="row">
        <div class="col-8 col-sm-6 col-lg-3 col-xs-12">
          <a class="mb-6 d-block" href="index.php">
						<?php
						mobile_image( 'assets/img/logo-footer.png', '福島学生委員会', 'img-fluid rounded');
						?>
          </a>
        </div>

        <div class="col-sm-6 col-lg-3 col-xs-12">
          <h4 class="section-title-sm font-weight-bold text-white mb-6"><a href="gi.php">学生委員とは</a></h4>
        </div>

        <div class="col-sm-6 col-lg-3 col-xs-12">
          <h4 class="section-title-sm font-weight-bold text-white mb-6">主な活動紹介</h4>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="spring.php">
                <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i>春の活動
              </a>
            </li>
            <li class="mb-4">
              <a href="summer.php">
                <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i>夏の活動
              </a>
            </li>
            <li class="mb-4">
              <a href="autumn.php">
                <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i>秋の活動
              </a>
            </li>
            <li class="mb-4">
              <a href="other.php">
                <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i>冬･その他の活動
              </a>
            </li>
          </ul>
        </div>

						<?php /*
        <div class="col-sm-6 col-lg-3 col-xs-12">
          <h4 class="section-title-sm font-weight-bold text-white mb-6"><a href="club.php">サークル・団体</a></h4>
        </div>
						*/ ?>

      </div>
    </div>
  </div>

  <!-- Copy Right -->
  <div class="copyright">
    <div class="container">
      <div class="row py-4 align-items-center">
        <div class="col-sm-7 col-xs-12 order-1 order-md-0">
          <div class="copyright-text"><p id="copyright">&copy; <span id="copy-year"></span> - <a href="<?php echo HTTP.'/';?>" target="_blank"><?php echo(COOPNAME_EN);?></a></p> </div>
        </div>

        <div class="col-sm-5 col-xs-12">
          <ul class="list-inline d-flex align-items-center justify-content-md-end justify-content-center mb-md-0">
            <li class="me-3">
              <a class="icon-rounded-circle-small bg-danger" href="https://z-p15.www.instagram.com/fukudaicoop/">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
            <li class="me-3 Xf">
              <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukudai01">
																				<svg xmlns="http://www.w3.org/2000/svg" height="0.8em" viewBox="0 0 512 512">
																				<style>
																				li.Xf svg{fill:#ffffff;}li.Xf a {line-height: 1.0;}li.Xf svg{margin-top: 3px;position: relative;top: 2px;}
																				</style>
																				<path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
																				</svg>
														</a>
            </li>
						<li class="me-3">
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>





<!--scrolling-->
<div class="">
  <a href="#pageTop" class="back-to-top" id="back-to-top" style="opacity: 1;">
    <i class="fas fa-arrow-up" aria-hidden="true"></i>
  </a>
</div>

<!-- Javascript -->
<script src='assets/plugins/jquery/jquery.min.js'></script>
<script src='assets/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>

<script src='assets/plugins/fancybox/jquery.fancybox.min.js'></script>
<script src='assets/plugins/isotope/isotope.min.js'></script>
<script src='assets/plugins/images-loaded/js/imagesloaded.pkgd.min.js'></script>

<script src='assets/plugins/lazyestload/lazyestload.js'></script>
<script src='assets/plugins/velocity/velocity.min.js'></script>
<script src='assets/plugins/smoothscroll/SmoothScroll.js'></script>


<script src='assets/plugins/owl-carousel/owl.carousel.min.js'></script>
<script src='assets/plugins/revolution/js/jquery.themepunch.tools.min.js'></script>
<script src='assets/plugins/revolution/js/jquery.themepunch.revolution.min.js'></script>

<script src="/js/jquery/jquery.matchHeight/jquery.matchHeight.min.js"></script>
<script>
	$(function(){
		$('.card').matchHeight();
	});
</script>

<!-- Load revolution slider only on Local File Systems. The following part can be removed on Server -->
<!-- 
<script src='assets/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js'></script>
<script src='assets/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js'></script>
<script src='assets/plugins/revolution/js/extensions/revolution.extension.navigation.min.js'></script> 
-->

<script src='assets/plugins/wow/wow.min.js'></script>

<script>
  var d = new Date();
  var year = d.getFullYear();
  document.getElementById("copy-year").innerHTML = year;
</script>
<script src='<?php fp_ft('/GI/assets/js/GI.js'); ?>'></script>
</body>

</html>

