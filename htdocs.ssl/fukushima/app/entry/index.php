<?php
require_once '../../adm/lib/set_path.php';

// ライブラリの組み込み

require_once 'initialize.php';
require_once 'userSmarty.php';

//$smarty->assign('post', []);

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
			$cinfo = new appEntryDB();
			$cinfo->setAuth($userAuth);
			$cinfo->set_category_code($category_code);
			$categoryinfo = $cinfo->getEntryCategory();

//在庫テーブルから取得
			$stock = $cinfo->getAppEntryCountOnly();

			$app_count_state = $stock['status'];
			$stock_multi = $stock['stock_multi'];
			$smarty->assign('stock_multi', $stock_multi);

//在庫簡易チェック
			if ($stock['status'] < 1) {
				throw new Exception("お申込みは予定数に達しました。", 1);
			}

			if ($categoryinfo['date_limit']) {
				if (time() > strtotime($categoryinfo['date_limit'])) {
					$smarty->assign('closed', 1);
					throw new Exception("お申込みは終了しました。", 1);

				} else if (time() <= strtotime($categoryinfo['date_start'])) {
					throw new Exception('お申込みは' . $categoryinfo['date_start'] . 'より開始します。', 1);
				}
			}

			if ($categoryinfo['authorization']) {
				if ($categoryinfo['onduplicate'] == 1) {
					$cinfo->checkDuplicateApp();
				} else if ($categoryinfo['onduplicate'] == 9) {
					$cinfo->checkDuplicateComedateApp();
				}
			}

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
$stock_multi = HTTP_Session2::get('stock_multi');

$smarty->assign('post', $postdata);

$smarty->assign('category_id', $category_id);
$smarty->assign('category_ic', $category_code);

$smarty->assign("category", $category);          //項目のテンプレート発行
$smarty->assign("methods", $category['method']); //項目のテンプレート発行

if (count($stock_multi)) {
	$smarty->assign('stock_multi', $stock_multi);
}

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
// ログイン済みの場合の処理

// モードの初期化
$modes = [
	'input' => 1,
	'confirm' => 1,
	'reinput' => 1,
	'complete' => 1,
];

// URLでモードが設定されていなければ、「input」のモードにする
if (!isset($_GET['mode'])) {
	$_GET['mode'] = 'input';
	$smarty->assign('mode', 'input');
	$smarty->assign('step', [1 => 'now']);
	// セッション初期化
	$postdata = [];
	HTTP_Session2::set('postdata', $postdata);
}

$mode = htmlspecialchars($_GET['mode'], 3, 'UTF-8');
$smarty->assign('mode', $mode);

$stepsFile[COMPONENT] = [
	'input' => 'entry',
	'confirm' => 'entry',
	'complete' => 'entry',
];
$smarty->assign('stepsFile', $stepsFile);

$confirmList = [
	'input' => 1,
	'confirm' => 1,
	'reinput' => 1,
];

$smarty->assign('confirmList', $confirmList);

// モードに応じたページを表示
if ($modes[$_GET['mode']]) {
	$smarty->assign('show_menu', 1);
	require_once 'entry/' . $_GET['mode'] . '.php';
}
// 存在しないモードを指定された場合はエラーを表示
else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'そのようなモードはありません。');
	$smarty->display('error.tpl');
}

?>
