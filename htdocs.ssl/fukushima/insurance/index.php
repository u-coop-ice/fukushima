<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<!-- XML Parser + Banners -->
<script type="text/javascript" src="/js/xml/jkl-parsexml.js"></script>
<link rel="stylesheet" href="/js/banners/banners.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="/js/banners/banners.js"></script>

<style>
a.list-group-item.non_link:hover,
a.list-group-item.non_link:focus {
  color: #555;
  text-decoration: none;
  background-color: #fff;
}
</style>


<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main" class="left">

<h2 id="title_insurance">住まい・共済</h2>

<?php
mobile_image('./images/insurance_top.jpg', '', 'img-responsive');
mobile_image('./images/map_honbu.jpg', '', 'img-responsive');
?>

<h3>共済</h3>

<div class="row">
<div class="col-sm-6">
<h4>学生総合共済給付申請について</h4>
<p class="pad_l">詳しい申請方法はこちらから</p>
<div><a  onclick="ga('send', 'event', 'banner', 'click', '共済金請求のしかた - /index.php');" href="https://kyosai.univcoop.or.jp/procedure/application.html" target="_blank"><img class="img img-responsive" src="/banners/210/bnr_kyosai_kyufu.png" alt="共済金請求のしかた" /></a></div>
</div>

<div class="col-sm-6">
<?php
mobile_image('./images/insurance_01.jpg', '', 'img-responsive');
?>
</div>
</div><!-- /row -->





<h3>住まい紹介・アパート情報</h3>

<p class="pad_l">お部屋探しは福島大学生協へ!</p>
<p class="pad_l">大学周辺から市内まで幅広く物件をご案内しております。</p>
<p class="pad_l">新しくひとり暮らしをする方も引越しをお考えの方も是非お気軽にご相談ください。</p>

<p class="pad_l">
<a href="https://www.tohoku.u-coop.com/fukushima_university" target="_blank">
<img class="img" src="/banners/bnr_livingsearch_210.png" width="210" height="50" alt="物件検索はこちら" /></a>
</p>


<div class="list-group ic_list">
<a class="list-group-item ic_newlife" href="https://newlife.u-coop.or.jp/fukushima/" target="_blank">
<h5 class="list-group-item-heading">新入生、受験希望の方のお部屋さがしは……福島大学生協の［受験生・新入生サポート］<i class="fa fa-external-link"></i></h5>
<?php
/*<p>現在、東日本大震災の影響で福島県内の賃貸物件が「応急仮設住宅」として扱われたり、震災復興工事や除染関連の方が住まわれたりしている影響で、ご紹介できるお部屋が非常に少なくなっております。</p>
 */
?>
<p>ご紹介できるお部屋については日々変動しておりますので、住まいをお探しの方はお気軽にお問い合わせください。</p>
</a>
</div>


<div class="list-group ic_list">
<a class="list-group-item ic_newlife" href="https://www.univcoop-housing.co.jp/room-grad-pre/index.html" target="_blank">
<h5 class="list-group-item-heading">新社会人向けのお部屋探し <i class="fa fa-external-link"></i></h5>
<img src="/banners/210/bnr_uch_room_grad_210.png" class="img" style="margin-left:1.8em;" >
<p>新社会人向けのお部屋探しも生協がお手伝いします。大学生協で提携している仲介会社を通じてお部屋探しができる新社会人向けのサイトです。ぜひご活用ください。</p>
</a>

<a class="list-group-item ic_info" href="/insurance/bousai/">
<h5 class="list-group-item-heading">もしもの時のために備えよう災害時に命を守るために必要なこと<i class="fa fa-fw fa-chevron-right"></i></h5>
<p>まずは住まいが決定したら、緊急時の避難場所やハザードマップを確認するようにしましょう。<br />福島大学生協では福島大生のローリングストックを応援しています！</p>
</a>
</div>


<div class="box">
<h5>《お問い合わせ・ご連絡先》</h5>
<p class="center bold"><span class="em12">福島大学生活協同組合&nbsp;不動産部</span><br />
TEL：024-548-8660／FAX：024-548-3477</p>
<p class="center">〒960-1296　福島県福島市金谷川1番地<br />
免許番号　福島県知事（4）第2777号</p>
</div>



<div class="clearfix"></div>

<div class="list-group ic_list">
<a class="list-group-item ic_store non_link" <?php /*?>href="http://vh.u-coop.or.jp/" target="_blank"<?php */?>><h5 class="list-group-item-heading">オーナー様へ 求む！賃貸物件 </h5>
<p>随時、学生向け賃貸物件を募集しています。<br />
また、管理委託も承りますので、何でもご相談下さい。</p>
</a>

<a href="http://kyosai.univcoop.or.jp/" class="list-group-item ic_info" target="_blank">
<h5 class="list-group-item-heading">学生総合共済・学生賠償責任保険・就学費用保障保険のご案内 <i class="fa fa-external-link"></i></h5>
<p>学生同士のたすけあいの制度『学生総合共済』のご案内ページです。もしものときのための『学生賠償責任保険』『就学費用保障保険』もご案内しております。</p>
<p class="cpt">※全国大学生協共済生活協同組合連合会のサイトに移動します。</p>
</a>
<a class="list-group-item ic_info" href="http://hoken.univcoop.or.jp" target="_blank"><h5 class="list-group-item-heading">大学生協保険サービス〜大学生協組合員保険のご案内〜<i class="fa fa-external-link"></i></h5>
<p>こちらは、全国大学生活協同組合連合会の会員生協の組合員ならびにご家族の皆様のために、Webでの保険商品（制度）案内や安心・安全情報などをお届けする目的で作成されています。ご利用に際しましては、大学生協にご加入いただきますようお願いいたします。</p>
<p class="cpt">※大学生協保険サービスのサイトに移動します。</p>
</a>
</div>


<h3>引越</h3>
<div class="list-group ic_list">
<a class="list-group-item ic_store" href="https://career.u-coop.or.jp/move/" target="_blank"><h5 class="list-group-item-heading">大学生協の引越しプラン <i class="fa fa-external-link"></i></h5>
<p>面倒な引越しは、大学生協にすべておまかせ！</p>
</a>
</div>


</div><!--content終了 -->


<!-- sub -->

<div id="sub">


<div class="sidecolumn navi">
<div id="menu-inner">

<!-- banners：バナー -->
<div id="banners"><img src="/js/banners/loading.gif" alt="loading" style="display: block; margin: 0 auto 0 auto; padding: 80px 0; border: none; background: transparent;" /></div>
<!-- /banners -->

</div>
</div>



</div><!-- sub終了 -->


<div class="clear"></div>


<?php
include $rootpath . '/include/footer.txt';
?>
