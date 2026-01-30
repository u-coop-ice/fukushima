<?php

function smarty_function_get_app_count($params, &$smarty) {

	// データベース関連の情報を得る
	$view_archived = intval($smarty->getTemplateVars('view_archived'));

	try {

		$cinfo = new adminEntryDB();
		$cinfo->set_category_id($params['category_id']);
		$cinfo->set_archived($view_archived);
		$stock = $cinfo->getAppEntryCountOnly();

//		$nn = $cinfo->getEntryCategory();

		$app_count_state = $stock['status'];

//stock state判定
		switch ($stock['onstock']) {
		case 2:
			$stock_multi = $stock['stock_multi'];

			$smarty->assign('stock_multi', $stock_multi);
			break;
		default:

			$smarty->assign('app_count', $stock['stock_multi']['ct']);

			break;
		}

	} catch (Exception $e) {
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'データベースへの処理に失敗しました。' . $e->getMessage());
		$smarty->assign('error_get_app_count', '1');

	}

	$smarty->assign('app_count_state', $app_count_state);
	return;
}
?>
