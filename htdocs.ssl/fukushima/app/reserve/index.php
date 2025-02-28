<?php
require_once '../../adm/lib/set_path.php';

// ライブラリの組み込み

require_once 'initialize.php';
require_once 'userSmarty.php';

$category_code = HTTP_Session2::get('category_code');

if (!isset($_GET['mode'])) {

// URLにcdが指定されている
	if (isset($_GET['cd']) || $category_code) {

		HTTP_Session2::set('stock_multi', null);
		HTTP_Session2::set('postdata', null);

		if (isset($_GET['cd'])) {
			$category_code = htmlspecialchars(addslashes($_GET['cd']), 3, 'UTF-8');
		}

		HTTP_Session2::set('category_code', $category_code);

		try {
			$cinfo = new appReserveDB();
			$cinfo->setAuth($userAuth);
			$cinfo->set_category_code($category_code);
			$categoryinfo = $cinfo->getEntryCategory();

			$cinfo->checkWorkigEntryCategory($categoryinfo);

		} catch (Exception $e) {
			$errmsg = "不正なアクセスです";
			if ($e->getMessage()) {
				$errmsg = $e->getMessage();
			}

			switch ($e->getCode()) {
			case 7:
				$smarty->assign('stepsFile', []);
				$smarty->assign('page_title', 'エラー');
				$smarty->assign('errmsg', 'お申込みが重複しています');
				$smarty->display('duplicate.tpl');
				exit();
			case 3:
				$smarty->assign('msg_app', '<h5>' . $categoryinfo['denomination'] . '</h5>お申込みにはサインインが必要になります。ユーザーアカウントをお持ちでない方は、ユーザー新規登録をお願いします。');

				$smarty->display('login.tpl');
				exit();
				break;
			default:
				$smarty->assign('page_title', 'エラー');
				$smarty->assign('errmsg', $errmsg);
				$smarty->assign('category', $categoryinfo);

				$smarty->display('error.tpl');
				exit();

			}

		}

		HTTP_Session2::set('category_id', $categoryinfo['id']);
		HTTP_Session2::set('category', $categoryinfo);

		HTTP_Session2::set('method', $cinfo->get_method_category());
		HTTP_Session2::set('stock_multi', $cinfo->get_multi_stock());
	}
}

$postdata = HTTP_Session2::get('postdata');

$category_id = HTTP_Session2::get('category_id');
$category_code = HTTP_Session2::get('category_code');
$method = HTTP_Session2::get('method');
$category = HTTP_Session2::get('category');

$smarty->assign('post', $postdata);

$smarty->assign('view_category_id', $category_id);
$smarty->assign('category_ic', $category_code);

$smarty->assign("category", $category); //項目のテンプレート発行
$smarty->assign("methods", $category['method']); //項目のテンプレート発行

if (!$category_code) {
	//codeがみあたらない場合
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
}

if ($category['authorization']) {
	if (!$userAuth->checkAuth()) {
		$smarty->assign('msg_app', '<h5>' . $category['denomination'] . '</h5>お申込みにはサインインが必要になります。ユーザーアカウントをお持ちでない方は、ユーザー新規登録をお願いします。');

		$smarty->display('login.tpl');
		exit();
	}
}

try {

	$rsv = new appReserveDB();
	$rsv->set_category_id($category_id);
	$setDay = $rsv->getSetDays();
	$setOverDay = $rsv->get_setOverDay();
	$setDayList = $rsv->get_setDayList();

} catch (Exception $e) {
	$errmsg = "不正なアクセスです";
	if ($e->getMessage()) {
		$errmsg = $e->getMessage();
	}

	switch ($e->getCode()) {
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}

}

// カレンダー生成用
$setDays = implode(",", $setDay);
$setOverDays = implode(",", $setOverDay);

$smarty->assign("setDayList", $setDayList);
$smarty->assign("setDay", $setDays);
$smarty->assign("setOverDay", $setOverDays);
$smarty->assign("startYear", mb_substr(current($setDay), 1, 4));
$smarty->assign("startMonth", intval(mb_substr(current($setDay), 6, 2)));
$smarty->assign("startDay", intval(mb_substr(current($setDay), 9, 2)));
$smarty->assign("endYear", mb_substr(end($setDay), 1, 4));
$smarty->assign("endMonth", intval(mb_substr(end($setDay), 6, 2)));
$smarty->assign("endDay", intval(mb_substr(end($setDay), 9, 2)));

// モードの初期化
$modes = [
	'input' => 1,
	'confirm' => 1,
	'reinput' => 1,
	'complete' => 1,
	'select_calendar_time' => 1,
];

// URLでモードが設定されていなければ、「input」のモードにする
if (!isset($_GET['mode'])) {
	$_GET['mode'] = 'input';
	$smarty->assign('mode', 'input');
	$smarty->assign('step', array(1 => 'now'));
	// セッション初期化
	$postdata = [];
	HTTP_Session2::set('postdata', $postdata);
}

$mode = htmlspecialchars($_GET['mode'], 3, 'UTF-8');
$smarty->assign('mode', $mode);

$stepsFile[COMPONENT] = array(
	'input' => 'reserve',
	'confirm' => 'reserve',
	'complete' => 'reserve',
);
$smarty->assign('stepsFile', $stepsFile);

$confirmList = array(
	'input' => 1,
	'confirm' => 1,
	'reinput' => 1,
);

$smarty->assign('confirmList', $confirmList);

// モードに応じたページを表示
if ($modes[$_GET['mode']]) {
	$smarty->assign('show_menu', 1);
	require_once 'reserve/' . $_GET['mode'] . '.php';
}
// 存在しないモードを指定された場合はエラーを表示
else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'そのようなモードはありません。');
	$smarty->display('error.tpl');
}

exit();

// URLにcdが指定されている
if (preg_match('/^leave/', PART)) {

	HTTP_Session2::set('stock_multi', null);

	$cinfo = new livingDB();
	$cinfo->set_params(array('component' => COMPONENT, 'part' => PART));
	$data = $cinfo->get_init_category_info();

	if ($data['id']) {
		HTTP_Session2::set('category_id', $data['id']);
		HTTP_Session2::set('category_denomination', $data['denomination']);
		HTTP_Session2::set('category_description', $data['description']);
		HTTP_Session2::set('category_description_web', $data['description_web']);
	} else {
		$smarty->assign('page_title', '不正なアクセス');
		$smarty->assign('errmsg', '不正なアクセスです。');
		$smarty->display('error.tpl');
		exit();
	}

//ガラケーチェック

	if (!$agent->isNonMobile()) {
		$smarty->assign('page_title', 'デバイスエラー');
		$smarty->assign('errmsg', 'フューチャーフォンには対応していません。パソコン・スマートフォンからアクセスしてください。');
		$smarty->assign('category', $data);
		$smarty->display('error.tpl');
		exit();
	}

//重複申込のチェック
	if ($is_login && $data['onduplicate'] == 9) {

		$dpdata = array();
		$dpdata[":regist_id"] = $auth_user_id;

		$dps = new livingDB();
		$dps->set_postdata($dpdata);

		$duc = $dps->get_duplicate();

		if ($smarty->getTemplateVars("db_error")) {
			// データベースアクセスに失敗したらエラーとする
			$smarty->assign('page_title', 'データベース接続エラー');
			$smarty->assign('errmsg', 'データベースからのデータの読み込みに失敗しました。');
			$smarty->display('error.tpl');
			exit();
		}

		if ($duc > 0) {
//				$scdata = array();
			//				HTTP_Session2::set('scdata', $scdata); //セッションキャッシュ解除
			$smarty->assign('page_title', '重複申込エラー');
			$smarty->assign('errmsg', 'お申込みが重複しています。');
			$smarty->display('duplicate.tpl');
			exit();
		}

	}

	if ($data['date_limit']) {
		if (time() > strtotime($data['date_limit'])) {

			$smarty->assign('page_title', 'お申込みエラー');
			$smarty->assign('errmsg', 'お申込みは終了しました。');
			$smarty->assign('category', $data);
			$smarty->display('error.tpl');
			exit();
		} else if (time() <= strtotime($data['date_start'])) {
			$smarty->assign('page_title', 'お申込みエラー');
			$smarty->assign('errmsg', 'お申込みは' . $data['date_start'] . 'より開始します。');
			$smarty->assign('category', $data);
			$smarty->display('error.tpl');
			exit();
		}
	}

	$methods = json_decode($data['method'], ture);

	$method = array();

	foreach ($methods as $key => $value) {
		if ($key != 'extra') {
			if ($value['use']) {
				$method[$key] = $value['sort'];
			}
		} else {
			foreach ($value as $k => $v) {
				if ($v['use']) {
					$method[$key . $k] = $v['sort'];
				}
			}
		}
	}
	asort($method);

	HTTP_Session2::set('authorization', $data['authorization']);
	HTTP_Session2::set('methods', $methods);
	HTTP_Session2::set('method', $method);
	HTTP_Session2::set('category_denomination', $data['denomination']);
	HTTP_Session2::set('category_description', $data['description']);
	HTTP_Session2::set('category_description_web', $data['description_web']);
	HTTP_Session2::set('category_comedate_title', $data['comedate_title']);
	HTTP_Session2::set('category_cometime_title', $data['cometime_title']);
}

//--------------------------------

$entrydata = HTTP_Session2::get('entrydata');
$code = HTTP_Session2::get('code');
$authorization = HTTP_Session2::get('authorization');
$method = HTTP_Session2::get('method');
$methods = HTTP_Session2::get('methods');
$category_id = HTTP_Session2::get('category_id');
$category_denomination = HTTP_Session2::get('category_denomination');
$category_description = HTTP_Session2::get('category_description');
$category_description_web = HTTP_Session2::get('category_description_web');
//}

$sf = new livingDB();
$sf->set_ship_flag($methods['ship_flag']);
$category_ship_flag_list = $sf->get_ship_flag_list();
$smarty->assign('category_id', $category_id);
$smarty->assign('category_ic', $code);
$smarty->assign('category_ship_flag_list', $category_ship_flag_list);

$smarty->assign("methods", $methods); //項目のテンプレート発行
$smarty->assign("category_denomination", $category_denomination); //項目のテンプレート発行
$smarty->assign("category_description", $category_description); //項目のテンプレート発行
$smarty->assign("category_description_web", $category_description_web); //項目のテンプレート発行

$smarty->assign("category_comedate_title", HTTP_Session2::get('category_comedate_title')); //項目のテンプレート発行
$smarty->assign("category_cometime_title", HTTP_Session2::get('category_cometime_title')); //項目のテンプレート発行

/*
if (!$code) {
//codeがみあたらない場合
$smarty->assign('page_title', 'エラー');
$smarty->assign('errmsg', '不正なアクセスですよ');
$smarty->display('error.tpl');
exit();
}
 */

if ($authorization) {
	if (!$is_login) {
		$smarty->assign('msg_app', '<h5>' . $category_denomination . '</h5>お申込みにはサインインが必要になります。ユーザーアカウントをお持ちでない方は、ユーザー新規登録をお願いします。');

		$smarty->display('login.tpl');
		exit();
	}

	if ($data['onduplicate'] == 9) {

		$dp = new setDB();
		$dp->set_auth_user_id($auth_user_id);
		$dp->set_category_id($category_id);
		if ($dp->get_check_duplicate() > 0) {
			$smarty->assign('page_title', '重複申込エラー');
			$smarty->assign('errmsg', '重複して申込はできません。');
			$smarty->display('duplicate.tpl');
			exit();
		}
	}
}

$sc = new livingDB();

$setDay = $sc->getSetDays();
$setOverDay = $sc->get_setOverDay();
$setDayList = $sc->get_setDayList();

if (count($setDay) == 0) {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '選択可能日がありません。');
	$smarty->display('error.tpl');
	exit();
}

// カレンダー生成用
$setDays = implode(",", $setDay);
$setOverDays = implode(",", $setOverDay);

$smarty->assign("setDayList", $setDayList);
$smarty->assign("setDay", $setDays);
$smarty->assign("setOverDay", $setOverDays);
$smarty->assign("startYear", mb_substr(current($setDay), 1, 4));
$smarty->assign("startMonth", intval(mb_substr(current($setDay), 6, 2)));
$smarty->assign("startDay", intval(mb_substr(current($setDay), 9, 2)));
$smarty->assign("endYear", mb_substr(end($setDay), 1, 4));
$smarty->assign("endMonth", intval(mb_substr(end($setDay), 6, 2)));
$smarty->assign("endDay", intval(mb_substr(end($setDay), 9, 2)));

// ログイン済みの場合の処理

// モードの初期化
$modes = array('welcome' => 1,
	'input' => 1,
	'confirm' => 1,
	'reinput' => 1,
	'complete' => 1,
	'select_calendar_time' => 1,
);

// URLでモードが設定されていなければ、「input」のモードにする
if (!isset($_GET['mode'])) {
	$_GET['mode'] = 'input';
	$smarty->assign('mode', 'input');
	$smarty->assign('step', array(1 => 'now'));
	// セッション初期化
	$entrydata = array();

	if (isset($_GET['sf'])) {
		$entrydata['ship_flag'] = intval(trim($_GET['sf']));
		if (!$category_ship_flag_list[$entrydata['ship_flag']]) {
			$smarty->assign('page_title', '不正なアクセス');
			$smarty->assign('errmsg', '不正なアクセスです。');
			HTTP_Session2::set('entrydata', array());
			$smarty->display('error.tpl');
			exit();
		}

	} else {
		$smarty->assign('page_title', '不正なアクセス');
		$smarty->assign('errmsg', '不正なアクセスです。');
		HTTP_Session2::set('entrydata', array());
		$smarty->display('error.tpl');
		exit();
	}
	$smarty->assign('post', $entrydata);
	HTTP_Session2::set('entrydata', $entrydata);
} else {
	if ($entrydata['complete']) {
		$smarty->assign('page_title', 'お申込みは完了しています');
		$smarty->assign('errmsg', 'お申込みは完了しています。');
		HTTP_Session2::set('entrydata', array());
		$smarty->display('error.tpl');
		exit();

	} else if (!isset($entrydata['ship_flag'])) {
		$smarty->assign('page_title', '不正なアクセス');
		$smarty->assign('errmsg', '不正なアクセスです。');
		HTTP_Session2::set('entrydata', array());
		$smarty->display('error.tpl');
		exit();
	}
}

if ($entrydata['ship_flag'] == 2) {
	unset($method['bank']);
	unset($methods['bank']);
	HTTP_Session2::set('methods', $methods);
	HTTP_Session2::set('method', $method);
}

$mode = htmlspecialchars($_GET['mode'], 3, 'UTF-8');
$smarty->assign('mode', $mode);

$stepsFile[COMPONENT] = array(
	'input' => 'leave',
	'confirm' => 'leave',
	'complete' => 'leave',
);
$smarty->assign('stepsFile', $stepsFile);

$confirmList = array(
	'input' => 1,
	'confirm' => 1,
	'reinput' => 1,
);

$smarty->assign('confirmList', $confirmList);

// モードに応じたページを表示
if ($modes[$_GET['mode']]) {
	$smarty->assign('show_menu', 1);
	require_once 'leave/' . $_GET['mode'] . '.php';
}
// 存在しないモードを指定された場合はエラーを表示
else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'そのようなモードはありません。');
	$smarty->display('error.tpl');
}

?>
