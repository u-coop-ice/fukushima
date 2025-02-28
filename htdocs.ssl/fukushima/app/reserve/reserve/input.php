<?php

$pp = 'edit_';
while (list($key, $value) = each($method)) {
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

			$smarty->assign('extraList', $extraList[$k]);
		}

		$html .= $smarty->fetch($pp . 'extra.tpl');
	}
}
$smarty->assign("html", $html); //項目のテンプレート発行

$smarty->display('input.tpl');
?>
