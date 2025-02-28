<?php
function smarty_function_get_item_info($params, &$smarty) {

// pdoオブジェクトを得る
	$pdo = $smarty->getTemplateVars('pdo');

// SQLを作成する

	$sql = <<< HERE
SELECT i.*
,sc.term_start as subcategory_term_start
,sc.term_end as subcategory_term_end
,sc.intervals as subcategory_intervals
,sc.flag_drink as flag_drink
 FROM sp_item as i,sp_subcategory as sc
 WHERE i.subcategory_id = sc.id

HERE;

	if (intval($params['id'])) {

		$item_id = intval($params['id']);
	} else {
		$item_id = $smarty->getTemplateVars('item["id"]');
	}

	$sql .= " AND i.id = ?";

	try {
		$res = $pdo->prepare($sql);
		$res->execute(array($item_id));
	} catch (Exception $e) {
// データベースアクセスに失敗したらエラーとする
		$smarty->assign('db_error', 1);
	}
// 商品を配列に読み込む
	$itm = $res->fetch();

// 商品がない場合
	if (count($itm) == 0) {
		$smarty->assign('no_itm', 1);
		return;
	}

// レコードの各フィールドをSmartyの変数に設定する
	if (count($itm)) {

		$itm['name'] = htmlspecialchars_decode($itm['name']);

		foreach (array('extra', 'cart') as $key) {
			for ($i = 1; $i <= 3; $i++) {
				if ($itm[$key . $i . '_use'] > 0) {

					$itm[$key . $i . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($itm[$key . $i . '_select']));
					$tmp = null;
					if ($itm[$key . $i . '_select']) {
						$tmp = explode(",", $itm[$key . $i . '_select']);
						array_unshift($tmp, '');
					}

					$itm[$key][$i] = array(
						'use' => $itm[$key . $i . '_use'],
						'title' => $itm[$key . $i . '_title'],
						'select' => $tmp,
						'note' => $itm[$key . $i . '_note'],
					);
				}
			}
		}

/*
for ($ii = 1; $ii <= 3; $ii++) {
$itm['extra' . $ii . '_select'] = str_replace(array("\r\n", "\r", "\n"), ',', trim($itm['extra' . $ii . '_select']));
$tmp = explode(",", $itm['extra' . $ii . '_select']);
array_unshift($tmp, '');
$smarty->assign('extra' . $ii . 'List', $tmp);
}
 */
		$js_term_end = mb_substr($itm['subcategory_term_end'], 5, 2) . '/' . mb_substr($itm['subcategory_term_end'], 8, 2) . '/' . mb_substr($itm['subcategory_term_end'], 0, 4);

		$js_term_start = mb_substr($itm['subcategory_term_start'], 5, 2) . '/' . mb_substr($itm['subcategory_term_start'], 8, 2) . '/' . mb_substr($itm['subcategory_term_start'], 0, 4);

		$itm['js_term_end'] = $js_term_end;
		$itm['js_term_start'] = $js_term_start;

		if (!$itm['subcategory_term_end']) {$temp = '';} else {
			$tmp = array();
			if (!$itm['subcategory_term_start']) {$itm['subcategory_term_start'] = date('Y-m-d');}

			$days = intval((strtotime($itm['subcategory_term_end']) - strtotime($itm['subcategory_term_start'])) / 24 / 60 / 60) + 1;
			$ts = strtotime($itm['subcategory_term_start']);
			$tt = strtotime($itm['subcategory_term_start']) - ($itm['subcategory_intervals']) * 60 * 60 * 24;
			if (!is_null($itm['subcategory_weekday'])) {
				//曜日指定の有無
				$wd = explode(',', $itm['subcategory_weekday']);
			}
			for ($j = 0; $j < $days; $j++) {
				if (time() < $tt + 60 * 60 * 24 * $j) {
					if (count($wd)) {
						if (!in_array(date('w', $ts + 60 * 60 * 24 * $j), $wd)) {continue;}
					}
					array_push($tmp, date('Y-m-d', $ts + 60 * 60 * 24 * $j));
				}
			}
			if (count($tmp)) {
				$temp = '\'' . implode(',', $tmp) . '\'';
			} else {
				$temp = 'false';
			}
		}
		$itm['setDay'] = $temp;

		$smarty->assign('itm', $itm);
	}

}
?>
