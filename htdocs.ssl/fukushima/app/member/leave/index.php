<?php
require_once '../../../adm/lib/set_path.php';

// ライブラリの組み込み

require_once 'initialize.php';
require_once 'userSmarty.php';

$smarty->assign('post', array());

// URLにcdが指定されている
if (!isset($_GET['mode'])) {

// URLにcdが指定されている
	if (defined('PART') && PART == 'leave') {

		HTTP_Session2::set('stock_multi', null);
		HTTP_Session2::set('postdata', null);

		try {

			$obj = 'app' . ucfirst(COMPONENT) . ucfirst(PART) . 'DB';
			$cinfo = new $obj;
			$cinfo->setAuth($userAuth);
			$cinfo->set_component(COMPONENT);
			$cinfo->set_part(PART);
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

//--------------------------------

$postdata = HTTP_Session2::get('postdata');

$category_id = HTTP_Session2::get('category_id');
$method = HTTP_Session2::get('method');
$category = HTTP_Session2::get('category');
$stock_multi = HTTP_Session2::get('stock_multi');

$smarty->assign('post', $postdata);

$smarty->assign('category_id', $category_id);

$smarty->assign("category", $category); //項目のテンプレート発行
$smarty->assign("methods", $category['method']); //項目のテンプレート発行

if (count($stock_multi)) {
	$smarty->assign('stock_multi', $stock_multi);
}

if ($category['authorization']) {
	if (!$userAuth->checkAuth()) {
		$smarty->assign('msg_app', '<h5>' . $category['denomination'] . '</h5>お申込みにはサインインが必要になります。ユーザーアカウントをお持ちでない方は、ユーザー新規登録をお願いします。');

		$smarty->display('login.tpl');
		exit();
	}
}

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
	require_once PART . '/' . $_GET['mode'] . '.php';
}
// 存在しないモードを指定された場合はエラーを表示
else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'そのようなモードはありません。');
	$smarty->display('error.tpl');
}

?>
