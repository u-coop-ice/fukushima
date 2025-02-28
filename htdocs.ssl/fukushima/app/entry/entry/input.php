<?php

//ユーザー情報取得
/*
if ($userAuth->getAuthData('birthday')) {
$regist['birth_year'] = substr($userAuth->getAuthData('birthday'), 0, 4);
$regist['birth_month'] = intval($userAuth->getAuthData('birthday'), 4, 2);
$regist['birth_day'] = intval($userAuth->getAuthData('birthday'), -2);
}

//電話番号分割
$phone = array('mobilephone', 'parent_mobile', 'student_phone', 'parent_com_phone', 'phonenumber');

foreach ($phone as $key) {
$temp = array();
if ($regist[$key]) {
$temp = explode("-", $regist[$key]);
if (count($temp)) {
foreach ($temp as $i => $ii) {
$regist[$key . ($i + 1)] = $ii;
}
}
}
}

$smarty->assign("regist", $regist);
 */

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

		}
		$smarty->assign('extraList', $extraList[$k]);

		$html .= $smarty->fetch($pp . 'extra.tpl');
	}
}

$smarty->assign("html", $html); //項目のテンプレート発行

$smarty->display('input.tpl');
?>
