<?php

function smarty_function_get_app_info($params, &$smarty) {

	try {

		$ainfo = new adminEntryDB();
		$ainfo->set_app_id($params['app_id']);
		$app = $ainfo->getAppinfo();
		$smarty->assign('app', $app);

	} catch (Exception $e) {

		throw new Exception("Database Error", 1);

	}
}
?>
