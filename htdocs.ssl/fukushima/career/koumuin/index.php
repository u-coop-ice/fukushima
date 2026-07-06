<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>


<!--css-->
<link href="./css/koumuin.css" rel="stylesheet" media="screen,print" />

<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />

<script>
$(function() {
	$(".movie-thumb").on("click", function(){
		if($('.sp-spacer').is(':visible')){
			window.open('https://www.youtube.com/embed/x59kx092YrA?loop=1&playlist=x59kx092YrA&autoplay=0&mute=1','_blank');
		} else {
			videoControl("playVideo",$(this).prev("iframe"));
			$(this).hide();
		}
	});
	function videoControl(action,tgt){
		var $playerWindow = $(tgt)[0].contentWindow;
		$playerWindow.postMessage('{"event":"command","func":"'+action+'","args":""}', '*');
	}
});
</script>

<?php
include $rootpath . 'include/header2.txt';
?>









<div id="main2" class="full">


<h2 id="koumuin">福島大生のための公務員試験対策講座 <span class="label label-danger em07">ガイダンス申込み受付中！</span></h2>


<nav class="navbar navbar-default">

			<ul class="nav navbar-nav">
				<li><a href="#guidance" class="triangle">公務員講座ガイダンス予約</a></li>
				<li><a href="#overview" class="triangle">公務員試験対策講座について</a></li>
				<li><a href="#reason" class="triangle">生協の公務員講座が選ばれる理由</a></li>
				<li><a href="#message" class="triangle">生協講座出身の先輩からのメッセージ</a></li>
				<li><a href="#pass" class="triangle">受講生の主な合格先</a></li>
				<li><a href="#what" class="triangle">公務員とは？</a></li>
				<li><a href="#contents" class="triangle">試験内容は？</a></li>
				<li><a href="#contact" class="triangle">公務員講座事務局のご案内</a></li>
			</ul>
</nav>




<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="movie-content-wrap">
	<iframe width="800" height="450" src="https://www.youtube.com/embed/3s1WTE3Bvdo?si=4-piV6KOl4iT6t9t" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php /* <img src="http://img.youtube.com/vi/3s1WTE3Bvdo/maxresdefault.jpg" alt="" class="movie-thumb img-responsive"> */ ?>
</div>
</div>
</div>






<div class="box olive">
<h3 id="guidance">公務員講座ガイダンス予約受付中！</h3>
</div>
<p>公務員を目指す福島大生と保護者様のために、対面・オンラインでのガイダンスを開催します。事前予約制ですので、以下からご予約ください。</p>

<div class="contact green_line">

<h5>＜行政職対象＞</h5>
<table>
<tr><th class="nowrap">1回目：</th><td>4月14日（火）15：00〜16：00</td></tr>
<tr><th class="nowrap">2回目：</th><td>4月14日（火）16：30〜17：30</td></tr>
<tr><th class="nowrap">&nbsp;</th><td>※行政職コースのガイダンスは1回目・2回目の内容は同じです。使用教室の都合上、分けて実施しています。</td></tr>
</table>

<h5>＜技術職対象＞</h5>
<table>
<tr><th class="nowrap">理工学類対象：</th><td>4月22日（水）13：00〜14：00</td></tr>
<tr><th class="nowrap">食農学類対象：</th><td>4月22日（水）14：30〜15：30</td></tr>
</table>

</div>

<p><a class="btn btn-success" href="https://forms.gle/vB7PqmhCZC1HcuCP8" target="_blank">ガイダンスの予約申込はこちら <i class="fa fa-fw fa-chevron-right"></i></a></p>



<br>
<div class="box olive">
<h3 id="overview">6月開講 3年生向け公務員講座</h3>
</div>

<div class="row">
<div class="col-sm-9">
<div class="contact green_line">
<span class="olive bold em12">こんな人におすすめ！</span>
<ul>
<li>本気で公務員を目指す方</li>
<li>漠然と公務員を考えている方</li>
<li>民間企業と併願を考えている方</li>
</ul>
</div>

<p>パンフレットは購買店で配布中です。</p>

<p><a class="btn btn-success" href="https://koza-w.seikyou.jp/KouzaSupport/WebForm/Guidance/Reception" target="_blank">講座内容とガイダンス動画配信はこちら <i class="fa fa-fw fa-chevron-right"></i></a><br>
※動画視聴には事前登録が必要です</p>

<?php /*?><p><a class="btn btn-success" href="" disabled="disabled" style="cursor: no-drop">【準備中】新型コロナウイルス感染症対策について <i class="fa fa-fw fa-chevron-right"></i></a></p><?php */?>
</div>
<?php /*?><div class="col-sm-3 col-sm-offset-0 col-xs-offset-3 col-xs-6 col-xs-offset-3">
<img src="./images/21_koumuin.jpg" alt="開講3年生(現2年生)向け公務員講座" class="img-responsive shadow">
</div><?php */?>
</div>





<br>
<div class="box olive">
<h3 id="reason">ここがオリジナル！生協の公務員講座が選ばれる理由</h3>
</div>

<ol class="calender_list">

<li><p class="olive bold wf-roundedmplus1c em12">学内だから通いやすい！</p>
通いやすさは継続のしやすさに繋がります。諦めずに勉強を続けることが何よりも大切。模試の実施や2次試験対策も学内で行われます。<br>
また、講座事務局の窓口は生協購買店内にあり、受講生からの個別相談に素早く対応し、適切なアドバイスを随時行っています。<br>
2次試験対策の予約なども簡単に行えます。</li>

<li><p class="olive bold wf-roundedmplus1c em12">反復学習で理解が深まる！</p>
講義は全てストリーミング配信されます。いつでもどこでも受講でき、何度でも繰り返し見ることができます。<br>
分からなかったところや、もう一度復習したい講義などに活用が可能です。</li>

<li><p class="olive bold wf-roundedmplus1c em12">二次試験は納得いくまで！</p>
人物重視の公務員試験において、2次試験の対策は必要不可欠です。<br>
生協講座では、面接カードの添削や個人面接、集団討論等の個別指導を合格するまで繰り返し行います。<br>
2次試験対策の費用は受講料に含まれています。何度指導を受けても追加料金は発生しません。</li>

</ol>





<br>
<div class="box olive">
<h3 id="message">先輩からの声</h3>
</div>

<div class="row">
<?php /*?>	<div class="col-sm-2 col-sm-offset-0 col-xs-6 col-xs-offset-3 center">
<img src="./images/voice2020_01.jpg" alt="利用者の声" class="img-responsive">
</div><?php */?>
	<div class="col-sm-10 col-xs-12">
	<p class="border_bottom_dot"><span class="olive em11">裁判所事務官内定</span> 人間発達文化学類</p>
		<p class="fukidashi_right wf-roundedmplus1c">講座を受講する利点は、必要な情報をもれなく得られることにあると思います。特に人事の方が講座生向けに開いてくださる説明会は、独学ではなかなか知ることのできない職業に興味を持つきっかけとなります。私自身、進路選択にあたっては講座内の説明会が大きく影響しました。視野を広く持ちたい方には受講をお勧めします。</p>
	</div>
	<br><br>
	<div class="col-sm-10 col-xs-12">
	<p class="border_bottom_dot"><span class="olive em11">防衛省内定</span> 経済経営学類</p>
		<p class="fukidashi_right wf-roundedmplus1c">公務員試験は試験科目数も多く、長期間にわたりますが、講座を受けていることで勉強のペースをつかむことができました。公務員講座に蓄積されてきた豊富な情報量も試験を受ける際にとても役に立ちました。定期的にも模試もあるため、実力チェックができるのもよかったです。面接練習は10回ほどやりましたが、様々な講師陣や生協の職員の方々が面接の極意を教えてくださったので、苦手だった面接を克服できました。勉強スケジュールについては、試験は朝早くから始まるため、生活スタイルを朝型に変えました。“夜更かしをして1時間多く勉強する”よりも、“朝早く起きて1時間多く勉強する”ことを心がけていました。</p>
	</div>
</div>


<br />


<?php /* 
<div class="box olive">
<h3 id="pass">2025年 合格実績（一部抜粋）</h3>
</div>
<p>国家総合職…１名</p>
<p>国家一般職…３２名</p>
<p>国家専門職…２８名</p>
<br>
<p>福島県庁…１９名</p>
<p>他都道府県庁計：４１名</p>
<br>
<p>他市町村計：４５名</p>
<br>
<p>福島県警察…３名</p>
*/?>


<?php /* 
<p class="olive bold wf-roundedmplus1c em12">国家公務員</p>
<p>文部科学省/福岡出入国管理局/長崎労働局/門司税関/九州農政局/仙台国税局/福岡国税局/自衛隊幹部候補生(陸上)海上自衛隊一般曹候補</p>

<p class="olive bold wf-roundedmplus1c em12">地方公務員</p>
<p>長崎県/長崎県教育事務/長崎県警察事務/福岡県/大分県/熊本県/佐賀県/鹿児島県/鹿児島県教育事務/東京都特別区 佐世保市/長崎市/五島市/長崎県長与町/福岡市/北九州市/宗像市/鹿島市/伊万里市/仙台市/中津川市/岡山市</p>

<p class="olive bold wf-roundedmplus1c em12">警察・消防</p>
<p>長崎県警/福岡県警/佐賀県警/宮崎県警/長野県警/横浜市消防局</p>

<p class="olive bold wf-roundedmplus1c em12">独立行政法人・地方公共団体</p>
<p>九州地区国立大学法人/長崎県商工会連合会/独立行政法人労働者健康安全機構/独立行政法人高齢障害求職者雇用支援機構  </p>
*/?>




<br>
<div class="box olive">
<h3 id="what">公務員とは？</h3>
</div>
<p>公務員は、国家公務員と地方公務員に分けられます。</p>

<p class="olive bold wf-roundedmplus1c em12">国家公務員…</p>
<p>国に採用され、国の機関（12府省庁、国会、裁判所）で働きます。国を動かす仕事にやりがいを感じられるでしょう。</p>

<p class="olive bold wf-roundedmplus1c em12">地方公務員…</p>
<p>地方自治体に採用され、各都道府県や市区町村で働きます。地域住民との距離が近く、成果を実感しやすい仕事といえます。</p>

<br>
<p>試験区分によっては、1次試験の合格発表から2次試験日までの日数が極端に短くなる場合があります。<br>
慌てずにすむように、2次試験の対策は1次試験対策と並行して行いましょう。</p>


<br>
<div class="box olive">
<h3 id="contents">試験内容は？</h3>
</div>
<p class="olive bold wf-roundedmplus1c em12">教養試験・基礎能力試験…</p>
<p>地方公務員試験の教養試験は大半が試験区分に関係なく共通して出題されます。<br>
出題科目は、一般知能分野と一般知識分野に大別できます。<br>
一般知能分野は公務員試験特有の科目が並び、一般知識分野は高校で学んだ政治・経済、地理、歴史、数学や理科などの科目です。</p>

<p class="olive bold wf-roundedmplus1c em12">専門試験…</p>
<p>各試験の区分に応じて必要な専門的知識を測るために出題されます。<br>
受験する試験の出題科目や科目別出題数を調べて対策しましょう。</p>

<p class="olive bold wf-roundedmplus1c em12">その他の試験…</p>
<p>主に2次試験において、記述式試験、論文試験、人物試験、適性検査などが課されます。</p>

<br>
<p>試験区分によっては、1次試験の合格発表から2次試験日までの日数が極端に短くなる場合があります。<br>
慌てずにすむように、2次試験の対策は1次試験対策と並行して行いましょう。</p>


<br>
<div class="box olive">
<h3 id="contact">公務員講座事務局のご案内</h3>
</div>
<p>大学生協公務員講座の窓口カウンターは、大学会館1階の大学生協店舗内にございます。<br>
公務員試験の受験や講座受講に関するご相談を随時受けつけています。<br>
お気軽にご相談ください。</p>

福島大学生協購買店カウンター 公務員講座事務局<br>
受付時間　10:00-17:00<br>
TEL　024-548-0091<br>



<br>
<br>
<p><a class="btn btn-primary" href="/career/"><i class="fa fa-fw fa-reply"></i>学内講座・資格トップへ戻る</a>
</p>



</div><!--content終了 -->










<?php
include $rootpath . '/include/footer.txt';
?>

