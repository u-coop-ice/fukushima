<?php

$self = preg_split("/\//", $_SERVER['PHP_SELF']);

$depth = count($self);

for ($i = 1; $i <= $depth; $i++) {
	if (preg_match("/\.php/", $self[$i])) {
		$phpfilename = $self[$i];
		break;
	}
}

$pos = strrpos($phpfilename, '.');
$filename = substr($phpfilename, 0, $pos); // ファイル名（.php抜き）を取得

//$message = '<p class="note">掲載の情報は2015年度のものです。2016年度に向けてただ今準備中です。</p>';

$title["home"]["index"] = '';
$title["home"]["privacypolicy"]["index"] = 'プライバシーポリシー';
$title["home"]["customer_harassment"]["index"] = '従業員保護';
$title["home"]["personaldata"]["index"] = '個人情報の保護について';
$title["home"]["rijikai"]["index"] = '理事会';
$title["home"]["sodaikai"]["index"] = '総代会';
$title["home"]["about"]["index"] = '福島大学生協とは';
$title["home"]["ucapp"]["index"] = '大学生協アプリ';


$title["home"]["sodaikai2020"]["report"] = '総代会終了報告';
$title["home"]["sodaikai2020"]["sodaikai"] = '総代会告示';
$title["home"]["sodaikai2020"]["senkyo"] = '総代選挙公示';
$title["home"]["sodaikai2020"]["yakuin"] = '役員選挙公示';
$title["home"]["sodaikai2020"]["kaisaiannai"] = '第89回通常総代会開催のご案内';
$title["home"]["sodaikai2020"]["notice"] = '2020年度 通常総代会招集通知';

$title["home"]["sodaikai"]["report"] = '総代会終了報告';
$title["home"]["sodaikai"]["sodaikai"] = '総代会告示';
$title["home"]["sodaikai"]["senkyo"] = '総代選挙公示';
$title["home"]["sodaikai"]["yakuin"] = '役員選挙公示';
$title["home"]["sodaikai"]["kaisaiannai"] = '第90回通常総代会開催のご案内';
$title["home"]["sodaikai"]["notice"] = '2021年度 通常総代会招集通知';

$title["home"]["whatsnew"]["index"] = '新着情報';
$title["home"]["sitemap"]["index"] = 'サイトマップ';
$title["home"]["teikan"]["index"] = '定款';
$title["home"]["articles"]["index"] = '定款・規則・規約等';
$title["home"]["regulation"]["index"] = '規約・規則等';
$title["home"]["regulation"]["koumuin"] = '公務員講座 規定';
$title["home"]["aid"]["sd"]["index"] = 'CO･OP学生総合共済勧誘方針';

$title["home"]["news"]["2020covid19"]["index"] = '新型コロナウイルス感染症対応';
$title["home"]["news"]["2020covid19"]["action"] = '新型コロナウイルス影響拡大への対策・対応';
$title["home"]["news"]["2020covid19"]["hakama"] = '福島大学　学位記授与式中止による卒業袴の対応について';
$title["home"]["news"]["200529news"] = '図書館店からのおしらせ';
$title["home"]["news"]["200824news"] = '新型コロナウイルス感染症を「不慮の事故とみなす感染症」として取り扱います';
$title["home"]["news"]["online_consultation"]["index"] = '福島大学生協オンライン相談会';
$title["home"]["news"]["youtube"]["index"] = 'YouTubeはじめました!!';
$title["home"]["news"]["210119news"] = '食堂メニュー価格改定のお知らせ';
$title["home"]["news"]["210401"] = '組合員証（コプリカ）のお渡しについて';
$title["home"]["news"]["220128_time"]["index"] = '遠隔授業に伴い営業時間変更のお知らせ';
$title["home"]["news"]["211029pctenken"]["index"] = '生協パソコン点検会';
$title["home"]["news"]["pctenken"]["index"] = '生協Surface点検会';

$title["store"]["index"] = '店舗';
$title["store"]["time"]["index"] = '営業時間';
$title["store"]["access"]["index"] = 'アクセスマップ';
$title["store"]["react"]["index"] = '購買店 Re;act';

$title["foodservice"]["index"] = '食';
$title["foodservice"]["green"]["index"] = 'Quick Lunch グリーン';
$title["foodservice"]["reaf"]["index"] = 'ダイニング リーフ';
$title["foodservice"]["meal"]["index"] = 'ミールパス';
$title["foodservice"]["news"]["230512tennotsubu"]["index"] = '3店舗のお米が「天のつぶ」に変わります！';

$title["insurance"]["index"] = '住まい・共済';

$title["insurance"]["bousai"]["index"] = 'もしもの時のために備えよう災害時に命を守るために必要なこと';
$title["insurance"]["bousai"]["bousai_gift"] = '長期保存食販売特設ページ';

$title["travel"]["index"] = '旅行';
$title["travel"]["kaigaitehai"]["index"] = '海外航空券手配';
$title["travel"]["gogaku"]["index"] = '語学留学・テーマのある旅相談会開催';
$now_year = date("Y");

for ($i = 0; $i <= 2; $i++) {
	$y = $now_year - $i - 2000;
	for ($j = 1; $j <= 12; $j++) {
		$title["aid"][$y]['index_' . $y . sprintf("%02d", $j)] = "学生総合共済・火災共済の" . ($y + 2000) . "年" . $j . "月の給付実績";
	}
}

$title["shopping"]["index"] = 'ショッピング・教科書';
$title["shopping"]["fruits"]["index"] = '福島のフルーツ';
$title["shopping"]["text"]["index"] = '教科書販売についてのご案内';
$title["shopping"]["goods"]["index"] = 'オリジナルグッズ';

$title["graduate"]["index"] = '卒業';

$title["graduate"]["album"]["index"] = '卒業アルバム';
$title["graduate"]["album"]["photo"] = '写真撮影';
$title["graduate"]["hakama"]["index"] = '卒業式袴衣装 早期・学内展示予約会のご案内';

$title["career"]["index"] = '学内講座・資格';
$title["career"]["careersupport"]["index"] = 'キャリアサポートサイト';
$title["career"]["toeic"]["index"] = 'TOEIC Listening & Reading IP Test情報';
$title["career"]["flying"]["index"] = '公務員講座フライングスタート講座のご案内';
$title["career"]["public"]["index"] = '公務員採用試験対策講座';
$title["career"]["public_conference"]["index"] = 'なんでも相談会';
$title["career"]["public_startin"]["index"] = 'スタート イン講座';
$title["career"]["sg"]["index"] = '【大学生協推奨】教員講座(WEB)申込み開始のお知らせ';
$title["career"]["ict"]["index"] = '新社会人のためのICT活用講座';
$title["career"]["next_MovieContent"]["index"] = 'Ne”x”t動画コンテンツ';

$title["menkyo"]["fukushima"]["index"] = '自動車運転免許';
$title["menkyo"]["fukushima"]["school"] = '提携校一覧';


$title["GI"]["index"] = '福島学生委員会';
$title["GI"]["spling"] = '春の活動';
$title["GI"]["summer"] = '夏の活動';
$title["GI"]["autumn"] = '秋の活動';
$title["GI"]["other"] = '冬･その他のの活動';
$title["GI"]["club"] = 'サークル・団体';

$dirurl = '/';
global $focus;
$focus = array();
$breadcrumb = '<a href="/">HOME</a>';
$dd = "";
$dt = "";

for ($i = 1; $i <= ($depth - 1); $i++) {
	if ($self[$i] != end($self)) {
		$dd .= "['" . $self[$i] . "']";
		$dt .= $self[$i];
		$dirurl .= $self[$i] . '/';
//		eval("\$focus['" . $dt . "'] = 'focus current';");
		$focus[$dt] = 'focus current';

	} else {
		if (end($self) != "index.php") {
			$str = "return \$title" . ${dd} . "['" . $filename . "'];"; // return 重要!!
			$title_text = eval($str);
			$breadcrumb .= '&nbsp;&gt;&nbsp;<a href="' . $_SERVER["PHP_SELF"] . '">' . $title_text . '</a>';
			$dt .= $filename;
//			eval("\$focus['" . $dt . "'] = 'focus current';");
			$focus[$dt] = 'focus current';
		}
		break;
	}
	if ($self[$i] == "home") {continue;}
	$str = "return \$title" . $dd . "['index'];"; // return 重要!!
	$title_text = eval($str);
	if (!$title_text) {continue;}
	$breadcrumb .= '&nbsp;&gt;&nbsp;<a href="' . $dirurl . '">' . $title_text . '</a>';
} //for

if ($self[1] == 'index.php') {
	$title_text = '';
	$focus["home"] = 'focus current';
	$page_id = "page_home";
}

$page_title = $title_text;

if ($title_text != "") {
	$title_text = $title_text . ' :: ';
}

//wordpress用補足

if ($wp_text) {
	$title_text = $wp_text . ' - ' . $title_text;
	$breadcrumb .= '&nbsp;&gt;&nbsp' . $wp_text;
}

?>
