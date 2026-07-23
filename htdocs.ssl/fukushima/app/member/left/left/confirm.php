<?php

if ($postdata['complete']) {
	$postdata = [];
	HTTP_Session2::set('postdata', $postdata);
	header("Location: $init_url");
	exit();
}

$obj = 'app' . ucfirst(COMPONENT) . ucfirst(PART) . 'DB';

try {
	$ap = new $obj;
	$ap->setAuth($userAuth);
	$ap->set_component(COMPONENT);
	$ap->set_part(PART);
	$ap->saveAppEntry();

} catch (Exception $e) {

	switch ($e->getCode()) {
	case 9:

		$cinfo = new $obj;
		$cinfo->setAuth($userAuth);
		$cinfo->set_component(COMPONENT);
		$cinfo->set_part(PART);
		$categoryinfo = $cinfo->getEntryCategory();
		$method = $cinfo->get_method_category();

		$pp = 'post_';

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

		$smarty->assign("html", $html); //項目のテンプレート発行
		$steps[1] = 'now';
		$smarty->assign('step', $steps);

		$smarty->display('input.tpl');
		exit();
	case 8:
		$method = $ap->get_method_category();
		$pp = 'conf_';

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

		$smarty->assign("html", $html); //項目のテンプレート発行

		$steps[1] = 'cleared';
		$steps[2] = 'now';
		$smarty->assign('step', $steps);

		$smarty->display('confirm.tpl');
		exit();
	case 7:
		$smarty->assign('stepsFile', []);
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お申込みが重複しています');
		$smarty->display('duplicate.tpl');
		exit();
	default:
		$smarty->assign('page_title', 'エラー');
		$smarty->assign('errmsg', 'お申込みの登録に失敗しました。' . $e->getMessage());
		$smarty->display('error.tpl');
		exit();
	}

}

exit();

?>
