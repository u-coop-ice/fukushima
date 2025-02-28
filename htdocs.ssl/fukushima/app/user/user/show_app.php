<?php

// URLから記事のIDを得る

if (isset($_GET['ic'])) {
	$view_app_ic = htmlspecialchars($_GET['ic'], ENT_QUOTES, 'UTF-8');

	$smarty->assign('view_app_ic', $view_app_ic);

	if (!$view_app_ic) {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', '不正なアクセスです。');
		$smarty->display('error.tpl');
		exit();
	}

	$ap = new appUserDB;
	$ap->setAuth($userAuth);
	$ap->set_app_code($view_app_ic);
	$appinfo = $ap->getAppInfoArranged();

	$smarty->assign('app', $appinfo);
	$smarty->assign('methods', $appinfo['methods']);
	$smarty->assign('method', $appinfo['method']);
	$smarty->assign('extras', $appinfo['extras']);

	if (!$appinfo['cancelled']) {
		if ($appinfo['component'] == "reserve") {
			$ap->set_category_id($appinfo['category_id']);
			$category = $ap->getEntryCategory();

			if ($category['oncancel']) {

				if (strtotime($appinfo['comedate']) - ($category['limit_time'] - 6) * 60 * 60 > time()) {
					$smarty->assign('cancelable', 1);
				}

			}

		}
	}

// 記事編集ページを表示する
	$smarty->display('show_app.tpl');
} else {
	$smarty->display('list_app.tpl');

}
exit();
?>
