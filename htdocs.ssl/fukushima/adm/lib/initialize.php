<?php

function initialize() {
	// グローバル変数の設定
	global $smarty, $init_description, $init_coopname, $init_coopnameOfficial, $init_url, $init_coopurl;
	global $init_univurl, $init_univname;
	global $dbuser, $dbpass, $dbuser_regist, $dbpass_regist, $dbhost, $database, $dbsocket, $dbsocket_repl, $pfx, $pfx2;
	global $dbuser_cmp, $dbpass_cmp;
	global $idms_salt, $idms_serviceID, $idms_base_url;
// 初期設定情報の読み込み

	$smarty->configLoad('config.php');

//Sendgrid Api
	define('SENDGRID_API_KEY', $smarty->getConfigVars('sendgrid_api_key'));

	$smarty->assign('GOOGLE_CODE', $smarty->getConfigVars('init_google_code'));
	$smarty->assign('GOOGLE_CODE_M', $smarty->getConfigVars('init_google_code_m'));

	$init_coopname = $smarty->getConfigVars('init_coopname');
	$smarty->assign('init_coopname', $init_coopname);

	$init_coopnameOfficial = $smarty->getConfigVars('init_coopnameOfficial');
	$smarty->assign('init_coopnameOfficial', $init_coopnameOfficial);

	$init_coopnameE = $smarty->getConfigVars('init_coopnameE');
	$smarty->assign('init_coopnameE', $init_coopnameE);

	$init_coopurl = $smarty->getConfigVars('init_coopurl');
	$smarty->assign('init_coopurl', $init_coopurl);

	$init_url = $smarty->getConfigVars('init_url');
	$smarty->assign('init_url', $init_url);

	$init_univname = $smarty->getConfigVars('init_univname');
	$smarty->assign('init_univname', $init_univname);

	$init_univurl = $smarty->getConfigVars('init_univurl');
	$smarty->assign('init_univurl', $init_univurl);

	$registList = [-9 => '非登録', 1 => '登録済', 9 => '退会済'];
	$smarty->assign('registList', $registList);

	$prefList = ['', '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '東京都', '神奈川県', '埼玉県',
		'千葉県', '茨城県', '栃木県', '群馬県', '山梨県', '新潟県', '長野県', '富山県', '石川県', '福井県',
		'愛知県', '岐阜県', '静岡県', '三重県', '大阪府', '兵庫県', '京都府', '滋賀県', '奈良県', '和歌山県',
		'鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県',
		'佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'];

	$identityList = ['学部学生', '大学院生', '研究生', '科目履修生', '教員', '職員', 'その他'];
	$smarty->assign('identityList', $identityList);

	$smarty->assign('prefList', $prefList);

	$smarty->assign('monthList', ['' => '（月）', 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12]);

	$yearList = ['' => '（年）'];
	$registYearList = ['' => '（年）'];
	$birthYearList = ['' => '（年）'];
	$now_year = date('Y');
	for ($i = 1; $i < 13; ++$i) {
		$ttt = $now_year + ($i - 1);
		$yearList[$ttt] = $ttt;
	}

	for ($i = 1; $i < 13; ++$i) {
		$ttt = $now_year - ($i - 1);
		$registYearList[$ttt] = $ttt;
	}
	for ($i = 1; $i < 100; ++$i) {
		$ttt = $now_year - (15 + $i - 1);
		$birthYearList[$ttt] = $ttt;
	}

	$smarty->assign('yearList', $yearList);
	$smarty->assign('registYearList', $registYearList);
	$smarty->assign('birthYearList', $birthYearList);

	$dayList = ['' => '（日）'];
	for ($i = 1; $i <= 31; ++$i) {
		$dayList[$i] = $i;
	}
	$smarty->assign('dayList', $dayList);

	$expYearList = [''];
	for ($i = 0; $i <= 15; $i++) {
		array_push($expYearList, date('Y') + $i);
	}

	$smarty->assign('expYearList', $expYearList);

	$expMonthList = ['', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
	$smarty->assign('expMonthList', $expMonthList);

	$smarty->assign('paymentJpoList', ['10' => "一括払い", "61C03" => "分割3回払い", "61C05" => "分割5回払い", "61C06" => "分割6回払い", "61C10" => "分割10回払い", "61C12" => "分割12回払い", "80" => "リボ払い"]);

	$newaddList = ['1' => '実家とは異なる', '3' => '実家と同じ'];
	$smarty->assign('newaddList', $newaddList);

	$sexList = ['' => '', 1 => '男', 2 => '女', 9 => '不明'];
	$smarty->assign('sexList', $sexList);

	$rankList = ['' => '', 1 => '本人', 2 => '保護者'];
	$smarty->assign('rankList', $rankList);

	$memberList = [1 => '学生', 2 => '夜間生', 3 => '短大生', 4 => '院生', 9 => 'その他'];
	$smarty->assign('memberList', $memberList);

	$parentRelationList = ['', '父', '母', 'その他'];
	$smarty->assign('parentRelationList', $parentRelationList);

	$smarty->assign('schoolyear', ['', '1年', '2年', '3年', '4年', '院生', 'その他']);

	$smarty->assign('bankSortList', [1 => '普通', 2 => '当座']);

	$smarty->assign('extraList', [0 => ' 不使用', 1 => ' 任意項目', 2 => ' 必須項目']);

	$smarty->assign('useList', [0 => ' 不使用', 2 => ' 必須項目']);
	$smarty->assign('onoffList', [0 => 'OFF', 1 => 'ON']);
	$smarty->assign('onoffmultiList', [0 => 'OFF', 1 => 'ON', 2 => 'MULTIPLE']);
	$smarty->assign('applicationList', [-1 => '未申込', 1 => '申込済']);
	$smarty->assign('componentList', ['entry' => '汎用エントリ', 'shopping' => 'ショッピング']);

	$smarty->assign('tagList', ['checkbox' => 'checkbox', 'radio' => 'radio', 'select' => 'select', 'text' => 'text', 'textarea' => 'textarea']);
	$smarty->assign('tagstockList', ['radio' => 'radio', 'select' => 'select']);

	$smarty->assign('reasonList', ['', '生協組合員ではなくなった', 'あまり使わなかった', 'メールなどの連絡を受け取りたくない', 'サービスの品質に不満がある', '更新および欲しい情報がない', 'その他']);

	$reactList = [0 => '未対応', 1 => '未対応', 2 => '対応中', 3 => '対応中', 9 => '対応済'];
	$smarty->assign('reactList', $reactList);
	$smarty->assign('reactColorList', [0 => 'orange', 1 => 'red', 2 => 'yellow', 3 => 'yellow', 9 => 'navy']);

	$smarty->assign('stateColorList', [0 => 'green', 1 => 'black', -1 => 'red']);
	$smarty->assign('stockColorList', [1 => 'green', 0 => 'navy', -1 => 'red']);

	$readList = [0 => '未読', 1 => '既読'];
	$smarty->assign('readList', $readList);

// 支払い方法リスト
	$paymentList = [1 => '郵便払込', 2 => '大学生協購買店にてお支払い', 3 => '銀行振込',
//		, 4 => 'クレジットカード',
		5 => 'クレジットカード',
	];
	$smarty->assign('paymentList', $paymentList);

//veritransの変数

	$detailOrderTypeList = ['a' => '与信',
		'ax' => '与信（期限切れ）',
		'ap' => '与信（保留）',
		'ac' => '与信売上',
		'acp' => '与信売上（保留）',
		'pa' => '売上',
		'rn' => '新規返品',
		'rnp' => '新規返品（保留）',
		'va' => '与信→取消',
		'rad' => '与信→取消',
		'rae' => '与信→取消',
		'vap' => '与信→取消（保留）',
		'rap' => '与信→取消（保留）',
		'vac' => '与信売上→取消',
		'racd' => '与信売上→取消',
		'race' => '与信売上→取消',
		'vacp' => '与信売上→取消（保留）',
		'racp' => '与信売上→取消（保留）',
		'vpa' => '売上→取消',
		'rpad' => '売上→取消',
		'rpae' => '売上→取消（残額有）',
		'vpap' => '売上→取消（保留）',
		'rpap' => '売上→取消（保留）',
		'drpad' => '売上→ダイレクト返品',
		'drpae' => '売上→ダイレクト返品（残額有）',
//cvs
		'authorize' => '決済請求',
		'cancel_authorize' => '決済請求取消',
		'capture' => '決済完了（入金済）',
		'fix_capture' => '決済完了（入金確定）',
		'cancel_capture' => '決済完了（入金取消）',

	];
	$smarty->assign('detailOrderTypeList', $detailOrderTypeList);

	$detailOrderColorList = [
		'a' => 'yellow',
		'ax' => 'red',
		'ap' => 'gray',
		'ac' => 'green',
		'acp' => 'black',
		'pa' => 'green',
		'rn' => 'black',
		'rnp' => 'black',
		'va' => 'black',
		'rad' => 'black',
		'rae' => 'black',
		'vap' => 'black',
		'rap' => 'gray',
		'vac' => 'black',
		'racd' => 'black',
		'race' => 'black',
		'vacp' => 'gray',
		'racp' => 'gray',
		'vpa' => 'black',
		'rpad' => 'black',
		'rpae' => 'green',
		'vpap' => 'gray',
		'rpap' => 'gray',
		'drpad' => 'black',
		'drpae' => 'green',
//cvs
		'authorize' => 'yellow',
		'cancel_authorize' => 'black',
		'capture' => 'green',
		'fix_capture' => 'green',
		'cancel_capture' => 'black',
	];
	$smarty->assign('detailOrderColorList', $detailOrderColorList);

	$weightList = [3 => '3kg', 5 => '5kg', 10 => '10kg'];
	$smarty->assign('weightList', $weightList);

	$paymentAdminList = [1 => '郵便払込', 2 => '店頭', 3 => '銀行振込',
//		4 => 'PAY.JP',
		5 => '全旅',
	];
	$smarty->assign('paymentAdminList', $paymentAdminList);

	$smarty->assign('paymentTypeList', [1 => 0, 2 => 0, 3 => 0, 4 => 1, 5 => 1]);

	$shipList = [0 => 'ご注文者さまに発送', 1 => 'ご注文者さまとは別のお届け先に発送', 2 => '店頭にて受け取り'];
	$smarty->assign('shipList', $shipList);

	$shipAdminList = [0 => '注文者宛', 1 => '注文者とは別の宛先', 2 => '店頭受取', -9 => 'お申込みのみ（配送・お渡しのない商品、講座など）＊未完成'];
	$smarty->assign('shipAdminList', $shipAdminList);

	$shipTypeList = [0 => 1, 1 => 1, 2 => 0];
	$smarty->assign('shipTypeList', $shipTypeList);

	$storeList = ['', 'SHAREA', '医学部店'];
	$smarty->assign('storeList', $storeList);

// 送料
	$postageList = [0 => '', 1 => '送料別', 2 => '送料込'];
	$smarty->assign('postageList', $postageList);

// 包装状態
	$packageList = ['', '無包装', '簡易包装', '簡易バック', '二重包装', '化粧箱（完全包装）', '保冷袋'];
	$smarty->assign('packageList', $packageList);

// 包装状態
	$temperatureList = [0 => '', 1 => '常温', 2 => '冷蔵', 3 => '冷凍'];
//	$temperatureList = array(0 => '', 1 => 'ゆうパック', 2 => 'チルドゆうパック', 3 => '冷凍ゆうパック', 4 => 'クロネコヤマト', 5 => 'クロネコヤマトクール');
	$smarty->assign('temperatureList', $temperatureList);

// 配送不可
	$nosendList = [0 => '', 1 => '離島へのお届け不可', 2 => '小笠原・伊豆諸島不可（大島・八丈除く）'];
	$smarty->assign('nosendList', $nosendList);

// 配達時間リスト
	$shipTimeList = ['', '希望なし', '午前中', '12時〜14時', '14時〜16時', '16時〜18時', '18時〜20時', '20時〜21時'];
	$smarty->assign('shipTimeList', $shipTimeList);

	$shiptimeKeyList = ['' => '', 'non' => '指定なし', '0812' => '午前中（08：00～12：00）', '1416' => '14時〜16時（午後）', '1618' => '16時〜18時（夕方）', '1820' => '18時〜20時（夜間１）', '2021' => '20時〜21時（夜間２）'];
	$smarty->assign('shiptimeKeyList', $shiptimeKeyList);

	$noshiList = ['', '不要', '必要'];
	$smarty->assign('noshiList', $noshiList);

	$visibleList = [0 => '非表示', 1 => '表示'];
	$smarty->assign('visibleList', $visibleList);

	$publishList = [0 => '下書き', 1 => '公開'];
	$smarty->assign('publishList', $publishList);

	$visibleColorList = [0 => 'gray', 1 => 'green', 9 => 'black', -9 => 'gray'];
	$smarty->assign('visibleColorList', $visibleColorList);

	$noshi2List = ['', '不要', 'お中元', 'お歳暮', '紅白無地', 'その他'];
	$smarty->assign('noshi2List', $noshi2List);

	$billList = ['' => '', 1 => '商品に同梱', 2 => 'お申込み者さまに郵送', 3 => '指定住所に郵送'];
	$smarty->assign('billList', $billList);

	$statusList = [0 => '未対応', 1 => '処理済', 2 => '保留'];
	$smarty->assign('statusList', $statusList);

	$statusOrderList = [0 => '未対応', 1 => '手配済', 2 => '保留', 9 => 'キャンセル', -1 => "決済途中", -9 => "決済エラー"];
	$smarty->assign('statusOrderList', $statusOrderList);

//	$paidList = array(-1 => '要返金', 0 => '未払', 1 => '入金済', 2 => '保留');
	$paidList = [0 => '未払', 1 => '入金済', 2 => '要返金'];
	$smarty->assign('paidList', $paidList);

	$stateOpenList = [0 => '準備中', 1 => '受付中', 9 => '受付終了', -9 => '非表示'];
	$smarty->assign('stateOpenList', $stateOpenList);

	$labelList = [0 => 'label-danger', 1 => 'label-success', 2 => 'label-default', 9 => 'label-default'];
	$smarty->assign('labelList', $labelList);

	$ableList = [0 => '不可', 1 => '可'];
	$smarty->assign('ableList', $ableList);

	$dmList = [0 => '配信中', 1 => '停止'];
	$smarty->assign('dmList', $dmList);

	$intervalList = ['', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
	$smarty->assign('intervalList', $intervalList);

	$ageCheckList = [-1 => '未成年', 1 => '成年'];
	$smarty->assign('ageCheckList', $ageCheckList);

	$chargedList = [-9 => '失効済', -8 => '一部失効済', 0 => '仮売上', 1 => '実売上', 8 => '一部払戻済', 9 => '全額払戻済'];
	$smarty->assign('chargedList', $chargedList);

	$chargedColorList = [-9 => 'red', -8 => 'orange', 0 => 'yellow', 1 => 'green', 8 => 'gray', 9 => 'black'];
	$smarty->assign('chargedColorList', $chargedColorList);

//カード認証エラーメッセージ
	$errmsgCardList = ['card_declined' => 'カードの認証に失敗しました', 'incorrect_cvc' => 'CVCが間違っています', 'processing_error' => '処理中にエラーが発生しました', 'incorrect_number' => 'カードの番号が不正です', 'invalid_name' => 'カード名義のフォーマットが不正です', 'invalid_expiry_month' => 'カードの有効期限の月が不正です', 'invalid_expiry_year' => 'カードの有効期限の年が不正です', 'invalid_cvc' => 'カードのCVCが不正です', 'missing' => '請求を行った顧客にカードが紐付いていません',

	];

	$smarty->assign('errmsgCardList', $errmsgCardList);

//htkt

	$mediaList = [1 => 'キャンパス掲示', 2 => 'WEB投稿'];
	$smarty->assign('mediaList', $mediaList);
	$smarty->assign('mediaLabelList', [1 => 'default', 2 => 'primary']);

	if (COMPONENT == "arbeit") {
		$pfx = "arbeit_";

		$smarty->assign('department', ['', '教育学部', '人文社会学部', '農学生命科学部', '理工学部', '医学部医学科', '医学部保健学科', 'その他']);
		$smarty->assign('schoolyear', ['', '1年', '2年', '3年', '4年', '5年', '6年', '院生']);

		$lengthList = ['短期（1週間以内）', '短期（1ヶ月以内）', '短期（3ヶ月以内）', '長期'];
		$smarty->assign('lengthList', $lengthList);

		$emolumentList = ['', '時給', '日給', '月給'];
		$smarty->assign('emolumentList', $emolumentList);

		$emolument2List = ['', '時給'];
		$smarty->assign('emolument2List', $emolument2List);

		$trafficTypeList = ['あり', 'あり（一部）', 'あり（定額）', 'なし'];
		$smarty->assign('trafficTypeList', $trafficTypeList);
		$transportList = ['', '徒歩', '自転車', '車'];
		$smarty->assign('transportList', $transportList);

		$init_industry = $smarty->getConfigVars('init_industry');
		$industryList = explode(",", $init_industry);
		$smarty->assign('industryList', $industryList);

		$smarty->assign('statusList', [0 => '申請中', 1 => '公開', 2 => '取り下げ', 3 => '取り下げ(管理者)', 9 => '掲載不可', -9 => '下書き']);
		$smarty->assign('statusAskList', [0 => '未処理', 1 => '対応済', 9 => '保留']);
		$smarty->assign('paymentList', [0 => '未払い', 1 => '振込済', 2 => '現金済', 9 => 'キャンセル', -1 => 'その他']);

		$smarty->assign('listingFeeList', [0, 3300, 3850]);

		$smarty->assign('paymentColorList', [0 => 'yellow', 1 => 'green', -9 => 'orange']);
		$smarty->assign('statusColorList', [0 => 'yellow', 1 => 'green', 2 => 'gray', 3 => 'black']);

		$smarty->assign('visibleList', [0 => '未公開', 1 => '公開中', 2 => '掲載終了']);

		$smarty->assign('registStatusList', [0 => 'pendding', 1 => 'live', 9 => 'invalid', -9 => 'admin']);

		$smarty->assign('minuteList', ['', 0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]);

		$smarty->assign('mealList', ['あり', '補助', 'なし']);
		$smarty->assign('payList', ['日払い', '週払い', '月払い', 'アルバイト終了時（即時払い）', 'その他']);

		$connectList = [1 => '下記へ電話連絡', 2 => 'メールで連絡', 3 => '電話またはメールで連絡', 9 => 'その他'];
		$smarty->assign('connectList', $connectList);

		$purposeList = [1 => '中学受験', 2 => '高校受験', 3 => '大学受験', 4 => '学力養成', 9 => 'その他'];
		$smarty->assign('purposeList', $purposeList);

		$schoolList = ['' => '', 1 => '小学生', 2 => '中学生', 3 => '高校生', 9 => 'その他'];
		$smarty->assign('schoolList', $schoolList);

		$sexList = [1 => '男', 2 => '女'];
		$smarty->assign('sexList', $sexList);

		$subjectList = [1 => '全般', 9 => 'その他'];
		$smarty->assign('subjectList', $subjectList);

		$dayList = [1 => '月', 2 => '火', 3 => '水', 4 => '木', 5 => '金', 6 => '土', 7 => '日'];
		$smarty->assign('dayList', $dayList);

		$smarty->assign('departmentList', ['教育学部', '人文社会学部', '農学生命科学部', '理工学部', '医学部医学科', '医学部保健学科', 'その他']);

		$needList = [1 => '必要', 9 => '不要'];
		$smarty->assign('needList', $needList);

		$smarty->assign('status2List', [0 => '申請中', 1 => '公開', 3 => '取り下げ(管理者)', 9 => '掲載不可']);

	}

	$authList = [
		'regist' => ['name' => '登録ユーザー', 'description' => '登録ユーザー情報の閲覧'],
		'ask' => ['name' => 'お問い合わせ・システムメール', 'description' => 'お問い合わせの閲覧、システムメールの作成・送信'],
		'entry' => ['name' => '汎用エントリ', 'description' => '説明会等フォームの設定、説明会等のお申込み情報閲覧'],

		'reserve' => ['name' => '日付選択型エントリ', 'description' => '来店予約など日付選択型のエントリフォーム'],
		'shopping' => ['name' => 'ショッピング', 'description' => 'ショッピングカートのシステム管理',
			'master' => 'カテゴリの新規作成権限',
			'delete' => 'さまざまな削除権限',
		],
		'living' => ['name' => '不動産', 'description' => '不動産関連'],

		'mm' => ['name' => 'メルマガ・一斉メール送信', 'description' => 'メールマガジン・登録ユーザー向け一斉メールの設定および送信'],
		//		'master' => array('name' => 'システム管理', 'description' => '所属コード・大学合格種別（KLAS）の設定'),
	];
	$smarty->assign('authList', $authList);

	$smarty->assign('subAuthList', ['show', 'edit', 'delete', 'master']);

	$init_coopurl = $smarty->getConfigVars('init_coopurl');
	$smarty->assign('init_coopurl', $init_coopurl);

	$dbuser = $smarty->getConfigVars('dbuser');
	$dbpass = $smarty->getConfigVars('dbpass');
	$dbuser_regist = $smarty->getConfigVars('dbuser_regist');
	$dbpass_regist = $smarty->getConfigVars('dbpass_regist');
	$dbhost = $smarty->getConfigVars('dbhost');
	$database = $smarty->getConfigVars('database');
	$dbsocket = $smarty->getConfigVars('dbsocket');
	$dbsocket_repl = $smarty->getConfigVars('dbsocket_repl');

	$dbuser_cmp = $smarty->getConfigVars('dbuser_cmp');
	$dbpass_cmp = $smarty->getConfigVars('dbpass_cmp');

//組合員マスター問合せ系
	$idms_salt = $smarty->getConfigVars('idms_salt');
	$idms_serviceID = $smarty->getConfigVars('idms_serviceID');
	$idms_base_url = $smarty->getConfigVars('idms_base_url');
}

function my_convert_post($arr) {
	if (is_array($arr)) {
		return array_map('my_convert_kana', $arr);
	} else {
		$chg = trim($arr);
		$chg = mb_convert_kana($arr, 'KV');
		$chg = htmlspecialchars($chg, 3, 'UTF-8');

		return $chg;
	}
}

// 半角を全角に変換
function han2zen($string) {
	$before = ['!', '"', '#', '\$', '%', '&', "'", '\(', '\)', '=', '~', '\|', '-', '\^', '\\\\', '`', '\{', '@', '\[', '\+', '\*', '}', ';', ':', ']', '<', '>', '\?', '_', ',', '\.', '/', '「', '」'];
	$after = ['！', '”', '＃', '＄', '％', '＆', '’', '（', '）', '＝', '〜', '｜', '−', '＾', '¥', '｀', '｛', '＠', '［', '＋', '＊', '｝', '；', '：', '］', '＜', '＞', '？', '＿', '，', '．', '／', '「', '」'];

	foreach ($before as $i => $pattern) {
		$replacement = $after[$i];
		$string = mb_ereg_replace($pattern, $replacement, $string);
	}
//	$string = mb_ereg_replace("[-ー−‐]", "ー", $string);
	$string = mb_convert_kana($string, 'NRKHSV');
	$string = mb_ereg_replace('[-ー−‐]', 'ー', $string);

	return $string;
}

//全角半角変換関数定義

function zen2han($string) {
	$string = mb_convert_kana($string, 'anr', 'UTF-8');
	$string = mb_ereg_replace('ー', '-', $string);

	return $string;
}

function zen2han_more($string) {
	$string = mb_convert_kana($string, 'anrk', 'UTF-8');
	$string = mb_ereg_replace('ー', '-', $string);

	return $string;
}

function calc_age($string) {
	$age = (int) ((date('Ymd') - $string) / 10000);

	return $age;
}

function calc_mobilephone($string) {
	if (preg_match('/^050/', $string)) {
		$type = false;
	} elseif (preg_match("/^0\d0/", $string)) {
		$type = true;
	} else {
		$type = false;
	}

	return $type;
}
