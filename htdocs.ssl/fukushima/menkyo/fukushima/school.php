<?php
require_once '../../adm/lib/set_path.php';
include 'config.php';
include $rootpath . '/include/js_index.txt';
?>

<?php
include $rootpath . 'include/header2.txt';
?>

<h2>福島大学生協　提携校一覧</h2>

<div class="row">
<div class="col-sm-4"><p><a class="btn btn-success btn-block" href="#fukudai">福島大学付近 <i class="fa fa-fw fa-chevron-right"></i></a></p></div>
<div class="col-sm-4"><p><a class="btn btn-success btn-block" href="#fukushima">福島市方面 <i class="fa fa-fw fa-chevron-right"></i></a></p></div>
<div class="col-sm-4"><p><a class="btn btn-success btn-block" href="#motomiya">本宮・郡山方面 <i class="fa fa-fw fa-chevron-right"></i></a></p></div>
</div>


<?php
if (time() < strtotime("2021-12-01 00:00:00")){
?>
<div class="alert alert-warning" role="alert">
<h4>＜自動車学校提携校秋キャンペーン開催中＞</h4>
<p class="lead">福島大学生協提携校に期間中のお申込みで、コプリカ2000円分チャージ！<br />
11月1日～11月30日まで</p>
</div>
<?php
}
?>


<h3 id="fukudai" class="em18"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>福島大学付近</h3>

<div class="container-fluid">
<div class="row">

<!-- 東亜自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">東亜自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県福島市松川町浅川字卸荷ヶ沢5<br class="visible-xs-block">［電話］024-567-3231
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_toua.jpg" alt="東亜自動車学校" title="東亜自動車学校" ></p>
</div>

<div class="col-sm-7">
<p>福島大学直近で地元の自動車学校で、毎時間の送迎実施もあります。<br />
広々としたコースで、のびのび教習することができます。<br />
学生さんのスケジュールに合わせた技能教習の予約を受け付けています。<br />
ペーパードライバー講習を在学中無料で1回受講できます。</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">福島大学から一番通いやすい学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>310,130円</td>
				<td>281,630円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>326,700円</td>
				<td>295,830円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<?php /* 
<div class="alert alert-danger" role="alert">
<strong>【新入生ふくふくプラン対象特典】</strong><br />
<p class="pad_l bold">コプリカチャージ券プレゼント 5,000円分</p></div>
*/ ?>

<p>
<a class="btn btn-primary" href="https://www.license.co.jp/toa/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /東亜自動車学校 -->


<!-- 杉妻自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">杉妻自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県福島市清水町字東檀9<br class="visible-xs-block">［電話］024-549-3331
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_sugitsuma.jpg" alt="杉妻自動車学校" title="杉妻自動車学校" ></p>
</div>

<div class="col-sm-7">
<p>皆さんの大切な時間を有効に生かしたスケジュールを、スタッフ一同で入校から卒業まで、親切・丁寧に一生懸命サポートさせていただきます。どのようなことでも、お気軽に声をかけてくださいね！</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">福島大学・南福島から送迎バスで約5分の学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>313,490円</td>
				<td>282,100円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>329,990円</td>
				<td>296,900円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<p>
<a class="btn btn-primary" href="https://www.sugitsuma-ds.jp/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /杉妻自動車学校 -->



<h3 id="fukushima" class="em18"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>福島市方面</h3>

<!-- マツキドライビングスクール福島飯坂校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">マツキドライビングスクール福島飯坂校 </span>　<br class="visible-xs-block">［住所］福島県福島市飯坂町湯野字洞下1<br class="visible-xs-block">［電話］024-542-1131
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_matsuki.jpg" alt="マツキドライビングスクール福島飯坂校" title="マツキドライビングスクール福島飯坂校" ></p>
</div>

<div class="col-sm-7">
<p class="pad_l">当校の職員はみんなフレンドリーです。何でも気軽に聞いてください！送迎も充実、教習スケジュールも相談に応じます。空き時間は、無料コミックコーナーや自転車も利用できます。ご入校から卒業まで、しっかりバックアップさせていただきます！</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">無料送迎・年中無休　温泉街にある学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>321,640円</td>
				<td>285,000円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>364,980円</td>
				<td>340,000円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<p>
<a class="btn btn-primary" href="https://www.iizaka-ds.jp/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /マツキドライビングスクール福島飯坂校 -->


<!-- 福島自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">福島自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県福島市町庭坂字原中2－51<br class="visible-xs-block">［電話］024-591-1703
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_fukushima.jpg" alt="福島自動車学校" title="福島自動車学校" ></p>
</div>

<div class="col-sm-7">
<p>女性指導員をはじめ、職員一同いつも親切丁寧な教習を心がけています。運転に関する技術や知識はもちろん、思いやりのあるドライバーを育てることが福島自動車学校のモットーです。<br />
さらに無料の個別送迎や待合室には3000冊の漫画本と常に最新の雑誌、Wi-Fiも完備しております。スタッフ一同みなさまのご入校をお待ちしております。</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">自宅から学校まで教習時間に合わせてフリー送迎ありの学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>308,250円</td>
				<td>272,250円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>324,750円</td>
				<td>287,100円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<p>
<a class="btn btn-primary" href="https://www.fukushima-ds.jp/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /福島自動車学校 -->


<!-- 北部日本自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">北部日本自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県伊達市原島95<br class="visible-xs-block">［電話］024-583-3331
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_hokubu.jpg" alt="北部日本自動車学校" title="北部日本自動車学校" ></p>
</div>

<div class="col-sm-7">
<p>県北最大の教習コースでのびのび丁寧な安全指導が受けられます。<br />
指導員はもちろん、全スタッフが卒業まで完全フォローいたします。</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">のびのび教習できる県北最大コースがある学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>311,000円</td>
				<td>281,630円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>327,500円</td>
				<td>295,830円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<?php /*
<div class="alert alert-danger" role="alert">
<strong>【新入生ふくふくプラン対象特典】</strong><br />
<p class="pad_l bold">コプリカチャージ券プレゼント 10,000円分</p></div>
*/ ?>

<p>
<a class="btn btn-primary" href="https://www.license.co.jp/hokubu/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /北部日本自動車学校 -->


<!-- 保原自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">保原自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県伊達市保原町字泉町65<br class="visible-xs-block">［電話］024-575-2224
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_yasuhara.jpg" alt="保原自動車学校" title="保原自動車学校" ></p>
</div>

<div class="col-sm-7">

<p>免許取得するなら、安心できる保原で！<br />
当校はアットホームな雰囲気で免許取得をバックアップします。<br />
「ほばらっていいよ」と言ってもらえるような接遇をスタッフ一同目指しています。<br />
気軽にいつでも声をかけてください。</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">完全フリー送迎、完全オーダー講習で自分のスタイルで免許取得できる学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>312,880円</td>
				<td>280,137円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>329,380円</td>
				<td>294,987円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<p>
<a class="btn btn-primary" href="http://www.hobara.co.jp/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /保原自動車学校 -->



<h3 id="motomiya" class="em18"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>本宮・郡山方面</h3>

<!-- 本宮自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">本宮自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県安達郡大玉村大山字狐森18<br class="visible-xs-block">［電話］0243-48-2218
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_motomiya.jpg" alt="本宮自動車学校" title="本宮自動車学校" ></p>
</div>

<div class="col-sm-7">
<p>大学生のみなさん！本宮で免許取りませんか？<br />
当校では、ほめ達3級全職員取得で安心！<br />
大学生プラン　自分に合わせた教習スケジュール、大学や自宅までの送迎を責任をもって行います。<br />
みなさまのお越しをお待ちしております！ </p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">完全フリー送迎で、通学しやすい学校　追加実技3時間サービス</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>310,870円</td>
				<td>272,976円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>327,370円</td>
				<td>287,496円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<p>
<a class="btn btn-primary" href="https://www.motomiya-ds.co.jp/" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>
</div>

	</div>
</div>
<!-- /本宮自動車学校 -->


<!-- 富久山自動車学校 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="lead">富久山自動車学校 <span class="label label-warning">フリー送迎あり</span></span>　<br class="visible-xs-block">［住所］福島県郡山市富久山町福原字水穴1<br class="visible-xs-block">［電話］024-922-8070
	</div>
	<div class="panel-body">

<div class="col-sm-5">
<p><img class="img-responsive" src="./images/f_fukuyama.jpg" alt="冨久山自動車学校" title="冨久山自動車学校" ></p>
</div>

<div class="col-sm-7">
<p>不安をもって入校された初心者の生徒さんの身になって、十分なサポートを常に心がけるスタッフがみなさま方を待ちしております。</p>

<div class="alert alert-warning" role="alert"><strong>［アピールポイント］<br class="visible-xs-block">郡山周辺の方に人気の学校</strong></div>

<div class="table-responsive">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>一般料金</th>
				<th>生協組合員料金<br /><small>（生協に支払う金額）</small></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>オートマ限定</th>
				<td>313,610円</td>
				<td>280,610円</td>
			</tr>
			<tr>
				<th>マニュアル</th>
				<td>350,460円</td>
				<td>317,460円</td>
			</tr>
			<tr>
				<th>別途料金</th>
				<td colspan="2">2,900円<br />※仮免試験受講手数料など<br />※追加技能料金あり</td>
			</tr>
		</tbody>
	</table>
</div>

<p>
<a class="btn btn-primary" href="http://www.fds.ne.jp/top.html" target="_blank" ontouchstart>ホームページはこちら <i class="fa fa-external-link"></i></a>
</p>

</div>

	</div>
</div>
<!-- /冨久山自動車学校 -->


</div><!-- /row -->
</div><!-- /container-fluid -->

<p><a class="btn btn-primary" href="./index.php"><i class="fa fa-fw fa-reply"></i>自動車運転免許へ戻る</a>
</p>


<?php
include $rootpath . '/include/footer.txt';
?>
