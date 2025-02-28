<?php
require_once '../../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!--FB シェアボタン用-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.12';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<!--//共通項目-->
<meta property="og:title" content="1階食堂店舗名称（愛称）決定！" />
<meta property="og:type" content="article" />
<meta property="og:url" content="http://www.fukushima.u-coop.or.jp/foodservice/news/180601naming/" />
<meta property="og:image" content="http://www.fukushima.u-coop.or.jp/foodservice/news/180601naming/images/1200_naming_ogp_0601.jpg" />
<meta property="og:site_name"  content="福島大学生活共同組合" />
<meta property="og:description" content="福島大学生協の1階食堂店舗名称（愛称）決定！" />

<!--//Twitter用-->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@fukudaicoop" />


<?php
include $rootpath . 'include/header2.txt';
?>


<h3>1階食堂店舗名称（愛称）決定！</h3>
<img src="./images/naming_poster_0601.jpg" width="762" height="539" alt="1階食堂店舗名称（愛称）決定！">

<br />


<div class="Share_btn">
<!--LINE シェアボタン-->
<div class="line-it-button" data-lang="ja" data-type="share-a" data-url="http://www.fukushima.u-coop.or.jp/foodservice/news/180601naming/" style="display: none;"></div>
 <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>

<!--FB シェアボタン-->
<div class="fb-share-button" data-href="http://www.fukushima.u-coop.or.jp/foodservice/news/180601naming/" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.fukushima.u-coop.or.jp%2Ffoodservice%2Fnews%2F180601naming%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">シェア</a></div>

<!--Twitter シェアボタン-->
<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</!--Twitter>
<br />

<div class="box">
<p class="ttlgreen">食 堂</p>
<p>福島大学生活協同組合</p>
<p class="em12"><span class="ttl">TEL</span>024-548-7300</p>
<p>〒960-8151 福島市金谷川1番地 大学会館1F</p>

<p><span class="ttl">平日</span>8：00〜20：00&ensp;&ensp;<span class="ttl sat">土</span>11:00〜19:00&ensp;&ensp;<span class="ttl sun">日祝</span>休業</p>
<p>※長期休暇期間は短縮営業となります。詳細は&ensp;<span class="btn navy min"><a href="http://www.fukushima.u-coop.or.jp/store/businesshours.php">営業時間をご確認ください&nbsp;&#62;</a></span></p>

</div>
<div class="clear"></div>

<p><a class="btn btn-primary" href="/foodservice/"><i class="fa fa-fw fa-reply"></i>食堂トップへ戻る</a></p>

<?php
include $rootpath . '/include/footer.txt';
?>