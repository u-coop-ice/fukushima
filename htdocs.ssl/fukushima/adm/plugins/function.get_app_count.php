<?php

function smarty_function_get_app_count($params, &$smarty) {

	// データベース関連の情報を得る
	$view_archived = intval($smarty->getTemplateVars('view_archived'));

	try {

		$cinfo = new adminEntryDB();
		$cinfo->set_category_id($params['category_id']);
		$cinfo->set_archived($view_archived);
		$nn = $cinfo->getEntryCategory();

		$smarty->assign('app_count', $nn['entry_count']);

//stock state判定
		if ($nn['onstock'] == 1) {
			$n = $nn['stock'] - $nn['entry_count'];

			if ($n > 0) {
				$app_count_state = 1;
			} else if ($n == 0) {
				$app_count_state = 0;
			} else {
				$app_count_state = -1;
			}
		} else if ($nn['onstock'] == 2) {
			$cinfo->get_multi_stock_count();
			$stock_multi = $cinfo->get_multi_stock();
			$app_count_state = $cinfo->app_count_state_multi();
			$smarty->assign('stock_multi', $stock_multi);
		}

	} catch (Exception $e) {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'データベースへの処理に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}

	$smarty->assign('app_count_state', $app_count_state);
	return;
}
?>
