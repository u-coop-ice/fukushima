<?php
require_once '../adm/lib/set_path.php';
include 'config.php';
//include $rootpath . '/include/js_index.txt';
?>


<?php
include $rootpath . '/GI/include/header.php';
?>


<div class="main-wrapper blog-single">


<!-- ====================================
ーーー	BREADCRUMB
===================================== -->
<section class="breadcrumb-bg" style="background-image: url(assets/img/background/page-title-bg-img_05.jpg); ">
	<div class="container">
		<div class="breadcrumb-holder">
			<div>
				<h1 class="breadcrumb-title">サークル・団体</h1>
				<ul class="breadcrumb breadcrumb-transparent">
					<li class="breadcrumb-item">
						<a class="text-white" href="index.php">Home</a>
					</li>
					<li class="breadcrumb-item text-white active" aria-current="page">
						サークル・団体
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- ====================================
ーーー	Blog SINGLE
===================================== -->
<section class="py-8 py-md-10" id="club">
	<div class="container">

<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-4">
    <div class="d-grid gap-2">
      <button type="button" class="btn btn-outline-warning"><a href="#001">文化系サークル <i class="fas fa-caret-down"></i></a></button>
    </div>
    </div>
    <div class="col-md-4">
    <div class="d-grid gap-2">
      <button type="button" class="btn btn-outline-info"><a href="#019">体育系サークル <i class="fas fa-caret-down"></i></a></button>
    </div>
    </div>
  </div>

<br />

		<div id="001" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">コーヒーサークルBE-AM</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">福島大学コーヒーサークルBE-AMです！<br />
				普段の活動では、ドリップ練習・温度や挽き目による香り、味の違いを調べたりしています。また、イベントでの出店やボランティアを行ったり、コーヒーイベントに参加したりしています。<br />
				<br />
				［活動日時］毎週水曜日(13:00～16:00）・2週間ごとに月曜日(13:00～16:00）<br />
				［活動場所］S棟の教室、学生会館の教室<br />
				［入部方法］サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/coffeeclub_beam/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img001.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="002" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福島大学吹奏楽団</h3>
			<div class="row">
			<div class="col-sm-6">
				<p class="card-text text-justify mb-3">こんにちは！福島大学吹奏楽団FUWEです。私たちは「地域に根差した音楽づくり」をモットーに、毎週水曜日と土曜日に楽しく活動しています。今年は競馬場ファンファーレやイベントでの依頼演奏に加え数年ぶりに吹奏楽コンクールに出場し、3月には定期演奏会を行いました。その他新歓やクリスマス会などのイベントも行っています。学年関係なく仲の良いサークルです。初心者も大歓迎ですので、興味のある方はDMからご連絡ください！<br />
				<br />
				［活動日時］毎週水曜日・土曜日<br />
				［活動場所］文化系サークル棟、大集会室<br />
				［入部方法］X(旧Twitter)またはInstagramのDMで連絡、サオリに参加する
</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/FUWEsound" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://z-p15.www.instagram.com/fuwestagram/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-6">
				<div class="row">
				<div class="col-6">
				<?php
					mobile_image( 'assets/img/club/club-img002_1.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				<div class="col-6">
				<?php
					mobile_image( 'assets/img/club/club-img002_2.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
				</div>
				</div>
			</div>
		</div>


		<div id="003" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">ポケモンサークル</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">福島大学ポケモンサークルでは、主にswitch、カード、Goを用いたポケモンにまつわる活動に加え、部内戦による大会、ポケモン風にアレンジしたゲーム等、月に1回ほどの頻度で企画を行っております。また、他校のポケモンサークルとの交流会等にも参加し、ポケモンを通じて親睦を深めるサークルとなっております。<br />
				<br />
				［活動日時］毎週水曜日<br />
				［活動場所］主にS棟のいずれかの教室<br />
				［入部方法］X(旧Twitter)のDMにて連絡をする、サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukushima_poke/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img003.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="004" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福島大学ねこサークル</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">福島大学ねこサークルの主な活動内容は、大学内にいる野良猫へのTNR活動や体調管理のための餌やりです。他にも大学祭への参加、地域猫や大学猫に関する広報等も行っています。活動条件は週に1、2回程度で、他のサークルとも掛け持ちしやすいです。興味のある方は、気軽にXのDMなどから連絡下さい！<br />
				<br />
				［活動日時］毎日昼と夕方<br />
				［活動場所］福島大学構内<br />
				［入部方法］サオリに参加する、活動している部員に声をかける、X(旧Twitter)のDMにて連絡をする</p>
								<div class="">
					<ul class="list-inline d-flex-end">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukuneko2_2" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img004.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="005" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福大Voteプロジェクト</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">私たち福大Voteプロジェクトは、若者の投票率向上に向けて活動しており、期日前投票所の設営・運営やSNSでの発信などを行っております！これだけ聞くと、「お堅いサークル」に見えるかもしれませんが、少人数でみんな仲が良く、アットホームな雰囲気で楽しく活動しています(^^)<br />
				<br />
				［活動日時］毎週水曜日(ミーティング)、その他、投票所設営や啓発活動など不定期で活動が入ることがあります！<br />
				［活動場所］主に大学内(S棟空き教室など)<br />
				［入部方法］基本的に、
<script type="text/javascript">
<!--
function converter(M){
var str="", str_as="";
for(var i=0;i<M.length;i++){
str_as = M.charCodeAt(i);
str += String.fromCharCode(str_as + 1);
}
return str;
}
function mail_to(k_1,k_2)
{eval(String.fromCharCode(108,111,99,97,116,105,111,110,46,104,114,101,102,32,
61,32,39,109,97,105,108,116,111,58) 
+ escape(k_1) + 
converter(String.fromCharCode(101,116,106,116,99,96,104,45,117,110,115,100,63,102,108,96,104,107,45,98,110,108,
62,114,116,97,105,100,98,115,60)) 
+ escape(k_2) + "'");} 
document.write('<a href=JavaScript:mail_to("","")>メール <i class="fa fa-fw fa-chevron-right"></i><\/a>');
//-->
</script>
またはInstagram・XのDMにて連絡していただけると対応します！<br />サオリに参加していなくても加入できますし、新入生だけでなく新2年生も大歓迎です！</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://x.com/voteproject02" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukudaivoteproject" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img005.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="006" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福島大学混声合唱団</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">私たちは、月、水、木、土の週4回活動を行っており、合唱曲からポップスまで幅広い曲の練習をしています。主なイベントに全日本合唱コンクール、福大祭、定期演奏会などがあります。また、依頼演奏を行うこともあります。当団では合唱経験者も未経験者も楽しく活動をしています！私たちと一緒に歌ってみませんか？<br />
				<br />
				［活動日時］<br />
				月曜日　16時30分～18時30分<br />水曜日　13時00分～15時00分<br />木曜日　16時30分～18時30分<br />土曜日　09時00分～12時00分<br />
				［活動場所］文化系サークル棟・大学会館 など<br />
				［入部方法］X(旧Twitter)、instagramのDMにて連絡をする、サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukukon_u/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukukon_u/">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img006.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="007" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">ハートフル☆スタジオ</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">ハートフル☆スタジオ(通称ハトスタ)ではアコースティックギターを中心に弾き語りを行うサークルです。大学に入学してから始めた人も多く、和気あいあいと楽しく活動しています。弾き語りをしたい人はもちろん、ギターなどの楽器を弾きたい人や歌うことが大好きな人も大歓迎です‼<br />
				<br />
				［活動日時］月・火・木・金曜日<br />
				［活動場所］文化サークル棟大集会室または中集会室<br />
				［入部方法］サオリへの参加</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/Heartful_Studio/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img007.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="008" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">化学研究会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは化学研究会です！私たちは部員30名ほどで楽しく活動しています．主な活動は、県内で子供たちを対象に「科学をテーマにしたボランティア活動」です．科学が好きな方・好きになってほしい方、ボランティアをしたい方、幅広く繋がりを広げたい方など、大歓迎です！活動頻度は、一ヶ月に1回で、理工共通棟で活動しています．皆さんと楽しく活動していきたいです！<br />
				<br />
				［活動日時］基本的に月に一回、水曜日13時<br />
				［活動場所］理工共通棟または空き教室<br />
				［入部方法］XのDMにて連絡する、サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/KakenFuChem/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img008.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="009" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福島大学BBS会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">BBSとは、非行少年や生きづらさを抱える少年たちの立ち直りを助けることを目的とする団体です。こう聞くと法律や犯罪に詳しくなきゃならないと思ってしまいがちですが、予備知識は必要ありません！学類年齢不問で、誰でも大歓迎です！月2回ほどの定例会議と、定期的な支援活動を予定しています。ぜひ一緒に活動しましょう！<br />
				<br />
				［活動日時］第1、第2週の火曜日・最終週の水曜日<br />
				［活動場所］福島大学・自立更生促進センター<br />
				［入部方法］XのDMにて連絡する、サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukudai_bbs/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukudai_bbs/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img009.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="010" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">ジャグリングサークル</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">私達ジャグリングサークルは週に2回程度の練習と、福大祭や地域のイベントでパフォーマンスをしています。部員はほぼ初心者からのスタートなので、やったことない方も心配はいりません！ジャグリングを極めたい方も、ゆるく仲良くやりたい方も大歓迎です！楽しむことを第一に、最高の大学生活を一緒に作っていきましょう！<br />
				<br />［活動日時］平日週2日程度、16時半から18時半まで<br />
				［活動場所］大集会室<br />
				［入部方法］X(旧Twitter)のDMに連絡する、サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fjc_juglube" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img010.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="011" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">自費出版同好会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">自費出版同好会は、毎週水曜日13:00～17:00にS棟の空き教室で活動しております。『好きなものを好きなように』をモットーに、イラスト・ハンドメイド・小説・コスプレ、部員同士の交流をメインに活動しております。自分の好きをありのままに表現できる自由なサークルです！興味のある方はSNS等で気軽にご連絡ください！<br />
				<br />
				［活動日時］毎週水曜日13:00〜17:00(予約状況によって変わる）<br />
				［活動場所］S棟の空き教室、または大学会館の小集会室や大集会室(予約状況によって変わる)<br />
				［入部方法］X(旧Twitter)のDMまたはInstagramの DMから連絡をする、サオリに参加する、サークルのメンバーに入部したい旨を伝える(見学からでも大丈夫です)</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://x.com/2y_creators/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukudai_creators/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img011.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="012" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福大祭実行委員会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">私たち福大祭実行委員会は、毎年10月に開催される福大祭の準備や運営を行っています。去年は2年生が40名、1年生が155名で福大祭を盛り上げました！また、みなさんに楽しんでもらえるような企画や合宿もあり、楽しく充実した1年間を送ることができます！ぜひ、学祭で一緒に活動して最高な思い出を作りましょう！<br />
				<br />
				［活動日時］水、木、金で18時から20時まで<br />
				［活動場所］S棟<br />
				［入部方法］サオリに参加していただき、希望届を出してもらいます。</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukudaisai60/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img012.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="013" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">Colors</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">国際交流サークルCOLORsでは本学の学生と留学生が楽しく、仲良く交流＋「ルワンダの教育を考える会」を支援を主として活動しています。主に企画メンバーはSNS班、留学生イベント班、ルワンダ班、ハラル班に分かれて活動中です。興味がある方はイベント等に気軽に参加してみてはいかがでしょうか！！<br />
				<br />
				［活動日時］イベントごとに日程は異なります。毎週金曜日昼休みににミーティングを行っています。<br />
				［活動場所］イベントごとに異なりますが、主に経済棟115室を使用しています。<br />
				［入部方法］SNS等で連絡する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukushimacolors/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img013.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="014" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福島大学農林サークル ～福桃～</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは！農林サークル福桃です！私たち農林サークルは農業を中心とした幅広い活動を行っています！また、農業以外にも多くの活動やイベントも行っているので、楽しく自由度の高いサークルとなっています！少しでも興味があればお気軽にDMなどお待ちしております！みなさまの入部、楽しみにしています！<br />
				<br />
				［活動日時］おもに水曜の午後と土日（不定期開催）<br />
				［活動場所］大学周辺の圃場、福島市内外の農家さんの畑など<br />
				［入部方法］各種SNSへのDMで連絡をする、サークルオリエンテーションへの参加、サークル員に仲介してもらうなど</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukudai_nourin/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukushima.univ_nourin/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img014.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="015" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">発酵くらぶ～ferment~</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">福島大学発酵くらぶ～ferment～です！2023年の6月に食農学類１年生の有志で作った新しいサークルです。活動は主に発酵食品の食べ比べ、試作、酒蔵などへの見学を予定しています。発酵食品が好き！料理が好き！食べることが好き！な方、ぜひ私たちと一緒に活動しませんか？食農学類以外の子も大歓迎です！！<br />
				<br />
				［活動日時］毎週水曜日<br />
				［活動場所］空き教室<br />
				［入部方法］X(旧Twitter)、instagramのDMにて連絡する</p>
								<div>
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fu__ferment/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img015.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="016" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">福島大学スマブラサークル</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは！福島大学スマブラサークルです。福大生のスマブラspにおける交流を目的としています。実力不問でスマブラが好きな人大歓迎です。毎週水曜日の午後S棟にて、1on1や乱闘などをして遊んでいます。ご興味がありましたら是非一度足を運んでみて下さい！<br />
				<br />
				［活動日時］水曜13:00~18:00<br />
				［活動場所］s41~44<br />
				［入部方法］X(旧Twitter)のDMで連絡をする・サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2 Xc">
										<a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukudaismash/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img016.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="017" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">Folk &amp; Rock研究会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは、Folk &amp; Rock研究会です！バンド演奏を行うサークルで、初心者でも、経験者でも、性別、学年問わずみーんな仲良しです！アットホーム！やりたい曲をやりたいときにバンド演奏できるので他のサークルやバイトとの両立可能です。ライブ、打ち上げ、合宿と楽しいイベント山盛り〜！ぜひ私たちと楽しく音楽しませんか！？<br />
				<br />
				［活動日時］不定期<br />
				［活動場所］文化サークル棟3階など<br />
				［入部方法］サオリ後の集会への参加、随時SNSで入会受付中！</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2 Xc">
										<a class="icon-rounded-circle-small bg-dark" href="https://x.com/folkandrockFU/" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fu.folkandrock/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://youtube.com/@FR_fu/" target="_blank">
										<i class="fab fa-youtube"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img017.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="018" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-primary">
				<h3 class="card-title text-primary mb-5">F-cationサークルホップ</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">F-cationサークルホップでは、&#9312;まほろば学習室（居場所づくり、学習支援、異年齢交流）&#9313;只見町での勉強合宿（学習支援）&#9314;石川町での教育プログラムの実施（イベントの企画運営）など、「大学生のやりたい！やってみたい！」を仲間と実践することができます。人や地域、みんなの心がつながるサークルです。<br />
				<br />
				［活動日時］毎週水曜日16:00〜20:30<br />
				［活動場所］チェンバおおまち3階・市民活動サポートセンター<br />
				［入部方法］InstagramのDMにて連絡をする・部員に声をかける・毎週水曜日の活動（詳細はInstagram）に参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/mahoroba_f/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img018.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-primary img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>




		<div id="019" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">福島大学ソフトテニス部</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは！福島大学ソフトテニス部です！現在、ソフトテニス部は1.2年生を中心に男子10人女子6人で活動しています。部員大募集中です！！普段は仲良く活動しつつ、大会等にも出場しています。経験者はもちろん大歓迎！興味のある方は見学だけでもぜひ来てください！よろしくお願いします！<br />
				<br />
				［活動日時］月曜水曜火曜(金曜)<br />
				［活動場所］福島大学テニスコート<br />
				［入部方法］DM等でも可能ですが、直接来ていただくのが理想です！</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
										<a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/kamabok19197251" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://instagram.com/fukushima_u_softtennis/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img019.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="020" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">福島大学経済バスケットボール部</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">お疲れ様です、経済バスケットボール部です。一言でまとめると私たちはバスケ大好き集団です。バスケのためなら疲れなど気にしません。活動内外に関わらず本当に仲が良く盛り上がりに期待できるメンバーばかりです。メンバー構成も他学類の方が多いのでバスケが好きな方はぜひチェックしてみてください。<br />
				<br />
				［活動日時］毎週火曜日・金曜日<br />
				［活動場所］福島大学第一体育館<br />
				［入部方法］サオリに参加する、もしくはインスタへDMください</p>
								<div>
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2">
												<?php /* <!-- <a class="icon-rounded-circle-small bg-dark" href="https://x.com/keibasu10">X</a>
		        </li> --> */ ?>
								<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/keibaskket/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img020.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="021" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">オリエンテーリング部</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">オリエンテーリング部では、日々の活動や大会以外にも旅行や飲み会などといったイベントも多くやっており、やりたいことがあれば、自由に提案できます。初心者から始める人がほぼ全員で、先輩達から優しく教えてもらえます。活動内容として、地図とコンパスを使った練習やランニングなどがあります。<br />
				<br />
				［活動日時］水曜日午後1時から<br />
				［活動場所］大学構内<br />
				［入部方法］サオリに参加する、X(旧Twitter)のDMにて連絡する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
		        <li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/fukushimadaiolc?s=21" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
		      </ul>
				</div>
				</div>
								<?php /* <!-- <div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-single-03.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div> --> */ ?>
				</div>
			</div>
		</div>


		<div id="022" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">行政バレーボールサークル</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">行政バレーボールサークル（行バレ）という名前ですが、サークル員の2/3は行政以外の学類生です！毎回の活動はもちろんのこと、サークル内の大会や合宿などが充実していて、経験者も未経験者も一緒に楽しく活動しています。基本的に水曜日と金曜日の週二回、南体育館で活動しているのでバレーボールに興味のある人は気軽に参加してみてください！！<br />
				<br />
				［活動日時］毎週水曜日・金曜日<br />
				［活動場所］福島市南体育館<br />
				［入部方法］知人かインスタのDMを通じて見学の連絡をくれれば大歓迎します。飛び入りでもOKです。</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/gyo.volley/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img022.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="023" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">硬式テニス同好会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">サークル紹介を見ているそこのあなた！ぜひ、わたしたち硬式テニス同好会と一緒に活動しませんか！テニスの経験は問いませんよ～！私たちテニ同はテニスだけでなく色々なイベントも開催しており、学年関係なくみんなで楽しくゆるーく活動しています。テニ同に入ってより一層楽しい大学生活を送りましょう！<br />
				<br />
				［活動日時］火·木14:30～、土13:00～<br />
				［活動場所］学内テニスコート<br />
				［入部方法］インスタのDMにて連絡、サオリに参加</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fuku.tenidou/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img023.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="024" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">夜間主バドミントン同好会</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは！夜間主バドミントン同好会、通称夜バドです！夜バドは夜間主という文字が入っているのは夜間主コースのサークルという意味ではなく、活動している時間が夕方であることに起因しています(どなたでも参加できます)。バドミントンはもちろん、イベントも充実しています。バドミントン経験者はもちろん未経験者も大歓迎です！(割合はちょうど5:5くらいです！) 夜バドで一緒にたくさん思い出を作りましょう！<br />
				<br />
				［活動日時］火曜16:30-21:00(第1体育館改修工事が終われば水曜20:00-22:30, 土曜20:00-22:30の予定)<br />
				［活動場所］第1体育館、第2体育館<br />
				［入部方法］SNSのDMに連絡する、サオリに参加する。</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/f_yabado/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img024.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="025" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">コピーダンスサークル&#201;tica</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">みなさんこんにちは！コピーダンスサークル&#201;ticaです！私たちは主に月木16:10~19:00で活動しています！KPOPやJPOP、アイドルの曲など、様々なジャンルに挑戦しています。入サぜひお待ちしております<br />
				<br />
				［活動日時］月木 16:10~19:00<br />
				［活動場所］S棟、生協大集会室<br />
				［入部方法］インスタDMにて連絡をする、サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/etica_fukudai/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img025.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="026" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">バレーボールサークル凛</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">こんにちは！バレーボールサークル凛です。毎週木曜日の16:30から第二体育館で活動しています。サークルのメンバーの9割程が初心者です。<br />
季節ごとにBBQなどのイベントも企画しています。バレーを気軽に楽しみたい方、バレーボールサークル凛と一緒に大学生活を楽しみましょう！<br />
				<br />
				［活動日時］毎週木曜日16:30<br />
				［活動場所］第二体育館<br />
				［入部方法］サオリに参加する、サークルに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukushima.u_rin_volleyball/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img026.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>


		<div id="027" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">山岳部</h3>
			<div class="row">
			<div class="col-sm-8">
				<p class="card-text text-justify mb-3">福島大学山岳部は毎月県内外の山々を登っています。ほとんどの部員が大学に入ってから登山を始めております！気軽に運動したい方など、是非とも一緒に山を登って美しい自然を楽しみましょう！<br />
				<br />
				［活動日時］土曜日・日曜日(共に不定期)<br />
				［活動場所］体育サークル棟104器具室・日本全国<br />
				［入部方法］&#9312;SNS(X or Instagram)のDMにて連絡をする、&#9313;サオリに参加する</p>
								<div class="">
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2 Xc">
		          <a class="icon-rounded-circle-small bg-dark" href="https://twitter.com/Fukudai_sangaku" target="_blank">
		          <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512">
		          <style>
		          li.Xc svg{fill:#ffffff;}li.Xc a {line-height: 1.5;}li.Xc svg{margin-top: 1px;position: relative;top: 0px;}
		          </style>
		          <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
		          </svg>
												</a>
		        </li>
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-danger" href="https://www.instagram.com/fukudai_sangaku/" target="_blank">
										<i class="fab fa-instagram"></i>
									</a>
		        </li>
		      </ul>
				</div>
				</div>
				<div class="col-sm-4">
				<?php
					mobile_image( 'assets/img/club/club-img027.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>





<?php /*?><p class="alert alert-danger mt-3">現在ページは準備中です。今しばらくお待ちください。</p><?php */?>








<!-- 

		<div id="016" class="card">
			<div class="card-body border-top-5 px-3 rounded-bottom border-info">
				<h3 class="card-title text-info mb-5">物理学研究会</h3>
			<div class="row">
			<div class="col-sm-6">
				<p class="card-text text-justify mb-3">無理せず、お金もかからずゆるーく活動を開始しているサークルです。</p>
					<ul class="list-inline d-flex-end mb-2">
						<li class="me-2">
		          <a class="icon-rounded-circle-small bg-info" href="https://twitter.com/physicsfu22">
		            <i class="fab fa-twitter text-white" aria-hidden="true"></i>
		          </a>
		        </li>
		      </ul>
				</div>
				<div class="col-sm-6">
					<?php
					mobile_image( 'assets/img/club/club-single-26.jpg', 'Card image cap', 'card-img-top border-bottom-5 border-info img-fluid');
					?>
				</div>
				</div>
			</div>
		</div>
 -->






	</div>
</section>




<p class="center"><a href="/GI/" class="btn_home">Topページに戻る</a></p>

</div> <!-- element wrapper ends -->




<?php
include $rootpath . '/GI/include/footer.php';
?>



