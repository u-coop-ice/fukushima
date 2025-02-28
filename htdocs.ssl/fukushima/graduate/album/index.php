<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<link rel="stylesheet" href="./css/f4.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="./css/album.css" type="text/css" media="screen,print" />

<script>
jQuery(function($){
    $('[rel="lightbox[ph]"]').fancybox({
helpers: {
  overlay: {
    locked: false
  }
}
    });
});
</script>

<?php
include $rootpath . 'include/header2.txt';
?>

<div id="main2" class="full">


<h2><span class="em08">完全予約制・限定出版</span><br />
福島大学卒業記念アルバム　予約購入のご案内</h2>

<div class="row">
<div class="col-sm-6 col-xs-12">
<p class="topmenu"><a href="./photo.php" title="" class="btn btn-aqua btn-block btn-square row_center bold">個人写真撮影会について<span class="label label-default label-outline em07">click!</span></a></p>
</div>
<div class="col-sm-6 col-xs-12">
<p class="topmenu"><a href="./photo.php#group" title="" class="btn btn-aqua btn-block btn-square row_center bold">集合写真撮影会について<span class="label label-default label-outline em07">click!</span></a></p>
</div>
</div>


<h4>入学式から卒業式まで完全ドキュメント！</h4>
<div class="row">
<div class="col-sm-4 col-sm-push-8">
<?php
mobile_image('./images/album.jpg', 'アルバムイメージ', 'img-responsive img center');
?>
</div>
<div class="col-sm-8 col-sm-pull-4">
<p>個人写真・研究室・ゼミ・サークル集合写真、そして、講義風景やサークル活動など、卒業生お一人おひとりが福島大学で見せる表情をカメラマンは日々追いかけています。ご卒業にむけて制作される一冊のアルバムを、かけがえない記録として皆様にお届けいたします。</p>
</div>
</div>


<dl>
<dt>入学の頃</dt>
<dd>探して下さい、あの頃の自分。
春の香りとともによみがえる入学の頃を収録しています。</dd>

<dt>キャンパススナップ</dt>
<dd>朝の登校風景、学食でのお昼休み、友だちとのおしゃべり<br />
アルバムにはあなたのキャンパスライフがあふれています<br />
入学から卒業までの軌跡、4年間のキャンパスライフを完全ドキュメント！</dd>

<dt>サークル活動</dt>
<dd>あなたが流した汗、あなたが奏でた音色は永遠の宝物です
サークル活動に打ち込む姿をカメラは切り取ります</dd>

<dt>イベント</dt>
<dd>大学祭、スポーツ大会、教育実習などを
さまざまな表情とともに掲載しています</dd>

<dt>ゼミ・講義風景</dt>
<dd>迷ったときはアルバムをひらいてください<br />
恩師の姿、友との語らいにきっと答えがあるはずです</dd>

<dt>卒業式</dt>
<dd>旅立ちの時<br />新しいステージへと向かう晴れやかな表情は忘れられない思い出です</dd>

<dt>個人写真・集合写真</dt>
<dd>その表情のむこうがわには<br />
あなたのキャンパスライフが広がっています</dd>
</dl>

<?php
if ($career == 'pc') {
	?>

<h4>アルバムイメージ&nbsp;<strong class="em07">画像をクリックすると拡大表示します。</strong></h4>
<dl class="caption">

<dt><a href="./images/0001.jpg" rel="lightbox[ph]"><img src="./images/0001s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0002.jpg" rel="lightbox[ph]"><img src="./images/0002s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0003.jpg" rel="lightbox[ph]"><img src="./images/0003s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0004.jpg" rel="lightbox[ph]"><img src="./images/0004s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0005.jpg" rel="lightbox[ph]"><img src="./images/0005s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0006.jpg" rel="lightbox[ph]"><img src="./images/0006s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0007.jpg" rel="lightbox[ph]"><img src="./images/0007s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0008.jpg" rel="lightbox[ph]"><img src="./images/0008s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0009.jpg" rel="lightbox[ph]"><img src="./images/0009s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0010.jpg" rel="lightbox[ph]"><img src="./images/0010s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0011.jpg" rel="lightbox[ph]"><img src="./images/0011s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0012.jpg" rel="lightbox[ph]"><img src="./images/0012s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0013.jpg" rel="lightbox[ph]"><img src="./images/0013s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0014.jpg" rel="lightbox[ph]"><img src="./images/0014s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0015.jpg" rel="lightbox[ph]"><img src="./images/0015s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0016.jpg" rel="lightbox[ph]"><img src="./images/0016s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0017.jpg" rel="lightbox[ph]"><img src="./images/0017s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0018.jpg" rel="lightbox[ph]"><img src="./images/0018s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0019.jpg" rel="lightbox[ph]"><img src="./images/0019s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0020.jpg" rel="lightbox[ph]"><img src="./images/0020s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0021.jpg" rel="lightbox[ph]"><img src="./images/0021s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0022.jpg" rel="lightbox[ph]"><img src="./images/0022s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0023.jpg" rel="lightbox[ph]"><img src="./images/0023s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0024.jpg" rel="lightbox[ph]"><img src="./images/0024s.jpg" width="95" height="95" /></a></dt>
<dt><a href="./images/0025.jpg" rel="lightbox[ph]"><img src="./images/0025s.jpg" width="95" height="95" /></a></dt>
</dl>
<div class="clear"></div>
<p class="rev_ind">※写真は過去の福島大学卒業記念アルバムからの抜粋となります。実際に掲載される写真とは異なります。</p>

<?php
}
?>


<h4>福島大学卒業記念アルバム仕様</h4>
<dl>
<dt>仕様・掲載内容</dt>
<dd>
<div class="row">
<div class="col-sm-7">
<div class="res_table">
<table class="tblFull">
<thead>
<tr><th class="title" data-title="　■ " data-label="価格" colspan="2">価格</th></tr>
</thead>
<tbody>
<tr><td class="title" data-title="　■ " data-label="アルバムのみ">アルバムのみ</td><td>22,000円（消費税・送料含）</td></tr>
</tbody>
</table>
</div>
</div>
</div>
</dd>
<dt>仕様・体裁</dt>
<dd>A4判（210×297mm）</dd>
<dd>128ページ（予定）オールカラー上製本・ケース付</dd>
<dt>掲載内容</dt>
<dd>集合写真[演習（ゼミ・研究室）・サークル・各種団体]、個人写真、大学沿革、恩師肖像写真、入学式、キャンパス風景、講義風景、サークル活動風景、卒業式など</dd>
</dl>



<h4>予約申込み方法</h4>
<ul class="tri">
<li>ご予約された方だけの限定出版となっております。</li>
<li>専用の振込用紙にて、お近くの郵便局からお振込ください。<br />※商品到着まで、振込受領書は大切に保管ください。</li>
<li>お届け時期／2025年6月上旬予定<br />
<p><span class="rev_ind">※振り込み用紙にご記入いただきましたアルバム送付先住所へお届けいたします。</span>
<span class="rev_ind">※お申し込みいただいた方の個人情報は福島大学卒業記念アルバムの制作・販売以外の目的には使用いたしません。</span></p>
</li>
</ul>

<h4>お届け時期</h4>
<p class="ind"><strong class="red em14">2025年6月上旬予定</strong></p>

<div class="box">
<dl>
<dt>企画／発行</dt>
<dd>福島大学卒業記念アルバム編集委員会</dd>
<dt>お問い合せ</dt>
<dd>卒業記念アルバム制作会社　<br class="visible-xs-block">(株)四九一アヴァン内福島大学卒業記念アルバム係<br />
〒983-0824 <br class="visible-xs-block">
宮城県仙台市宮城野区鶴ヶ谷2丁目8-1-2F <br>Tel 022-253-7677</dd>
</dl>
</div>

<p><a class="btn btn-primary" href="../"><i class="fa fa-fw fa-reply"></i>卒業に戻る</a></p>

</div><!--content終了 -->

<?php
include $rootpath . '/include/footer.txt';
?>
