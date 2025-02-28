<?php
require_once '../../../adm/lib/set_path.php';

require_once 'Auth/Auth.php';

require_once 'HTTP/Session2.php';
require_once 'Net/UserAgent/Mobile.php';

require_once 'initialize.php';
require_once 'userSmarty.php';

//classLoaderでクラスの自動呼び出し

require_once 'classLoader.class.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(ROOT_DIR . ADM_DIR . 'lib/Classes/');
$classLoader->registerDir(ROOT_DIR . ADM_DIR . 'lib/Classes/trait/');

if ($_SERVER['HTTPS'] != "on") {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', '不正なアクセスです。');
	$smarty->display('error.tpl');
	exit();
}

$askdata = HTTP_Session2::get('askdata');

$methods = array('email' => array('use' => 2), 'name' => array('use' => 2), 'student_phone' => array('use' => 2), 'memo' => array('use' => 2));

$smarty->assign('methods', $methods);

$purposeList = [
	'最新の空室情報を知りたい',
	'実際の物件を見たい',
	'その他',
];

$smarty->assign('purposeList', $purposeList);

// モードの初期化
$modes = array('welcome' => 1,
	'step1' => 1,
	'confirm' => 1,
	'complete' => 1,
);
// URLでモードが設定されていなければ、「step1」のモードにする
if (isset($_GET['mode'])) {
	$mode = htmlspecialchars($_GET['mode'], 3, 'UTF-8');
}
if (!isset($_GET['mode'])) {
// セッション初期化
	$askdata = [];
	HTTP_Session2::set('askdata', $askdata);

	$mode = 'step1';
	$steps[1] = 'now';
	$smarty->assign('step', $steps);
	$smarty->assign('mode', 'step1');

}
// モードに応じたページを表示
if ($modes[$mode]) {

	$stepsFile[PART] = array(
		'step1' => 'ask',
		'confirm' => 'ask',
		'complete' => 'ask',
	);
	$smarty->assign('stepsFile', $stepsFile);

//        $smarty->assign('show_menu', 1);
	$smarty->assign('mode', $mode);
	require_once PART . '/' . $mode . '.php';
}
// 存在しないモードを指定された場合はエラーを表示
else {
	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', 'そのようなモードはありません。');
	$smarty->display('error.tpl');
}

//}

?>
