<?php

// URLから記事のIDを得る
$category_id = intval($_REQUEST['category_id']);
$component = addslashes($_REQUEST['component']);

// IDが指定されていれば、それを変数view_entry_idに設定する

try {

	$class = 'admin' . ucfirst($component) . 'DB';

	$cinfo = new $class;
	$cinfo->set_category_id($category_id);
	$cinfo->set_component($component);
	$cinfo->set_skip_auth_check();

	$category = $cinfo->getEntryCategory();
	$cinfo->checkWorkigEntryCategory($category);

	$smarty->assign('category', $category);

	switch ($category['component']) {
	case 'entry':
		$stock_multi = $cinfo->get_multi_stock();

		if (count($stock_multi)) {
			$smarty->assign('stock_multi', $stock_multi);
		}
		break;

	case 'reserve':

		try {
			$setDay = $cinfo->getSetDays();
		} catch (Exception $e) {
			$setDay = [];
		}

		$setOverDay = $cinfo->get_setOverDay();
		$setDayList = $cinfo->get_setDayList();

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

		break;
	default:
		break;
	}

	$method = $cinfo->get_method_category();
	$smarty->assign("methods", $category['method']); //項目のテンプレート発行

	$smarty->addTemplateDir(ETC_DIR . 'app/templates/common');
	$smarty->addTemplateDir(ETC_DIR . 'app/templates/entry');

	$pp = 'edit_';
	$html = '';
	if (isset($method) && is_array($method)) {
		foreach ($method as $key => $value) {
			if (!preg_match('/^extra/', $key)) {
				$html .= $smarty->fetch($pp . $key . '.tpl');
			} else {
				$k = intval(substr($key, 5));
				$smarty->assign('k', $k);
				$extraList[$k] = [];
				if ($category['method']['extra'][$k]['select']) {
					$select = trim($category['method']['extra'][$k]['select']);
					$select = preg_replace('/\n|\r\n/', "\n", $select);

					$extraList[$k] = explode("\n", $select);
					if ($k == 0) {
						foreach ($extraList[$k] as $v) {
							$tmp = explode(",", $v);
							$tmps[$tmp[0]] = $tmp[1];
						}
						$extraList[$k] = array_keys($tmps);
					}

				}
				$smarty->assign('extraList', $extraList[$k]);

				$html .= $smarty->fetch($pp . 'extra.tpl');
			}
		}
	}

	$smarty->assign("html", $html); //項目のテンプレート発行

} catch (Exception $e) {

	$smarty->assign('page_title', 'エラー');
	$smarty->assign('errmsg', $e->getMessage());
	$smarty->display('preview_error.tpl');
	exit();

}

$smarty->display('preview_form.tpl');

exit();
?>
