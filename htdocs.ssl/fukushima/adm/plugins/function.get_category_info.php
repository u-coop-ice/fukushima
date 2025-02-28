<?php
function smarty_function_get_category_info($params, &$smarty) {

// pdoオブジェクトを得る
	$pdo = $smarty->getTemplateVars('pdo');
	if ($smarty->getTemplateVars('init_category')) {
		$init_category = $smarty->getTemplateVars('init_category');
	} else {
		$ct = new shoppingDB();
		$init_category = $ct->get_category_info();
	}

	if ($init_category['flag_send']) {
		if ($init_category['term_end']) {
			$init_category['js_term_end'] = mb_substr($init_category['term_end'], 5, 2) . '/' . mb_substr($init_category['term_end'], 8, 2) . '/' . mb_substr($init_category['term_end'], 0, 4);
		} else {
			$init_category['js_term_end'] = 'false';
		}
		if ($init_category['term_start']) {
			$init_category['js_term_start'] = mb_substr($init_category['term_start'], 5, 2) . '/' . mb_substr($init_category['term_start'], 8, 2) . '/' . mb_substr($init_category['term_start'], 0, 4);
		} else {
			$init_category['js_term_start'] = 'false';
		}

		if (!$init_category['term_end']) {$temp = '';} else {
			$tmp = array();
			if (!$init_category['term_start']) {$init_category['term_start'] = date('Y-m-d');}

			$days = intval((strtotime($init_category['term_end']) - strtotime($init_category['term_start'])) / 24 / 60 / 60) + 1;
			$ts = strtotime($init_category['term_start']);
			$tt = strtotime($init_category['term_start']) - ($init_category['intervals']) * 60 * 60 * 24;
			if (!is_null($init_category['weekday'])) {
				//曜日指定の有無
				$wd = explode(',', $init_category['weekday']);
			}
			for ($j = 0; $j <= $days; $j++) {
				if (time() < $tt + 60 * 60 * 24 * $j) {
					if (count($wd)) {
						if (!in_array(date('w', $ts + 60 * 60 * 24 * $j), $wd)) {continue;}
					}
					array_push($tmp, date('Y-m-d', $ts + 60 * 60 * 24 * $j));
				}
			}
			$temp = '\'' . implode(',', $tmp) . '\'';
		}
		$init_category['setDay'] = $temp;

	}

	$smarty->assign('init_category', $init_category);

}
?>
